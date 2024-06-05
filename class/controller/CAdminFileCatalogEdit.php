<?php

class CAdminFileCatalogEdit extends CMainAdminFancyBoxInit
{
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		//$this->setCSS();
		$this->setJavaScript();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$objMFileCatalog = MFileCatalog::getInstance();

		if (false === $fileCatalogInfo = $objMFileCatalog->getInfo($this->vars["fileCatalogId"]))
		{
			Error::message("STOP");
		}

		$data = array
		(
  			"pageTitleH1" => "Редактирование каталога файдлов \"".$fileCatalogInfo["title"]."\"",
  			"fileCatalogId" => $fileCatalogInfo["id"],
			"title" => $fileCatalogInfo["title"],
			"devName" => $fileCatalogInfo["devName"],
			"fileCatalog_id" => $fileCatalogInfo["fileCatalog_id"],

  			"submitButtonTitle" => "Редактировать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminFile", "adminFileCatalogEdit", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-file-catalog.js");
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

		$this->objValidation->checkVars("fileCatalogId", $rules, $_GET);

 		//Проверяем существование с таким id
		if (!$objMFileCatalog->isExist($this->objValidation->vars["fileCatalogId"]))
		{
			$this->objSOutput->critical("Каталога файлов с таким id не существует [".$this->objValidation->vars["fileCatalogId"]."]");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>