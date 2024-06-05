<?php

class CAdminSliderImageEdit extends CMainAdminFancyBoxInit
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
		$objMSliderImage = MSliderImage::getInstance();
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();
		$objMLang = MLang::getInstance();

		//Достаем формацию о языке
		$langInfo = $objMLang->getInfo(GLOB::$langId);

		if (false === $sliderImageInfo = $objMSliderImage->getInfo($this->vars["sliderImageId"]))
		{
			Error::message("STOP");
		}

		$sliderImageCatalogInfo = $objMSliderImageCatalog->getInfo($sliderImageInfo["sliderImageCatalogId"]);

		$data =
		[
  			"pageTitleH1" => "Редактирование изображения слайдера \"".$sliderImageInfo["title"]."\"",
  			"sliderImageCatalogId" => $sliderImageInfo["sliderImageCatalogId"],
  			"sliderImageId" => $sliderImageInfo["id"],
  			"imgSrc" => GLOB::$SETTINGS["sliderImgDir"]."/".$sliderImageInfo["fileName"],
			"imgWidth_1" => $sliderImageCatalogInfo["imgWidth_1"],
			"imgHeight_1" => $sliderImageCatalogInfo["imgHeight_1"],
		    "title" => $sliderImageInfo["title"],
		    "position" => $sliderImageInfo["position"],
  			"href" => $sliderImageInfo["href"],
  			"onclick" => $sliderImageInfo["onclick"],
			"btnText" => $sliderImageInfo["btnText"],
			"description" => $sliderImageInfo["description"],
			"text" => $sliderImageInfo["text"],

			"showKey_checked" => (0 === (int)$sliderImageInfo["showKey"]) ? "" : "checked=\"checked\"",

  			"submitButtonTitle" => "Редактировать (".$langInfo["name"].")",
		];

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminSliderImage", "adminSliderImageEdit", $data);
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
		$objMSliderImage = MSliderImage::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [sliderImageId]",
			Validation::isNum => "Некоректные данные [sliderImageId]",
		);
		$this->objValidation->checkVars("sliderImageId", $rules, $_GET);

 		//Проверяем существование с таким id
  		if (false === $objMSliderImage->isExist($this->objValidation->vars["sliderImageId"]))
  		{
  			$this->objSOutput->critical("Изображения слайдера с таким id не существует [".$this->objValidation->vars["sliderImageId"]."]");
  		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>