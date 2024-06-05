<?php

class CAdminArticleEdit extends CMainAdminFancyBoxInit
{
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		$this->setCSS();
		$this->setJavaScript();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$objMArticle = MArticle::getInstance();
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMLang = MLang::getInstance();

		//Достаем формацию о языке
		$langInfo = $objMLang->getInfo(GLOB::$langId);

		if (false === $articleInfo = $objMArticle->getInfo($this->vars["articleId"]))
		{
			$this->objSOutput->critical("Ошибка выборки информации о статье из БД [".$this->vars["articleId"]."]");
		}

        $articleCatalogInfo = $objMArticleCatalog->getInfo($articleInfo["articleCatalogId"]);

		$data =
		[
  			"pageTitleH1" => "Редактирование статьи \"".$articleInfo["title"]."\"",
  			"inputTitleName" => "Название статьи",
  			"articleCatalogId" => $articleInfo["articleCatalogId"],
  			"id" => $articleInfo["id"],
  			"devName" => $articleInfo["devName"],
  			"urlName" => preg_replace("#-a".$this->vars["articleId"]."#iu", "", $articleInfo["urlName"]),
  			"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$articleInfo["fileName1"],
  			"imgSrc2" => GLOB::$SETTINGS["articleImgDir"]."/".$articleInfo["fileName2"],
  			"imgSrc3" => GLOB::$SETTINGS["articleImgDir"]."/".$articleInfo["fileName3"],
			"title" => $articleInfo["title"],
			"position" => $articleInfo["position"],
			"addField_1" => $articleInfo["addField_1"],
			"addField_2" => $articleInfo["addField_2"],
			"addField_3" => $articleInfo["addField_3"],
			"addField_4" => $articleInfo["addField_4"],
			"addField_5" => $articleInfo["addField_5"],
			"addField_6" => $articleInfo["addField_6"],
			"date" => $articleInfo["date"],
			"time" => date("H:i", $articleInfo["time"]),

			"pageTitle" => $articleInfo["pageTitle"],
			"linkToCompany" => $articleInfo["linkToCompany"],
			"description" => $articleInfo["description"],
			"text" => $articleInfo["text"],
			"tag" => $articleInfo["tag"],
		    "addField_lang_1" => $articleInfo["addField_lang_1"],
		    "addField_lang_2" => $articleInfo["addField_lang_2"],
		    "addField_lang_3" => $articleInfo["addField_lang_3"],
		    "addField_lang_4" => $articleInfo["addField_lang_4"],
		    "addField_lang_5" => $articleInfo["addField_lang_5"],
		    "addField_lang_6" => $articleInfo["addField_lang_6"],
			"metaTitle" => $articleInfo["metaTitle"],
			"metaKeywords" => $articleInfo["metaKeywords"],
			"metaDescription" => $articleInfo["metaDescription"],

			"articleImgInCatalogWidth_1" => $articleCatalogInfo["articleImgInCatalogWidth_1"],
			"articleImgInCatalogHeight_1" => $articleCatalogInfo["articleImgInCatalogHeight_1"],
			"articleImgInCatalogWidth_2" => $articleCatalogInfo["articleImgInCatalogWidth_2"],
			"articleImgInCatalogHeight_2" => $articleCatalogInfo["articleImgInCatalogHeight_2"],

			"serviceCatalogListBlock" => "",
			"tagLine" => "",

			"showKey_checked" => (0 === (int)$articleInfo["showKey"]) ? "" : "checked=\"checked\"",

  			"submitButtonTitle" => "Редактировать (".$langInfo["name"].")",
		];

		$templateName = "adminArticleEdit";

		if ($this->isSuitableCatalog($articleCatalogInfo["id"], "donate"))
		{
			if (1 === (int)$articleInfo["addField_1"])
			{
				$data["selected_addField_1_0"] = "";
				$data["selected_addField_1_1"] = "selected=\"selected\"";
			}
			else
			{
				$data["selected_addField_1_0"] = "selected=\"selected\"";
				$data["selected_addField_1_1"] = "";
			}

			if (1 === (int)$articleInfo["addField_2"])
			{
				$data["selected_addField_2_0"] = "";
				$data["selected_addField_2_1"] = "selected=\"selected\"";
			}
			else
			{
				$data["selected_addField_2_0"] = "selected=\"selected\"";
				$data["selected_addField_2_1"] = "";
			}

			$templateName = "adminArticleEdit_donate";
		}
		elseif ($this->isSuitableCatalog($articleCatalogInfo["id"], "getInvolved"))
		{
			if (1 === (int)$articleInfo["addField_1"])
			{
				$data["selected_0"] = "";
				$data["selected_1"] = "selected=\"selected\"";
			}
			else
			{
				$data["selected_0"] = "selected=\"selected\"";
				$data["selected_1"] = "";
			}

			$templateName = "adminArticleEdit_getInvolved";
		}
		elseif ($this->isSuitableCatalog($articleCatalogInfo["id"], "project"))
		{
			$data["donateSelect"] = $this->getHtml_donateSelect($articleInfo["addField_3"]);

			if (1 === (int)$articleInfo["addField_4"])
			{
				$data["selected_addField_4_0"] = "";
				$data["selected_addField_4_1"] = "selected=\"selected\"";
			}
			else
			{
				$data["selected_addField_4_0"] = "selected=\"selected\"";
				$data["selected_addField_4_1"] = "";
			}

			if (1 === (int)$articleInfo["addField_lang_4"])
			{
				$data["selected_addField_lang_4_0"] = "";
				$data["selected_addField_lang_4_1"] = "selected=\"selected\"";
			}
			else
			{
				$data["selected_addField_lang_4_0"] = "selected=\"selected\"";
				$data["selected_addField_lang_4_1"] = "";
			}

			$templateName = "adminArticleEdit_project";
		}
		elseif ($this->isSuitableCatalog($articleCatalogInfo["id"], "projectVideo"))
		{
			$data["donateSelect"] = $this->getHtml_donateSelect($articleInfo["addField_3"]);

			if (1 === (int)$articleInfo["addField_4"])
			{
				$data["selected_addField_4_0"] = "";
				$data["selected_addField_4_1"] = "selected=\"selected\"";
			}
			else
			{
				$data["selected_addField_4_0"] = "selected=\"selected\"";
				$data["selected_addField_4_1"] = "";
			}

			if (1 === (int)$articleInfo["addField_lang_4"])
			{
				$data["selected_addField_lang_4_0"] = "";
				$data["selected_addField_lang_4_1"] = "selected=\"selected\"";
			}
			else
			{
				$data["selected_addField_lang_4_0"] = "selected=\"selected\"";
				$data["selected_addField_lang_4_1"] = "";
			}

			$templateName = "adminArticleEdit_projectVideo";
		}
		elseif ($this->isSuitableCatalog($articleCatalogInfo["id"], "team"))
		{
			$templateName = "adminArticleEdit_team";
		}
		elseif ($this->isSuitableCatalog($articleCatalogInfo["id"], "gallery"))
		{
			$templateName = "adminArticleEdit_gallery";
		}
		elseif ($this->objSTemplate->isExistTemplate("adminArticle", "adminArticleEdit_".$articleCatalogInfo["devName"]))
		{
			$templateName = "adminArticleEdit_".$articleCatalogInfo["devName"];
		}

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminArticle", $templateName, $data);
 	}

	//*********************************************************************************

	private function isSuitableCatalog($articleCatalogId, $devName)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();

		if (false === ($articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId)))
		{
			return false;
		}

		if (0 === Func::mb_strcmp($articleCatalogInfo["devName"], $devName))
		{
			return true;
		}

		if (0 === (int)$articleCatalogInfo["articleCatalog_id"])
		{
			return false;
		}

		return $this->isSuitableCatalog($articleCatalogInfo["articleCatalog_id"], $devName);
	}

	//*********************************************************************************

	private function getHtml_orderPaySystemSelect($onlinePaySystemId)
	{
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();

		$html = "<option value=''>[НЕ ВЫБРАНО]</option>";

		if (($res = $objMOnlinePaySystem->getList()) !== false)
		{
			foreach($res AS $row)
			{
				$selected = "";

				if ((int)$row["id"] === (int)$onlinePaySystemId)
				{
					$selected = "selected='selected'";
				}

				$html .= "<option value='".$row["id"]."' ".$selected.">".Convert::textUnescape($row["title"])."</option>";
			}
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_donateSelect($donateId)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("donate"));

		$html = "<option value=''>[НЕ ВЫБРАНО]</option>";

		$parameterArray =
		[
			"articleCatalogIdArray" => $articleCatalogInfo["id"],
			"orderType" => $articleCatalogInfo["orderInCatalog"],
			"showKey" => 1,
		];

		if
		(
			false === $articleCatalogInfo
			OR
			false === ($res = $objMArticle->getList($parameterArray))
		)
		{
			return $html;
		}

		foreach($res AS $row)
		{
			$selected = "";

			if ((int)$row["id"] === (int)$donateId)
			{
				$selected = "selected='selected'";
			}

			$html .= "<option value='".$row["id"]."' ".$selected.">".Convert::textUnescape($row["title"])."</option>";
		}

		return $html;
	}

	//*********************************************************************************

	private function serviceCatalogListBlock()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticleCatalogArticle = MArticleCatalogArticle::getInstance();

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("services"));

		$parameterArray =
		[
			"articleCatalogIdArray" => [$articleCatalogInfo["id"]],
		];

		if (false === ($res = $objMArticleCatalog->getList($parameterArray)))
		{
			return "";
		}

		$html = "";

		foreach ($res AS $row)
		{
			$html2 = "";
			$parameterArray =
			[
				"articleCatalogIdArray" => [$row["id"]],
			];

			if (false === ($res2 = $objMArticleCatalog->getList($parameterArray)))
			{
				continue;
			}

			foreach ($res2 AS $row2)
			{
				$data =
				[
					"id" => $row2["id"],
					"checked" => ($objMArticleCatalogArticle->isExist($row2["id"], $this->vars["articleId"])) ? "checked=\"checked\"" : "",
					"title" => Convert::textUnescape($row2["title"], true),
				];
				$html2 .= $this->objSTemplate->getHtml("adminArticle", "subArticleCatalogListItem", $data);
			}

			$data =
			[
				"articleCatalogTitle" => trim(Convert::textUnescape($row["title"], true)),
				"subArticleCatalogList" => $html2,
			];
			$html .= $this->objSTemplate->getHtml("adminArticle", "articleCatalogListItem_2", $data);
		}

		$data =
		[
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"], false),
			"articleCatalogList" => $html,
		];
		return $this->objSTemplate->getHtml("adminArticle", "articleCatalogListBlock", $data);
	}

	//*********************************************************************************

	private function getTagListHtml($articleCatalogId)
	{
		$objMArticle = MArticle::getInstance();
		$html = "";
		$tagList = array();

		if (false === ($res = $objMArticle->getList($articleCatalogId)))
		{
			return "";
		}

		foreach($res AS $row)
  		{
			$tagList_temp = preg_split("#\\r\\n#iu", $row["tag"], -1, PREG_SPLIT_NO_EMPTY);

			foreach($tagList_temp AS $index => $value)
	  		{
	  			if (!in_array($value, $tagList))
	  			{
	  				$tagList[] = $value;
	  			}
	  		}
  		}

		if (0 === count($tagList))
		{
			return "";
		}

		foreach($tagList AS $index => $value)
  		{
			$data = array
	  		(
	  			"title" => trim(Convert::textUnescape($value, false)),
	  		);

			$html .= $this->objSTemplate->getHtml("adminArticle", "tagListItem", $data);
  		}

		return $html;
	}

	//*********************************************************************************

	private function setCSS()
	{
	   $this->objCSS->addCSSFile("/js/jquery/themes/astrid-theme/jquery-ui.css");
	   $this->objCSS->addCSSFile("/js/jquery/themes/astrid-theme/jquery-ui-timepicker-addon.css");
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$objMArticle = MArticle::getInstance();

		$this->objJavaScript->addJavaScriptCode("var _articleCatalogId = \"".$objMArticle->getArticleCatalogId($this->vars["articleId"])."\";");
		$this->objJavaScript->addJavaScriptCode("var _articleId = \"".$this->vars["articleId"]."\";");

		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");

		$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery-ui-timepicker-addon.js");
		$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery.ui.datepicker-ru.js");

		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-article.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-article-one-image-delete.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMArticle = MArticle::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [articleId]",
			Validation::isNum => "Некоректные данные [articleId]",
		);
		$this->objValidation->checkVars("articleId", $rules, $_GET);

 		//Проверяем существование с таким id
  		if (false === $objMArticle->isExist($this->objValidation->vars["articleId"]))
  		{
  			$this->objSOutput->critical("Статьи с таким id не существует [".$this->objValidation->vars["articleId"]."]");
  		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>
