<?php

class CAAdminAvailabilityData extends CAjaxInit
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
        $objMData = MData::getInstance();

        if ($objMData->isAvailable($this->vars["dataId"]))
        {
            $this->setAvailabilityKey(1);
            $addClass = "no";
        }
        else
        {
            $this->setAvailabilityKey(0);
            $addClass = "yes";
        }

        $data = array
        (
        	"dataId" => $this->vars["dataId"],
        	"addClass" => $addClass,
        );
	 
		$this->objSOutput->ok("Ок", $data);
	}

	//*********************************************************************************
	
	private function setAvailabilityKey($notAvailableKey)
	{
		$objMData = MData::getInstance();
        
        $data = array
		(
			"notAvailableKey" => (int)$notAvailableKey,
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

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>