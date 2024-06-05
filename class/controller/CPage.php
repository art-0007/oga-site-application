<?php

class CPage extends CMainInit
{
	/*********************************************************************************/

	//Ключ, отвечающий за отображение страницы
	//если false то произошла ошибка
	private $showPage404Key = false;

	/*********************************************************************************/

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		$this->init();
	}

	/*********************************************************************************/

 	private function init()
 	{
		if(!$this->showPage404Key)
		{
			$this->setJavaScript();

			$objMPage = MPage::getInstance();
			//Достаем информацию о странице
			$pageInfo = $objMPage->getInfo($this->vars["pageId"]);

			$data =
			[
				"id" => $pageInfo["id"],
				"text" => Convert::textUnescape($pageInfo["text"]),
			];

			$pageTitle = $this->getPageTitle($pageInfo);
			$content = "content";

			switch($pageInfo["devName"])
			{
				case "about":
				{
					$objForm = Form::getInstance();

					$data["videoBlock"] = $this->getHtml_videoBlock($pageInfo["addField_lang_1"]);
					$data["someElement1Block"] = $this->getHtml_someElementBlock("someElement1", "");
					$data["someElement2Block"] = $this->getHtml_someElementBlock("someElement2", "bgBlue", "white", "type4");
					$data["teamBlock"] = $this->getHtml_teamBlock();
					$data["partnerBlock"] = $this->getHtml_partnerBlock();
					$data["partnerBlock"] = $this->getHtml_partnerBlock();
					$data["contactUsForm"] = $objForm->getHtml_contactUsForm();
					$content = $content."_".$pageInfo["devName"];

					break;
				}
				case "contacts":
				{
					$objForm = Form::getInstance();


					$data["pageTitle"] = (!empty($pageInfo["pageTitle"]) ? Convert::textUnescape($pageInfo["pageTitle"]) : Convert::textUnescape($pageInfo["title"]));
					$data["imgSrc"] = GLOB::$SETTINGS["pageImgDir"]."/".$pageInfo["fileName1"];
					$data["socialNetworkList"] = $this->getHtml_socialNetworkListItem();
					$data["contactUsForm"] = $objForm->getHtml_contactUsForm();
					$data["description"] = Convert::textUnescape($pageInfo["description"]);
					$data["map"] = Convert::textUnescape($pageInfo["map"]);
					$data["contactsBlock"] = $this->getHtml_contactsBlock();
					$content = $content."_".$pageInfo["devName"];

					$pageTitle = "";

					break;
				}
				default :
				{

					$objDonate = Donate::getInstance();

					$data["donateBlock"] = $objDonate->getHtml_donateBlock();

					$content = "content";
					break;
				}
			}

			//Page Title
			$this->html["pageTitle"] = $pageTitle;
			//Выводим контент страницы
	 		$this->html["content"] = $this->objSTemplate->getHtml("staticPage", $content, $data);
		}
		else
		{
 			$this->setJavaScriptForPage404();

			//Отсылаем заголовок 404
			$this->objSResponse->sendStatus404(false);

			//Page Title
			$this->html["pageTitle"] = "";
			//Выводим информацию, что данная страница недоступна
			$this->html["content"] = $this->objSTemplate->getHtml("pageNotFound", "page");
		}
 	}

	//*********************************************************************************

	private function getPageTitle($pageInfo)
	{
		$data =
		[
			"id" => $pageInfo["id"],
			"pageTitle" => (!empty($pageInfo["pageTitle"]) ? Convert::textUnescape($pageInfo["pageTitle"]) : Convert::textUnescape($pageInfo["title"])),
			"controllerId" => 2,
			"textBlock" => $this->getHtml_pageTitle_textBlock($pageInfo),
		];

		return $this->objSTemplate->getHtml("pageTitle", "content", $data);
	}

	//*********************************************************************************

	private function getHtml_pageTitle_textBlock(&$pageInfo)
	{
		if (0 === mb_strlen($pageInfo["description"]))
		{
			return "";
		}

		$data =
		[
			"description" => Convert::textUnescape($pageInfo["description"]),
		];

		return $this->objSTemplate->getHtml("pageTitle", "textBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_videoBlock($video)
	{
		if (0 === mb_strlen($video))
		{
			return "";
		}

		$data =
		[
			"video" => Convert::textUnescape($video),
		];

		return $this->objSTemplate->getHtml("video", "videoBlock2", $data);
	}

	//*********************************************************************************

	private function getHtml_someElementBlock($articleCatalogDevName, $addBlockClass = "", $textColorClass = "", $addBtnClass = "")
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
				"textColorClass" => $textColorClass,
				"addBtnClass" => $addBtnClass,
				"id" => $row["id"],
				"icoCode" => Convert::textUnescape($row["addField_1"]),
				"href" => "/".$row["urlName"]."/",
				"title" => Convert::textUnescape($row["title"]),
				"description" => Convert::textUnescape($row["description"]),
			];

			$html .= $this->objSTemplate->getHtml("someElement", "someElementListItem_3", $data);
		}

		$data =
		[
			"addBlockClass" => $addBlockClass,
			"textColorClass" => $textColorClass,
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
			"articleCatalogDevName" => Convert::textUnescape($articleCatalogInfo["devName"]),
			"someElementList" => $html,
		];

		return $this->objSTemplate->getHtml("someElement", "someElementBlock_3", $data);
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

	private function getHtml_contactsBlock()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("contacts"));

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
				"title" => Convert::textUnescape($row["title"]),
				"email" => Convert::textUnescape($row["addField_1"]),
				"phone" => Convert::textUnescape($row["addField_2"]),
				"phoneA" => Func::toTelephoneSearch(Convert::textUnescape($row["addField_2"])),
				"address" => Convert::textUnescape($row["addField_lang_1"]),
				"description" => Convert::textUnescape($row["description"]),
			];

			$html .= $this->objSTemplate->getHtml("contacts", "contactsListItem", $data);
		}

		$data =
		[
			"contactsList" => $html,
		];

		return $this->objSTemplate->getHtml("contacts", "contactsBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_socialNetworkListItem()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("socialNetwork"));

		if (false === $articleCatalogInfo)
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

		$counter = 0;
		foreach($res AS $row)
		{
			$counter++;

			$data =
			[
				"id" => $row["id"],
				"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
				"imgSrc2" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName2"],
				"title" => Convert::textUnescape($row["title"]),
				"href" => Convert::textUnescape($row["addField_1"], true),
			];

			$html .= $this->objSTemplate->getHtml("staticPage", "socialNetworkListItem", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function setJavaScript()
	{
	}

	/*********************************************************************************/

	//JS для 404 страницы
	private function setJavaScriptForPage404()
	{
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMPage = MPage::getInstance();

		//Достаем ID страници по ее pageUrlName
		$this->vars["pageId"] = $objMPage->getIdByUrlName($_GET["pageUrlName"]);

		//Если ID страницы не существует то выводим ошибку
		if
		(
			false === $this->vars["pageId"]
			OR
			0 === Func::mb_strcmp("index", $_GET["pageUrlName"])
		)
		{
			$this->showPage404Key = true;
			return;
		}
	}

	/*********************************************************************************/
}

?>