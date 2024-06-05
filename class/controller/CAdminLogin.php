<?php

class CAdminLogin extends CMainInit
{
	/*********************************************************************************/
	/*********************************************************************************/

	public function __construct()
	{
		parent::__construct();

		//$this->setInputVars();
		$this->setCSS();
		$this->setJavaScript();
		$this->init();
	}

	/*********************************************************************************/

 	private function init()
 	{
		$data = array
		(
			"" => "",
		);

		//Выводим контент страницы
 		$this->html["content"] = $this->objSTemplate->getHtml("adminLogin", "content", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
		$this->objCSS->addCSSFile("/template/css/admin-login.css");
		$this->objCSS->addCSSFile("/template/css/edit-form.css");
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-login.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	/*********************************************************************************/
}

?>