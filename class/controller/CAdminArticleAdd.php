<?php

class CAdminArticleAdd extends CMainAdminFancyBoxInit
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
		$objMArticleCatalog = MArticleCatalog::getInstance();

		$articleCatalogInfo = $objMArticleCatalog->getInfo($this->vars["articleCatalogId"]);

		$data = array
		(
  			"pageTitleH1" => "Создание статьи в каталоге: \"".$articleCatalogInfo["title"]."\"",
  			"articleCatalogId" => $this->vars["articleCatalogId"],

  			"submitButtonTitle" => "Создать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminArticle", "adminArticleAdd", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-article.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [articleCatalogId]",
			Validation::isNum => "Некоректные данные [articleCatalogId]",
		);

		$this->objValidation->checkVars("articleCatalogId", $rules, $_GET);

 		//Проверяем существование с таким id
		if (!$objMArticleCatalog->isExist($this->objValidation->vars["articleCatalogId"]))
		{
			$this->objSOutput->critical("Каталог статей не найдено в базе данных");
		}

		//-----------------------------------------------------------------------------------

 		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>