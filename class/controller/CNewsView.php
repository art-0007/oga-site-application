<?php

class CNewsView extends CMainInit
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
			$objDonate = Donate::getInstance();

			if (false === ($articleInfo = $objMArticle->getInfo($this->vars["newsId"])))
			{
				$this->objSOutput->error("Ошибка выборки информации о новости");
			}

			$fileName = $articleInfo["fileName2"];

			if (0 === mb_strlen($articleInfo["fileName2"]))
			{
				$fileName = $articleInfo["fileName1"];
			}

			$data =
			[
				"id" => $this->vars["newsId"],
				"imgSrc" => GLOB::$SETTINGS["articleImgDir"]."/".$fileName,
				"text" => Convert::textUnescape($articleInfo["text"]),
				"donateBlock" => $objDonate->getHtml_donateBlock(),
			];

			$this->html["pageTitle"] = $this->getPageTitle($articleInfo);

			//Контент страницы
			$this->html["content"] = $this->objSTemplate->getHtml("news", "content_view", $data);
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

		$data =
  		[
  			"id" => $articleInfo["id"],
  			"pageTitle" => (!empty($articleInfo["pageTitle"]) ? Convert::textUnescape($articleInfo["pageTitle"]) : Convert::textUnescape($articleInfo["title"])),
		    "textBlock" => "", //$this->getHtml_pageTitle_textBlock($articleInfo),
		];

		return $this->objSTemplate->getHtml("pageTitle", "content", $data);
	}

	//*********************************************************************************

	private function getHtml_pageTitle_textBlock(&$articleInfo)
	{
		if (0 === mb_strlen($articleInfo["description"]))
		{
			return "";
		}

		$data =
		[
			"description" => Convert::textUnescape($articleInfo["description"]),
		];

		return $this->objSTemplate->getHtml("pageTitle", "textBlock", $data);
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		//$this->objJavaScript->addJavaScriptFile("/js/news_view.js");

		$this->objJavaScript->addJavaScriptCode("var _newsId = ".$this->vars["newsId"].";");
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

		$this->objValidation->vars["newsId"] = 0;

		if (isset($_GET["newsId"]))
		{
			$rules =
			[
				Validation::exist => "Недостаточно данных [newsId]",
				Validation::isNum => "Некоректные данные [newsId]"
			];

			$this->objValidation->checkVars("newsId", $rules, $_GET);
		}
		else
		{
			if (isset($_GET["articleUrlName"]))
			{
				$rules =
				[
					Validation::exist => "Недостаточно данных [articleUrlName]",
				];

				$this->objValidation->checkVars("articleUrlName", $rules, $_GET);

				$this->objValidation->vars["newsId"] = $objMArticle->getIdByUrlName($this->objValidation->vars["articleUrlName"]);
			}
			else
			{
				$this->showPage404Key = true;
				return;
			}
		}

		//Достаем информацию о каталоге услуги и проверяем на его существование
		if (false === ($articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("news"))))
		{
			$this->showPage404Key = true;
			return;
		}

		//Достаем информацию о услуге
		$articleInfo = $objMArticle->getInfo($this->objValidation->vars["newsId"]);

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