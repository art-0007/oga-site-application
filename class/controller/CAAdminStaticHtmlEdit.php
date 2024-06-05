<?php

class CAAdminStaticHtmlEdit extends CAjaxInit
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

		$this->editStaticHtml();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Статический html отредактирован");

	}

	//*********************************************************************************

	private function editStaticHtml()
	{
		$objMStaticHtml = MStaticHtml::getInstance();

  		//Проверяем существование с таким наименованием
  		if (true === $objMStaticHtml->isExistByName($this->vars["name"], $this->vars["staticHtmlId"]))
  		{
  			$this->objSOutput->error("Статический html с таким наименованием уже существует");
  		}

  		$data = array
		(
			"name" => $this->vars["name"],
			"autoReplaceKey" => (true === $this->vars["autoReplaceKey"]) ? "1" : "0",
		);

  		$objMStaticHtml->edit($this->vars["staticHtmlId"], $data);

		//Редактируем строки в языковозависимой таблице
		$data = array
		(
			"html" => $this->vars["html"],
		);

		$objMStaticHtml->editLang($this->vars["staticHtmlId"], $this->vars["langId"], $data);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMStaticHtml = MStaticHtml::getInstance();
		$objMLang = MLang::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [staticHtmlId]",
			Validation::isNum => "Некоректные данные [staticHtmlId]",
		);
		$this->objValidation->checkVars("staticHtmlId", $rules, $_POST);

 		//Проверяем существование с таким id
  		if (false === $objMStaticHtml->isExist($this->objValidation->vars["staticHtmlId"]))
  		{
  			$this->objSOutput->critical("Статического html`я с таким id не существует [".$this->objValidation->vars["staticHtmlId"]."]");
  		}

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [langId]",
			Validation::isNum => "Некоректные данные [langId]",
		);
		$this->objValidation->checkVars("langId", $rules, $_POST);

		//Проверяем существование с таким id
		if (false === $objMLang->isExist($this->objValidation->vars["langId"]))
		{
			$this->objSOutput->critical("Языка с таким id не существует [".$this->objValidation->vars["langId"]."]");
		}

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