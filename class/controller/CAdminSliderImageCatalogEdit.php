<?php

class CAdminSliderImageCatalogEdit extends CMainAdminFancyBoxInit
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

		if (false === $sliderImageCatalogInfo = $objMSliderImageCatalog->getInfo($this->vars["sliderImageCatalogId"]))
		{
			$this->objSOutput->critical("Ошибка выборки информации о каталоге слайдера из БД [".$this->vars["sliderImageCatalogId"]."]");
		}

		$data = array
		(
  			"pageTitleH1" => "Редактирование каталога \"".$sliderImageCatalogInfo["title"]."\"",
  			"sliderImageCatalogId" => $sliderImageCatalogInfo["id"],
  			"sliderImageCatalog_id" => $sliderImageCatalogInfo["sliderImageCatalog_id"],
			"devName" => $sliderImageCatalogInfo["devName"],
			"position" => $sliderImageCatalogInfo["position"],
			"title" => $sliderImageCatalogInfo["title"],
			"imgWidth_1" => $sliderImageCatalogInfo["imgWidth_1"],
			"imgHeight_1" => $sliderImageCatalogInfo["imgHeight_1"],

  			"submitButtonTitle" => "Редактировать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminSliderImage", "adminSliderImageCatalogEdit", $data);
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
		if (!$objMSliderImageCatalog->isExist($this->objValidation->vars["sliderImageCatalogId"]))
		{
			$this->objSOutput->critical("Каталог слайдера не найдено в базе данных");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>