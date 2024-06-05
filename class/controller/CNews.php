<?php

class CNews extends CMainInit
{
	//*********************************************************************************

	private $articleCatalogInfo = "";

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
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objDonate = Donate::getInstance();

		$this->articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("news"));

		$data =
		[
			"newsList" => $this->getHtml_newsListBlock(),
			"donateBlock" => $objDonate->getHtml_donateBlock(),
			//"paginationList" => $this->getPaginationListHtml(),
		];

		$this->html["pageTitle"] = $this->getPageTitle();
		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("news", "content", $data);
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

	private function getHtml_newsListBlock()
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
			return $this->objSTemplate->getHtml("news", "newsList_empty");
		}

		foreach($res AS $row)
		{
			$data =
			[
				"addClass" => "type2",
				"id" => $row["id"],
				"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
				"href" => "/news/".$row["urlName"]."/",
				"altTitle" => Convert::textUnescape($row["title"], true),
				"title" => Convert::textUnescape($row["title"]),
				"description" => Convert::textUnescape($row["description"]),
				"date" => date("d.m.Y", $row["time"]),
			];

			$html .= $this->objSTemplate->getHtml("news", "newsListItem", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function getPaginationListHtml()
	{
		$objMArticle = MArticle::getInstance();
		$objPagination = Pagination::getInstance();

		$pageAmount = (int)ceil($objMArticle->getAmount_byParameter($this->articleCatalogInfo["id"]) / GLOB::$SETTINGS["newsAmountInNewsList"]);

		return $objPagination->getPaginationList("/news/", $this->vars["page"], $pageAmount);
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

		//$this->objJavaScript->addJavaScriptFile("/js/news.js");
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