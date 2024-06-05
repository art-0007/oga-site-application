<?php

class CAdminArticleCatalogAdd extends CMainAdminFancyBoxInit
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
		$pageTitleH1 = "Создание родительского каталога";

		if ((int)$this->vars["articleCatalogId"] !== 0)
		{
			$articleCatalogInfo = $objMArticleCatalog->getInfo($this->vars["articleCatalogId"]);

			$pageTitleH1 = "Создание каталога в каталоге: \"".$articleCatalogInfo["title"]."\"";
		}

		$data = array
		(
  			"pageTitleH1" => $pageTitleH1,
  			"articleCatalogId" => $this->vars["articleCatalogId"],

  			"orderInCatalogSelect" => $this->getOrderInCatalogSelectHtml(),

  			"submitButtonTitle" => "Создать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminArticle", "adminArticleCatalogAdd", $data);
 	}

	//*********************************************************************************

	private function getOrderInCatalogSelectHtml()
	{
		$html = "";

		foreach(EOrderInArticleCatalogType::$orderInArticleCatalogTypeTitleArray AS $index => $value)
		{
			$html .= "<option value='".$index."'>".$value."</option>";
		}

		return $html;
	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-article-catalog.js");
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
		if ((int)$this->objValidation->vars["articleCatalogId"] !== 0 AND !$objMArticleCatalog->isExist($this->objValidation->vars["articleCatalogId"]))
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