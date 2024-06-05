<?php

class CAAdminEmailDelete extends CAjaxInit
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
		if (!is_array($this->vars["emailId"]))
 		{
			$this->vars["emailId"] = array($this->vars["emailId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->delete();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Письма удалены", array("emailId" => $this->vars["emailId"]));
	}

	//*********************************************************************************

	private function delete()
	{
		$objMEmail = MEmail::getInstance();

		foreach ($this->vars["emailId"] AS $emailId)
		{
	  		if (false === $objMEmail->isExist($emailId))
	  		{
	  			$this->objSOutput->critical("E-mail-а с таким id не существует [".$emailId."]");
	  		}
		}

		foreach ($this->vars["emailId"] AS $emailId)
		{
	 		$emailInfo = $objMEmail->getInfo($emailId);

			@unlink(PATH.GLOB::$SETTINGS["emailImgDir"]."/".$emailInfo["fileName"]);
			//Удаляем
			$objMEmail->delete($emailId);
		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [emailId]",
		);

		$this->objValidation->checkVars("emailId", $rules, $_POST);

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>