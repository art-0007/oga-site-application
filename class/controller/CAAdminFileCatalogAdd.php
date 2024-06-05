<?php

class CAAdminFileCatalogAdd extends CAjaxInit
{
	//*********************************************************************************
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

		$this->add();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Каталог создан", array("fileCatalogId" => $this->vars["fileCatalogId"]));

	}

	//*********************************************************************************

	private function add()
	{
		$objMFileCatalog = MFileCatalog::getInstance();

		//Проверяем существование с таким title
		if (true === $objMFileCatalog->isExistByTitle($this->vars["title"]))
		{
			$this->objSOutput->error("Каталог с таким наименованием уже существует");
		}

		$time = time();

  		$data = array
		(
			"fileCatalog_id" => $this->vars["fileCatalogId"],
			"title" => $this->vars["title"],
			"devName" => $this->vars["devName"],
			"time" => $time,
		);

  		$objMFileCatalog->add($data);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMFileCatalog = MFileCatalog::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [fileCatalogId]",
			Validation::isNum => "Некоректные данные [fileCatalogId]",
		);

		$this->objValidation->checkVars("fileCatalogId", $rules, $_POST);

 		//Проверяем существование с таким id
		if (!$objMFileCatalog->isExist($this->objValidation->vars["fileCatalogId"]))
		{
			$this->objSOutput->critical("Каталога файлов с таким id не существует [".$this->objValidation->vars["fileCatalogId"]."]");
		}

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [title]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите наименование каталога",
		);

		$this->objValidation->checkVars("title", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [devName]",
			Validation::trim => "",
		);

		$this->objValidation->checkVars("devName", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>