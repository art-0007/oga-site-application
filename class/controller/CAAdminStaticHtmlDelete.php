<?php

class CAAdminStaticHtmlDelete extends CAjaxInit
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
		if (!is_array($this->vars["staticHtmlId"]))
 		{
			$this->vars["staticHtmlId"] = array($this->vars["staticHtmlId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->deleteStaticHtml();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Статические html`и удалены", array("staticHtmlId" => $this->vars["staticHtmlId"]));
	}

	//*********************************************************************************

	private function deleteStaticHtml()
	{
		$objMStaticHtml = MStaticHtml::getInstance();

		foreach ($this->vars["staticHtmlId"] AS $staticHtmlId)
		{
	  		if (false === $objMStaticHtml->isExist($staticHtmlId))
	  		{
	  			$this->objSOutput->critical("Статического html`я с таким id не существует [".$staticHtmlId."]");
	  		}
		}

		foreach ($this->vars["staticHtmlId"] AS $staticHtmlId)
		{
			//Удаляем
			$objMStaticHtml->delete($staticHtmlId);
		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [staticHtmlId]",
		);

		$this->objValidation->checkVars("staticHtmlId", $rules, $_POST);

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>