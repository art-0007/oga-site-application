<?php

class CAdminArticleImageEdit extends CMainAdminFancyBoxInit
{
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
		$objMArticleImage = MArticleImage::getInstance();
		$objMLang = MLang::getInstance();

		//Достаем формацию о языке
		$langInfo = $objMLang->getInfo(GLOB::$langId);

		if (false === $articleImageInfo = $objMArticleImage->getInfo($this->vars["articleImageId"]))
		{
			Error::message("STOP");
		}

		$data = array
		(
  			"pageTitleH1" => "Редактирование изображения статьи \"".Convert::textUnescape($objMArticle->getTitle($articleImageInfo["article_id"]))."\"",
  			"articleId" => $articleImageInfo["article_id"],
  			"articleImageId" => $articleImageInfo["id"],
  			"imgSrc" => GLOB::$SETTINGS["articleImgDir"]."/".$articleImageInfo["fileName"],
  			"href" => $articleImageInfo["href"],
			"title" => $articleImageInfo["title"],
  			"position" => $articleImageInfo["position"],
			"text" => $articleImageInfo["text"],

  			"submitButtonTitle" => "Редактировать (".$langInfo["name"].")",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminArticleImage", "adminArticleImageEdit", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-article-image.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMArticleImage = MArticleImage::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [articleImageId]",
			Validation::isNum => "Некоректные данные [articleImageId]",
		);
		$this->objValidation->checkVars("articleImageId", $rules, $_GET);

 		//Проверяем существование с таким id
  		if (false === $objMArticleImage->isExist($this->objValidation->vars["articleImageId"]))
  		{
  			$this->objSOutput->critical("Изображения статьи с таким id не существует [".$this->objValidation->vars["sliderImageId"]."]");
  		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>