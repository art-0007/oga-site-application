<?php

class CTeamView extends CMainInit
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

			if (false === ($articleInfo = $objMArticle->getInfo($this->vars["teamId"])))
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
				"id" => $this->vars["teamId"],
				"imgSrc" => GLOB::$SETTINGS["articleImgDir"]."/".$fileName,
				"pageTitle" => (!empty($articleInfo["pageTitle"]) ? Convert::textUnescape($articleInfo["pageTitle"]) : Convert::textUnescape($articleInfo["title"])),
				"post" => Convert::textUnescape($articleInfo["addField_lang_1"]),
				"text" => Convert::textUnescape($articleInfo["text"]),
			];

			$this->html["pageTitle"] = ""; //$this->getPageTitle($articleInfo);

			//Контент страницы
			$this->html["content"] = $this->objSTemplate->getHtml("team", "content_view", $data);
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
		//$this->objJavaScript->addJavaScriptFile("/js/team_view.js");

		$this->objJavaScript->addJavaScriptCode("var _teamId = ".$this->vars["teamId"].";");
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

		$this->objValidation->vars["teamId"] = 0;

		if (isset($_GET["teamId"]))
		{
			$rules =
			[
				Validation::exist => "Недостаточно данных [teamId]",
				Validation::isNum => "Некоректные данные [teamId]"
			];
			$this->objValidation->checkVars("teamId", $rules, $_GET);
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

				$this->objValidation->vars["teamId"] = $objMArticle->getIdByUrlName($this->objValidation->vars["articleUrlName"]);
			}
			else
			{
				$this->showPage404Key = true;
				return;
			}
		}

		//Достаем информацию о услуге
		$articleInfo = $objMArticle->getInfo($this->objValidation->vars["teamId"]);

		//Проверяем существование статьи и пренадлежит ли статья к данному каталогу
		if (false === $articleInfo OR !$objArticleCatalog->isSuitableCatalog($articleInfo["articleCatalogId"], "team"))
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