<?php

class CSomeElementView extends CMainInit
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

			$data =
			[
				"id" => $this->vars["articleId"],
				"imgSrc" => GLOB::$SETTINGS["articleImgDir"]."/".$fileName,
				"text" => Convert::textUnescape($articleInfo["text"]),
				"articleImageSlider" => $this->getHtml_articleImageSlider(),
			];

			$this->html["pageTitle"] = $this->getPageTitle($articleInfo);

			//Контент страницы
			$this->html["content"] = $this->objSTemplate->getHtml("someElement", "content_view", $data);
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

	private function getHtml_articleImageSlider()
	{
		$objMArticleImage = MArticleImage::getInstance();
		$html = "";

		if (false === ($res = $objMArticleImage->getList($this->vars["articleId"])))
		{
			return "";
		}

		foreach ($res AS $row)
		{
			$data =
			[
				"id" => $row["id"],
				"imgSrc" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName"],
				"titleAlt" => Convert::textUnescape($row["title"], true),
				"title" => Convert::textUnescape($row["title"]),
			];

			$html .= $this->objSTemplate->getHtml("slider", "articleImageSliderListItem_2", $data);
		}

		$data =
		[
			"id" => $this->vars["articleId"],
			"articleImageSliderList" => $html,
		];

		return $this->objSTemplate->getHtml("slider", "articleImageSliderBlock_2", $data);
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptCode("var _articleId = ".$this->vars["articleId"].";");
		$this->objJavaScript->addJavaScriptFile("/js/some_element_view.js");
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
		$objMArticle = MArticle::getInstance();

		//-------------------------------------------------------------

		$this->objValidation->vars["articleId"] = 0;

		if (isset($_GET["articleId"]))
		{
			$rules =
			[
				Validation::exist => "Недостаточно данных [articleId]",
				Validation::isNum => "Некоректные данные [articleId]"
			];

			$this->objValidation->checkVars("articleId", $rules, $_GET);
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

				$this->objValidation->vars["articleId"] = $objMArticle->getIdByUrlName($this->objValidation->vars["articleUrlName"]);
			}
			else
			{
				$this->showPage404Key = true;
				return;
			}
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>