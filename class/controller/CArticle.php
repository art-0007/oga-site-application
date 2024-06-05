<?php

class CArticle extends CMainInit
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
		$this->articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("article"));

		$data = array
		(
			"articleListBlock" => $this->getArticleListBlockHtml(),
			"linkBlock" => $this->getLinkBlockHtml(),
		);

		//Page Title
		$this->html["pageTitle"] = $this->getPageTitle();
		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("article", "content", $data);
 	}

	//*********************************************************************************

	private function getPageTitle()
	{
		$data = array
  		(
  			"id" => $this->articleCatalogInfo["id"],
  			"pageTitle" => (!empty($this->articleCatalogInfo["pageTitle"]) ? Convert::textUnescape($this->articleCatalogInfo["pageTitle"], false) : Convert::textUnescape($this->articleCatalogInfo["title"], false)),
  			"controllerId" => 4,
  		);

  		return $this->objSTemplate->getHtml("pageTitle", "content", $data);
	}

	//*********************************************************************************

	private function getArticleListBlockHtml()
	{
		$objMArticle = MArticle::getInstance();
		$html = "";

		if
		(
			false === $this->articleCatalogInfo
			OR
			false === ($res = $objMArticle->getList($this->articleCatalogInfo["id"], null, null, $this->articleCatalogInfo["orderInCatalog"]))
		)
		{
			return $this->objSTemplate->getHtml("article", "articleList_empty");
		}


		$count = count($res);

		foreach($res AS $row)
  		{
			$data = array
	  		(
	  			"id" => $row["id"],
	  			"href" => (!empty($row["urlName"])) ? "/article/".$row["urlName"]."/" : "/article/".$row["id"]."/",
	  			"imgSrc" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
	  			"articleImageTitle" => Convert::textUnescape($row["title"], true),
	  			"title" => Convert::textUnescape($row["title"], false),
	  			"date" => date("d.m.Y", $row["time"]),
	  			"description" => (0 === mb_strlen($row["description"])) ? Convert::textUnescape($row["text"], true, 300) : Convert::textUnescape($row["description"], true, 300),
	  		);

			$html .= $this->objSTemplate->getHtml("article", "articleListItem", $data);
  		}

  		if (($count % 2) !== 0)
  		{
  			$html .= $this->objSTemplate->getHtml("article", "articleListItem_last");
  		}

		return $html;
	}

		//*********************************************************************************

	private function getLinkBlockHtml()
	{
		$objActiveLinkClass = ActiveLinkClass::getInstance();

		return $this->objSTemplate->getHtml("linkBlock", "linkBlock_news", $objActiveLinkClass->getActiveLinkClass());
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

		//$this->objJavaScript->addJavaScriptFile("/js/article.js");
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