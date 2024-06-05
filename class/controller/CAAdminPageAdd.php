<?php

class CAAdminPageAdd extends CAjaxInit
{
	//*********************************************************************************

	private $pageId = null;

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

		$this->add();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Статическая страница создана", array("pageId"=> $this->pageId));
	}

	//*********************************************************************************

	private function add()
	{
		$objMPage = MPage::getInstance();

  		//Проверяем существование с таким наименованием
  		if (true === $objMPage->isExistByDevName($this->vars["devName"]))
  		{
  			$this->objSOutput->error("Страница с таким именем для разработчика уже существует");
  		}

  		//Проверяем существование с таким наименованием
  		if (true === $objMPage->isExistByUrlName($this->vars["urlName"]))
  		{
  			$this->objSOutput->error("Страница с таким URL-лом страницы уже существует");
  		}

  		//Проверяем существование с таким наименованием
  		if (true === $objMPage->isExistByTitle($this->vars["title"]))
  		{
  			$this->objSOutput->error("Страница с таким наименованием уже существует");
  		}

 		$data = array
		(
			"devName" => $this->vars["devName"],
			"urlName" => $this->vars["urlName"],
			"position" => $objMPage->getMaxPosition() + 1,
		);

  		$this->pageId = $objMPage->addAndReturnId($data);

		//Создаем строки в языковозависимой таблице

		$objLang = Lang::getInstance();

		$data = array
		(
			"page_id" => $this->pageId,
			"title" => $this->vars["title"],
		);

		$objLang->insertLangDataInDB(DB_pageLang, $data);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [devName]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите имя для разработчика"
		);
		$this->objValidation->checkVars("devName", $rules, $_POST);

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [urlName]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите URL страницы"
		);
		$this->objValidation->checkVars("urlName", $rules, $_POST);

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [title]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите наименование страницы"
		);
		$this->objValidation->checkVars("title", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>