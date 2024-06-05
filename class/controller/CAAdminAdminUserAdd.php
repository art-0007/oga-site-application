<?php

class CAAdminAdminUserAdd extends CAjaxInit
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
		$this->objMySQL->startTransaction();

		$this->addAdminUser();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Пользователь админпанели создан");

	}

	//*********************************************************************************

	private function addAdminUser()
	{
		$objMAdminUser = MAdminUser::getInstance();

		/** Добавление доступно только root или base */
  		if(!$objMAdminUser->isBase(GLOB::$ADMIN_USER["id"]) AND !$objMAdminUser->isRoot(GLOB::$ADMIN_USER["id"]))
		{
			$this->objSOutput->error("В доступе отказано. Вы не можете добавлять новых ползователей админпанели");
		}

  		//Проверяем существование пользователя с таким логином
  		if (true === $objMAdminUser->isExistByEmail($this->vars["email"]))
  		{
  			$this->objSOutput->error("Пользователь с таким логином уже существует");
  		}

  		$data = array
		(
			"firstName" => $this->vars["firstName"],
			"email" => $this->vars["email"],
			"password" => md5($this->vars["password"]),
			"adminKey" => 1,
		);

  		$objMAdminUser->add($data);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [firstName]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите имя"
		);

		$this->objValidation->checkVars("firstName", $rules, $_POST);

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [email]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите email",
			Validation::isEmail => "Email имеет некорректный формат",
		);

		$this->objValidation->checkVars("email", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [password]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите пароль",
			Validation::minLength."[6]" => "Пароль должен иметь длину от 6 до 24 символов",
			Validation::maxLength."[24]" => "Пароль должен иметь длину от 6 до 24 символов"
		);

		$this->objValidation->checkVars("password", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>