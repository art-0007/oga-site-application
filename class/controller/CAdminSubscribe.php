<?php

class CAdminSubscribe extends CMainAdminFancyBoxInit
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
  			"pageTitleH1" => "Список E-mail подписчиков на рассылку",
  			"emailList" => $this->getSubscribeListHtml(),
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminSubscribe", "content", $data);
 	}

	//*********************************************************************************

	private function getSubscribeListHtml()
	{
		$objMSubscribe = MSubscribe::getInstance();
		$html = "";

		if (false === ($res = $objMSubscribe->getList()))
		{
			return $html;
		}

		foreach ($res AS $row)
		{
			$html .= $row["email"].",\r\n";
		}

		$html = mb_substr($html, 0, mb_strlen($html) - 3);

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