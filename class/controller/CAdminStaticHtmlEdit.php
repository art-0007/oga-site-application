<?php

class CAdminStaticHtmlEdit extends CMainAdminFancyBoxInit
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
		$objMStaticHtml = MStaticHtml::getInstance();
		$objMLang = MLang::getInstance();

		//Достаем формацию о языке
		$langInfo = $objMLang->getInfo($this->vars["langId"]);

		if (false === $staticHtmlInfo = $objMStaticHtml->getInfo($this->vars["staticHtmlId"], $this->vars["langId"]))
		{
			Error::message("STOP");
		}

		$data = array
		(
  			"pageTitleH1" => "Редактирование статического html`я \"".$staticHtmlInfo["name"]."\"",
  			"staticHtmlId" => $staticHtmlInfo["staticHtmlId"],
  			"langId" => $this->vars["langId"],
  			"name" => $staticHtmlInfo["name"],
  			"html" => $staticHtmlInfo["html"],
  			"checked" => (1 === (int)$staticHtmlInfo["autoReplaceKey"]) ? "checked='checked'" : "",

  			"submitButtonTitle" => "Редактировать (".$langInfo["name"].")",
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminStaticHtml", "adminStaticHtmlEdit", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-static-html.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMStaticHtml = MStaticHtml::getInstance();
		$objMLang = MLang::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [staticHtmlId]",
			Validation::isNum => "Некоректные данные [staticHtmlId]",
		);
		$this->objValidation->checkVars("staticHtmlId", $rules, $_GET);

 		//Проверяем существование с таким id
  		if (false === $objMStaticHtml->isExist($this->objValidation->vars["staticHtmlId"]))
  		{
  			$this->objSOutput->critical("Статического html`я с таким id не существует [".$this->objValidation->vars["staticHtmlId"]."]");
  		}

		//-------------------------------------------------------------

		if (isset($_GET["langId"]))
		{
			$objMLang = MLang::getInstance();

			//Проверяем существование с таким id
			if (false === $objMLang->isExist($_GET["langId"]))
			{
				$this->objSOutput->error("Ошибка: Языка с таким ИД нет в БД [".$_GET["langId"]."]");
			}

			$this->objValidation->vars["langId"] = $_GET["langId"];
		}
		else
		{
			$this->objSResponse->redirect("/admin/language-selection-page/?refererUrl=".urlencode("/admin/static-html/edit/".$this->objValidation->vars["staticHtmlId"]."/"), SERedirect::found);
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>