<?php

class CAAdminArticleCatalogAdd extends CAjaxInit
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

		$articleCatalogId = $this->add();

		$this->objMySQL->commit();

		$data = array
  		(
  			"parentArticleCatalogId" => $this->vars["articleCatalogId"],
  			"articleCatalogId" => $articleCatalogId,
  		);

		$this->objSOutput->ok("Каталог статей создан", $data);
	}

	//*********************************************************************************

	private function add()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();

		//Проверяем существование с таким title
		if (true === $objMArticleCatalog->isExistByTitle($this->vars["title"], null, $this->vars["articleCatalogId"]))
		{
			$this->objSOutput->error("Каталог с таким наименованием уже существует");
		}

  		$data = array
		(
			"articleCatalog_id" => $this->vars["articleCatalogId"],
			"position" => $objMArticleCatalog->getMaxPosition($this->vars["articleCatalogId"]) + 1,
		);
		$articleCatalogId = $objMArticleCatalog->addAndReturnId($data);

  		$data = array
		(
			"urlName" => Func::translitForUrlName($this->vars["title"])."-ac".$articleCatalogId,
			//"urlName" => Func::translitForUrlName($this->vars["title"]),
		);
  		$objMArticleCatalog->edit($articleCatalogId, $data);

		//Языковая
  		$data = array
		(
			"articleCatalog_id" => $articleCatalogId,
			"title" => $this->vars["title"],
		);
  		$objLang = Lang::getInstance();
  		$objLang->insertLangDataInDB(DB_articleCatalogLang, $data);

  		return $articleCatalogId;
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
		if ((int)$this->objValidation->vars["articleCatalogId"] !== 0 AND !$objMArticleCatalog->isExist($this->objValidation->vars["articleCatalogId"]))
		{
			$this->objSOutput->critical("Каталога статьи с таким id не существует [".$this->objValidation->vars["articleCatalogId"]."]");
		}

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [title]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите наименование каталога",
		);
		$this->objValidation->checkVars("title", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>