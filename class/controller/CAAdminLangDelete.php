<?php

class CAAdminLangDelete extends CAjaxInit
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
		if (!is_array($this->vars["langId"]))
 		{
			$this->vars["langId"] = array($this->vars["langId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->delete();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Языки удалены", array("langId" => $this->vars["langId"]));
	}

	//*********************************************************************************

	private function delete()
	{
		$objMLang = MLang::getInstance();

 		foreach($this->vars["langId"] AS $langId)
  		{
	  		//Проверяем существование с таким id
	  		if (false === $objMLang->isExist($langId))
	  		{
	  			$this->objSOutput->critical("Языка с таким id не существует");
	  		}
		}

 		foreach($this->vars["langId"] AS $langId)
  		{
	 		$langInfo = $objMLang->getInfo($langId);

			@unlink(PATH.$langInfo["img"]);
			@unlink(PATH.$langInfo["imgBig"]);

			//Удаляем указанный каталог
	  		$objMLang->delete($langId);
  		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [langId]",
		);

		$this->objValidation->checkVars("langId", $rules, $_POST);

 		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>