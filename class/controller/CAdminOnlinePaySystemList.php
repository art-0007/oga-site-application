<?php

class CAdminOnlinePaySystemList extends CMainAdminFancyBoxInit
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
		$data =
		[
  			"pageTitleH1" => "Список онлайн систем",
  			"toolbarButton" => "",
  			"onlinePaySystemList" => $this->getHtml_onlinePaySystemList(),
		];

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminOnlinePaySystem", "content", $data);
 	}

	//*********************************************************************************

	private function getHtml_onlinePaySystemList()
	{
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();
		$html = "";

		if (false === ($res = $objMOnlinePaySystem->getList()))
		{
			return $this->objSTemplate->getHtml("adminOnlinePaySystem", "onlinePaySystemList_empty");
		}

		$count = 0;
		foreach ($res AS $row)
		{
			$count++;

			$data =
	   		[
			    "zebra" => (0 === ($count % 2)) ? "zebra" : "",
			    "id" => $row["id"],
	   			"title" => Convert::textUnescape($row["title"]),
	   			"devName" => Convert::textUnescape($row["devName"]),
	   			"position" => $row["position"],
	   		];
	   		$html .= $this->objSTemplate->getHtml("adminOnlinePaySystem", "onlinePaySystemListItem", $data);
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
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-online-pay-system-list.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>