<?php

class CASubscribeFormShow extends CAjaxInit
{
	//*********************************************************************************
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		//$this->setInputVars();
		$this->init();
	}

	//*********************************************************************************

 	private function init()
 	{
	    $objStaticHtml = StaticHtml::getInstance();

	    $data =
	    [
		    "modalHtml" => $objStaticHtml->replaceInString($this->objSTemplate->getHtml("form", "subscribeForm")),
	    ];

	    $this->objSOutput->ok("Ок", $data);
 	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------
		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>