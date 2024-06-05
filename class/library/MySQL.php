<?php

/**
 * Обеспечиваем работу с MySQL сервером. Включает функционал работы с соединением к серверу, работу с SQL запросами и обрабатывает кеширование (реализованое в настоящем движке)
 * */

class MySQL
{
	//*********************************************************************************

	public static $queryAmount = 0; //Счетчик кол-ва запросов
	public static $queryCacheAmount = 0; //Счетчик кол-ва кешированных запросов
	public static $queryTime = 0; //Общее время выполнения запросов
	public static $transactionAmount = 0; //Счетчик количества транзакций [используется для кеша]
	public static $resultCache = array(); //Кеш результатов запросов

	private static $obj = null;
	public static $db = false; //Идентификатор соеденения с БД

	private static $queryLog = ""; //Лог запросов

	private $lastQuery = ""; //Последний запрос

	private $objSOutput = null;

	const queryResultNotFromCache = 1;
	const queryResultFromCache = 2;

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new MySQL();
		}

		return self::$obj;
	}

	//*********************************************************************************

	private function __construct()
	{
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$this->objSOutput = SOutput::getInstance();

		//Устанавливаем соеденение с БД
		$this->setConnection();
	}

	//*********************************************************************************

	private function __clone()
	{
	}

	//*********************************************************************************

	//Возвращает лог запросов
	public function getQueryLog()
	{
		$objSRouter = SRouter::getInstance();
		$objSOutput = SOutput::getInstance();

		switch($objSRouter->processorType)
		{
			case SEProcessorType::usual:
			case SEProcessorType::ajax:
			{
				return "<pre>".self::$queryLog."</pre>";
				break;
			}
			case SEProcessorType::base:
			{
				return self::$queryLog;
				break;
			}
			default:
			{
				$objSOutput->critical("Некорректный тип обработчика [".$objSRouter->processorType."]");
			}
		}
	}

	//*********************************************************************************

	//Возвращает статистику запросов
	public function getQueryStatistic()
	{
		return "Запросов ".(self::$queryAmount + self::$queryCacheAmount)." (из кеша: ".self::$queryCacheAmount."), сгенерированны за: ".self::$queryTime." с.";
	}

	//*********************************************************************************

	public function startTransaction()
	{
		$this->query("START TRANSACTION;");
	}

	//*********************************************************************************

	public function commit()
	{
		/**
		 * Необходимо проверить не пустой ли буфер вывода.
		 * Если он не пуст, значит произошла ошибка и не нужно выполнять никаких завершений транзакций
		 * */

		if (false === SGLOB::$stdOutProcessed AND ob_get_length() > 0)
		{
			//Буфер вывода не пуст, значит возможно произошла какая-то ошибка
			$this->objSOutput->critical("Буфер вывода не обработан [".md5(ob_get_contents())."]");
		}

		$this->query("COMMIT;");
	}

	//*********************************************************************************

	public function rollback()
	{
		$this->query("ROLLBACK;");
	}

	//*********************************************************************************

	public function getLastQuery()
	{
		return $this->lastQuery;
	}

	//*********************************************************************************

	/**
	 * Обрабатывает MySQL запрос любого характера
	 * @param $query string Текст запроса
	 * @param $cacheKey bool Ключ кэширования запроса
	 *
	 * @return mixed FALSE - при ошибке. Результат выполнения запроса: если это запрос типа SELECT, то возвращает array массив строк, если это другие запросы, то возвращается mysqlresult
	 * */
	public function query($query, $cacheKey = true)
	{
		$this->lastQuery = $query;

		//Обрезаем пробелы в запросе
		$query = trim($query);
		//md5 запроса
		$queryMD5 = md5($query);

		//Проверяем существует ли кеш запроса
		if($this->isResultCacheExist($queryMD5))
		{
			//Увеличиваем счтчик запросов взятых из кеша
			self::$queryCacheAmount++;

			//Пишем лог запросов
			$this->addQueryLog($query, 0, self::queryResultFromCache);

			//Возвыращаем запрос из кеша
			return $this->getResultCache($queryMD5);
		}

		//Увеличиваем счетчик кол-ва запросов
		self::$queryAmount++;

		//Записываем время старта запроса
		$startTime = microtime(true);

		//Выполнение запроса
		$res = mysqli_query(self::$db, $query);

		/**
		 * ВНИМАНИЕ! Обработка специфической ситуации "deadlock".
		 * Иногда, при одновременном обращении к строке таблице и использовании ее блокировки (это происходит автоматически),
		 * возникает ситуация "мертвой блокировки", т.е., например две транзакции ждут освобождения блокировки к одной и той же строке для друг друга,
		 * т.е. никогда не дождутся. Потому тот запрос, который создал такую взаимную блокировку не выполняется и для него выдается ошибка
		 * (а первый работает себе дальше!!!!!).
		 * Возникает ошибка 1213 - "Deadlock found when trying to get lock; try restarting transaction;"
		 * @link http://dev.mysql.com/doc/refman/5.1/en/innodb-lock-modes.html
		 *
		 * В официальной документации рекомендуют "перезапускать транзакцию, которая откатилась в случае такой ошибки".
		 * Нужно помнить, что в InnoDB - один отдельный (не заключенный в транзакцию вручную) запрос является "транзакцией"
		 * (т.е. имеется ввиду, что нужно выполнить снова один этот запрос).
		 * Решено было сделать следующее:
		 * 1) Если во время выполнения запроса произошла данная ошибка (1213),
		 * 1.1) то ничего не откатывать, а просто выждать паузу,
		 * 1.2) а потом повторить запрос
		 * Так как проблема же не во всем стеке запросов в транзакции, а именно в этом запросе, это он вызвал взаимную блокировку с другим и был отброшен.
		 * 2) Если блокировка все еще актуальна, значит только тогда выдаем ошибку
		 * */
		if ((false === $res) && (1213 === (int)mysqli_errno(self::$db)))
		{
			//Уведомляем разработчиков о данной ситуации (но не прикращаем работу программы)
			SDebug::sendEmail("Произошла ошибка работы с базой данных: 1213 - Deadlock found when trying to get lock; try restarting transaction;");

			sleep(1);
			$res = mysqli_query(self::$db, $query);
		}

		//Расчитаем общее время выполнения запросов
		$workTime = round(microtime(true) - $startTime, 6);
		//Добавляем в переменную класса время выполнения текущего запроса
		self::$queryTime += $workTime;

		//Пишем лог запросов
		$this->addQueryLog($query, $workTime);

		//Проверяем выполнился ли вообще запрос
		if(false === $res)
		{
			//Выводим сообщение с ошибкой
			$this->showQueryError($query, mysqli_errno(self::$db), mysqli_error(self::$db));

			return false;
		}
		else
		{
			//Проверяем, относится ли запрос к группе SELECT
			if(mb_stripos($query, "SELECT") === 0)
			{
				//Массив строк с ответом с БД
				$resultArray = array();

				//Собираем массив с результатов запроса
				while($row = mysqli_fetch_assoc($res))
				{
					$resultArray[] = $row;
				}

				//Если нет активных транзакций, то добавляем резултат в кеш
				if(0 === self::$transactionAmount AND true === $cacheKey)
				{
					$this->addResultCache($queryMD5, $resultArray);
				}

				return $resultArray;
			}
			else
			{
				//Если прошел запрос на стар транзакции, то запускаем счетчик транзакций
				if(0 === mb_stripos($query, "START TRANSACTION"))
				{
					self::$transactionAmount++;
				}

				//Если прошел один из запросов завершеняи тарнзакции, то уменьшаем счетчик транзакций
				if(0 === mb_stripos($query, "COMMIT") OR 0 === mb_stripos($query, "ROLLBACK"))
				{
					//Счетчик уменьшается, только если он больше 0 [защита от лишенго завершения транзакции программистом]
					if(self::$transactionAmount > 0)
					{
						self::$transactionAmount--;
					}
				}

				//Сбрасываем кеш [это нужно делать только в определенных случаях, но мы сбрасываем всегда]
				$this->dropResultCache();

				//Запрос не относится к группе "SELECT", значит возвращаем результат
				return $res;
			}
		}
	}

	//*********************************************************************************

	/**
	 * Выполняет запрос с оператором COUNT
	 *
	 * @param string $table Имя таблицы
	 * @param string $where Условие выборки (без ключевого слова WHERE)
	 *
	 * @return int Количество найденых строк
	 * */
	public function count($table, $where = "")
	{
		//Обрамляем условие, если оно есть
		$where = (empty($where)) ? "" :  " WHERE (".$where.")";

		$query = "SELECT COUNT(*) AS `count` FROM `".$table."`".$where;

		if(false === ($res = $this->query($query)))
		{
			return false;
		}
		else
		{
			return (int)$res[0]["count"];
		}
	}

	//*********************************************************************************

	/**
	 * Выполняет запрос выборки значения поля $field в таблице $table
	 *
	 * @param string $table Имя таблицы
	 * @param string $field Имя поля в таблице
	 * @param string $where Условие выборки (без ключевого слова WHERE)
	 *
	 * @return int Количество найденых строк
	 * */
	public function getFieldValue($table, $field, $where = "")
	{
		//Обрамляем условие, если оно есть
		$where = (empty($where)) ? "" :  " WHERE (".$where.")";

		$query = "SELECT `".$field."` FROM `".$table."`".$where;

		$res = $this->query($query);

		if (0 === count($res))
		{
			return false;
		}
		else
		{
			return $res[0][$field];
		}
	}

	//*********************************************************************************

	/**
	 * Выполняет запрос установки значения поля $field в таблице $table
	 *
	 * @param string $table Имя таблицы
	 * @param string $field Имя поля в таблице
	 * @param string $where Условие выборки (без ключевого слова WHERE)
	 *
	 * @return int Количество найденых строк
	 * */
	public function setFieldValue($table, $field, $value, $where = "")
	{
		$data[$field] = $value;

		$res = $this->update($table, $data, $where);

		if(false === $res)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	//*********************************************************************************

	/**
	 * Обрабатывает MySQL запрос типа INSERT
	 * @param string $table Имя таблицы
	 * @param array $data Массив, где ключем является имя поля, а значением содержимое поля MySQL таблицы
	 * @param bool $processDataKey Ключ указывающий необходимо ли обрабатывать данные перед вставков в БД
	 *
	 * @return mixed FALSE - при ошибке. TRUE - если все ОК
	 * */
	public function insert($table, $data, $processDataKey = true)
	{
		if(count($data) > 0)
		{
			$count = count($data);
			$query = "";

			if (false === $processDataKey)
			{
				//Не обрабатываем входные данные
				foreach($data as $fieldName => $value)
				{
					$count--;

					if($count === 0)
					{
						$query .= "`".$fieldName."` = '".mysqli_real_escape_string($value)."'";
					}
					else
					{
						$query .= "`".$fieldName."` = '".mysqli_real_escape_string($value)."',";
					}
				}
			}
			else
			{
				//Обрабатываем входные данные
				foreach($data as $fieldName => $value)
				{
					$count--;

					if($count === 0)
					{
						$query .= "`".$fieldName."` = '".Func::res($value)."'";
					}
					else
					{
						$query .= "`".$fieldName."` = '".Func::res($value)."',";
					}
				}
			}

			$query = "INSERT INTO `".$table."` SET ".$query;

			if($this->query($query))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		return false;
	}

	//*********************************************************************************

	/**
	 * Обрабатывает MySQL груповой запрос типа INSERT
	 * @param string $table Имя таблицы
	 * @param array $data Числовой массив, зачениями элементов которого являются массивы, где ключем является имя поля, а значением содержимое поля MySQL таблицы
	 * @param bool $processDataKey Ключ указывающий необходимо ли обрабатывать данные перед вставков в БД
	 * @param int $insertRowInQuery Кол-во запросов в группе
	 *
	 * @return mixed FALSE - при ошибке. TRUE - если все ОК
	 * */
	public function insertGroup($table, $data, $processDataKey = true, $insertRowInQuery = 0)
	{
		if(count($data) > 0)
		{
			//Кол-во строк для вставки
			$count = count($data);

			//Префикс запроса
			$queryPrefix = "";
			//Суфикс запроса
			$querySuffix = "";

			//Temp переменная для имен полей
			$tempFieldNameQuery = "";
			//Определяем кол-во полей в запросе
			$fieldAmount = count($data[0]);

			//Обходим первую строку, чтобы сформировать названия полей
			foreach($data[0] as $fieldName => $value)
			{
				$fieldAmount--;

				if(0 === $fieldAmount)
				{
					$tempFieldNameQuery .= "`".$fieldName."`";
				}
				else
				{
					$tempFieldNameQuery .= "`".$fieldName."`, ";
				}
			}

			//Формируем первую часть запроса
			$queryPrefix = "INSERT INTO `".$table."` (".$tempFieldNameQuery.") VALUES \r\n ";

			//Номер текущей строки
			$currentLine = 0;
			//Удаляем $tempFieldNameQuery
			unset($tempFieldNameQuery);

			//Обходим строки
			foreach($data as $row)
			{
				$count--;
				$currentLine++;

				//Кол-во полей
				$fieldAmount = count($row);
				//Temp переменная для запроса
				$tempValuesQuery = "";

				//Обходим поля в строке
				foreach($row as $fieldName => $value)
				{
					$fieldAmount--;

					if(0 === $fieldAmount)
					{
						//Проверяем, нужно ли обрабатывать данные перед вставкой
						if(false === $processDataKey)
						{
							$tempValuesQuery .= "'".mysqli_real_escape_string($value)."'";
						}
						else
						{
							$tempValuesQuery .= "'".Func::res($value)."'";
						}
					}
					else
					{
						//Проверяем, нужно ли обрабатывать данные перед вставкой
						if(false === $processDataKey)
						{
							$tempValuesQuery .= "'".mysqli_real_escape_string($value)."', ";
						}
						else
						{
							$tempValuesQuery .= "'".Func::res($value)."', ";
						}
					}
				}

				//Заворачиваем запрос и доавбляем в цонец строки "," или ";" если это последняя строка
				//Если не указанно разбиение на группы, т.е. $insertRowInQuery = 0, то в IF зайдет в конце формирования запросса
				if(0 === $count OR $insertRowInQuery === $currentLine)
				{
					$tempValuesQuery = "(".$tempValuesQuery.");";
					//Добавляем часть запроса
					$querySuffix .= $tempValuesQuery;

					//Выполняем запрос (последний запрос в случае если есть разбиение на группы)
					//это условие сработает, когда count = 0 и нет разбиения на группы,
					//т.е. когда нужно выполнить один запрос INSERT
					if(0 === $count OR 0 === $insertRowInQuery)
					{
						//Выполянем запрос
						if($this->query($queryPrefix.$querySuffix))
						{
							return true;
						}
						else
						{
							return false;
						}
					}
					else
					{
						//Проверяем, нужно ли делать разбивку на несколько INSERT.
						if($count > 0)
						{
							//Сбрасываем счетчик строк
							$currentLine = 0;

							//Выполянем запрос на вставку части данных
							if(!$this->query($queryPrefix.$querySuffix))
							{
								return false;
							}

							//Очичаем суфикс запроса
							$querySuffix = "";
						}
					}
				}
				else
				{
					$tempValuesQuery = "(".$tempValuesQuery."),\r\n";
					//Добавляем часть запроса
					$querySuffix .= $tempValuesQuery;
				}
			}
		}

		return false;
	}

	//*********************************************************************************

	/**
	 * Обрабатывает MySQL запрос типа UPDATE
	 * @param string $table Имя таблицы
	 * @param array $data Массив, где ключем является имя поля, а значением содержимое поля MySQL таблицы
	 * @param string $where Строка условия в полном mysql формате (без ключевого слова WHERE)
	 * @param bool $processDataKey Ключ указывающий необходимо ли обрабатывать данные перед вставков в БД
	 *
	 * @return mixed FALSE - при ошибке. TRUE - если все ОК
	 * */
	public function update($table, $data, $where = "", $processDataKey = true)
	{
		if(count($data) > 0)
		{
			$count = count($data);
			$query = "";

			if (false === $processDataKey)
			{
				//Не обрабатываем входные данные

				foreach($data as $fieldName => $value)
				{
					$count--;

					if($count === 0)
					{
						$query .= "`".$fieldName."` = '".mysqli_real_escape_string($value)."'";
					}
					else
					{
						$query .= "`".$fieldName."` = '".mysqli_real_escape_string($value)."',";
					}
				}
			}
			else
			{
				//Обрабатываем входные данные

				foreach($data as $fieldName => $value)
				{
					$count--;

					if($count === 0)
					{
						$query .= "`".$fieldName."` = '".Func::res($value)."'";
					}
					else
					{
						$query .= "`".$fieldName."` = '".Func::res($value)."',";
					}
				}
			}

			if(!empty($where))
			{
				$where = " WHERE (".$where.")";
			}

			$query = "UPDATE `".$table."` SET ".$query.$where;

			if($this->query($query))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		return false;
	}

	//*********************************************************************************

	/**
	 * Обрабатывает MySQL запрос типа DELETE
	 * @param string $table Имя таблицы
	 * @param string $where Строка условия в полном mysql формате (без ключевого слова WHERE). ОБЯЗАТЕЛЬНОЕ ПОЛЕ, для того чтобы предотвратить ошибки неуказания условия выборки. Если нужно удалить все строки, то просто нужно указать что-то типа '1'='1'
	 * @param string $limit Введен как параметр для предотвращения ситуаций удаления большого числа строк, когда нужно удалять одну
	 *
	 * @return mixed FALSE - при ошибке. TRUE - если все ОК
	 * */
	public function delete($table, $where, $limit = null)
	{
		$where = " WHERE (".$where.")";

		$query = "DELETE FROM `".$table."`".$where.((is_null($limit)) ? "" : " LIMIT ".$limit );

		if($this->query($query))
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	public function getLastInsertId()
	{
		$query = "SELECT last_insert_id() AS `id`";

		if (false === ($res = $this->query($query)))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	//*********************************************************************************

	//Проверяет установленно ли соеденение с БД
	public function checkConnection()
	{
		if(false === self::$db)
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	//Проверяет существование кеша
	private function isResultCacheExist(&$md5)
	{
		if(isset(self::$resultCache[$md5]))
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	/**
	 * Добавляет инфомрацию о запросе в лог лог запросов к БД
	 * */
	private function addQueryLog($query, $workTime, $type = self::queryResultNotFromCache)
	{
		if (false === Config::$logDBQueries) return;

		if(self::queryResultNotFromCache === $type)
		{
			$queryInfo = "<strong>Запрос:</strong><br>".$query."<br><strong>Время:</strong> ".$workTime." с.";
		}
		else
		{
			$queryInfo = "<strong>Запрос (из кеша):</strong><br><pre>".$query."</pre><br><strong>Время:</strong> ".$workTime." с.";
		}

		self::$queryLog .= "<p style=\"margin: 20px 0px 0px 0px\">".$queryInfo."</p>";
	}

	//*********************************************************************************

	//Вовзаращает кеш
	private function addResultCache(&$md5, &$resultArray)
	{
		//Добавляем запрос в кеш
		self::$resultCache[$md5] = $resultArray;
	}

	//*********************************************************************************

	//Вовзаращает кеш
	private function getResultCache(&$md5)
	{
		if(isset(self::$resultCache[$md5]))
		{
			return self::$resultCache[$md5];
		}

		return false;
	}

	//*********************************************************************************

	//Очищает кеш
	private function dropResultCache()
	{
		self::$resultCache = array();
	}

	//*********************************************************************************

	/**
	 * Отображает ошибку
	 * */
	private function showQueryError($query, $errno, $error)
	{
		if(true === Config::$debug)
		{
			$this->objSOutput->critical("Ошибка выполнения запроса в базу данных [код: ".$errno."] <br><strong>Описание ошибки:</strong><br>".$error.";<br><strong>Запрос</strong>:<br><pre>".$query."</pre>");
		}
		else
		{
			$this->objSOutput->critical("Ошибка выполнения запроса в базу данных [".md5($query)."]");
		}
	}

	//*********************************************************************************

	/**
	 * Устанавливает соеденение с БД
	 * */
	private function setConnection()
	{
		//var_dump(Config::$db);exit;
		if(!self::$db)
		{
			if (!isset(Config::$db["host"]) || !isset(Config::$db["port"]) || !isset(Config::$db["user"]) || !isset(Config::$db["password"]))
			{
				$this->objSOutput->critical("Ошибка конфигурации доступа к базе данных");
			}

			self::$db = mysqli_connect(Config::$db["host"], Config::$db["user"], Config::$db["password"], Config::$db["dbName"], Config::$db["port"]);
			if (false === self::$db)
			{
				$this->objSOutput->critical("Ошибка соединения с базой данных");
			}
			else
			{
				if(false === mysqli_select_db(self::$db, Config::$db["dbName"]))
				{
					$this->objSOutput->critical("Ошибка выбора базы данных");
				}

				//Здесь размещаются действия (запросы), которые нужно выполнить при каждом подключении к базе данных
				mysqli_query(self::$db, "SET NAMES utf8");
			}
		}
	}

	//*********************************************************************************
}

?>