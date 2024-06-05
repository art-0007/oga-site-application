<?php

class CGetInvolved extends CMainInit
{
	//*********************************************************************************

	private $articleCatalogInfo = "";

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
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objAdminFile = AdminFile::getInstance();

		$this->articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("getInvolved"));

		$data =
		[
			"getInvolvedTitleList" => $this->getHtml_getInvolvedTitleList(),
			"getInvolvedList" => $this->getHtml_getInvolvedList(),
			"fileBlock" => (Func::isEmpty($this->articleCatalogInfo["addField_3"])) ? "" : $objAdminFile->getHtml_fileBlock($this->articleCatalogInfo["addField_3"]),
		];

		$this->html["pageTitle"] = ""; //$this->getPageTitle();
		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("getInvolved", "content", $data);
 	}

	//*********************************************************************************

	private function getPageTitle()
	{
		$data =
  		[
  			"id" => $this->articleCatalogInfo["id"],
  			"pageTitle" => (!empty($this->articleCatalogInfo["pageTitle"]) ? Convert::textUnescape($this->articleCatalogInfo["pageTitle"], false) : Convert::textUnescape($this->articleCatalogInfo["title"], false)),
  			"controllerId" => 2,
		    "textBlock" => $this->getHtml_pageTitle_textBlock(),
	    ];

		return $this->objSTemplate->getHtml("pageTitle", "content", $data);
	}

	//*********************************************************************************

	private function getHtml_pageTitle_textBlock()
	{
		if (0 === mb_strlen($this->articleCatalogInfo["description"]))
		{
			return "";
		}

		$data =
		[
			"description" => Convert::textUnescape($this->articleCatalogInfo["description"]),
		];

		return $this->objSTemplate->getHtml("pageTitle", "textBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_getInvolvedTitleList()
	{
		$objMArticle = MArticle::getInstance();
		$html = "";

		$parameterArray =
		[
			"articleCatalogIdArray" => $this->articleCatalogInfo["id"],
			"orderType" => $this->articleCatalogInfo["orderInCatalog"],
			"showKey" => 1,
		];

		if
		(
			false === $this->articleCatalogInfo
			OR
			false === ($res = $objMArticle->getList($parameterArray))
		)
		{
			return "";
		}

		foreach($res AS $row)
		{
			$data =
			[
				"id" => $row["id"],
				"title" => Convert::textUnescape($row["title"]),
			];

			$html .= $this->objSTemplate->getHtml("getInvolved", "getInvolvedListItem_title", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_getInvolvedList()
	{
		$objMArticle = MArticle::getInstance();
		$html = "";

		$parameterArray =
		[
			"articleCatalogIdArray" => $this->articleCatalogInfo["id"],
			"orderType" => $this->articleCatalogInfo["orderInCatalog"],
			"showKey" => 1,
		];

		if
		(
			false === $this->articleCatalogInfo
			OR
			false === ($res = $objMArticle->getList($parameterArray))
		)
		{
			return $this->objSTemplate->getHtml("getInvolved", "getInvolvedList_empty");
		}

		foreach($res AS $row)
		{
			$data =
			[
				"id" => $row["id"],
				"title" => Convert::textUnescape($row["title"]),
				"description" => Convert::textUnescape($row["description"]),
				"btnBlock" => (1 === (int)$row["addField_1"]) ? $this->objSTemplate->getHtml("getInvolved", "btnBlock", ["id" => $row["id"]]) : "",
			];

			$html .= $this->objSTemplate->getHtml("getInvolved", "getInvolvedListItem", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$objAdminUser = AdminUser::getInstance();

		if ($objAdminUser->isAuthorized())
		{
			$this->objJavaScript->addJavaScriptFile("/js/admin/admin-article.js");
			$this->objJavaScript->addJavaScriptFile("/js/admin/admin-article-catalog.js");
		}

		//$this->objJavaScript->addJavaScriptFile("/js/get-involved.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>