<?php
class CMainInit extends Controller
{
	//*********************************************************************************

	protected $html = array(); //Содержит все части HTML страницы
	protected $vars = array(); //Массив входящих данных

	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		switch($this->objSRouter->className)
		{
			//Страница входа в админку
			case "CAdminLogin":
			{
				$this->templateFileName = "mainLogin";
				break;
			}

			default:
			{
				$this->templateFileName = "mainFull";
				break;
			}
		}

		$this->templateName = "content";

		$this->setInputVars(); //Прием переменных
		$this->setCSS(); //Установка CSS перед контроллером
		$this->setJavaScript(); //Установка JS перед контроллером
	}

	/*********************************************************************************/

	//Доступ только авторизированным пользователям
	protected function accessOnlyAuthorizedUser()
	{
		$objAuthorizationCheck = AuthorizationCheck::getInstance();

		if(!$objAuthorizationCheck->isUserAuthorized())
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
					$this->objSOutput->error("Доступ только авторизированным пользователям");
					break;
				}
			}
		}
	}

	/*********************************************************************************/

	//Доступ только не авторизированным пользователям
	protected function accessOnlyNoAuthorizedUser()
	{
		$objAuthorizationCheck = AuthorizationCheck::getInstance();

		if($objAuthorizationCheck->isUserAuthorized())
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
					$this->objSOutput->error("Доступ только не авторизированным пользователям");
					break;
				}
			}
		}
	}

	//*********************************************************************************

	/**
	 * Прием входящих переменных нужных для всех контроллеров наследующих данный
	 * */
	private function setInputVars()
	{
	}

	//*********************************************************************************

	/**
	 * Подключение css нужных для всех контроллеров наследующих данный
	 * */
	private function setCSS()
	{
		$objAdminUser = AdminUser::getInstance();

		$this->objCSS->addCSSFile("/template/css/popup-message.css");
		$this->objCSS->addCSSFile("/template/css/popup-form.css");
		$this->objCSS->addCSSFile("/template/css/float-message.css");

		$this->objCSS->addCSSFile("/template/bootstrap/bootstrap.css");
		$this->objCSS->addCSSFile("/template/font-awesome/css/font-awesome.min.css");
		$this->objCSS->addCSSFile("/template/fancybox/jquery.fancybox.css");

		$this->objCSS->addCSSFile("/template/slick/slick.css");
		$this->objCSS->addCSSFile("/template/slick/slick-theme.css");

		$this->objCSS->addCSSFile("/template/css/reset.css");
		$this->objCSS->addCSSFile("/template/css/style.css");

		if ($objAdminUser->isAuthorized())
		{
			$this->objCSS->addCSSFile("/template/css/edit-form.css");
			$this->objCSS->addCSSFile("/template/css/admin-panel.css");
		}
	}

	//*********************************************************************************

	/**
	 * Подключение скриптов нужных для всех контроллеров наследующих данный
	 * */
	private function setJavaScript()
	{
		$objAdminUser = AdminUser::getInstance();

 		$this->objJavaScript->addJavaScriptFile("/js/ajax/lib/JsHttpRequest/JsHttpRequest.js");
 		$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery.js");
 		$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery-ui.min.js");
 		$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery.cookies.min.js");
 		//$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery.hover-intent.js");

		$this->objJavaScript->addJavaScriptFile("//cdn.jsdelivr.net/npm/jquery.marquee@1.6.0/jquery.marquee.min.js");

		$this->objJavaScript->addJavaScriptFile("/js/jquery/jquery.scrollTo.js");

		$this->objJavaScript->addJavaScriptFile("/template/fancybox/jquery.fancybox.min.js");

		$this->objJavaScript->addJavaScriptFile("/template/bootstrap/popper.min.js");
		$this->objJavaScript->addJavaScriptFile("/template/bootstrap/bootstrap.min.js");

		$this->objJavaScript->addJavaScriptFile("/template/slick/slick.min.js");

		$this->objJavaScript->addJavaScriptFile("/js/func.js");
 		$this->objJavaScript->addJavaScriptFile("/js/console.js");

 		$this->objJavaScript->addJavaScriptFile("/js/jeoverlay.js");
 		$this->objJavaScript->addJavaScriptFile("/js/jeautocomplete.js");
 		$this->objJavaScript->addJavaScriptFile("/js/popup-message.js");
 		$this->objJavaScript->addJavaScriptFile("/js/popup-form.js");
 		$this->objJavaScript->addJavaScriptFile("/js/float-message.js");
 		$this->objJavaScript->addJavaScriptFile("/js/ajax-request.js");

 		$this->objJavaScript->addJavaScriptFile("/js/url-hash.js");

		$this->objJavaScript->addJavaScriptFile("/js/rotator.js");

 		$this->objJavaScript->addJavaScriptFile("/js/form.js");
 		$this->objJavaScript->addJavaScriptFile("/js/main.js");
		$this->objJavaScript->addJavaScriptFile("/js/header.js");

		$this->objJavaScript->addJavaScriptCode("var _adminUserIsAuthorized = false;");
		$this->objJavaScript->addJavaScriptCode("var _domain = \"".$_SERVER["SERVER_NAME"]."\";");
		$this->objJavaScript->addJavaScriptCode("var _router = \"".$this->objSRouter->className."\";");

		if ($objAdminUser->isAuthorized())
		{
			$this->objJavaScript->addJavaScriptFile("/js/admin/admin-tinymce-option.js");
			$this->objJavaScript->addJavaScriptFile("/js/tinymce/tinymce.min.js");
			$this->objJavaScript->addJavaScriptFile("/js/tinymce/jquery.tinymce.min.js");
			$this->objJavaScript->addJavaScriptFile("/js/admin/admin-panel.js");
			$this->objJavaScript->addJavaScriptFile("/js/admin/admin-hot-edit.js");
			$this->objJavaScript->addJavaScriptFile("/js/admin/translit-url-name.js");

			$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
			$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-page.js");

			$this->objJavaScript->addJavaScriptCode("var _adminUserIsAuthorized = true;");
		}

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

	//*********************************************************************************

 	protected function templateInit()
 	{
 		//CSS
 		$this->html["mainCSS"] = $this->objSTemplate->getHtml("css", "mainCSS");
 		$this->html["css"] = $this->objCSS->getHtml();

 		//JavaScript
 		$this->html["javascript"] = $this->objJavaScript->getHtml();

		//Мета теги
		$objMetaTags = MetaTags::getInstance();
		$this->html["metaTitle"] = $objMetaTags->metaTitle;
		$this->html["metaKeywords"] = $objMetaTags->metaKeywords;
		$this->html["metaDescription"] = $objMetaTags->metaDescription;

		$objAdminUser = AdminUser::getInstance();
		if ($objAdminUser->isAuthorized())
		{
			//Админ панель
			$objAdminPanel = AdminPanel::getInstance();
			$this->html["adminPanel"] = $objAdminPanel->getHtml();
		}
		else
		{
			$this->html["adminPanel"] = "";
		}

		//Шапка сайта
		$objHeader = Header::getInstance();
		$this->html["header"] = $objHeader->getHtml();

		//Строка навигации
		$objNavigationLine = NavigationLine::getInstance();
		$objNavigationLine->initNavLine(false);
		$this->html["navigationLine"] = $objNavigationLine->getHtml();

		//Левое меню сайта
		$objLeftMenu = LeftMenu::getInstance();
		$this->html["leftMenu"] = $objLeftMenu->getHtml();

		//Footer сайта
		$objFooter = Footer::getInstance();
		$this->html["footer"] = $objFooter->getHtml();

		//Формы E-mail
		//$objForm = Form::getInstance();
		//$this->html["subscribeForm"] = $objForm->getSubscribeFormHtml();

	    $this->html["pageClass"] = $this->getHtml_pageClass();
	    $this->html["langCode"] = GLOB::$langCode;
	    $this->html["companyName"] = GLOB::$SETTINGS["front_companyName"];

	    $this->html["phone1"] = Convert::textUnescape(GLOB::$SETTINGS["phone1"], false);
	    $this->html["phone1A"] = Func::toTelephoneSearch(GLOB::$SETTINGS["phone1"]);
	    $this->html["phone2"] = Convert::textUnescape(GLOB::$SETTINGS["phone2"], false);
	    $this->html["phone2A"] = Func::toTelephoneSearch(GLOB::$SETTINGS["phone2"]);
	    $this->html["email1"] = Convert::textUnescape(GLOB::$SETTINGS["email1"], false);
	    $this->html["email2"] = Convert::textUnescape(GLOB::$SETTINGS["email2"], false);
	    $this->html["frontUrl"] = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"];

	    $this->html["schemaOrganization"] = $this->getHtml_schemaOrganization();

	    $this->html["companyName"] = GLOB::$SETTINGS["front_companyName"];

		//Статический html
		$objStaticHtml = StaticHtml::getInstance();
		$objStaticHtml->extendArray($this->html);
 	}

	//*********************************************************************************

	private function getHtml_pageClass()
	{
		if (0 === Func::mb_strcmp("Cpage", $this->objSRouter->className))
		{
			$objMPage = MPage::getInstance();
			//Достаем ID страници по ее pageUrlName
			$pageId = $objMPage->getIdByUrlName($_GET["pageUrlName"]);

			$pageClass = strtolower($objMPage->getDevName($pageId));
		}
		else
		{
			$pageClass = strtolower(mb_substr($this->objSRouter->className, 1));
		}

		return $pageClass;
	}

	//*********************************************************************************

	private function getHtml_schemaOrganization()
	{
		$data =
		[
			"url" => $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"],
			"email" => Convert::textUnescape(GLOB::$SETTINGS["email1"], false),
			"faxNumber" => Convert::textUnescape(GLOB::$SETTINGS["phone1"], true),
			"telephone" => Convert::textUnescape(GLOB::$SETTINGS["phone1"], true),
			"logo" => $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]."/template/img/logo_ba_{langCode}.svg",
			"sameAs" => $this->getHtml_socList(),
		];

		return $this->objSTemplate->getHtml("main", "schemaOrganization", $data);
	}

	//*********************************************************************************

	private function getHtml_socList()
	{
		$objMArticle = MArticle::getInstance();
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$html = "";

		if (false === ($articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("socialNetwork"))))
		{
			return "";
		}

		$parameterArray =
		[
			"articleCatalogIdArray" => $articleCatalogInfo["id"],
			"orderType" => $articleCatalogInfo["orderInCatalog"],
			"showKey" => 1,
		];

		if (false === ($res = $objMArticle->getList($parameterArray)))
		{
			return "";
		}

		$count = count($res);
		$counter = 0;

		foreach($res AS $row)
		{
			$counter++;

			if ($counter === $count)
			{
				$html .= "\"".Convert::textUnescape($row["addField_1"], false)."\"";
			}
			else
			{
				$html .= "\"".Convert::textUnescape($row["addField_1"], false)."\",\r\n";
			}
		}

		return $html;
	}

	//*********************************************************************************
}

?>