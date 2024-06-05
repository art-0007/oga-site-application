<?php

class CDonate extends CMainInit
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
		$this->articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("donate"));

		$data =
		[
			"donateList" => $this->getHtml_donateList(),
			"donateInformationBlock" => $this->getHtml_donateInformationBlock(),
		];

		$this->html["pageTitle"] = $this->getPageTitle();
		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("donate", "content", $data);
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

	private function getHtml_donateList()
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
			return $this->objSTemplate->getHtml("donate", "donateList_empty");
		}

		foreach($res AS $row)
		{
			$donateBtn = "";

			if (!Func::isEmpty($row["addField_lang_1"]))
			{
				$donateBtn = $this->objSTemplate->getHtml("donate", "donateBtn_a", ["href" => $row["addField_lang_1"]]);
			}

			if (!Func::isEmpty($row["addField_3"]))
			{
				$donateBtn = $this->objSTemplate->getHtml("donate", "donateBtn", ["id" => $row["id"]]);
			}

			$data =
			[
				"id" => $row["id"],
				"imgSrc2" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName2"],
				"altTitle" => Convert::textUnescape($row["title"], true),
				"title" => Convert::textUnescape($row["title"]),
				"href" => Convert::textUnescape($row["addField_lang_1"]),
				"date" => date("d.m.Y", $row["time"]),
				"donateBtn" => $donateBtn,
				"description" => Convert::textUnescape($row["description"]),
			];

			$html .= $this->objSTemplate->getHtml("donate", "donateListItem3", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_donateInformationBlock()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("donateInformation"));

		if (false === $articleCatalogInfo OR 0 === (int)$articleCatalogInfo["showKey"])
		{
			return "";
		}

		$parameterArray =
		[
			"articleCatalogIdArray" => $articleCatalogInfo["id"],
			"orderType" => $articleCatalogInfo["orderInCatalog"],
			"showKey" => 1,
		];

		if (false === ($res = $objMArticle->getList($parameterArray)))
		{
			return "";
		}

		foreach($res AS $row)
		{
			$data =
			[
				"id" => $row["id"],
				"icoCode" => Convert::textUnescape($row["addField_1"]),
				"title" => Convert::textUnescape($row["title"]),
				"description" => Convert::textUnescape($row["description"]),
			];

			$html .= $this->objSTemplate->getHtml("donateInformation", "donateInformationListItem", $data);
		}

		$data =
		[
			"addClass" => "bgBlue",
			"donateInformationList" => $html,
		];

		return $this->objSTemplate->getHtml("donateInformation", "donateInformationBlock", $data);
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

		//$this->objJavaScript->addJavaScriptFile("/js/donate.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>