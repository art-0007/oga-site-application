<?php

class CAAdminLogin extends CAjaxALoginInit
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
		$objMAdminUser = MAdminUser::getInstance();

		if (false === ($adminUserId = $objMAdminUser->getIdByEmail($this->vars["email"])))
		{
			$this->objSOutput->error("Вы неверно указали E-mail или пароль");
		}

		//Проверяем существование пользователя с таким id и паролем
		if(!$objMAdminUser->isExistByIdAndPassword($adminUserId, md5($this->vars["password"])))
		{
			$this->objSOutput->error("Вы неверно указали E-mail или пароль");
		}

		/** Авторизируем пользователя */

		$objMAdminUserSession = MAdminUserSession::getInstance();

		//Добавляем новую сессию
		$objMAdminUserSession->add($adminUserId);

		$this->objSOutput->ok("Авторизация прошла успешно");
 	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		//--------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [email]",
			Validation::isNoEmpty => "Введите E-mail"
		);
		$this->objValidation->checkVars("email", $rules, $_POST);

		//--------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [password]",
			Validation::isNoEmpty => "Введите пароль"
		);
		$this->objValidation->checkVars("password", $rules, $_POST);

		//--------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => ""
		);
		$this->objValidation->checkVars("holdInSystemKey", $rules, $_POST);

		//--------------------------------------------------------------------

		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>