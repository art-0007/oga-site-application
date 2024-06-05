<?php

class CAdminAdminUserEdit extends CMainAdminFancyBoxInit
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
		$objMAdminUser = MAdminUser::getInstance();

		if (false === $adminUserInfo = $objMAdminUser->getInfo($this->vars["adminUserId"]))
		{
			Error::message("STOP");
		}

		$data = array
		(
  			"pageTitle" => "Редактирование пользователя админпанели",
  			"id" => $adminUserInfo["id"],
  			"firstName" => $adminUserInfo["firstName"],
  			"middleName" => $adminUserInfo["middleName"],
  			"lastName" => $adminUserInfo["lastName"],
  			"email" => $adminUserInfo["email"],
  			"sendEmailWhenOrderAddKey_checked" => (1 === (int)$adminUserInfo["sendEmailWhenOrderAddKey"]) ? "checked=\"checked\"" : "",

  			"submitButtonTitle" => "Редактировать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminAdminUser", "adminUserEdit", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-admin-user.js");
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
		$this->objValidation->checkVars("adminUserId", $rules, $_GET);

 		//Проверяем существование с таким id
  		if (false === $objMAdminUser->isExist($this->objValidation->vars["adminUserId"]))
  		{
  			$this->objSOutput->critical("Пользователя админпанели с таким id не существует [".$this->objValidation->vars["adminUserId"]."]");
  		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>