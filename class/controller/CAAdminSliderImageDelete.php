<?php

class CAAdminSliderImageDelete extends CAjaxInit
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
		if (!is_array($this->vars["sliderImageId"]))
 		{
			$this->vars["sliderImageId"] = array($this->vars["sliderImageId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->delete();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Изображения слайдера удалены", array("sliderImageId" => $this->vars["sliderImageId"]));
	}

	//*********************************************************************************

	private function delete()
	{
		$objMSliderImage = MSliderImage::getInstance();

		foreach ($this->vars["sliderImageId"] AS $sliderImageId)
		{
	  		if (false === $objMSliderImage->isExist($sliderImageId))
	  		{
	  			$this->objSOutput->critical("Изображения слайдера с таким id не существует [".$sliderImageId."]");
	  		}
		}

		foreach ($this->vars["sliderImageId"] AS $sliderImageId)
		{
			$sliderImageInfo = $objMSliderImage->getInfo($sliderImageId);

			@unlink(PATH.GLOB::$SETTINGS["sliderImgDir"]."/".$sliderImageInfo["fileName"]);

			//Удаляем
			$objMSliderImage->delete($sliderImageId);
		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [sliderImageId]",
		);

		$this->objValidation->checkVars("sliderImageId", $rules, $_POST);

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>