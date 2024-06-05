<?php

class CAAdminAdminUserEdit extends CAjaxInit
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

		$this->editAdminUser();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Пользователь админпанели отредактирован");

	}

	//*********************************************************************************

	private function editAdminUser()
	{
		$objMAdminUser = MAdminUser::getInstance();

		if (!$objMAdminUser->isBase(GLOB::$ADMIN_USER["id"]) AND !$objMAdminUser->isRoot(GLOB::$ADMIN_USER["id"]) AND (int)$this->vars["adminUserId"] !== (int)GLOB::$ADMIN_USER["id"])
		{
			$this->objSOutput->error("Вы не можете редактировать этого пользователя");
		}

  		//Проверяем существование пользователя с таким логином
  		if (true === $objMAdminUser->isExistByEmail($this->vars["email"], $this->vars["adminUserId"]))
  		{
  			$this->objSOutput->error("Пользователь с таким логином уже существует");
  		}

  		$data = array
		(
			"firstName" => $this->vars["firstName"],
			"middleName" => $this->vars["middleName"],
			"lastName" => $this->vars["lastName"],
			"email" => $this->vars["email"],
			"sendEmailWhenOrderAddKey" => (true === $this->vars["sendEmailWhenOrderAddKey"]) ? 1 : 0,
		);

		//Обрабатываем пароль, если он указан
		if (mb_strlen($this->vars["password"]) !== 0)
		{
			if (mb_strlen($this->vars["password"]) < 6 || mb_strlen($this->vars["password"]) > 24)
			{
				$this->objSOutput->error("Пароль должен иметь длину от 6 до 24 символов");
			}

			$data["password"] = md5($this->vars["password"]);
		}

  		$objMAdminUser->edit($this->vars["adminUserId"], $data);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMAdminUser = MAdminUser::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [adminUserId]",
			Validation::isNum => "Некоректные данные [adminUserId]",
		);
		$this->objValidation->checkVars("adminUserId", $rules, $_POST);

 		//Проверяем существование с таким id
  		if (false === $objMAdminUser->isExist($this->objValidation->vars["adminUserId"]))
  		{
  			$this->objSOutput->critical("Пользователя с таким id не существует [".$this->objValidation->vars["adminUserId"]."]");
  		}

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [firstName]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите имя"
		);
		$this->objValidation->checkVars("firstName", $rules, $_POST);

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [middleName]"
		);
		$this->objValidation->checkVars("middleName", $rules, $_POST);

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [lastName]"
		);
		$this->objValidation->checkVars("lastName", $rules, $_POST);

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [email]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите email",
		);
		$this->objValidation->checkVars("email", $rules, $_POST);

		if (false === $objMAdminUser->isBase($this->objValidation->vars["adminUserId"]))
		{
			if (false === Reg::isEmail($this->objValidation->vars["email"]))
			{
				$this->objSOutput->error("Email имеет некорректный формат");
			}
		}

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [password]",
		);
		$this->objValidation->checkVars("password", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$this->objValidation->vars["sendEmailWhenOrderAddKey"] = false;
		if (isset($_POST["sendEmailWhenOrderAddKey"]))
		{
			$this->objValidation->vars["sendEmailWhenOrderAddKey"] = true;
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>