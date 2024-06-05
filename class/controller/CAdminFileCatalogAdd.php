<?php

class CAdminFileCatalogAdd extends CMainAdminFancyBoxInit
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

		$fileCatalogInfo = 	$objMFileCatalog->getInfo($this->vars["fileCatalogId"]);

		$data = array
		(
  			"pageTitleH1" => "Создание каталога в каталоге: \"".$fileCatalogInfo["title"]."\"",
  			"fileCatalogId" => $this->vars["fileCatalogId"],

  			"submitButtonTitle" => "Создать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminFile", "adminFileCatalogAdd", $data);
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
			$this->objSOutput->critical("Каталог файлов не найдено в базе данных");
		}

		//-----------------------------------------------------------------------------------

 		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>