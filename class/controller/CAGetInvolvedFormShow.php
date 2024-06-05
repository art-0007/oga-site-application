<?php

class CAGetInvolvedFormShow extends CAjaxInit
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
		    "articleId" => $this->vars["articleId"],
		    "getInvolvedTitle" => Convert::textUnescape($objMArticle->getTitle($this->vars["articleId"])),
	    ];

	    $data =
	    [
		    "modalHtml" => $objStaticHtml->replaceInString($this->objSTemplate->getHtml("form", "getInvolvedForm", $data)),
	    ];

	    $this->objSOutput->ok("Ок", $data);
 	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();

		$this->objValidation->vars["articleId"] = null;

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [articleId]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("articleId", $rules, $_POST);

		if (!$objMArticle->isExist($this->objValidation->vars["articleId"]))
		{
			$this->objSOutput->critical("GetInvolved does not exist [".$this->objValidation->vars["articleId"]."]");
		}

		//Достаем информацию о каталоге услуги и проверяем на его существование
		if (false === ($articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("getInvolved"))))
		{
			$this->objSOutput->critical("Error");
		}

		//Достаем информацию о статье
		$articleInfo = $objMArticle->getInfo($this->objValidation->vars["articleId"]);

		//Проверяем существование статьи и пренадлежит ли статья к данному каталогу
		if (false === $articleInfo OR (int)$articleInfo["articleCatalogId"] !== (int)$articleCatalogInfo["id"])
		{
			$this->objSOutput->critical("GetInvolved does not exist");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>