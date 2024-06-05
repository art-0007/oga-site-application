<?php

class CAAdminSliderImageCatalogAdd extends CAjaxInit
{
	//*********************************************************************************

	private $sliderImageCatalogId = null;

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

		$this->objSOutput->ok("Каталог создан", array("sliderImageCatalogId" => $this->sliderImageCatalogId));

	}

	//*********************************************************************************

	private function add()
	{
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();

		//Проверяем существование с таким title
		if (true === $objMSliderImageCatalog->isExistByTitle($this->vars["title"]))
		{
			$this->objSOutput->error("Каталог с таким наименованием уже существует");
		}

  		$data = array
		(
			"sliderImageCatalog_id" => $this->vars["sliderImageCatalogId"],
			"position" => $objMSliderImageCatalog->getMaxPosition($this->vars["sliderImageCatalogId"]) + 1,
		);

		$this->sliderImageCatalogId = $objMSliderImageCatalog->addAndReturnId($data);

		//Языковая
		$data = array
		(
			"sliderImageCatalog_id" => $this->sliderImageCatalogId,
			"title" => $this->vars["title"],
		);
		$objLang = Lang::getInstance();
		$objLang->insertLangDataInDB(DB_sliderImageCatalogLang, $data);
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
		if ((int)$this->objValidation->vars["sliderImageCatalogId"] !== 0 AND !$objMSliderImageCatalog->isExist($this->objValidation->vars["sliderImageCatalogId"]))
		{
			$this->objSOutput->critical("Каталога слайдеров с таким id не существует [".$this->objValidation->vars["sliderImageCatalogId"]."]");
		}

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [title]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите наименование каталога",
		);
		$this->objValidation->checkVars("title", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>