<?php

class CProjectView extends CMainInit
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
			//$objDonate = Donate::getInstance();

			if (false === ($articleInfo = $objMArticle->getInfo($this->vars["projectId"])))
			{
				$this->objSOutput->error("Ошибка выборки информации о проэкте");
			}

			$fileName = $articleInfo["fileName2"];

			if (0 === mb_strlen($articleInfo["fileName2"]))
			{
				$fileName = $articleInfo["fileName1"];
			}

			$data =
			[
				"id" => $this->vars["projectId"],
				//"donateBlock2" => $objDonate->getHtml_donateBlock2(),
				"topSliderBlock" => $this->getHtml_sliderBlock($articleInfo["addField_5"]),
				"imgSrc" => GLOB::$SETTINGS["articleImgDir"]."/".$fileName,
				"text" => $this->getHtml_text($articleInfo["text"]),
				"projectBlock" => "",
				"videoBlock" => $this->getHtml_videoBlock($articleInfo),
				//"donateBlock" => $objDonate->getHtml_donateBlock(),
				"projectVideoBlock" => $this->getHtml_projectVideoBlock($articleInfo),
				"bottomSliderBlock" => $this->getHtml_sliderBlock($articleInfo["addField_6"]),
			];

			$this->html["pageTitle"] = $this->getPageTitle($articleInfo);

			//Контент страницы
			$this->html["content"] = $this->objSTemplate->getHtml("project", "content_view", $data);
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
  			"textBlock" => "",
  		];

  		return $this->objSTemplate->getHtml("pageTitle", "content", $data);
	}

	//*********************************************************************************

	private function getHtml_text($text)
	{
		$text = Convert::textUnescape($text);

		$galleryCatalogIdArray = [];

		preg_match_all("#\{ivSlider_([0-9]+)\}#i", $text, $galleryCatalogIdArray);

		if (count($galleryCatalogIdArray[1]) > 0)
		{
			foreach ($galleryCatalogIdArray[1] as $galleryCatalogId)
			{
				$html = $this->getHtml_slider($galleryCatalogId, 2);

				$text = strtr($text, ["{ivSlider_".$galleryCatalogId."}" => $html]);
			}
		}

		$text = preg_replace("#<iframe#ui", "<div class=\"videoIframe\"><div><iframe", $text);
		$text = preg_replace("#</iframe>#ui", "</iframe></div></div>", $text);

		return $text;
	}

	//*********************************************************************************

	private function getHtml_sliderBlock($addField, $type = 1)
	{
		$html = "";

		if (!Func::isEmpty($addField))
		{
			//Разбиваем текст на массив с ИД
			$galleryCatalogIdArray = preg_split("#,#", $addField, -1, PREG_SPLIT_NO_EMPTY);

			foreach ($galleryCatalogIdArray as $galleryCatalogId)
			{
				$html .= $this->getHtml_slider($galleryCatalogId, $type);
			}
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_slider($galleryCatalogId, $type = 1)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		if (($articleCatalogInfo = $objMArticleCatalog->getInfo($galleryCatalogId)) !== false)
		{
			$parameterArray =
			[
				"articleCatalogIdArray" => $articleCatalogInfo["id"],
				"orderType" => $articleCatalogInfo["orderInCatalog"],
				"showKey" => 1,
			];

			$listItemHtml = "";

			if (($res = $objMArticle->getList($parameterArray)) !== false)
			{
				foreach ($res AS $row)
				{
					$href = Convert::textUnescape($row["addField_lang_1"], true);
					$code = "";

					if (stripos($href, "https://youtu.be/") !== false)
					{
						$code = str_replace("https://youtu.be/", "", $href);
					}
					elseif (stripos($href, "https://www.youtube.com/embed/") !== false)
					{
						$code = str_replace("https://www.youtube.com/embed/", "", $href);
					}
					elseif (stripos($href, "https://www.youtube.com/watch?v=") !== false)
					{
						$code = str_replace("https://www.youtube.com/watch?v=", "", $href);
					}
					elseif (stripos($href, "https://www.youtube.com/shorts/") !== false)
					{
						$code = str_replace("https://www.youtube.com/shorts/", "", $href);
						$code = str_replace("?feature=share", "", $code);

						$href = "https://www.youtube.com/watch?v=".$code;
					}

					$data =
					[
						"articleCatalogId" => $articleCatalogInfo["id"],
						"id" => $row["id"],
						"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
						"code" => $code,
						"href" => $href,
						"titleAlt" => Convert::textUnescape($row["title"], true),
						"title" => Convert::textUnescape($row["title"]),
						"description" => Convert::textUnescape($row["description"]),
					];

					if (Func::isEmpty($row["addField_lang_1"]))
					{
						$listItemHtml .= $this->objSTemplate->getHtml("slider", "ivSliderListItem", $data);
					}
					else
					{
						$listItemHtml .= $this->objSTemplate->getHtml("slider", "ivSliderListItem2", $data);
					}
				}

				$data =
				[
					"articleCatalogId" => $articleCatalogInfo["id"],
					"ivSliderList" => $listItemHtml,
				];

				if (1 === $type)
				{
					$html .= $this->objSTemplate->getHtml("slider", "ivSliderBlock", $data);
				}
				else if (2 === $type)
				{
					$html .= $this->objSTemplate->getHtml("slider", "ivSliderBlock2", $data);
				}
			}
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_videoBlock(&$articleInfo)
	{
		if (0 === mb_strlen($articleInfo["addField_lang_3"]))
		{
			return "";
		}

		$data =
		[
			"articleCatalogTitle" => Convert::textUnescape($articleInfo["addField_lang_1"]),
			"description" => Convert::textUnescape($articleInfo["addField_lang_2"]),
			"video" => Convert::textUnescape($articleInfo["addField_lang_3"]),
		];

		return $this->objSTemplate->getHtml("video", "videoBlock", $data);
	}

    //*********************************************************************************

    private function getHtml_projectVideoBlock(&$articleInfo)
    {
        if (0 === mb_strlen($articleInfo["addField_lang_6"]))
        {
            return "";
        }
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($articleInfo["addField_lang_6"]);

		if (false === $articleCatalogInfo OR 0 === (int)$articleCatalogInfo["showKey"])
		{
			return "";
		}

		$parameterArray =
		[
			"articleCatalogIdArray" => $articleCatalogInfo["id"],
			"orderType" => $articleCatalogInfo["orderInCatalog"],
			"showKey" => 1,
		];

		if (false === ($res = $objMArticle->getList($parameterArray)))
		{
			return "";
		}

		foreach($res AS $row)
		{
			$href = Convert::textUnescape($row["addField_lang_1"], true);
			$code = "";

			if (stripos($href, "https://youtu.be/") !== false)
			{
				$code = str_replace("https://youtu.be/", "", $href);
			}
			elseif (stripos($href, "https://www.youtube.com/embed/") !== false)
			{
				$code = str_replace("https://www.youtube.com/embed/", "", $href);
			}
			elseif (stripos($href, "https://www.youtube.com/watch?v=") !== false)
			{
				$code = str_replace("https://www.youtube.com/watch?v=", "", $href);
			}
			elseif (stripos($href, "https://www.youtube.com/shorts/") !== false)
			{
				$code = str_replace("https://www.youtube.com/shorts/", "", $href);
				$code = str_replace("?feature=share", "", $code);

				$href = "https://www.youtube.com/watch?v=".$code;
			}

			$data =
			[
				"id" => $row["id"],
				"code" => $code,
				"href" => $href,
				"title" => Convert::textUnescape($row["title"]),
				"btnBlock" => (1 === (int)$row["addField_lang_4"]) ? $this->objSTemplate->getHtml("projectVideo", "btnBlock", ["id" => $row["id"]]) : "",
			];

			$html .= $this->objSTemplate->getHtml("projectVideo", "projectVideoListItem", $data);
		}

		$data =
		[
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
			"projectVideoList" => $html,
		];

        return $this->objSTemplate->getHtml("projectVideo", "projectVideoBlock", $data);
    }

    //*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptCode("var _projectId = ".$this->vars["projectId"].";");
		$this->objJavaScript->addJavaScriptFile("/js/project_view.js");
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
		$objArticleCatalog = ArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();

		//-------------------------------------------------------------

		$this->objValidation->vars["projectId"] = 0;

		if (isset($_GET["projectId"]))
		{
			$rules =
			[
				Validation::exist => "Недостаточно данных [projectId]",
				Validation::isNum => "Некоректные данные [projectId]"
			];
			$this->objValidation->checkVars("projectId", $rules, $_GET);
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

				$this->objValidation->vars["projectId"] = $objMArticle->getIdByUrlName($this->objValidation->vars["articleUrlName"]);
			}
			else
			{
	  			$this->showPage404Key = true;
	  			return;
			}
		}

		//Достаем информацию об услуге
		$articleInfo = $objMArticle->getInfo($this->objValidation->vars["projectId"]);

		//Проверяем существование статьи и пренадлежит ли статья к данному каталогу
		if (false === $articleInfo OR !$objArticleCatalog->isSuitableCatalog($articleInfo["articleCatalogId"], "project"))
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
