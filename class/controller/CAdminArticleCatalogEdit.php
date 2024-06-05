<?php

class CAdminArticleCatalogEdit extends CMainAdminFancyBoxInit
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
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objArticleCatalog = ArticleCatalog::getInstance();

		if (false === $articleCatalogInfo = $objMArticleCatalog->getInfo($this->vars["articleCatalogId"]))
		{
			$this->objSOutput->critical("Ошибка выборки информации о каталоге статей из БД [".$this->vars["articleCatalogId"]."]");
		}

		$data =
		[
  			"pageTitleH1" => "Редактирование каталога \"".$articleCatalogInfo["title"]."\"",
  			"id" => $articleCatalogInfo["id"],
  			"articleCatalogId" => $articleCatalogInfo["id"],
  			"parentArticleCatalogId" => $articleCatalogInfo["articleCatalog_id"],
  			"urlName" => preg_replace("#-ac".$this->vars["articleCatalogId"]."#iu", "", $articleCatalogInfo["urlName"]),
			"devName" => $articleCatalogInfo["devName"],
			"position" => $articleCatalogInfo["position"],

			"showKey_checked" => (0 === (int)$articleCatalogInfo["showKey"]) ? "" : "checked=\"checked\"",

		    "addField_1" => $articleCatalogInfo["addField_1"],
		    "addField_2" => $articleCatalogInfo["addField_2"],
		    "addField_3" => $articleCatalogInfo["addField_3"],
		    "addField_4" => $articleCatalogInfo["addField_4"],
		    "addField_5" => $articleCatalogInfo["addField_5"],
		    "addField_6" => $articleCatalogInfo["addField_6"],

		    "imgSrc1" => GLOB::$SETTINGS["articleCatalogImgDir"]."/".$articleCatalogInfo["fileName1"],
			"imgSrc2" => GLOB::$SETTINGS["articleCatalogImgDir"]."/".$articleCatalogInfo["fileName2"],
			"imgSrc3" => GLOB::$SETTINGS["articleCatalogImgDir"]."/".$articleCatalogInfo["fileName3"],

			"catalogImgWidth_1" => $articleCatalogInfo["catalogImgWidth_1"],
			"catalogImgHeight_1" => $articleCatalogInfo["catalogImgHeight_1"],
			"catalogImgWidth_2" => $articleCatalogInfo["catalogImgWidth_2"],
			"catalogImgHeight_2" => $articleCatalogInfo["catalogImgHeight_2"],
			"catalogImgWidth_3" => $articleCatalogInfo["catalogImgWidth_3"],
			"catalogImgHeight_3" => $articleCatalogInfo["catalogImgHeight_3"],

			"articleImgInCatalogWidth_1" => $articleCatalogInfo["articleImgInCatalogWidth_1"],
			"articleImgInCatalogHeight_1" => $articleCatalogInfo["articleImgInCatalogHeight_1"],
			"articleImgInCatalogWidth_2" => $articleCatalogInfo["articleImgInCatalogWidth_2"],
			"articleImgInCatalogHeight_2" => $articleCatalogInfo["articleImgInCatalogHeight_2"],

			"addField_lang_1" => $articleCatalogInfo["addField_lang_1"],
			"addField_lang_2" => $articleCatalogInfo["addField_lang_2"],
			"addField_lang_3" => $articleCatalogInfo["addField_lang_3"],
			"addField_lang_4" => $articleCatalogInfo["addField_lang_4"],
			"addField_lang_5" => $articleCatalogInfo["addField_lang_5"],
			"addField_lang_6" => $articleCatalogInfo["addField_lang_6"],

			"title" => $articleCatalogInfo["title"],
			"pageTitle" => $articleCatalogInfo["pageTitle"],
			"description" => $articleCatalogInfo["description"],
			"text" => $articleCatalogInfo["text"],
			"metaTitle" => $articleCatalogInfo["metaTitle"],
			"metaKeywords" => $articleCatalogInfo["metaKeywords"],
			"metaDescription" => $articleCatalogInfo["metaDescription"],

			"orderInCatalogSelect" => $this->getOrderInCatalogSelectHtml($articleCatalogInfo["orderInCatalog"]),
			"designTypeSelect" => $this->getDesignTypeSelectHtml($articleCatalogInfo["designType"]),

  			"adminFileCatalogField" => "",
  			"articleParameterSelect" => "",

  			"submitButtonTitle" => "Редактировать",
		];

		$templateName = "adminArticleCatalogEdit";

		if ((int)$articleCatalogInfo["articleCatalog_id"] > 0 AND $objArticleCatalog->isSuitableCatalog($articleCatalogInfo["articleCatalog_id"], "project"))
		{
			$devName = $objMArticleCatalog->getDevName($articleCatalogInfo["articleCatalog_id"]);

			if (Func::isCaseCmp("project", $devName))
			{
				//Подкаталоги первого уровня (Фильтра)

				if (1 === (int)$articleCatalogInfo["addField_1"])
				{
					$data["selected_0"] = "";
					$data["selected_1"] = "selected=\"selected\"";
				}
				else
				{
					$data["selected_0"] = "selected=\"selected\"";
					$data["selected_1"] = "";
				}

				$templateName = "adminArticleCatalogEdit_sub_project";
			}
			else
			{
				//Подкаталоги > первого уровня (Проекты)

				$data["donateSelect"] = $this->getHtml_donateSelect($articleCatalogInfo["addField_3"]);

				if (1 === (int)$articleCatalogInfo["addField_4"])
				{
					$data["selected_addField_4_0"] = "";
					$data["selected_addField_4_1"] = "selected=\"selected\"";
				}
				else
				{
					$data["selected_addField_4_0"] = "selected=\"selected\"";
					$data["selected_addField_4_1"] = "";
				}

				if (1 === (int)$articleCatalogInfo["addField_lang_4"])
				{
					$data["selected_addField_lang_4_0"] = "";
					$data["selected_addField_lang_4_1"] = "selected=\"selected\"";
				}
				else
				{
					$data["selected_addField_lang_4_0"] = "selected=\"selected\"";
					$data["selected_addField_lang_4_1"] = "";
				}

				$templateName = "adminArticleCatalogEdit_sub_project_project";
			}
		}
		if (0 === Func::mb_strcmp($articleCatalogInfo["devName"], "getInvolved"))
		{
			$data1 =
			[
				"addField_3" => $articleCatalogInfo["addField_3"],
			];
			$data["adminFileCatalogField"] = $this->objSTemplate->getHtml("adminArticle", "adminFileCatalogField", $data1);
		}
		elseif ($this->objSTemplate->isExistTemplate("adminArticle", "adminArticleCatalogEdit_".$articleCatalogInfo["devName"]))
		{
			$templateName = "adminArticleCatalogEdit_".$articleCatalogInfo["devName"];
		}

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminArticle", $templateName, $data);
 	}

	//*********************************************************************************

	private function getOrderInCatalogSelectHtml($orderInCatalog)
	{
		$html = "";

		foreach(EOrderInArticleCatalogType::$orderInArticleCatalogTypeTitleArray AS $index => $value)
		{
			if ((int)$orderInCatalog === (int)$index)
			{
				$html .= "<option value='".$index."' selected=\"selected\">".$value."</option>";
			}
			else
			{
				$html .= "<option value='".$index."'>".$value."</option>";
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

	private function getDesignTypeSelectHtml($designType)
	{
		$html = "";

		foreach(EArticleCatalogDesignType::$typeTitleArray AS $index => $value)
		{
			if ((int)$designType === (int)$index)
			{
				$html .= "<option value='".$index."' selected=\"selected\">".$value."</option>";
			}
			else
			{
				$html .= "<option value='".$index."'>".$value."</option>";
			}
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_articleParameterSelect($articleParameterId)
	{
  		$objMArticleParameter = MArticleParameter::getInstance();
		$html = "";

		if (false === ($res = $objMArticleParameter->getList()))
		{
			return "";
		}

		$html .= "<option value='0'>[ВЫБРАТЬ]</option>";

		foreach($res AS $row)
  		{
			if ((int)$articleParameterId === (int)$row["id"])
			{
				$html .= "<option value='".$row["id"]."' selected=\"selected\">".$row["title"]."</option>";
			}
			else
			{
				$html .= "<option value='".$row["id"]."'>".$row["title"]."</option>";
			}
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
		$objMArticleCatalog = MArticleCatalog::getInstance();

		$this->objJavaScript->addJavaScriptCode("var _articleCatalogId = \"".$this->vars["articleCatalogId"]."\";");
		$this->objJavaScript->addJavaScriptCode("var _parentArticleCatalogId = \"".$objMArticleCatalog->getParentId($this->vars["articleCatalogId"])."\";");

		$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery-ui-timepicker-addon.js");
		$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery.ui.datepicker-ru.js");

		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-article-catalog.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [articleCatalogId]",
			Validation::isNum => "Некоректные данные [articleCatalogId]",
		);

		$this->objValidation->checkVars("articleCatalogId", $rules, $_GET);

 		//Проверяем существование с таким id
		if (!$objMArticleCatalog->isExist($this->objValidation->vars["articleCatalogId"]))
		{
			$this->objSOutput->critical("Каталог статей не найдено в базе данных");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>
