<?php

class CAAdminSliderImageCatalogDelete extends CAjaxInit
{
	//*********************************************************************************
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
		if (!is_array($this->vars["sliderImageCatalogId"]))
 		{
			$this->vars["sliderImageCatalogId"] = array($this->vars["sliderImageCatalogId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->delete();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Каталоги удалены", array("sliderImageCatalogId" => $this->vars["sliderImageCatalogId"]));
	}

	//*********************************************************************************

	private function delete()
	{
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();
		$objMSliderImage = MSliderImage::getInstance();

 		foreach($this->vars["sliderImageCatalogId"] AS $sliderImageCatalogId)
  		{
	  		//Проверяем существование с таким id
	  		if (false === $objMSliderImageCatalog->isExist($sliderImageCatalogId))
	  		{
	  			$this->objSOutput->critical("Каталога с таким id не существует");
	  		}

	  		//Проверяем базовый ли каталог
	  		if (true === $objMSliderImageCatalog->isBase($sliderImageCatalogId))
	  		{
	  			$this->objSOutput->error("Удаление невозможно! Каталог является базовым");
	  		}

	  		//Проверяем существование дочерних каталогов
	  		if (true === $objMSliderImageCatalog->hasChild($sliderImageCatalogId))
	  		{
	  			$this->objSOutput->error("Удаление невозможно! Каталог содержит дочерние каталоги");
	  		}

	  		//Проверяем существование файлов в каталоге
	  		if (true === $objMSliderImage->isExistBySliderImageCatalogId($sliderImageCatalogId))
	  		{
				$this->objSOutput->error("Удаление невозможно! Каталог содержит изображения слайдера");
	  		}
		}

 		foreach($this->vars["sliderImageCatalogId"] AS $sliderImageCatalogId)
  		{
			//Удаляем указанный каталог
	  		$objMSliderImageCatalog->delete($sliderImageCatalogId);
 		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [sliderImageCatalogId]",
		);

		$this->objValidation->checkVars("sliderImageCatalogId", $rules, $_POST);

 		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>