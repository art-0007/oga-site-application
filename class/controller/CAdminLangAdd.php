<?php

class CAdminLangAdd extends CMainAdminFancyBoxInit
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
  			"pageTitleH1" => "Создание языка",
  			"langSelect" => $this->getHtml_langSelect(),

  			"submitButtonTitle" => "Создать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminLang", "adminLangAdd", $data);
 	}

	//*********************************************************************************

	private function getHtml_langSelect()
	{
		$objMLang = MLang::getInstance();
		$html = "";

		if (false === ($res = $objMLang->getList()))
		{
			return $this->objSTemplate->getHtml("adminLang", "langList_empty");
		}

		foreach ($res AS $row)
		{
			$html .= "<option value='".$row["id"]."'>".Convert::textUnescape($row["name"], false)."</option>";
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
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-lang-list.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------
		//-----------------------------------------------------------------------------------

 		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>