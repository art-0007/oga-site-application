<?php

class CAAdminArticleOneImageDelete extends CAjaxInit
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
		$this->objMySQL->startTransaction();

		$this->delete();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Изображения статьи удалено");
	}

	//*********************************************************************************

	private function delete()
	{
		$objMArticle = MArticle::getInstance();

		$data[$this->vars["fieldName"]] = "";

		$objMArticle->editLang($this->vars["articleId"], $data);

		//Удаляем
		@unlink(PATH.$this->vars["imgSrc"]);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMArticle = MArticle::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [articleId]",
			Validation::isNum => "Некоректные данные [articleId]",
		);
		$this->objValidation->checkVars("articleId", $rules, $_POST);

 		//Проверяем существование с таким id
		if (!$objMArticle->isExist($this->objValidation->vars["articleId"]))
		{
			$this->objSOutput->critical("Статьи с таким id не существует [".$this->objValidation->vars["articleId"]."]");
		}

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [fieldName]",
		);

		$this->objValidation->checkVars("fieldName", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [imgSrc]",
		);

		$this->objValidation->checkVars("imgSrc", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>