<?php

class CAAdminUserAdd extends CAjaxInit
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

	    $userId = $this->addAdminUser();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Покупатель создан", ["userId" => $userId]);
	}

	//*********************************************************************************

	private function addAdminUser()
	{
		$objMUser = MUser::getInstance();

  		//Проверяем существование пользователя с таким логином
  		if (true === $objMUser->isExistByEmail($this->vars["email"]))
  		{
  			$this->objSOutput->error("Покупатель с таким E-mail уже существует");
  		}

  		$data = array
		(
			"password" => md5($this->vars["password"]),
			"firstName" => $this->vars["firstName"],
			"email" => $this->vars["email"],
			"time" => time(),
			"emailConfirmKey" => 1,
			"activeKey" => 1,
		);

  		$userId = $objMUser->addAndReturnId($data);

  		if (false === $userId)
  		{
  			$this->objSOutput->ok("Ошибка добавления покупателя");
  		}

  		return $userId;
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
			Validation::isNoEmpty => "Введите Имя"
		);

		$this->objValidation->checkVars("firstName", $rules, $_POST);

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [email]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите E-mail",
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