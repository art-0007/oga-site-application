<?php

class CTeam extends CMainInit
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

		if (0 === (int)$this->vars["articleCatalogId"])
		{
			$this->articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("team"));
		}
		else
		{
			$this->articleCatalogInfo = $objMArticleCatalog->getInfo($this->vars["articleCatalogId"]);
		}

		$data =
		[
			"teamCatalogList" => $this->getHtml_teamCatalogList(),
			"teamList" => $this->getHtml_teamList(),
			"textBlock" => $this->getHtml_textBlock(),
			"donateBlock" => "",
			//"paginationList" => $this->getPaginationListHtml(),
		];

		if ("directors" === $this->articleCatalogInfo["devName"])
		{
			$data["donateBlock"] = $objDonate->getHtml_donateBlock();
		}

		$this->html["pageTitle"] = $this->getPageTitle();
		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("team", "content", $data);
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

	private function getHtml_teamCatalogList()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$html = "";

		$parameterArray =
		[
			"articleCatalogIdArray" => $objMArticleCatalog->getIdByDevName("team"),
		];

		if (false === ($res = $objMArticleCatalog->getList($parameterArray)))
		{
			return "";
		}

		foreach ($res AS $row)
		{
			$data =
			[
				"activeClass" => ((int)$row["id"] === (int)$this->vars["articleCatalogId"]) ? "active" : "",
				"id" => $row["id"],
				"title" => Convert::textUnescape($row["title"]),
				"href" => "/team/".$row["urlName"]."/",
			];
			$html .= $this->objSTemplate->getHtml("team", "teamCatalogListItem", $data);
		}

		$data =
		[
			"activeClass" => (0 === (int)$this->vars["articleCatalogId"]) ? "active" : "",
			"teamCatalogList" => $html,
		];

		return $this->objSTemplate->getHtml("team", "teamCatalogListBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_teamList()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";
		$articleCatalogIdArray = [$this->articleCatalogInfo["id"]];

		if (0 === (int)$this->vars["articleCatalogId"])
		{
			$articleCatalogIdArray = $objMArticleCatalog->getList_id($this->articleCatalogInfo["id"]);
		}

		$parameterArray =
		[
			"articleCatalogIdArray" => $articleCatalogIdArray,
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
			return $this->objSTemplate->getHtml("team", "teamList_empty");
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

		return $this->objSTemplate->getHtml("team", "textBlock", $data);

	}
	
	//*********************************************************************************

	private function getPaginationListHtml()
	{
		$objMArticle = MArticle::getInstance();
		$objPagination = Pagination::getInstance();

		$pageAmount = (int)ceil($objMArticle->getAmount_byParameter($this->articleCatalogInfo["id"]) / GLOB::$SETTINGS["teamAmountInTeamList"]);

		return $objPagination->getPaginationList("/team/", $this->vars["page"], $pageAmount);
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

		//$this->objJavaScript->addJavaScriptFile("/js/team.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$this->objValidation->newCheck();

		$this->objValidation->vars["articleCatalogId"] = 0;

		//-----------------------------------------------------------------------------------

		if (isset($_GET["articleCatalogUrlName"]))
		{
			$rules =
				[
					Validation::exist => "Недостаточно данных [articleCatalogUrlName]",
					Validation::isNoEmpty => "Некоректные данные [articleCatalogUrlName]",
				];

			$this->objValidation->checkVars("articleCatalogUrlName", $rules, $_GET);

			$this->objValidation->vars["articleCatalogId"] = $objMArticleCatalog->getIdByUrlName($this->objValidation->vars["articleCatalogUrlName"]);

			//Проверяем существование с таким id
			if (!$objMArticleCatalog->isExist($this->objValidation->vars["articleCatalogId"]))
			{
				$this->objSOutput->critical("Каталога статей с таким id не существует [".$this->objValidation->vars["articleCatalogId"]."]");
			}
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>