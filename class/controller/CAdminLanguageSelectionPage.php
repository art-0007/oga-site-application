<?php

class CAdminLanguageSelectionPage extends CMainAdminFancyBoxInit
{
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		//$this->setCSS();
		//$this->setJavaScript();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$data = array
		(
  			"pageTitle" => "Выберите языковую форму",
  			"languageList" => $this->getLanguageListHtml(),
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminLanguageSelectionPage", "content", $data);
 	}

	//*********************************************************************************

	private function getLanguageListHtml()
	{
		$objMLang = MLang::getInstance();
		$html = "";

		if (false === ($res = $objMLang->getList()))
		{
			Error::message("Ошибка выборки списка языков из БД");
		}

		foreach ($res AS $row)
		{
			$data = array
	   		(
	   			"imgSrc" => $row["imgBig"],
	   			"title" => $row["name"],
	   			"href" => $this->vars["refererUrl"]."?langId=".$row["id"],
	   		);

			$html .= $this->objSTemplate->getHtml("adminLanguageSelectionPage", "languageListIteam", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		//$this->objJavaScript->addJavaScriptFile("/js/admin/admin-page.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [refererUrl]",
			Validation::trim => "",
			Validation::isNoEmpty => "Некоректные данные [refererUrl]",
		);
		$this->objValidation->checkVars("refererUrl", $rules, $_GET);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;

	}

	//*********************************************************************************
}

?>