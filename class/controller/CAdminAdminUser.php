<?php

class CAdminAdminUser extends CMainAdminFancyBoxInit
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
  			"pageTitle" => "Список пользователей админанели",
  			"toolbar" => $this->getToolbarHtml(),
  			"adminUserList" => $this->getAdminUserListHtml(),
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminAdminUser", "content", $data);
 	}

	//*********************************************************************************

	private function getToolbarHtml()
	{
		$objMAdminUser = MAdminUser::getInstance();

		if (!$objMAdminUser->isBase(GLOB::$ADMIN_USER["id"]) AND !$objMAdminUser->isRoot(GLOB::$ADMIN_USER["id"]))
		{
			return "";
		}

		return $this->objSTemplate->getHtml("adminAdminUser", "toolbar");
	}

	//*********************************************************************************

	private function getAdminUserListHtml()
	{
		$objMAdminUser = MAdminUser::getInstance();
		$html = "";
		$rootKey = false;

		if ($objMAdminUser->isRoot(GLOB::$ADMIN_USER["id"]))
		{
			$rootKey = true;
		}

		if (false === ($res = $objMAdminUser->getList($rootKey)))
		{
			return $this->objSTemplate->getHtml("adminAdminUser", "adminUserList_empty");
		}

		$count = 0;
		foreach ($res AS $row)
		{
			$count++;
			if (0 === ($count % 2))
			{
				$zebra = "zebra";
			}
			else
			{
				$zebra = "";
			}

			$data = array
	   		(
	   			"id" => $row["id"],
	   			"name" => $row["lastName"]." ".$row["firstName"]." ".$row["middleName"],
	   			"email" => $row["email"],
	   			"zebra" => $zebra,
	   		);

			$html .= $this->objSTemplate->getHtml("adminAdminUser", "adminUserListIteam", $data);
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
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-admin-user.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>