<?php

class CAdminSettingsEdit extends CMainAdminFancyBoxInit
{
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		//$this->setInputVars();
		//$this->setCSS();
		$this->setJavaScript();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$data = array
		(
  			"pageTitleH1" => "Общие настройки",
  			"emailFrom" => GLOB::$SETTINGS["emailFrom"],
  			"emailTo" => GLOB::$SETTINGS["emailTo"],
  			"eg1_checked" => "",
  			"eg2_checked" => "",
  			"eg3_checked" => "",
  			//"catalogImgWidth_1" => GLOB::$SETTINGS["catalogImgWidth_1"],
  			//"catalogImgHeight_1" => GLOB::$SETTINGS["catalogImgHeight_1"],
  			//"newsAmountInNewsList" => GLOB::$SETTINGS["newsAmountInNewsList"],
  			//"newsAmountInLeftMenu" => GLOB::$SETTINGS["newsAmountInLeftMenu"],
  			//"dataAmountInBlock" => GLOB::$SETTINGS["dataAmountInBlock"],
  			"projectAmountOnIndex" => GLOB::$SETTINGS["projectAmountOnIndex"],
  			"newsAmountOnIndex" => GLOB::$SETTINGS["newsAmountOnIndex"],
  			"partnerAmountOnIndex" => GLOB::$SETTINGS["partnerAmountOnIndex"],
  			"eventAmountOnIndex" => GLOB::$SETTINGS["eventAmountOnIndex"],
  			"teamAmountOnIndex" => GLOB::$SETTINGS["teamAmountOnIndex"],

		    //"minOrderSum" => GLOB::$SETTINGS["minOrderSum"],

  			//"numAmountAfterPoint" => GLOB::$SETTINGS["numAmountAfterPoint"],
  			//"cutLastNumberIfZeros0_checked" => "",
  			//"cutLastNumberIfZeros1_checked" => "",

		    "phone1" => GLOB::$SETTINGS["phone1"],
		    "phone2" => GLOB::$SETTINGS["phone2"],
		    "email1" => GLOB::$SETTINGS["email1"],
		    "email2" => GLOB::$SETTINGS["email2"],

		    "currencyRate" => GLOB::$SETTINGS["currencyRate"],
  			"front_domain" => GLOB::$SETTINGS["front_domain"],
  			"front_companyName" => GLOB::$SETTINGS["front_companyName"],

  			"submitButtonTitle" => "Сохранить",
		);

		$data["eg".GLOB::$SETTINGS["emailGateway"]."_checked"] = "checked=\"checked\"";
		$data["cutLastNumberIfZeros".GLOB::$SETTINGS["cutLastNumberIfZeros"]."_checked"] = "checked=\"checked\"";

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminSettingsEdit", "content", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-settings.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>