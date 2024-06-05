<?php

class CAAdminLangAdd extends CAjaxInit
{
	//*********************************************************************************

	/** @var array Массив имен таблиц, которые будет исключены из процесса дублирования в процессе создания языка */
	private $excludeLangTablesArray = [];

	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

 		$this->setInputVars();
		$this->init();
	}

	//*********************************************************************************

 	private function init()
 	{
		$this->objMySQL->startTransaction();

		$langId = $this->add();

		$this->objMySQL->commit();

		$data = array
  		(
  			"langId" => $langId,
  		);

		$this->objSOutput->ok("Язык создан", $data);
	}

	//*********************************************************************************

	private function add()
	{
		$objMLang = MLang::getInstance();

		//Проверяем существование с таким именем
		if (true === $objMLang->isExistByName($this->vars["name"]))
		{
			$this->objSOutput->error("Язык с таким именем уже существует");
		}

		//Проверяем существование с таким кодом
		if (true === $objMLang->isExistByCode($this->vars["code"]))
		{
			$this->objSOutput->error("Язык с таким кодом уже существует");
		}

  		$data = array
		(
			"name" => $this->vars["name"],
			"code" => $this->vars["code"],
		);
  		$langId = $objMLang->addAndReturnId($data);

		//Дублируем строки языковозависимых таблиц языка источника
		$this->duplicateLangRows($this->vars["langId"], $langId);

		return $langId;
	}

	//*********************************************************************************

	/**
	 * Дублирует строки языковозависимых таблиц языка источника
	 *
	 * @param int $duplicationLangId ИД языка для дублирования данных
	 * @param int $dstLangId ИД языка назначения
	 */
	private function duplicateLangRows($duplicationLangId, $dstLangId)
	{
		//Выполняем запрос посредством стандартных функций, чтобы иметь возможность обратится к столбцу результата по числовому индексу, так как имя его мы не знаем (ну узнать можно конечно, но не так надежно)
		//$query = "SHOW TABLES WHERE (`Tables_in_astrid` = 'dataMarkLang' OR `Tables_in_astrid` = 'bannerLang')";
		$query = "SHOW TABLES";
		$res = @mysqli_query(MySQL::$db, $query);

		if (false === $res)
		{
			$this->objSOutput->critical("Failed to load tables");
		}

		if (0 === mysqli_num_rows($res))
		{
			$this->objSOutput->critical("Failed to load lang tables");
		}

		while($row = mysqli_fetch_array($res))
		{
			//Отбираем только таблицы с окончанием "Lang"

			//ВНИМАНИЕ! В регулярном выражении не должно быть модификатора "i", так как в нем должен учитываться регистр
			if (false === ($res_pregMath = preg_match("#^.+Lang$#u", $row[0])))
			{
				//Ошибка в составлении регулярного выражения
				$this->objSOutput->critical("Wrong RegExp for table name");
			}

			//Исключаем некоторые таблицы с окончанием "Lang"
			if (in_array($row[0], $this->excludeLangTablesArray)) continue;

			//Если таблица содержит окончание "Lang", то выполняем дублирование необходимых строк данной таблицы
			if (1 === $res_pregMath)
			{
				$this->duplicateLangRows_copyTableRows($row[0], $duplicationLangId, $dstLangId);
			}
		}
	}

	//*********************************************************************************

	/**
	 * Производит копирование строк языковозависимых таблиц. Дублируются часть строк, которые соответствуют языку источнику ($langSrcId)
	 *
	 * @param string $tableName Имя таблицы, в которой производится дублирование части строк
	 * @param int $duplicationLangId ИД языка для дублирования данных
	 * @param int $dstLangId ИД языка назначения
	 * */
	private function duplicateLangRows_copyTableRows($tableName, $duplicationLangId, $dstLangId)
	{
		$tempTableName = "TEMP_".$tableName;

		//[1] Создается временная таблица, в которую помещаются все строки для языка источника
		$query = "CREATE TEMPORARY TABLE `".$tempTableName."` AS SELECT * FROM `".$tableName."` WHERE `lang_id` = '".Func::bb($duplicationLangId)."'";
		$this->objMySQL->query($query);

		//[2] Во временной таблице производится замена идентификатора языка на создаваемый язык
		$query = "UPDATE `".$tempTableName."` SET `lang_id`='".Func::bb($dstLangId)."'";
		$this->objMySQL->query($query);

		//[3] Все строки во временной таблице вставляем в таблицу назначения
		$query = "INSERT INTO `".$tableName."` SELECT * FROM `".$tempTableName."`";
		$this->objMySQL->query($query);

		//[4] Удаляем временную таблицу
		$query = "DROP TABLE `".$tempTableName."`";
		$this->objMySQL->query($query);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMLang = MLang::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [langId]",
			Validation::isNum => "Некоректные данные [langId]",
		);

		$this->objValidation->checkVars("langId", $rules, $_POST);

 		//Проверяем существование с таким id
		if (!$objMLang->isExist($this->objValidation->vars["langId"]))
		{
			$this->objSOutput->critical("Языка с таким id не существует [".$this->objValidation->vars["langId"]."]");
		}

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [name]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите имя языка",
		);

		$this->objValidation->checkVars("name", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [code]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите код языка",
		);

		$this->objValidation->checkVars("code", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>