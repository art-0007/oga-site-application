<?php

class CAdminArticleImageAdd extends CMainAdminFancyBoxInit
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

		if (false === ($articleInfo = $objMArticle->getInfo($this->vars["articleId"])))
		{
			$this->objSOutput->error("Ошибка выборки информации о статье");
		}

		$data = array
		(
  			"pageTitleH1" => "Создание изображения статьи \"".$articleInfo["title"]."\"",
  			"articleId" => $this->vars["articleId"],

  			"submitButtonTitle" => "Создать",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminArticleImage", "adminArticleImageAdd", $data);
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
		$objMArticle = MArticle::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [articleId]",
			Validation::isNum => "Некоректные данные [articleId]",
		);
		$this->objValidation->checkVars("articleId", $rules, $_GET);

 		//Проверяем существование с таким id
		if (!$objMArticle->isExist($this->objValidation->vars["articleId"]))
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