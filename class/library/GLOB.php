<?php

class GLOB extends SGLOB
{
	//*********************************************************************************

	public static $SETTINGS = array();
	public static $FRONT_DOMAIN = "";
	public static $FRONT_URL = "";
	public static $AUTHORIZATION = array();
	public static $PHP_SESSION_NAME = "psid";
	public static $AUTHORIZATION_COOKIES_NAME = "authorization";
	public static $ADMIN_USER_COOKIE_NAME = "uasid";
	public static $ADMIN_USER = array
	(
		"authorizedKey" => false,
		"id" => null
	);
	public static $langId = null;
	public static $langCode = null;

	private static $objSOutput = null;
	private static $objMySQL = null;

	//*********************************************************************************

	public static function init()
	{
		//Загружаем конфиг [происходит в самом начале, т.к. MySQL использует данные с конфига]
		Config::loadConfig();
		//Загружаем настройки системы
		self::setSettings();

		//Обьявляем константы
		self::defineConstants();
		self::$objSOutput = SOutput::getInstance();
		self::$objMySQL = MySQL::getInstance();

		//Домены и URL панели управления и сайта
		self::setDomainsAndUrls();

		self::authorizationCheck();
		//Стартуем PHP сессию
		self::phpSessionStart();
		self::checkAdminAuthorization();

		//Устанавливаем ID языка
		self::setDefaultLangId();
	}

	//*********************************************************************************

	public static function showPageError($text, $responseStatus)
	{
		SGLOB::$stdOutProcessed = true;
		//$tplData["content"] = $text;
		echo $text;
	}

	//*********************************************************************************

	//Определяет констант
	private static function defineConstants()
	{
		//share директория
		define("SHARE_PATH", PATH."/share");
		//URL к share директории
		define("SHARE_URL", "/share");
	}

	//*********************************************************************************

	/**
	 * Устанавливает домены и URL для панели управления и сайта
	 */
	private static function setDomainsAndUrls()
	{
		//------------------

		//Сайт

		self::$FRONT_DOMAIN = self::$SETTINGS["front_domain"];

		//Определяем URL сайта
		self::$FRONT_URL = "https://".self::$FRONT_DOMAIN;

		//------------------
	}

	/*********************************************************************************/

	private static function authorizationCheck()
	{
		$objAuthorizationCheck = AuthorizationCheck::getInstance();
	}

	//*********************************************************************************

	//Заполняет инфомарцию о пользователе
	private static function checkAdminAuthorization()
	{
		//Проверяем существует ли авторизационный кукис
		if(isset($_COOKIE[GLOB::$ADMIN_USER_COOKIE_NAME]))
		{
			$objMAdminUserSession = MAdminUserSession::getInstance();

			if(Reg::isCode($_COOKIE[GLOB::$ADMIN_USER_COOKIE_NAME]))
			{
				//Проверяем авторизирован ли пользователь
				if($objMAdminUserSession->isExist($_COOKIE[GLOB::$ADMIN_USER_COOKIE_NAME]))
				{
					//Достаем id пользователя
					$userId = $objMAdminUserSession->getUserId($_COOKIE[GLOB::$ADMIN_USER_COOKIE_NAME]);

					GLOB::$ADMIN_USER["authorizedKey"] = true;
					GLOB::$ADMIN_USER["id"] = (int)$userId;

					//Обновляем время последеней активности
					$objMAdminUserSession->updateRefreshTime($_COOKIE[GLOB::$ADMIN_USER_COOKIE_NAME]);
				}
				else
				{
					//Удаляем сесионный кукис
					$objMAdminUserSession->deleteCookie();
				}
			}
			else
			{
				//Удаляем сесионный кукис
				$objMAdminUserSession->deleteCookie();
			}
		}
	}

	//*********************************************************************************

	//Старт php сессии
	private static function phpSessionStart()
	{
		//Запуск сессии
		session_name(self::$PHP_SESSION_NAME);
		session_start();
	}

	/*********************************************************************************/

	//Загрузка настроек
	private static function setSettings()
	{
		$objMSettings = MSettings::getInstance();

		if (false === ($res = $objMSettings->getList()))
		{
			self::$objSOutput->critical("Настройки системы не определены");
		}

		foreach ($res AS $row)
		{
			self::$SETTINGS[$row["name"]] = $row["value"];
		}
	}

	//*********************************************************************************

	//Устанавливает id языка по умолчанию
	private static function setDefaultLangId()
	{
		$objMLang = MLang::getInstance();

		if (false === (self::$langId = $objMLang->getDefaultId()))
		{
			self::$objSOutput->critical("Язык используемый по умолчанию не определен");
		}

		if (isset($_COOKIE["langId"]) AND $objMLang->isExist($_COOKIE["langId"]))
		{
			self::$langId = (int)$_COOKIE["langId"];
		}

		self::$langCode = $objMLang->getCode(self::$langId);
	}

	//*********************************************************************************
}

?>