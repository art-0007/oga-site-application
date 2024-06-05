<?php

class CAdminLangList extends CMainAdminFancyBoxInit
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
				"pageTitleH1" => "Список языков",
				"toolbarButton" => "",
				"langList" => $this->getHtml_langList(),
			];

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminLang", "content", $data);
	}

	//*********************************************************************************

	private function getHtml_langList()
	{
		$objMLang = MLang::getInstance();
		$html = "";

		if (false === ($res = $objMLang->getList()))
		{
			return $this->objSTemplate->getHtml("adminLang", "langList_empty");
		}

		foreach ($res AS $row)
		{
			$data =
				[
					"id" => $row["id"],
					"name" => Convert::textUnescape($row["name"], false),
					"code" => Convert::textUnescape($row["code"], false),
					"img" => Convert::textUnescape($row["img"], false),
					"imgBig" => Convert::textUnescape($row["imgBig"], false),
					"position" => $row["position"],
					"default" => (1 === (int)$row["defaultKey"]) ? "Да" : "",
				];
			$html .= $this->objSTemplate->getHtml("adminLang", "langListItem", $data);
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
	}

	//*********************************************************************************
}

?>