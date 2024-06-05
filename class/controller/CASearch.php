<?php

class CASearch extends CAjaxInit
{
	//*********************************************************************************

	private $redirectUrl = "";

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
		$data = array
  		(
  			"searchString" => urlencode($this->vars["searchString"]),
  			"redirectUrl" => $this->redirectUrl,
  		);

  		$this->objSOutput->ok("Ok", $data);
 	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();
		$objMData = MData::getInstance();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [searchString]",
		);
		$this->objValidation->checkVars("searchString", $rules, $_POST);

		if (Reg::isNum($this->objValidation->vars["searchString"]) AND $objMData->isExist($this->objValidation->vars["searchString"]))
		{
			$this->redirectUrl = "http://".$_SERVER["HTTP_HOST"]."/product/".$this->objValidation->vars["searchString"]."/";
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>