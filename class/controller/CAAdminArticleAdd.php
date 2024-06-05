<?php

class CAAdminArticleAdd extends CAjaxInit
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
		$this->objMySQL->startTransaction();

		$articleId = $this->add();

		$this->objMySQL->commit();

		$data = array
  		(
  			"articleCatalogId" => $this->vars["articleCatalogId"],
  			"articleId" => $articleId,
  		);

		$this->objSOutput->ok("Статья создана", $data);
	}

	//*********************************************************************************

	private function add()
	{
		$objMArticle = MArticle::getInstance();

		//Проверяем существование с таким nameOriginal
		if (true === $objMArticle->isExistByTitle($this->vars["title"], null, $this->vars["articleCatalogId"]))
		{
			$this->objSOutput->error("Статья с таким наименованием уже существует");
		}

		$time = time();

  		$data = array
		(
			"articleCatalog_id" => $this->vars["articleCatalogId"],
			"position" => $objMArticle->getMaxPosition($this->vars["articleCatalogId"]) + 1,
			"date" => date("Y-m-d", $time),
			"time" => $time,
		);
  		$articleId = $objMArticle->addAndReturnId($data);

  		$data = array
		(
			"urlName" => Func::translitForUrlName($this->vars["title"])."-a".$articleId,
			//"urlName" => Func::translitForUrlName($this->vars["title"]),
		);
  		$objMArticle->edit($articleId, $data);

		//Языковая
  		$data = array
		(
			"article_id" => $articleId,
			"lang_id" => GLOB::$langId,
			"title" => $this->vars["title"],
		);
  		$objLang = Lang::getInstance();
  		$objLang->insertLangDataInDB(DB_articleLang, $data);

  		return $articleId;
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [articleCatalogId]",
			Validation::isNum => "Некоректные данные [articleCatalogId]",
		);

		$this->objValidation->checkVars("articleCatalogId", $rules, $_POST);

 		//Проверяем существование с таким id
		if (!$objMArticleCatalog->isExist($this->objValidation->vars["articleCatalogId"]))
		{
			$this->objSOutput->critical("Каталога статей с таким id не существует [".$this->objValidation->vars["articleCatalogId"]."]");
		}

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [title]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите наименование статьи",
		);

		$this->objValidation->checkVars("title", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>