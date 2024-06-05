<?php

class CAdminArticleImage extends CMainAdminFancyBoxInit
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
		$objMArticle = MArticle::getInstance();

		if (false === ($articleInfo = $objMArticle->getInfo($this->vars["articleId"])))
		{
			$this->objSOutput->error("Ошибка выборки информации о статье");
		}

		$pageTitleH1 = "Изображения статьи \"".$articleInfo["title"]."\"";

		$data = array
  		(
  			"articleCatalogId" => $articleInfo["articleCatalogId"],
  		);
		$toolbarButton = $this->objSTemplate->getHtml("adminArticleImage", "toolbarButton", $data);
		$tableHeader = $this->objSTemplate->getHtml("adminArticleImage", "tableHeader_articleImage");

		$addArticleImageHref = "href=\"/admin/article-image/add/".$this->vars["articleId"]."/\"";

		$data = array
		(
  			"pageTitleH1" => $pageTitleH1,
  			"articleId" => $this->vars["articleId"],

			"addArticleImageHref" => $addArticleImageHref,

			"toolbarButton" => $toolbarButton,
  			"tableHeader" => $tableHeader,
  			"articleImageContent" => $this->getArticleImageContentHtml(),
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminArticleImage", "content", $data);
 	}

	//*********************************************************************************

	private function getArticleImageContentHtml()
	{
		return $this->getArticleImageListHtml();
	}

	//*********************************************************************************

	private function getArticleImageListHtml()
	{
		$objMArticleImage = MArticleImage::getInstance();
		$html = "";

		if (false === ($res = $objMArticleImage->getList($this->vars["articleId"])))
		{
			return $this->objSTemplate->getHtml("adminArticleImage", "articleImageList_empty");
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

			$data = array
	   		(
	   			"id" => $row["id"],
				"imgSrc" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName"],
	   			"title" => $row["title"],
	   			"href" => $row["href"],
	   			"position" => $row["position"],
	   			"zebra" => $zebra,
	   		);

			$html .= $this->objSTemplate->getHtml("adminArticleImage", "articleImageListItem", $data);
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
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-article-image-catalog.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-article-image.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMArticle = MArticle::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [articleId]",
			Validation::isNum => "Некоректные данные [articleId]",
		);
		$this->objValidation->checkVars("articleId", $rules, $_GET);

		if (!$objMArticle->isExist($this->objValidation->vars["articleId"]))
		{
			$this->objSOutput->critical("Статьи не найдено в базе данных");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>