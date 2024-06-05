<?php

class CAAdminSliderImageAdd extends CAjaxInit
{
	//*********************************************************************************

	private $sliderImageId = null;

	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

 		$this->setInputVars();
		$this->init();
	}

	//*********************************************************************************

 	private function init()
 	{
		$this->objMySQL->startTransaction();

		$this->add();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Слайдер создан", array("sliderImageId" => $this->sliderImageId));

	}

	//*********************************************************************************

	private function add()
	{
		$objMSliderImage = MSliderImage::getInstance();

		//Проверяем существование с таким title
		if (true === $objMSliderImage->isExistByTitle($this->vars["title"], null, $this->vars["sliderImageCatalogId"]))
		{
			$this->objSOutput->error("Cлайдер с таким наименованием уже существует в текущем каталоге");
		}

  		$data = array
		(
			"sliderImageCatalog_id" => $this->vars["sliderImageCatalogId"],
			"position" => $objMSliderImage->getMaxPosition($this->vars["sliderImageCatalogId"]) + 1,
		);

  		$this->sliderImageId = $objMSliderImage->addAndReturnId($data);

		//Языковая
  		$data = array
		(
			"sliderImage_id" => $this->sliderImageId,
			"lang_id" => GLOB::$langId,
			"title" => $this->vars["title"],
		);
  		$objLang = Lang::getInstance();
  		$objLang->insertLangDataInDB(DB_sliderImageLang, $data);
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
		$this->objValidation->checkVars("sliderImageCatalogId", $rules, $_POST);

 		//Проверяем существование с таким id
		if (!$objMSliderImageCatalog->isExist($this->objValidation->vars["sliderImageCatalogId"]))
		{
			$this->objSOutput->critical("Каталога слайдеров с таким id не существует [".$this->objValidation->vars["sliderImageCatalogId"]."]");
		}

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [title]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите наименование изображения слайдера",
		);

		$this->objValidation->checkVars("title", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>