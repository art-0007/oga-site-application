<?php

class CAAdminFileCatalogEdit extends CAjaxInit
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

		$this->edit();

		$this->objMySQL->commit();

		$objMFileCatalog = MFileCatalog::getInstance();

		if (false === $fileCatalogInfo = $objMFileCatalog->getInfo($this->vars["fileCatalogId"]))
		{
			Error::message("STOP");
		}

		$this->objSOutput->ok("Каталог отредактирован", array("fileCatalogId" => $fileCatalogInfo["fileCatalog_id"]));

	}

	//*********************************************************************************

	private function edit()
	{
		$objMFileCatalog = MFileCatalog::getInstance();

		//Проверяем существование с таким title
		if (true === $objMFileCatalog->isExistByTitle($this->vars["title"], $this->vars["fileCatalogId"]))
		{
			$this->objSOutput->error("Каталог с таким наименованием уже существует");
		}

		$time = time();

  		$data = array
		(
			"title" => $this->vars["title"],
			"devName" => $this->vars["devName"],
		);

  		$objMFileCatalog->edit($this->vars["fileCatalogId"], $data);
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