<?php

class CProject extends CMainInit
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
		//$objDonate = Donate::getInstance();
		$objProject = Project::getInstance();

		if (0 === (int)$this->vars["articleCatalogId"])
		{
			$this->articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("project"));
		}
		else
		{
			$this->articleCatalogInfo = $objMArticleCatalog->getInfo($this->vars["articleCatalogId"]);
		}

		$devName = $objMArticleCatalog->getDevName($this->articleCatalogInfo["articleCatalog_id"]);

		if
		(
			(0 === (int)$this->vars["articleCatalogId"])
			OR
			(
				(int)$this->articleCatalogInfo["articleCatalog_id"] > 0 AND Func::isCaseCmp("project", $devName)
			)
		)
		{
			$data =
			[
				"projectCatalogList" => $this->getHtml_projectCatalogList(),
				"projectList" => $objProject->getHtml_projectList($this->articleCatalogInfo["id"], 2, null, false),
				"text" => Convert::textUnescape($this->articleCatalogInfo["text"]),
				"someElement2Block" => $this->getHtml_someElementBlock("someElement2"),
				//"donateBlock" => $objDonate->getHtml_donateBlock(),
				//"paginationList" => $this->getPaginationListHtml(),
			];

			$content = "content";

		}
		else
		{
			$fileName = $this->articleCatalogInfo["fileName2"];

			if (0 === mb_strlen($this->articleCatalogInfo["fileName2"]))
			{
				$fileName = $this->articleCatalogInfo["fileName1"];
			}

			$data =
			[
				"topSliderBlock" => $this->getHtml_sliderBlock($this->articleCatalogInfo["addField_5"]),
				"imgSrc" => GLOB::$SETTINGS["articleCatalogImgDir"]."/".$fileName,
				"text" => $this->getHtml_text($this->articleCatalogInfo["text"]),
				"projectBlock" => $objProject->getHtml_projectBlock2($this->articleCatalogInfo["id"], 1, null, false),
				"videoBlock" => $this->getHtml_videoBlock($this->articleCatalogInfo),
				"projectVideoBlock" => $this->getHtml_projectVideoBlock($this->articleCatalogInfo),
				"bottomSliderBlock" => $this->getHtml_sliderBlock($this->articleCatalogInfo["addField_6"]),
			];

			$content = "content_view";
		}

		$this->html["pageTitle"] = $this->getPageTitle();
		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("project", $content, $data);
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

	private function getHtml_projectCatalogList()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$html = "";

		$parameterArray =
		[
			"articleCatalogIdArray" => $objMArticleCatalog->getIdByDevName("project"),
		];

		if (false === ($res = $objMArticleCatalog->getList($parameterArray)))
		{
			return "";
		}

		$articleCatalogIdArray = ["renovation", "other"];

		foreach ($res AS $row)
		{
			if (in_array($row["devName"], $articleCatalogIdArray))
			{
				continue;
			}

			$data =
			[
				"activeClass" => ((int)$row["id"] === (int)$this->vars["articleCatalogId"]) ? "active" : "",
				"id" => $row["id"],
				"img" => Convert::textUnescape($row["addField_2"]),
				"title" => Convert::textUnescape($row["title"]),
				"href" => "/project/".$row["urlName"]."/",
				"priority" => (1 === (int)$row["addField_1"]) ? $this->objSTemplate->getHtml("project", "priority") : "",
			];
			$html .= $this->objSTemplate->getHtml("project", "projectCatalogListItem", $data);
		}

		$data =
		[
			"activeClass" => (0 === (int)$this->vars["articleCatalogId"]) ? "active" : "",
			"projectCatalogList" => $html,
		];

		return $this->objSTemplate->getHtml("project", "projectCatalogListBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_text($text)
	{
		$text = Convert::textUnescape($text);

		$galleryCatalogIdArray = [];

		preg_match_all("#\{ivSlider_([0-9]+)\}#i", $text, $galleryCatalogIdArray);

		if (count($galleryCatalogIdArray[1]) > 0)
		{
			foreach ($galleryCatalogIdArray[1] as $galleryCatalogId)
			{
				$html = $this->getHtml_slider($galleryCatalogId, 2);

				$text = strtr($text, ["{ivSlider_".$galleryCatalogId."}" => $html]);
			}
		}

		$text = preg_replace("#<iframe#ui", "<div class=\"videoIframe\"><div><iframe", $text);
		$text = preg_replace("#</iframe>#ui", "</iframe></div></div>", $text);

		return $text;
	}

	//*********************************************************************************

	private function getHtml_sliderBlock($addField, $type = 1)
	{
		$html = "";

		if (!Func::isEmpty($addField))
		{
			//Разбиваем текст на массив с ИД
			$galleryCatalogIdArray = preg_split("#,#", $addField, -1, PREG_SPLIT_NO_EMPTY);

			foreach ($galleryCatalogIdArray as $galleryCatalogId)
			{
				$html .= $this->getHtml_slider($galleryCatalogId, $type);
			}
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_slider($galleryCatalogId, $type = 1)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		if (($articleCatalogInfo = $objMArticleCatalog->getInfo($galleryCatalogId)) !== false)
		{
			$parameterArray =
			[
				"articleCatalogIdArray" => $articleCatalogInfo["id"],
				"orderType" => $articleCatalogInfo["orderInCatalog"],
				"showKey" => 1,
			];

			$listItemHtml = "";

			if (($res = $objMArticle->getList($parameterArray)) !== false)
			{
				foreach ($res AS $row)
				{
					$href = Convert::textUnescape($row["addField_lang_1"], true);
					$code = "";

					if (stripos($href, "https://youtu.be/") !== false)
					{
						$code = str_replace("https://youtu.be/", "", $href);
					}
					elseif (stripos($href, "https://www.youtube.com/embed/") !== false)
					{
						$code = str_replace("https://www.youtube.com/embed/", "", $href);
					}
					elseif (stripos($href, "https://www.youtube.com/watch?v=") !== false)
					{
						$code = str_replace("https://www.youtube.com/watch?v=", "", $href);
					}
					elseif (stripos($href, "https://www.youtube.com/shorts/") !== false)
					{
						$code = str_replace("https://www.youtube.com/shorts/", "", $href);
						$code = str_replace("?feature=share", "", $code);

						$href = "https://www.youtube.com/watch?v=".$code;
					}


					$data =
					[
						"articleCatalogId" => $articleCatalogInfo["id"],
						"id" => $row["id"],
						"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
						"code" => $code,
						"href" => $href,
						"titleAlt" => Convert::textUnescape($row["title"], true),
						"title" => Convert::textUnescape($row["title"]),
						"description" => Convert::textUnescape($row["description"]),
					];

					if (Func::isEmpty($row["addField_lang_1"]))
					{
						$listItemHtml .= $this->objSTemplate->getHtml("slider", "ivSliderListItem", $data);
					}
					else
					{
						$listItemHtml .= $this->objSTemplate->getHtml("slider", "ivSliderListItem2", $data);
					}
				}

				$data =
					[
						"articleCatalogId" => $articleCatalogInfo["id"],
						"ivSliderList" => $listItemHtml,
					];

				if (1 === $type)
				{
					$html .= $this->objSTemplate->getHtml("slider", "ivSliderBlock", $data);
				}
				else if (2 === $type)
				{
					$html .= $this->objSTemplate->getHtml("slider", "ivSliderBlock2", $data);
				}
			}
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_videoBlock(&$articleInfo)
	{
		if (0 === mb_strlen($articleInfo["addField_lang_3"]))
		{
			return "";
		}

		$data =
			[
				"articleCatalogTitle" => Convert::textUnescape($articleInfo["addField_lang_1"]),
				"description" => Convert::textUnescape($articleInfo["addField_lang_2"]),
				"video" => Convert::textUnescape($articleInfo["addField_lang_3"]),
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
				"addBtnClass" => "",
				"addDescriptionClass" => "",
				"id" => $row["id"],
				"icoCode" => Convert::textUnescape($row["addField_1"]),
				"href" => "/".$row["urlName"]."/",
				"title" => Convert::textUnescape($row["title"]),
				"description" => Convert::textUnescape($row["description"]),
			];

			$html .= $this->objSTemplate->getHtml("someElement", "someElementListItem_2", $data);
		}

		$data =
		[
			"addClass" => "",
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
			"articleCatalogDevName" => Convert::textUnescape($articleCatalogInfo["devName"]),
			"someElementList" => $html,
		];

		return $this->objSTemplate->getHtml("someElement", "someElementBlock_2", $data);
	}

	//*********************************************************************************

	private function getHtml_projectVideoBlock(&$this_articleCatalogInfo)
	{
		if (0 === mb_strlen($this_articleCatalogInfo["addField_lang_6"]))
		{
			return "";
		}
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($this_articleCatalogInfo["addField_lang_6"]);

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
			$href = Convert::textUnescape($row["addField_lang_1"], true);
			$code = "";

			if (stripos($href, "https://youtu.be/") !== false)
			{
				$code = str_replace("https://youtu.be/", "", $href);
			}
			elseif (stripos($href, "https://www.youtube.com/embed/") !== false)
			{
				$code = str_replace("https://www.youtube.com/embed/", "", $href);
			}
			elseif (stripos($href, "https://www.youtube.com/watch?v=") !== false)
			{
				$code = str_replace("https://www.youtube.com/watch?v=", "", $href);
			}
			elseif (stripos($href, "https://www.youtube.com/shorts/") !== false)
			{
				$code = str_replace("https://www.youtube.com/shorts/", "", $href);
				$code = str_replace("?feature=share", "", $code);

				$href = "https://www.youtube.com/watch?v=".$code;
			}

			$data =
			[
				"id" => $row["id"],
				"code" => $code,
				"href" => $href,
				"title" => Convert::textUnescape($row["title"]),
				"btnBlock" => (1 === (int)$row["addField_lang_4"]) ? $this->objSTemplate->getHtml("projectVideo", "btnBlock", ["id" => $row["id"]]) : "",
			];

			$html .= $this->objSTemplate->getHtml("projectVideo", "projectVideoListItem", $data);
		}

		$data =
			[
				"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
				"projectVideoList" => $html,
			];

		return $this->objSTemplate->getHtml("projectVideo", "projectVideoBlock", $data);
	}

	//*********************************************************************************

	private function getPaginationListHtml()
	{
		$objMArticle = MArticle::getInstance();
		$objPagination = Pagination::getInstance();

		$pageAmount = (int)ceil($objMArticle->getAmount_byParameter($this->articleCatalogInfo["id"]) / GLOB::$SETTINGS["projectAmountInProjectList"]);

		return $objPagination->getPaginationList("/project/", $this->vars["page"], $pageAmount);
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

		$this->objJavaScript->addJavaScriptFile("/js/project.js");
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
