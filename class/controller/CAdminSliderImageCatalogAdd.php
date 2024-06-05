<?php

class CAdminSliderImageCatalogAdd extends CMainAdminFancyBoxInit
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
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();
		$pageTitleH1 = "Создание родительского каталога";

		if ((int)$this->vars["sliderImageCatalogId"] !== 0)
		{
			$sliderImageCatalogInfo = $objMSliderImageCatalog->getInfo($this->vars["sliderImageCatalogId"]);

			$pageTitleH1 = "Создание каталога в каталоге: \"".$sliderImageCatalogInfo["title"]."\"";
		}

		$data = array
		(
  			"pageTitleH1" => $pageTitleH1,
  			"sliderImageCatalogId" => $this->vars["sliderImageCatalogId"],
  			"sliderImageCatalog_id" => (0 === (int)$this->vars["sliderImageCatalogId"]) ? 0 : $this->vars["sliderImageCatalog_id"],

  			"submitButtonTitle" => "Создать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminSliderImage", "adminSliderImageCatalogAdd", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-slider-image-catalog.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [sliderImageCatalogId]",
			Validation::isNum => "Некоректные данные [sliderImageCatalogId]",
		);

		$this->objValidation->checkVars("sliderImageCatalogId", $rules, $_GET);

 		//Проверяем существование с таким id
		if ((int)$this->objValidation->vars["sliderImageCatalogId"] !== 0 AND !$objMSliderImageCatalog->isExist($this->objValidation->vars["sliderImageCatalogId"]))
		{
			$this->objSOutput->critical("Каталог слайдеров не найдено в базе данных");
		}

		//-----------------------------------------------------------------------------------

 		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>