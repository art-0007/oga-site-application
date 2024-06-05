<?php

class CAProjectVideoFormShow extends CAjaxInit
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
		$objStaticHtml = StaticHtml::getInstance();

		$data =
		[
			"projectVideoId" => $this->vars["projectVideoId"],
		];

		$data =
		[
			"modalHtml" => $objStaticHtml->replaceInString($this->objSTemplate->getHtml("form", "projectVideoForm", $data)),
		];

		$this->objSOutput->ok("Ок", $data);
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
			Validation::exist => "Недостаточно данных [projectVideoId]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("projectVideoId", $rules, $_POST);

        if (!$objMArticle->isExist($this->objValidation->vars["projectVideoId"]))
        {
            $this->objSOutput->critical("Project video does not exist [".$this->objValidation->vars["projectVideoId"]."]");
        }

        //Достаем информацию о статье
        $articleCatalogId = $objMArticle->getArticleCatalogId($this->objValidation->vars["projectVideoId"]);

        //Проверяем существование статьи и пренадлежит ли статья к данному каталогу
        if (false === $articleCatalogId OR !$objArticleCatalog->isSuitableCatalog($articleCatalogId, "projectVideo"))
        {
            $this->objSOutput->critical("Project video does not exist");
        }

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>
