<?php

class CAAdminUserDelete extends CAjaxInit
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
		if (!is_array($this->vars["userId"]))
 		{
			$this->vars["userId"] = array($this->vars["userId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->deleteUser();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Покупатели удалены", array("userId" => $this->vars["userId"]));
	}

	//*********************************************************************************

	private function deleteUser()
	{
		$objMUser = MUser::getInstance();

		foreach($this->vars["userId"] AS $userId)
  		{
	  		//Проверяем существование с таким id
	  		if (false === $objMUser->isExist($userId))
	  		{
	  			$this->objSOutput->critical("Покупателя с таким id не существует");
	  		}

			//Удаляем указанного пользователя
	  		$objMUser->delete($userId);
  		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [userId]",
		);

		$this->objValidation->checkVars("userId", $rules, $_POST);

 		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>