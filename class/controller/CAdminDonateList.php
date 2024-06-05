<?php

class CAdminDonateList extends CMainAdminFancyBoxInit
{
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		//$this->setCSS();
		$this->setJavaScript();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$data =
		[
  			"pageTitleH1" => "Список донатов",
  			"toolbarButton" => "",
  			"donateList" => $this->getHtml_donateList(),
		    "paginationList" => $this->getPaginationListHtml(),
		];

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminDonate", "content", $data);
 	}

	//*********************************************************************************

	private function getHtml_donateList()
	{
		$objMDonate = MDonate::getInstance();
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$parameterArray =
		[
			"" => "",
		];

		if (false === ($res = $objMDonate->getList($parameterArray)))
		{
			return $this->objSTemplate->getHtml("adminDonate", "donateList_empty");
		}

		$count = 0;
		foreach ($res AS $row)
		{
			$count++;

			$data =
	   		[
			    "zebra" => (0 === ($count % 2)) ? "zebra" : "",
			    "id" => $row["id"],
	   			"progectTitle" => Convert::textUnescape($objMArticle->getTitle($row["article_id"])),
	   			"onlinePaySistemTitle" => Convert::textUnescape($objMOnlinePaySystem->getTitle($row["onlinePaySystem_id"])),
			    "code" => Convert::textUnescape($row["code"]),
			    "sum" => Convert::textUnescape($row["sum"]),
	   			"transactionAmount" => $objMOnlinePayTransaction->getAmount(["donateIdArray" => [$row["id"]]]),
	   		];
	   		$html .= $this->objSTemplate->getHtml("adminDonate", "donateListItem", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function getPaginationListHtml()
	{
		$objMDonate = MDonate::getInstance();
		$objPagination = Pagination::getInstance();

		$pageAmount = (int)ceil($objMDonate->getAmount() / 20);

		return $objPagination->getPaginationList("/admin/donat/list/", $this->vars["page"], $pageAmount);
	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-donate-list.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$page = 1;
		if (isset($_GET["page"]))
		{
			$page = $_GET["page"];
		}

		$this->vars["page"] = $page;
	}

	//*********************************************************************************
}

?>