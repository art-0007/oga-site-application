<?php

class CAAdminSetDataMark extends CAjaxInit
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
		$this->objMySQL->startTransaction();

		$this->setDataMark();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Ок");
	}

	//*********************************************************************************
	
	private function setDataMark()
	{
		$objMDataMark = MDataMark::getInstance();
		$objMDataMarkData = MDataMarkData::getInstance();
		
		if (false === ($res = $objMDataMark->getList()))
		{
			return;
		}

		foreach ($res AS $row)
		{
			$objMDataMarkData->delete($this->vars["dataId"], $row["id"]);
			
			if (isset($_POST["dataMark".$row["id"]]))
			{
				$data = array
		   		(
		   			"data_id" => $this->vars["dataId"],
		   			"dataMark_id" => $row["id"],
		   		);
	
				$objMDataMarkData->add($data);
			}
		}
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