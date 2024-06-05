<?php

class CPartner extends CMainInit
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
		$objDonate = Donate::getInstance();

		$this->articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("partner"));

		$data =
		[
			"partnerList" => $this->getHtml_partnerList(),
			"textBlock" => $this->getHtml_textBlock(),
			"donateBlock" => $objDonate->getHtml_donateBlock(),
		];

		$this->html["pageTitle"] = $this->getPageTitle();
		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("partner", "content", $data);
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

	private function getHtml_partnerList()
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
			return $this->objSTemplate->getHtml("partner", "partnerList_empty");
		}

		foreach($res AS $row)
		{
			$data =
			[
				"id" => $row["id"],
				"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
				"href" => "/partner/".$row["urlName"]."/",
				"altTitle" => Convert::textUnescape($row["title"], true),
				"title" => Convert::textUnescape($row["title"]),
				"date" => date("d.m.Y", $row["time"]),
				"description" => Convert::textUnescape($row["description"]),
			];

			$html .= $this->objSTemplate->getHtml("partner", "partnerListItem", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_textBlock()
	{
		if (0 === mb_strlen($this->articleCatalogInfo["text"]))
		{
			return "";
		}

		$data =
			[
				"text" => Convert::textUnescape($this->articleCatalogInfo["text"]),
			];

		return $this->objSTemplate->getHtml("event", "textBlock", $data);
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

		//$this->objJavaScript->addJavaScriptFile("/js/partner.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>