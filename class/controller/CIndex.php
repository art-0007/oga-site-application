<?php

class CIndex extends CMainInit
{
	//*********************************************************************************
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
		//$objMPage = MPage::getInstance();
		$objDonate = Donate::getInstance();
		$objProject = Project::getInstance();

		////Достаем информацию о странице
		//$pageInfo = $objMPage->getInfo(1);

		$data =
		[
			"sliderBlock" => $this->getHtml_sliderBlock(),
			"tickerBlock" => $this->getHtml_tickerBlock(),
			"projectBlock" => $objProject->getHtml_projectBlock(1, 1),
			"donateBlock" => $objDonate->getHtml_donateBlock(),
			"videoBlock" => $this->getHtml_videoBlock(),
			"someElement1Block" => $this->getHtml_someElementBlock("someElement1"),
			"someElement2Block" => $this->getHtml_someElementBlock("someElement2"),
			"teamBlock" => $this->getHtml_teamBlock(),
			"partnerBlock" => $this->getHtml_partnerBlock(),
			"eventBlock" => $this->getHtml_eventBlock(),
			"newsBlock" => $this->getHtml_newsBlock(),
		];

		//Page Title
		$this->html["pageTitle"] = "";
		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("index", "content", $data);
 	}

	//*********************************************************************************

	private function getHtml_sliderBlock()
	{
		$objMSliderImage = MSliderImage::getInstance();
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();

		$html = "";
		$sliderImageCatalogId = $objMSliderImageCatalog->getIdByDevName("indexSlider");

		if (false === ($res = $objMSliderImage->getList($sliderImageCatalogId, 1)))
		{
			return "";
		}

		$counter = 0;
		foreach ($res AS $row)
		{
			$counter++;

			$data =
			[
				"slideHiddenClass" => (1 === $counter) ? "" : "slide-hidden",
				"id" => $row["id"],
				"imgSrc" => GLOB::$SETTINGS["sliderImgDir"]."/".$row["fileName"],
				"title" => Convert::textUnescape($row["title"]),
				"href" => (0 === mb_strlen($row["onclick"])) ? Convert::textUnescape($row["href"]) : "javascript:void(0);",
				"onclick" => Convert::textUnescape($row["onclick"]),
				"btnText" => Convert::textUnescape($row["btnText"]),
				"description" => Convert::textUnescape($row["description"]),
				"text" => Convert::textUnescape($row["text"]),
			];

			$html .= $this->objSTemplate->getHtml("slider", "sliderListItem_index", $data);
		}

		$data =
		[
			"sliderList" => $html,
		];
		return $this->objSTemplate->getHtml("slider", "sliderBlock_index", $data);
	}

	//*********************************************************************************

	private function getHtml_tickerBlock()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("ticker"));

		if (false === $articleCatalogInfo OR 0 === (int)$articleCatalogInfo["showKey"])
		{
			return "";
		}

		$parameterArray =
		[
			"articleCatalogIdArray" => $articleCatalogInfo["id"],
			"orderType" => $articleCatalogInfo["orderInCatalog"],
			"start" => 0,
			"amount" => GLOB::$SETTINGS["projectAmountOnIndex"],
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
				"title" => Convert::textUnescape($row["title"]),
			];

			$html .= $this->objSTemplate->getHtml("ticker", "tickerListItem", $data);
		}

		$data =
		[
			"tickerList" => $html,
		];

		return $this->objSTemplate->getHtml("ticker", "tickerBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_videoBlock()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("video"));

		if (false === $articleCatalogInfo OR 0 === (int)$articleCatalogInfo["showKey"])
		{
			return "";
		}

		$data =
		[
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
			"description" => Convert::textUnescape($articleCatalogInfo["description"]),
			"video" => Convert::textUnescape($articleCatalogInfo["addField_2"]),
		];

		return $this->objSTemplate->getHtml("video", "videoBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_someElementBlock($articleCatalogDevName)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName($articleCatalogDevName));

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
				"href" => "/".$row["urlName"]."/",
				"title" => Convert::textUnescape($row["title"]),
				"description" => Convert::textUnescape($row["addField_lang_1"]),
			];

			$html .= $this->objSTemplate->getHtml("someElement", "someElementListItem", $data);
		}

		$data =
		[
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
			"articleCatalogDevName" => Convert::textUnescape($articleCatalogInfo["devName"]),
			"someElementList" => $html,
		];

		return $this->objSTemplate->getHtml("someElement", "someElementBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_teamBlock()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";
		$teamCatalogListHtml = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("team"));

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

		if (false === ($res = $objMArticleCatalog->getList($parameterArray)))
		{
			return "";
		}

		$articleCatalogIdArray = [];

		foreach ($res AS $row)
		{
			$articleCatalogIdArray[] = (int)$row["id"];

			$data =
			[
				"id" => $row["id"],
				"href" => "/team/".$row["urlName"]."/",
				"title" => Convert::textUnescape($row["title"]),
			];

			$teamCatalogListHtml .= $this->objSTemplate->getHtml("team", "teamBlock_teamCatalogListItem", $data);
		}

		$parameterArray =
		[
			"articleCatalogIdArray" => $articleCatalogIdArray,
			"orderType" => $articleCatalogInfo["orderInCatalog"],
			"start" => 0,
			"amount" => GLOB::$SETTINGS["teamAmountOnIndex"],
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
				"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
				"href" => "/team/".$row["urlName"]."/",
				"altTitle" => Convert::textUnescape($row["title"], true),
				"title" => Convert::textUnescape($row["title"]),
				"post" => Convert::textUnescape($row["addField_lang_1"]),
			];

			$html .= $this->objSTemplate->getHtml("team", "teamListItem", $data);
		}

		$data =
		[
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
			"teamCatalogList" => $teamCatalogListHtml,
			"teamList" => $html,
		];

		return $this->objSTemplate->getHtml("team", "teamBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_partnerBlock()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("partner"));

		if (false === $articleCatalogInfo OR 0 === (int)$articleCatalogInfo["showKey"])
		{
			return "";
		}

		$parameterArray =
		[
			"articleCatalogIdArray" => $articleCatalogInfo["id"],
			"orderType" => $articleCatalogInfo["orderInCatalog"],
			"start" => 0,
			"amount" => GLOB::$SETTINGS["partnerAmountOnIndex"],
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
				"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
				"altTitle" => Convert::textUnescape($row["title"], true),
				"title" => Convert::textUnescape($row["title"]),
			];

			$html .= $this->objSTemplate->getHtml("partner", "partnerListItem", $data);
		}

		$data =
		[
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
			"partnerList" => $html,
		];

		return $this->objSTemplate->getHtml("partner", "partnerBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_eventBlock()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("event"));

		if (false === $articleCatalogInfo OR 0 === (int)$articleCatalogInfo["showKey"])
		{
			return "";
		}

		$parameterArray =
		[
			"articleCatalogIdArray" => $articleCatalogInfo["id"],
			"orderType" => $articleCatalogInfo["orderInCatalog"],
			"start" => 0,
			"amount" => GLOB::$SETTINGS["eventAmountOnIndex"],
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
				"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
				"href" => "/event/".$row["urlName"]."/",
				"altTitle" => Convert::textUnescape($row["title"], true),
				"title" => Convert::textUnescape($row["title"]),
				"description" => Convert::textUnescape($row["description"]),
			];

			$html .= $this->objSTemplate->getHtml("event", "eventListItem", $data);
		}

		$data =
		[
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
			"eventList" => $html,
		];

		return $this->objSTemplate->getHtml("event", "eventBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_newsBlock()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("news"));

		if (false === $articleCatalogInfo OR 0 === (int)$articleCatalogInfo["showKey"])
		{
			return "";
		}

		$parameterArray =
		[
			"articleCatalogIdArray" => $articleCatalogInfo["id"],
			"orderType" => $articleCatalogInfo["orderInCatalog"],
			"start" => 0,
			"amount" => GLOB::$SETTINGS["newsAmountOnIndex"],
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
				"addClass" => "",
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

		$data =
		[
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
			"newsList" => $html,
		];

		return $this->objSTemplate->getHtml("news", "newsBlock", $data);
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/index.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>