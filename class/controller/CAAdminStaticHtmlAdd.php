<?php

class CAAdminStaticHtmlAdd extends CAjaxInit
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

		$this->addStaticHtml();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Статический html создан");

	}

	//*********************************************************************************

	private function addStaticHtml()
	{
		$objMStaticHtml = MStaticHtml::getInstance();

  		//Проверяем существование с таким наименованием
  		if (true === $objMStaticHtml->isExistByName($this->vars["name"]))
  		{
  			$this->objSOutput->error("Статический html с таким наименованием уже существует");
  		}

  		$data = array
		(
			"name" => $this->vars["name"],
			"autoReplaceKey" => (true === $this->vars["autoReplaceKey"]) ? "1" : "0",
		);

  		$staticHtmlId = $objMStaticHtml->addAndReturnId($data);

		//Создаем строки в языковозависимой таблице

		$objLang = Lang::getInstance();

		$data = array
		(
			"staticHtml_id" => $staticHtmlId,
			"html" => $this->vars["html"],
		);

		$objLang->insertLangDataInDB(DB_staticHtmlLang, $data);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [name]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите имя переменной"
		);
		$this->objValidation->checkVars("name", $rules, $_POST);

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [html]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите значенние переменой"
		);
		$this->objValidation->checkVars("html", $rules, $_POST);

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::checkbox => "",
		);
		$this->objValidation->checkVars("autoReplaceKey", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>