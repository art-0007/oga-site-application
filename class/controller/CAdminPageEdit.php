<?php

class CAdminPageEdit extends CMainAdminFancyBoxInit
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
		$objMPage = MPage::getInstance();
		$objMLang = MLang::getInstance();

		//Достаем формацию о языке
		$langInfo = $objMLang->getInfo(GLOB::$langId);

		if (false === $pageInfo = $objMPage->getInfo($this->vars["pageId"]))
		{
			Error::message("STOP");
		}

		$data =
		[
  			"pageTitleH1" => "Редактирование статической страницы \"".$pageInfo["title"]."\"",
  			"pageId" => $pageInfo["id"],
  			"devName" => $pageInfo["devName"],
  			"urlName" => $pageInfo["urlName"],
  			"imgSrc1" => GLOB::$SETTINGS["pageImgDir"]."/".$pageInfo["fileName1"],
			"imgWidth_1" => $pageInfo["imgWidth_1"],
			"imgHeight_1" => $pageInfo["imgHeight_1"],

			"title" => $pageInfo["title"],
			"pageTitle" => $pageInfo["pageTitle"],
			"description" => $pageInfo["description"],
			"text" => $pageInfo["text"],
			"map" => $pageInfo["map"],
			"addField_lang_1" => $pageInfo["addField_lang_1"],
			"metaTitle" => $pageInfo["metaTitle"],
			"metaKeywords" => $pageInfo["metaKeywords"],
			"metaDescription" => $pageInfo["metaDescription"],
  			"position" => $pageInfo["position"],

  			"submitButtonTitle" => "Редактировать (".$langInfo["name"].")",
		];

		$templateName = "adminPageEdit";

		if ($this->objSTemplate->isExistTemplate("adminPage", "adminPageEdit_".$pageInfo["devName"]))
		{
			$templateName = "adminPageEdit_".$pageInfo["devName"];
		}

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminPage", $templateName, $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-page.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMPage = MPage::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [pageId]",
			Validation::isNum => "Некоректные данные [pageId]",
		);
		$this->objValidation->checkVars("pageId", $rules, $_GET);

 		//Проверяем существование с таким id
  		if (false === $objMPage->isExist($this->objValidation->vars["pageId"]))
  		{
  			$this->objSOutput->critical("Статического html`я с таким id не существует [".$this->objValidation->vars["pageId"]."]");
  		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>