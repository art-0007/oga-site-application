<?php

class CArticleView extends CMainInit
{
	/*********************************************************************************/

	//Ключ, отвечающий за отображение страницы
	//если false то произошла ошибка
	private $showPage404Key = false;

	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		if(!$this->showPage404Key)
		{
			$this->setJavaScript();

			$objMArticle = MArticle::getInstance();

			if (false === ($articleInfo = $objMArticle->getInfo($this->vars["articleId"])))
			{
				$this->objSOutput->error("Ошибка выборки информации о статье");
			}

			$fileName = $articleInfo["fileName2"];

			if (0 === mb_strlen($articleInfo["fileName2"]))
			{
				$fileName = $articleInfo["fileName1"];
			}

			$data = array
			(
				"id" => $this->vars["articleId"],
				"pageTitle" => (!empty($articleInfo["pageTitle"]) ? Convert::textUnescape($articleInfo["pageTitle"]) : Convert::textUnescape($articleInfo["title"])),
				"imgSrc" => GLOB::$SETTINGS["articleImgDir"]."/".$fileName,
				"text" => Convert::textUnescape($articleInfo["text"]),
				"socBlock" => $this->objSTemplate->getHtml("socBlock", "content"),
			);

			//Page Title
			$this->html["pageTitle"] = $this->getPageTitle($articleInfo);
			//Контент страницы
			$this->html["content"] = $this->objSTemplate->getHtml("article", "content_view", $data);
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

	private function getPageTitle($articleInfo)
	{
		$data = array
  		(
  			"id" => $articleInfo["id"],
  			"pageTitle" => (!empty($articleInfo["pageTitle"]) ? Convert::textUnescape($articleInfo["pageTitle"]) : Convert::textUnescape($articleInfo["title"])),
  			"controllerId" => 4,
  		);

  		return $this->objSTemplate->getHtml("pageTitle", "content", $data);
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		//$this->objJavaScript->addJavaScriptFile("/js/article_view.js");

		$this->objJavaScript->addJavaScriptCode("var _articleId = ".$this->vars["articleId"].";");
	}

	/*********************************************************************************/

	//JS для 404 страницы
	private function setJavaScriptForPage404()
	{
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();

		//-------------------------------------------------------------

		$this->objValidation->vars["articleId"] = 0;

		if (isset($_GET["articleId"]))
		{
			$rules = array
			(
				Validation::exist => "Недостаточно данных [articleId]",
				Validation::isNum => "Некоректные данные [articleId]"
			);

			$this->objValidation->checkVars("articleId", $rules, $_GET);
		}
		else
		{
			if (isset($_GET["articleUrlName"]))
			{
				$rules = array
				(
					Validation::exist => "Недостаточно данных [articleUrlName]",
				);

				$this->objValidation->checkVars("articleUrlName", $rules, $_GET);


				$this->objValidation->vars["articleId"] = $objMArticle->getIdByUrlName($this->objValidation->vars["articleUrlName"]);
			}
			else
			{
	  			$this->showPage404Key = true;
	  			return;
			}
		}

		//Достаем информацию о каталоге услуги и проверяем на его существование
		if (false === ($articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("article"))))
		{
  			$this->showPage404Key = true;
  			return;
		}

		//Достаем информацию о услуге
		$articleInfo = $objMArticle->getInfo($this->objValidation->vars["articleId"]);

		//Проверяем существование статьи и пренадлежит ли статья к данному каталогу
		if (false === $articleInfo OR (int)$articleInfo["articleCatalogId"] !== (int)$articleCatalogInfo["id"])
		{
  			$this->showPage404Key = true;
  			return;
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>