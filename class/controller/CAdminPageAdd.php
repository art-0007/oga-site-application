<?php

class CAdminPageAdd extends CMainAdminFancyBoxInit
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
  			"pageTitleH1" => "Создание статической страницы",

  			"submitButtonTitle" => "Создать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminPage", "adminPageAdd", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-page.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>