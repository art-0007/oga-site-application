<?php

class CAdminStaticHtmlAdd extends CMainAdminFancyBoxInit
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
  			"pageTitleH1" => "Создание статического html`я",

  			"submitButtonTitle" => "Создать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminStaticHtml", "adminStaticHtmlAdd", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-static-html.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>