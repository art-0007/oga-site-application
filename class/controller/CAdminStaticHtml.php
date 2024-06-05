<?php

class CAdminStaticHtml extends CMainAdminFancyBoxInit
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
  			"pageTitleH1" => "Статический HTML (тексты)",
  			"staticHtmlList" => $this->getStaticHtmlListHtml(),
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminStaticHtml", "content", $data);
 	}

	//*********************************************************************************

	private function getStaticHtmlListHtml()
	{
		$objMStaticHtml = MStaticHtml::getInstance();
		$html = "";

		if (false === ($res = $objMStaticHtml->getList()))
		{
			return $this->objSTemplate->getHtml("adminStaticHtml", "staticHtmlList_empty");
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
	   			"id" => $row["staticHtmlId"],
	   			"name" => $row["name"],
	   			"html" => $row["html"],
	   			"zebra" => $zebra,
	   		);

			$html .= $this->objSTemplate->getHtml("adminStaticHtml", "staticHtmlListIteam", $data);
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
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-static-html.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>