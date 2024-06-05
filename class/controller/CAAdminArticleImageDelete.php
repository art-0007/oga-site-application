<?php

class CAAdminArticleImageDelete extends CAjaxInit
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
		if (!is_array($this->vars["articleImageId"]))
 		{
			$this->vars["articleImageId"] = array($this->vars["articleImageId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->delete();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Изображения статьи удалены", array("articleImageId" => $this->vars["articleImageId"]));
	}

	//*********************************************************************************

	private function delete()
	{
		$objMArticleImage = MArticleImage::getInstance();

		foreach ($this->vars["articleImageId"] AS $articleImageId)
		{
	  		if (false === $objMArticleImage->isExist($articleImageId))
	  		{
	  			$this->objSOutput->critical("Изображения статьи с таким id не существует [".$articleImageId."]");
	  		}
		}

		foreach ($this->vars["articleImageId"] AS $articleImageId)
		{
			$articleImageInfo = $objMArticleImage->getInfo($articleImageId);

			@unlink(PATH.GLOB::$SETTINGS["articleImgDir"]."/".$articleImageInfo["fileName"]);

			//Удаляем
			$objMArticleImage->delete($articleImageId);
		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [articleImageId]",
		);

		$this->objValidation->checkVars("articleImageId", $rules, $_POST);

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>