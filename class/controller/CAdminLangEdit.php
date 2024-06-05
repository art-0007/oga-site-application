<?php

class CAdminLangEdit extends CMainAdminFancyBoxInit
{
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		//$this->setCSS();
		$this->setJavaScript();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$objMLang = MLang::getInstance();

		if (false === $langInfo = $objMLang->getInfo($this->vars["langId"]))
		{
			$this->objSOutput->critical("Ошибка выборки информации о языке из БД [".$this->vars["langId"]."]");
		}

		$data =
		[
  			"pageTitleH1" => "Редактирование языка \"".$langInfo["name"]."\"",
  			"inputTitleName" => "Имя языка",
  			"id" => $langInfo["id"],
  			"name" => $langInfo["name"],
  			"code" => $langInfo["code"],
  			"imgSrc1" => $langInfo["img"],
  			"imgSrc2" => $langInfo["imgBig"],
			"position" => $langInfo["position"],
			"defaultKey" => $langInfo["defaultKey"],
			"defaultKey_checked" => (0 === (int)$langInfo["defaultKey"]) ? "" : "checked=\"checked\"",

  			"submitButtonTitle" => "Редактировать (".$langInfo["name"].")",
		];

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminLang", "adminLangEdit", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptCode("var _langId = \"".$this->vars["langId"]."\";");
		//$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-lang-list.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMLang = MLang::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [langId]",
			Validation::isNum => "Некоректные данные [langId]",
		];
		$this->objValidation->checkVars("langId", $rules, $_GET);

 		//Проверяем существование с таким id
  		if (false === $objMLang->isExist($this->objValidation->vars["langId"]))
  		{
  			$this->objSOutput->critical("Языка с таким id не существует [".$this->objValidation->vars["langId"]."]");
  		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>