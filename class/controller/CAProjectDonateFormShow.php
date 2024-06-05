<?php

class CAProjectDonateFormShow extends CAjaxInit
{
	//*********************************************************************************
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
		$objMArticle = MArticle::getInstance();
		$objStaticHtml = StaticHtml::getInstance();

		$data =
		[
			"projectTitle" => Convert::textUnescape($objMArticle->getTitle($this->vars["projectId"])),
			"projectDonateList" => $this->getHtml_projectDonateList(),
		];

		$data =
		[
			"modalHtml" => $objStaticHtml->replaceInString($this->objSTemplate->getHtml("form", "projectDonateForm", $data)),
		];

		$this->objSOutput->ok("Ок", $data);
	}

	//*********************************************************************************
	
	private function getHtml_projectDonateList()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("donate"));

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
			if (Func::isEmpty($row["addField_lang_1"]))
			{
				continue;
			}

			$data =
			[
				"id" => $row["id"],
				"altTitle" => Convert::textUnescape($row["title"], true),
				"title" => Convert::textUnescape($row["title"]),
				"href" => Convert::textUnescape($row["addField_lang_1"]),
			];

			$html .= $this->objSTemplate->getHtml("form", "projectDonateListItem", $data);
		}

		return $html;
	}
	
	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();
		$objArticleCatalog = ArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [projectId]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("projectId", $rules, $_POST);

		if (!$objMArticle->isExist($this->objValidation->vars["projectId"]))
		{
			$this->objSOutput->critical("Donate does not exist [".$this->objValidation->vars["projectId"]."]");
		}

		//Достаем информацию о статье
		$articleCatalogId = $objMArticle->getArticleCatalogId($this->objValidation->vars["projectId"]);

		//Проверяем существование статьи и пренадлежит ли статья к данному каталогу
		if (false === $articleCatalogId OR !$objArticleCatalog->isSuitableCatalog($articleCatalogId, "project"))
		{
			$this->objSOutput->critical("Project does not exist");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>