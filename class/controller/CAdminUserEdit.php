<?php

class CAdminUserEdit extends CMainAdminFancyBoxInit
{
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		//$this->setCSS();
		$this->setJavaScript();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$objMUser = MUser::getInstance();

		if (false === $userInfo = $objMUser->getInfo($this->vars["userId"]))
		{
			$this->objSOutput->error("Ошибка выборки информации о покупателе");
		}

		$data = array
		(
  			"pageTitle" => "Редактирование покупателя",
  			"id" => $userInfo["id"],
  			"firstName" => $userInfo["firstName"],
  			"middleName" => $userInfo["middleName"],
  			"lastName" => $userInfo["lastName"],
  			"email" => $userInfo["email"],
  			"phone" => $userInfo["phone"],
  			"city" => $userInfo["city"],
  			"discount" => $userInfo["discount"],
  			"sexSelect" => $this->getHtml_sexSelect($userInfo["sex"]),
  			"activeKey_checked" => (1 === (int)$userInfo["activeKey"]) ? "checked=\"checked\"" : "",
  			"emailConfirmKey_checked" => (1 === (int)$userInfo["emailConfirmKey"]) ? "checked=\"checked\"" : "",

  			"submitButtonTitle" => "Редактировать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminUser", "userEdit", $data);
 	}

	//*********************************************************************************

	private function getHtml_sexSelect($sex)
	{
		$html = "";

		foreach (EUserSex::$userSexTitleArray AS $key => $value)
		{
			$selected = "";

			if ((int)$sex === (int)$key)
			{
				$selected = "selected=\"selected\"";
			}

			$html .= "<option value=\"".$key."\" ".$selected.">".$value."</option>";
		}

		return $html;
	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-user.js");
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
		$this->objValidation->checkVars("userId", $rules, $_GET);

 		//Проверяем существование с таким id
  		if (false === $objMUser->isExist($this->objValidation->vars["userId"]))
  		{
  			$this->objSOutput->critical("Покупателя с таким id не существует [".$this->objValidation->vars["userId"]."]");
  		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>