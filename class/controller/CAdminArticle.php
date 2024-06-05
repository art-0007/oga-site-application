<?php

class CAdminArticle extends CMainAdminFancyBoxInit
{
	//*********************************************************************************
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
		$objMArticle = MArticle::getInstance();
		$pageTitleH1 = "Статьи / Новости";
		$toolbarButton = "";
		$tableHeader = "";
		$addArticlCatalogHref = "href=\"/admin/article-catalog/add/".$this->vars["articleCatalogId"]."/\"";
		$addArticlHref = "href=\"/admin/article/add/".$this->vars["articleCatalogId"]."/\"";

		if ((int)$this->vars["articleCatalogId"] !== 0)
		{
			$articleCatalogInfo = $objMArticleCatalog->getInfo($this->vars["articleCatalogId"]);

			$pageTitleH1 = "Каталог: \"".$articleCatalogInfo["title"]."\"";

			$data = array
	  		(
	  			"articleCatalogId" => $articleCatalogInfo["articleCatalog_id"],
	  		);
			$toolbarButton = $this->objSTemplate->getHtml("adminArticle", "toolbarButton", $data);
		}

		if ($objMArticleCatalog->hasChild($this->vars["articleCatalogId"]))
		{
			$addArticlHref = "href=\"javascript: void(0);\" onclick=\"alert('Создание статьи заблокировано. Каталог имеет дочерние каталоги');\"";
			$tableHeader = $this->objSTemplate->getHtml("adminArticle", "tableHeader_catalog");
		}
		else
		{
			if ($objMArticle->isExistByArticleCatalogId($this->vars["articleCatalogId"]))
			{
				$addArticlCatalogHref = "href=\"javascript: void(0);\" onclick=\"alert('Создание каталога заблокировано. Каталог имеет статьи');\"";
			}

			$tableHeader = $this->objSTemplate->getHtml("adminArticle", "tableHeader_article");
		}

		$data =
		[
  			"pageTitleH1" => $pageTitleH1,
  			"articleCatalogId" => $this->vars["articleCatalogId"],

			"addArticlCatalogHref" => $addArticlCatalogHref,
			"addArticlHref" => $addArticlHref,

			"toolbarButton" => $toolbarButton,
  			"tableHeader" => $tableHeader,
  			"articleContent" => $this->getArticleContentHtml(),
		];

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminArticle", "content", $data);
 	}

	//*********************************************************************************

	private function getArticleContentHtml()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();

		if ($objMArticleCatalog->hasChild($this->vars["articleCatalogId"]))
		{
			return $this->getArticleCatalogListHtml();
		}
		else
		{
			return $this->getArticleListHtml();
		}
	}

	//*********************************************************************************

	private function getArticleCatalogListHtml()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$html = "";

		$parameterArray = array
  		(
  			"articleCatalogIdArray" => $this->vars["articleCatalogId"],
  		);

		if (false === ($res = $objMArticleCatalog->getList($parameterArray)))
		{
			return $this->objSTemplate->getHtml("adminArticle", "articleCatalogList_empty");
		}

		$count = 0;
		foreach ($res AS $row)
		{
			$count++;
			if (0 === ($count % 2))
			{
				$zebra = "zebra";
			}
			else
			{
				$zebra = "";
			}

			$data =
	   		[
	   			"id" => $row["id"],
	   			"title" => $row["title"],
	   			"devName" => $row["devName"],
	   			"href" => "/admin/article/".$row["id"]."/",
	   			"position" => $row["position"],
	   			"show" => (0 === (int)$row["showKey"]) ? "Нет" : "",
	   			"zebra" => $zebra,
	   		];

			$html .= $this->objSTemplate->getHtml("adminArticle", "articleCatalogListItem", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function getArticleListHtml()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($this->vars["articleCatalogId"]);

		$parameterArray =
  		[
  			"articleCatalogIdArray" => $articleCatalogInfo["id"],
  			"orderType" => $articleCatalogInfo["orderInCatalog"],
  		];

		if (false === ($res = $objMArticle->getList($parameterArray)))
		{
			return $this->objSTemplate->getHtml("adminArticle", "articleList_empty");
		}

		$count = 0;
		foreach ($res AS $row)
		{
			$count++;

			$data =
	   		[
	   			"id" => $row["id"],
				"imgSrc" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
	   			"title" => $row["title"],
	   			"date" => Convert::dateFromISOToGOST($row["date"], "-", "-"),
	   			"time" => date("H:i:s", $row["time"]),
	   			"position" => $row["position"],
	   			"show" => (0 === (int)$row["showKey"]) ? "Нет" : "",
	   			"zebra" => (0 === ($count % 2)) ? "zebra" : "",
	   		];

			$html .= $this->objSTemplate->getHtml("adminArticle", "articleListItem", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-article-catalog.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-article.js");
		$this->objJavaScript->addJavaScriptCode("var _articleCatalogId = \"".$this->vars["articleCatalogId"]."\";");

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

		if ((int)$this->objValidation->vars["articleCatalogId"] !== 0 AND !$objMArticleCatalog->isExist($this->objValidation->vars["articleCatalogId"]))
		{
			$this->objSOutput->critical("Каталога статей не найдено в базе данных");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>