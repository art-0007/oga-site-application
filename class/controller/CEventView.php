<?php

class CEventView extends CMainInit
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
			$objForm = Form::getInstance();

			if (false === ($articleInfo = $objMArticle->getInfo($this->vars["eventId"])))
			{
				$this->objSOutput->error("Ошибка выборки информации о событии");
			}

			$fileName = $articleInfo["fileName2"];

			if (0 === mb_strlen($articleInfo["fileName2"]))
			{
				$fileName = $articleInfo["fileName1"];
			}

			$data =
			[
				"id" => $this->vars["eventId"],

				"projectImageSlider" => $this->getHtml_projectImageSlider(),

				"imgSrc" => GLOB::$SETTINGS["articleImgDir"]."/".$fileName,
				"text" => Convert::textUnescape($articleInfo["text"]),
				"date" => Convert::textUnescape($articleInfo["addField_lang_1"]),
				"time" => Convert::textUnescape($articleInfo["addField_lang_2"]),
				"eventCategories" => Convert::textUnescape($articleInfo["addField_lang_3"]),
				"website" => Convert::textUnescape($articleInfo["addField_lang_4"]),
				"venue" => Convert::textUnescape($articleInfo["addField_lang_5"]),
				"venueMap" => Convert::textUnescape($articleInfo["addField_lang_6"]),

				"registerForEventForm" => $objForm->getHtml_registerForEventForm("", $this->vars["eventId"]),
			];

			$this->html["pageTitle"] = $this->getPageTitle($articleInfo);

			//Контент страницы
			$this->html["content"] = $this->objSTemplate->getHtml("event", "content_view", $data);
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
  			"controllerId" => 4,
	    ];

		return $this->objSTemplate->getHtml("pageTitle", "content_2", $data);
	}

	//*********************************************************************************

	private function getHtml_projectImageSlider()
	{
		$objMArticleImage = MArticleImage::getInstance();
		$html = "";

		if (false === ($res = $objMArticleImage->getList($this->vars["eventId"])))
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

			$html .= $this->objSTemplate->getHtml("slider", "articleImageSliderListItem", $data);
		}

		$data =
		[
			"id" => $this->vars["eventId"],
			"articleImageSliderList" => $html,
		];

		return $this->objSTemplate->getHtml("slider", "articleImageSliderBlock", $data);
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptCode("var _eventId = ".$this->vars["eventId"].";");
		$this->objJavaScript->addJavaScriptFile("/js/event_view.js");
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

		$this->objValidation->vars["eventId"] = 0;

		if (isset($_GET["eventId"]))
		{
			$rules =
			[
				Validation::exist => "Недостаточно данных [eventId]",
				Validation::isNum => "Некоректные данные [eventId]"
			];

			$this->objValidation->checkVars("eventId", $rules, $_GET);
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

				$this->objValidation->vars["eventId"] = $objMArticle->getIdByUrlName($this->objValidation->vars["articleUrlName"]);
			}
			else
			{
	  			$this->showPage404Key = true;
	  			return;
			}
		}

		//Достаем информацию о каталоге и проверяем на его существование
		if (false === ($articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("event"))))
		{
  			$this->showPage404Key = true;
  			return;
		}

		//Достаем информацию о статье
		$articleInfo = $objMArticle->getInfo($this->objValidation->vars["eventId"]);

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