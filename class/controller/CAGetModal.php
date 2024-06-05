<?php

class CAGetModal extends CAjaxInit
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
	    $objModal = Modal::getInstance();

	    $data =
	    [
		    "modalHtml" => $objModal->get_modalHtml($this->vars["modalTitle"], $this->vars["modalBody"]),
	    ];

	    $this->objSOutput->ok("Ок", $data);
 	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$this->objValidation->vars["modalTitle"] = null;
		$this->objValidation->vars["modalBody"] = null;

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [modalTitle]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("modalTitle", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [modalBody]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("modalBody", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>