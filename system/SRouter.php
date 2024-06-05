<?php

/**
 * Обрабатывает правила адресации ("роуты") системы
 *
 * @package System
 * */
class SRouter
{
	//*********************************************************************************

	/**
	 * @var string Имя класса, объект которого будет создаватся для текущего правила
	 * */
	public $className = null;

	/**
	 * @var int Тип обработчика
	 * */
	public $processorType = null;

	/**
	 * @var mixed Дополнительные аргументы, указываемые в правиле
	 * */
	public $args = null; //Дополнительные параметры

	/**
	 * @var bool Ключ указывающий произведен ли запуск скрипта из консоли
	 * */
	public $startFromConsole = false; //Ключ указывающий, что запуск скрипта произведен из консоли

	/**
	 * @var object Ссылка на объект данного класса, использующаяся в механизме "Класс - одиночка"
	 * */
	private static $obj = null;

	private $objSURI = null;
	private $objSResponse = null;

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new SRouter();
		}

		return self::$obj;
	}

	//*********************************************************************************

 	private function __construct()
 	{
		//Вспомогательные классы
		$this->objSURI = SURI::getInstance();
		$this->objSResponse = SResponse::getInstance();

		//Сначала пробуем инициализировать данные контроллера, предполагая, что запуск скрипта был произведен из консоли,
		//а, если таковое не имело место, то производим обычную инициализацию
		if (false === $this->initFromConsole())
		{
			$this->init();
		}
		else
		{
			//Устанавливаем ключ, указывающий, что запуск скрипта произошел из консоли в TRUE
			$this->startFromConsole = true;
		}
 	}

	//*********************************************************************************

	private function __clone()
	{
	}

	//*********************************************************************************

	/**
	 * Используется в случае, если запуск скрипта произошел не из консоли.
	 * Инициализирует имя контроллера, который должен обрабатывать данную страницу, а также другие данные
	 * */
	private function init()
	{
		//Проверяем включены ли классические URL
		if(SConfig::$classicUrl)
		{
			//Проверяем, есть ли роуты для текущего URI
			if(!$this->checkRouteRules())
			{
				if (true === SConfig::$debug)
				{
					$this->objSResponse->showPageError404("Не найден роутер для обработки страницы.");
				}
				else
				{
					$this->objSResponse->showPageError404("");
				}
			}
		}
		else
		{
			//Проверяем, не пустой ли у нас URI
			if(!empty($this->objSURI->requestURI))
			{
				//Проверяем, есть ли роуты для текущего URI
				if(!$this->checkHSURouteRules())
				{
					if (true === SConfig::$debug)
					{
						$this->objSResponse->showPageError404("Не найден роутер для обработки страницы.");
					}
					else
					{
						$this->objSResponse->showPageError404("");
					}
				}
				else
				{
					//Роутер найден, проверяем есть ли "оригинальый" URI для проверки на "/" в конце и, если есть, то проверяем наличие слеша
					if(!empty($this->objSURI->requestURIForCheckSlech) AND !preg_match("#\/$#iu", $this->objSURI->requestURIForCheckSlech))
					{
						//Слеш не найден, редирект на страницу со слешем
						$this->objSResponse->redirect($this->objSURI->requestURI, SERedirect::movedPermanently);
					}
				}
			}
			else
			{
				//Если URI пустой, то устанавливаем в качестве обработчика, контроллер по умолчанию
	   			$this->className = SRoutes::$defaultController["controller"];
				$this->processorType = SRoutes::$defaultController["type"];

				if (isset(SRoutes::$defaultController["args"]))
				{
					$this->args = SRoutes::$defaultController["args"];
				}
			}
		}
	}

	//*********************************************************************************

	/**
	 * Используется в случае, если запуск скрипта произошел из консоли.
	 * Инициализирует имя контроллера, который должен обрабатывать данную страницу, а также другие данные
	 * */
	private function initFromConsole()
	{
		$argv = [];
		$argv_count = 0;

		if (isset($GLOBALS["argv"]))
		{
			$argv = $GLOBALS["argv"];
			$argv_count = count($GLOBALS["argv"]);
		}

		/**
		 * Даже если скрипт запускается НЕ напрямую (путем запуска бинарника php и передачи ему консольных аргументов),
		 * происходит заполнение массива $argv как минимум одной переменной "путь к запускаемому скрипту".
		 * */

		//Проверяем передаются ли дополнительные (пользовательские) консольные аргументы (учитывая, что есть всегда один служебный аргумент)
		if ($argv_count <= 1)
		{
			//Нет консольных аргументов
			return false;
		}

		/** ВНИМАНИЕ! В элементе с нулевым индексом хранится "путь к запускаемому скрипту", потому исключаем его из списка */
		for($i = 1; $i < $argv_count; $i++)
  		{
  			//Проверяем передается аргумент "имя контроллера"
  			//Для этого сравниваем первые три символа. Они должны быть равны строке "-c=" (Пример: -c=CSomeController)
  			if (0 === strncasecmp("-c=", $argv[$i], 3))
  			{
				$className = mb_substr($argv[$i], 3);
				if (0 !== mb_strlen($className))
				{
					//Инициализируем переменные движка, в которых хранится текущий контроллер и его тип (для скриптов запускаемых с аргументами, например через консоль, это тип "Базовый")
					$this->className = $className;
					$this->processorType = SEProcessorType::base;
					continue;
				}
  			}

  			//Производим обработку всех остальных аргументов
			//ВНИМАНИЕ! Все аргументы должны иметь вид "ИМЯ=ЗНАЧЕНИЕ", иначе они будут отброшены

			//Разбиваем на ДВА элемента по ПЕРВОМУ символу "=" ("равно").
			//ВНИМАНИЕ! Передавая третий аргумент, мы инициируем разбиение на максимум две подстроки (при этом в последнюю помещается оставшася часть).
			//Это сделано для того, чтобы разбить только по первому разделителю
  			$array = preg_split("#=#u", $argv[$i], 2);

			//Проверяем на то, чтобы данный аргумент имел корректный формат, т.е. был записан ввиде "ИМЯ=ЗНАЧЕНИЕ"
  			if (2 === count($array))
  			{
				//Добавляем в массив $_GET элемент с именем указанным до знака "равно" и значением, указанным после этого знака
  				$_GET[$array[0]] = $array[1];
  			}
  		}

		//Если была инициализирована переменная имени контроллера, то возвращаем TRUE, иначе - FALSE
  		if (!is_null($this->className))
  		{
  			return true;
  		}
  		else
  		{
  			return false;
  		}
	}

	//*********************************************************************************

	/**
	* Для класических URL.
	* Проверяет есть соответсвует ли имя скрипта одному из правил,
	* и устанавливает имя контроллера, который должен обрабатывать страницу
	*
	* @return bool TRUE - в случае, если найдено правило, соответствующее имени текущего скрипта; FALSE - не найдено
	*/
	private function checkRouteRules()
	{
		foreach(SRoutes::$rules as $scriptName => $paramsArray)
		{
			if(0 === Func::mb_strcasecmp($scriptName, $this->objSURI->scriptName))
			{
				//Устанавливаем имя класса, который должен обрабатывать данную страницу
				$this->className = $paramsArray["controller"];
				//Устанавливаем тип обработчика
				$this->processorType = $paramsArray["type"];
				//Заполняем массив доп. параметров, если такой есть
				if(isset($paramsArray["args"]))
				{
					$this->args = $paramsArray["args"];
				}

				return true;
			}
		}

		return false;
	}

	//*********************************************************************************

	/**
	* Для ЧПУ URL
	* Проверяет соответсвует ли REQUEST_URI одному из правил,
	* и устанавливает имя контроллера, который должен обрабатывать страницу
	*
	* @return bool TRUE - в случае, если найдено правило, соответствующее REQUEST_URI; FALSE - не найдено
	*/
	private function checkHSURouteRules()
	{
		if (!is_array(SRoutes::$rules))
		{
			exit("Core error 3");
		}

		foreach(SRoutes::$rules as $pattern => $paramsArray)
		{
			$normalPattern = $this->getNormalPattern($pattern);

			if(1 === preg_match("#^".$normalPattern."$#iuU", $this->objSURI->requestURI))
			{
				//Устанавливаем имя класса, который должен обрабатывать данную страницу
				$this->className = $paramsArray["controller"];

				//Устанавливаем тип обработчика
				$this->processorType = $paramsArray["type"];

				//Заполняем массив доп. параметров, если такой есть
				if(isset($paramsArray["args"]))
				{
					$this->args = $paramsArray["args"];
				}

				//Заполняем массив $_GET переменными
				$this->setGETArray($pattern, $normalPattern);

				return true;
			}
		}

		return false;
	}

	//*********************************************************************************

	/**
	 * Приводит регулярное выражение в правиле к виду, который используется в стандартных функциях (preg_*)
	 *
	 * @param string $pattern Паттерн пользователя, т.е. та строка, котора указан при формировании правил адресации
	 *
	 * @return string Паттерн приведенный к виду используемому в стандартных функциях работы с регулярными выражениями
	 * */
	private function getNormalPattern($pattern)
	{
		//Проверяем, содержит ли регулярное выражение запись в спец. формате
		if(false === mb_strpos($pattern, "{"))
		{
			//РВ в чистом виде, просто возвращаем его
			return $pattern;
		}

		$patternArray = array
		(
			"#\/{[a-z0-9_]+:~?#iu",
			"#}\/#iu"
		);
		$replaceArray = array
		(
			"/(",
			")/"
		);

		//[1] Удаляем из шаблона имена переменных и заменяем фигурные скобки на обычные
		//(например, для шаблонов с пользовательскими рег. выражениями проверки значений: "/data/{dataId:~[1-9][0-9]*}/" --> "/data/([1-9][0-9]*)/")
		//(например, для шаблонов с пользовательскими специальными шаблонами проверки значений: "/data/{dataId:(num)}/" --> "/data/((num))/")
		$pattern = preg_replace($patternArray, $replaceArray, $pattern);

		$patternArray = array
		(
			"#\/\(num\)\/#iu",
			"#\/\(string\)\/#iu",
			"#\/\(mixed\)\/#iu",
		);
		$replaceArray = array
		(
			"\/([0-9]+)\/",
			"\/([a-z]+)\/",
			"\/([a-z0-9]+)\/",
		);

		//[2] Заменяем специальные пользовательские шаблоны на соответствующие им регулярные выражения
		$pattern = preg_replace($patternArray, $replaceArray, $pattern);

		return $pattern;
	}

	//*********************************************************************************

	/**
	 * Заполняет массив $_GET переменными (и их значениями), которые берет из пользовательского шаблона, указанного в правилах адресации
	 *
	 * @param string $pattern Паттерн пользователя, т.е. та строка, котора указан при формировании правил адресации
	 * @param string $normalPattern Паттерн приведенный к виду используемому в стандартных функциях работы с регулярными выражениями
	 * */
	private function setGETArray($pattern, $normalPattern)
	{
		if(mb_strpos($pattern, "{") !== false)
		{
			//Массив вида "значение" => "переменная"
			$valueArray = array();

			//Выбираем имена всех переменных
			preg_match_all("#\/{([a-z0-9_]+):#iu", $pattern, $matchesValueNameArray, PREG_PATTERN_ORDER);

			//Выбираем значения всех переменных
			preg_match("#^".$normalPattern."$#iu", $this->objSURI->requestURI, $matchesValueArray);

			for($i = 0; $i < count($matchesValueNameArray[1]); $i++)
			{
				//Собираем имена переменных и их значения в массив
    			$valueArray[$matchesValueNameArray[1][$i]] = $matchesValueArray[$i + 1];
			}

			//Заполняем глобальный массив $_GET значениями
			$_GET = array_merge($_GET, $valueArray);
		}
	}

	//*********************************************************************************
}

?>