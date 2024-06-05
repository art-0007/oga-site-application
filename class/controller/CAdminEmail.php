<?php

class CAdminEmail extends CMainAdminFancyBoxInit
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
  			"pageTitleH1" => "Список E-mail",
  			"toolbarButton" => "",
  			"emailList" => $this->getEmailListHtml(),
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminEmail", "content", $data);
 	}

	//*********************************************************************************

	private function getEmailListHtml()
	{
		$objMEmail = MEmail::getInstance();
		$html = "";

		if (false === ($res = $objMEmail->getList()))
		{
			return $this->objSTemplate->getHtml("adminEmail", "emailList_empty");
		}

		foreach ($res AS $row)
		{
			$data = array
	   		(
	   			"id" => $row["id"],
	   			"subject" => Convert::textUnescape($row["subject"], false),
	   			"date" => date("d-m-Y", $row["time"]),
	   			"time" => date("H:i:s", $row["time"]),
	   			"file" => (!empty($row["fileName"])) ? "есть" : "",
	   		);
	   		$html .= $this->objSTemplate->getHtml("adminEmail", "emailListItem", $data);
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
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-email.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>