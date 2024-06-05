<?php

class CMainAdminFancyBoxInit extends Controller
{
	/*********************************************************************************/

	protected function __construct()
	{
		parent::__construct();

		switch($this->objSRouter->className)
		{
			default:
			{
				$this->accessOnlyAuthorizedAdminUser();
				$this->templateFileName = "mainAdminFancyBox";
				break;
			}
		}

		//$this->templateFileName = "main";
		$this->templateName = "content";

		$this->setInputVars();
		$this->setCss();
		$this->setJavaScript();
	}

	/*********************************************************************************/

	//Доступ только авторизированным пользователям
	protected function accessOnlyAuthorizedAdminUser()
	{
		$objAdminUser = AdminUser::getInstance();

		if (!$objAdminUser->isAuthorized())
		{
			switch($this->objSRouter->processorType)
			{
				case SEProcessorType::usual:
				{
					$this->objSResponse->redirect("http://".$_SERVER["SERVER_NAME"]);
					break;
				}

				case SEProcessorType::ajax:
				{
					$this->objSOutput->error("Доступ только авторизированным пользователям админпанели");
					break;
				}
			}
		}
	}

	/*********************************************************************************/

	/**
	 * Прием входящих переменных нужных всегда
	 * */
	private function setInputVars()
	{
	}

	/*********************************************************************************/

	private function setCss()
	{
		$this->objCSS->addCSSFile("/template/css/popup-message.css");
		$this->objCSS->addCSSFile("/template/css/popup-form.css");
		$this->objCSS->addCSSFile("/template/css/float-message.css");

		$this->objCSS->addCSSFile("/template/bootstrap/bootstrap.css");
		$this->objCSS->addCSSFile("/template/font-awesome/css/font-awesome.min.css");
		$this->objCSS->addCSSFile("/template/fancybox/jquery.fancybox.css");

		$this->objCSS->addCSSFile("/template/css/edit-form.css");
		$this->objCSS->addCSSFile("/template/css/style-admin-fancybox.css");
	}

	/*********************************************************************************/

	private function setJavaScript()
	{
 		//JavaScript
		$this->objJavaScript->addJavaScriptFile("/js/ajax/lib/JsHttpRequest/JsHttpRequest.js");
		$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery.js");
		$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery-ui.min.js");
		$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery.cookies.min.js");
		//$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery.hover-intent.js");

		$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery.scrollTo.js");

		$this->objJavaScript->addJavaScriptFile("/template/fancybox/jquery.fancybox.min.js");

		$this->objJavaScript->addJavaScriptFile("/template/bootstrap/popper.min.js");
		$this->objJavaScript->addJavaScriptFile("/template/bootstrap/bootstrap.min.js");

		$this->objJavaScript->addJavaScriptFile("/js/func.js");
 		$this->objJavaScript->addJavaScriptFile("/js/console.js");

		$this->objJavaScript->addJavaScriptFile("/js/jeoverlay.js");
		$this->objJavaScript->addJavaScriptFile("/js/jeautocomplete.js");
		$this->objJavaScript->addJavaScriptFile("/js/popup-message.js");
		$this->objJavaScript->addJavaScriptFile("/js/popup-form.js");
		$this->objJavaScript->addJavaScriptFile("/js/float-message.js");
		$this->objJavaScript->addJavaScriptFile("/js/ajax-request.js");

		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-tinymce-option.js");
		$this->objJavaScript->addJavaScriptFile("/js/tinymce/tinymce.min.js");
		$this->objJavaScript->addJavaScriptFile("/js/tinymce/jquery.tinymce.min.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/translit-url-name.js");

		$this->objJavaScript->addJavaScriptCode("var _domain = \"".$_SERVER["SERVER_NAME"]."\";");
		$this->objJavaScript->addJavaScriptCode("var _router = \"".$this->objSRouter->className."\";");

		//Устанавливаем конфигурацию для ключа дебага джаваскриптов
  		if (Config::$debug)
  		{
	 		$this->objJavaScript->addJavaScriptCode("var _debugJavaScript = true;");
  		}
  		else
  		{
	 		$this->objJavaScript->addJavaScriptCode("var _debugJavaScript = false;");
  		}
  	}

	/*********************************************************************************/

 	protected function templateInit()
 	{
		//CSS
		$this->html["css"] = $this->objCSS->getHtml();
 		//JavaScript
 		$this->html["javascript"] = $this->objJavaScript->getHtml();
 	}

	/*********************************************************************************/

}

?>