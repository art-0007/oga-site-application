<?php

class CAdminUser extends CMainAdminFancyBoxInit
{
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		//$this->setInputVars();
		//$this->setCSS();
		$this->setJavaScript();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$data = array
		(
  			"pageTitle" => "Список покупателей",
  			"toolbar" => $this->objSTemplate->getHtml("adminUser", "toolbar"),
  			"userList" => $this->getUserListHtml(),
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminUser", "content", $data);
 	}

	//*********************************************************************************

	private function getUserListHtml()
	{
		$objMUser = MUser::getInstance();
		$html = "";

		if (false === ($res = $objMUser->getList()))
		{
			return $this->objSTemplate->getHtml("adminUser", "userList_empty");
		}

		$count = 0;
		foreach ($res AS $row)
		{
			if (1 === (int)$row["id"]) { continue; }

			$count++;

			$data = array
	   		(
	   			"id" => $row["id"],
	   			"firstName" => $row["firstName"],
	   			"middleName" => $row["middleName"],
	   			"lastName" => $row["lastName"],
	   			"email" => $row["email"],
	   			"phone" => $row["phone"],
	   			"active" => (0 === (int)$row["activeKey"]) ? "Нет" : "",
	   			"emailConfirm" => (0 === (int)$row["emailConfirmKey"]) ? "Нет" : "",
	   			"zebra" => (0 === ($count % 2)) ? "zebra" : "",
	   		);

			$html .= $this->objSTemplate->getHtml("adminUser", "userListItem", $data);
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
	}

	//*********************************************************************************
}

?>