<?php

class CAAdminSetMarkData extends CAjaxInit
{
	//*********************************************************************************

	private $dataId = null;

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
        $this->setMarkKey();

		$key = (1 === (int)$this->vars["markValue"]) ? 0 : 1;
		$addClass = (1 === (int)$this->vars["markValue"]) ? "on" : "off";
    
        $data = array
        (
        	"dataId" => $this->vars["dataId"],
        	"markName" => $this->vars["markName"],
        	"html" => $this->objSTemplate->getHtml("adminData", "mark", array("id" => $this->vars["dataId"], "key" => $key, "name" => $this->vars["markName"], "addClass" => $addClass, )),
        );

	 
		$this->objSOutput->ok("Ок", $data);
	}

	//*********************************************************************************
	
	private function setMarkKey()
	{
		$objMData = MData::getInstance();
        
        $data = array
		(
			$this->vars["markName"] => $this->vars["markValue"],
		);
        
        $objMData->edit($this->vars["dataId"], $data);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMData = MData::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [dataId]",
			Validation::isNum => "Некоректные данные [dataId]",
		);

		$this->objValidation->checkVars("dataId", $rules, $_POST);

  		//Проверяем существование с таким id
  		if ((0 !== (int)$this->objValidation->vars["dataId"]) AND !$objMData->isExist($this->objValidation->vars["dataId"]))
  		{
  			$this->objSOutput->critical("Товара с таким id не существует");
  		}

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [markValue]",
			Validation::isNum => "Некоректные данные [markValue]",
		);

		$this->objValidation->checkVars("markValue", $rules, $_POST);

        if ((int)$this->objValidation->vars["markValue"] !== 0 AND (int)$this->objValidation->vars["markValue"] !== 1)
        {
            $this->objSOutput->error("Некоректные данные [markValue]");
        }

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [markName]",
			Validation::isString => "Некоректные данные [markName]",
		);

		$this->objValidation->checkVars("markName", $rules, $_POST);

        if
        (
            Func::mb_strcmp("newOffersKey", $this->objValidation->vars["markName"]) !== 0
            AND
            Func::mb_strcmp("promotionalOffersKey", $this->objValidation->vars["markName"]) !== 0
            AND
            Func::mb_strcmp("salesLeadersKey", $this->objValidation->vars["markName"]) !== 0
        )
        {
            $this->objSOutput->error("Некоректные данные [markName]");
        }

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>