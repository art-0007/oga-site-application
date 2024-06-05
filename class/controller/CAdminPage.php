<?php

class CAdminPage extends CMainAdminFancyBoxInit
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
  			"pageTitleH1" => "Статические страницы",
  			"staticPageList" => $this->getStaticPageListHtml(),
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminPage", "content", $data);
 	}

	//*********************************************************************************

	private function getStaticPageListHtml()
	{
		$objMPage = MPage::getInstance();
		$html = "";

		if (false === ($res = $objMPage->getList()))
		{
			return $this->objSTemplate->getHtml("adminPage", "staticPageList_empty");
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
	   			"title" => $row["title"],
	   			"devName" => $row["devName"],
	   			"urlName" => $row["urlName"],
	   			"position" => $row["position"],
	   			"zebra" => $zebra,
	   		);

			$html .= $this->objSTemplate->getHtml("adminPage", "staticPageListIteam", $data);
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
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-page.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>