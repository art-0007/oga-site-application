<?php

class CAdminFileAdd extends CMainAdminFancyBoxInit
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
  			"pageTitleH1" => "Загрузка файла хранилища в каталог: \"".$fileCatalogInfo["title"]."\"",
  			"fileCatalogId" => $this->vars["fileCatalogId"],

  			"submitButtonTitle" => "Загрузить",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminFile", "adminFileAdd", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-file.js");
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