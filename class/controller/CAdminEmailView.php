<?php

class CAdminEmailView extends CMainAdminFancyBoxInit
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
		$objMEmail = MEmail::getInstance();

		if (false === $emailInfo = $objMEmail->getInfo($this->vars["emailId"]))
		{
			Error::message("STOP");
		}

		$data = array
		(
  			"pageTitleH1" => "Просмотр письма \"".Convert::textUnescape($emailInfo["subject"], false)."\"",
  			"toolbarButton" => $this->objSTemplate->getHtml("adminEmail", "toolbarButton"),
  			"emailId" => $emailInfo["id"],

  			"subject" => Convert::textUnescape($emailInfo["subject"], false),
   			"date" => date("d-m-Y", $emailInfo["time"]),
   			"time" => date("H:i:s", $emailInfo["time"]),
  			"file" => (!empty($emailInfo["fileName"])) ? "<a href='".GLOB::$SETTINGS["emailImgDir"]."/".$emailInfo["fileName"]."' target='_blank'>Открыть</a>" : "нет",
  			"content" => Convert::textUnescape($emailInfo["content"], false),
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminEmail", "content_view", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		//$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
		//$this->objJavaScript->addJavaScriptFile("/js/admin/admin-email.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMEmail = MEmail::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [emailId]",
			Validation::isNum => "Некоректные данные [emailId]",
		);
		$this->objValidation->checkVars("emailId", $rules, $_GET);

 		//Проверяем существование с таким id
  		if (false === $objMEmail->isExist($this->objValidation->vars["emailId"]))
  		{
  			$this->objSOutput->critical("Письма с таким id не существует [".$this->objValidation->vars["emailId"]."]");
  		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>