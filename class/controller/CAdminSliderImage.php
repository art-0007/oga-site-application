<?php

class CAdminSliderImage extends CMainAdminFancyBoxInit
{
	//*********************************************************************************
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
		$objMSliderImage = MSliderImage::getInstance();
		$pageTitleH1 = "Слайдер";
		$toolbarButton = "";
		$tableHeader = "";
		$addSliderImageCatalogHref = "href=\"/admin/slider-image-catalog/add/".$this->vars["sliderImageCatalogId"]."/\"";
		$addSliderImageHref = "href=\"/admin/slider-image/add/".$this->vars["sliderImageCatalogId"]."/\"";

		if ((int)$this->vars["sliderImageCatalogId"] !== 0)
		{
			$sliderImageCatalogInfo = 	$objMSliderImageCatalog->getInfo($this->vars["sliderImageCatalogId"]);

			$pageTitleH1 = "Каталог: \"".$sliderImageCatalogInfo["title"]."\"";

			$data = array
	  		(
	  			"sliderImageCatalogId" => $sliderImageCatalogInfo["sliderImageCatalog_id"],
	  		);
			$toolbarButton = $this->objSTemplate->getHtml("adminSliderImage", "toolbarButton", $data);
		}

		if ($objMSliderImageCatalog->hasChild($this->vars["sliderImageCatalogId"]))
		{
			$addSliderImageHref = "href=\"javascript: void(0);\" onclick=\"alert('Создание слайдера заблокировано. Каталог имеет дочерние каталоги');\"";
			$tableHeader = $this->objSTemplate->getHtml("adminSliderImage", "tableHeader_catalog");
		}
		else
		{
			if ($objMSliderImage->isExistBySliderImageCatalogId($this->vars["sliderImageCatalogId"]))
			{
				$addSliderImageCatalogHref = "href=\"javascript: void(0);\" onclick=\"alert('Создание каталога заблокировано. Каталог имеет изображения слайдера');\"";
			}

			$tableHeader = $this->objSTemplate->getHtml("adminSliderImage", "tableHeader_sliderImage");
		}

		$data = array
		(
  			"pageTitleH1" => $pageTitleH1,
  			"sliderImageCatalogId" => $this->vars["sliderImageCatalogId"],

			"addSliderImageCatalogHref" => $addSliderImageCatalogHref,
			"addSliderImageHref" => $addSliderImageHref,

			"toolbarButton" => $toolbarButton,
  			"tableHeader" => $tableHeader,
  			"sliderImageContent" => $this->getSliderImageContentHtml(),
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminSliderImage", "content", $data);
 	}

	//*********************************************************************************

	private function getSliderImageContentHtml()
	{
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();

		if ($objMSliderImageCatalog->hasChild($this->vars["sliderImageCatalogId"]))
		{
			return $this->getSliderImageCatalogListHtml();
		}
		else
		{
			return $this->getSliderImageListHtml();
		}
	}

	//*********************************************************************************

	private function getSliderImageCatalogListHtml()
	{
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();
		$html = "";

		if (false === ($res = $objMSliderImageCatalog->getList($this->vars["sliderImageCatalogId"])))
		{
			return $this->objSTemplate->getHtml("adminSliderImage", "sliderImageCatalogList_empty");
		}

		$count = 0;
		foreach ($res AS $row)
		{
			$count++;
			if (0 === ($count % 2))
			{
				$zebra = "zebra";
			}
			else
			{
				$zebra = "";
			}

			$data = array
	   		(
	   			"id" => $row["id"],
	   			"href" => "/admin/slider-image/".$row["id"]."/",
	   			"title" => $row["title"],
	   			"devName" => $row["devName"],
	   			"position" => $row["position"],
	   			"zebra" => $zebra,
	   		);

			$html .= $this->objSTemplate->getHtml("adminSliderImage", "sliderImageCatalogListItem", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function getSliderImageListHtml()
	{
		$objMSliderImage = MSliderImage::getInstance();
		$html = "";

		if (false === ($res = $objMSliderImage->getList($this->vars["sliderImageCatalogId"])))
		{
			return $this->objSTemplate->getHtml("adminSliderImage", "sliderImageList_empty");
		}

		$count = 0;
		foreach ($res AS $row)
		{
			$count++;
			if (0 === ($count % 2))
			{
				$zebra = "zebra";
			}
			else
			{
				$zebra = "";
			}

			$data = array
	   		(
	   			"id" => $row["id"],
				"imgSrc" => GLOB::$SETTINGS["sliderImgDir"]."/".$row["fileName"],
	   			"title" => $row["title"],
	   			"href" => $row["href"],
	   			"position" => $row["position"],
	   			"show" => (0 === (int)$row["showKey"]) ? "Нет" : "",
	   			"zebra" => $zebra,
	   		);

			$html .= $this->objSTemplate->getHtml("adminSliderImage", "sliderImageListItem", $data);
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
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-slider-image-catalog.js");
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

		if ((int)$this->objValidation->vars["sliderImageCatalogId"] !== 0 AND !$objMSliderImageCatalog->isExist($this->objValidation->vars["sliderImageCatalogId"]))
		{
			$this->objSOutput->critical("Каталога слайдера не найдено в базе данных");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>