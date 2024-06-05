<?php

class CAdminSliderImageAdd extends CMainAdminFancyBoxInit
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
		$data = array
		(
  			"pageTitleH1" => "Создание изображения слайдера",
  			"sliderImageCatalogId" => $this->vars["sliderImageCatalogId"],

  			"submitButtonTitle" => "Создать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminSliderImage", "adminSliderImageAdd", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-slider-image.js");
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
		if (!$objMSliderImageCatalog->isExist($this->objValidation->vars["sliderImageCatalogId"]))
		{
			$this->objSOutput->critical("Каталога слайдеров с таким id не существует [".$this->objValidation->vars["sliderImageCatalogId"]."]");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;

	}

	//*********************************************************************************
}

?>