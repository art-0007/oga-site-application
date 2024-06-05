<?php

class CAAdminUserEdit extends CAjaxInit
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

		$this->editUser();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Покупатель отредактирован");

	}

	//*********************************************************************************

	private function editUser()
	{
		$objMUser = MUser::getInstance();

  		//Проверяем существование пользователя с таким логином
  		if (true === $objMUser->isExistByEmail($this->vars["email"], $this->vars["userId"]))
  		{
  			$this->objSOutput->error("Покупатель с таким E-mail уже существует");
  		}

  		$data = array
		(
			"firstName" => $this->vars["firstName"],
			"middleName" => $this->vars["middleName"],
			"lastName" => $this->vars["lastName"],
			"email" => $this->vars["email"],
			"phone" => $this->vars["phone"],
			"sex" => $this->vars["sex"],
			"city" => $this->vars["city"],
			"discount" => $this->vars["discount"],
  			"activeKey" => (true === $this->vars["activeKey"]) ? 1 : 0,
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

  		$objMUser->edit($this->vars["userId"], $data);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMUser = MUser::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [userId]",
			Validation::isNum => "Некоректные данные [userId]",
		);
		$this->objValidation->checkVars("userId", $rules, $_POST);

 		//Проверяем существование с таким id
  		if (false === $objMUser->isExist($this->objValidation->vars["userId"]))
  		{
  			$this->objSOutput->critical("Покупателя с таким id не существует [".$this->objValidation->vars["userId"]."]");
  		}

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [firstName]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите Имя"
		);
		$this->objValidation->checkVars("firstName", $rules, $_POST);

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [middleName]",
			Validation::trim => "",
		);
		$this->objValidation->checkVars("middleName", $rules, $_POST);

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [lastName]",
			Validation::trim => "",
		);
		$this->objValidation->checkVars("lastName", $rules, $_POST);

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [sex]",
			Validation::trim => "",
		);
		$this->objValidation->checkVars("sex", $rules, $_POST);

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [email]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите email",
			Validation::isEmail => "Email имеет некорректный формат",
		);
		$this->objValidation->checkVars("email", $rules, $_POST);

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [phone]",
			Validation::trim => "",
		);
		$this->objValidation->checkVars("phone", $rules, $_POST);

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [city]",
			Validation::trim => "",
		);
		$this->objValidation->checkVars("city", $rules, $_POST);

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [discount]",
			Validation::trim => "",
		);
		$this->objValidation->checkVars("discount", $rules, $_POST);

		if (!Reg::isFloat($this->objValidation->vars["discount"]))
		{
			$this->objSOutput->error("Значение скидки должно быть целое положительное число, дробь (разделитель - точка). Пример: 1.3, 5, 12.03. Или = 0");
		}

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [password]",
		);
		$this->objValidation->checkVars("password", $rules, $_POST);

		//---------------------------------------------------------------------------------

		$rules = array
		(
			Validation::checkbox => "",
		);
		$this->objValidation->checkVars("activeKey", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>