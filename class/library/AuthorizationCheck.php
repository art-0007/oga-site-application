<?php

class AuthorizationCheck extends Base
{
	private static $obj = null;

	/*********************************************************************************/

	protected function __construct()
	{
		parent::__construct();
		$this->init();
	}

	/*********************************************************************************/

	private function __clone()
	{
	}

	/*********************************************************************************/

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new AuthorizationCheck();
		}

		return self::$obj;
	}

	/*********************************************************************************/

	//Проверяет авторизирован ли пользователь
	public function isUserAuthorized()
	{
		if(isset(GLOB::$AUTHORIZATION["authorization"]) AND true === GLOB::$AUTHORIZATION["authorization"])
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*********************************************************************************/

	//Возвращает E-mail пользователя
	public function getUserEmail()
	{
		if(isset(GLOB::$AUTHORIZATION["email"]))
		{
			return (int)GLOB::$AUTHORIZATION["email"];
		}

		return false;
	}

	/*********************************************************************************/

	//Возвращает ID пользователя
	public function getUserId()
	{
		if(isset(GLOB::$AUTHORIZATION["userId"]))
		{
			return (int)GLOB::$AUTHORIZATION["userId"];
		}

		return false;
	}

	/*********************************************************************************/

 	private function init()
 	{
 		//Проверяем существует ли авторизационный кукис
		if(isset($_COOKIE[GLOB::$AUTHORIZATION_COOKIES_NAME]))
		{
			$objMUserSession = MUserSession::getInstance();

			if(Reg::isCode($_COOKIE[GLOB::$AUTHORIZATION_COOKIES_NAME]))
			{
				$objMUser = MUser::getInstance();

				//Проверяем авторизирован ли пользователь
				if($objMUserSession->isExist($_COOKIE[GLOB::$AUTHORIZATION_COOKIES_NAME], md5($_SERVER["HTTP_USER_AGENT"])))
				{
					//Достаем id пользователя
					$userId = $objMUserSession->getUserId($_COOKIE[GLOB::$AUTHORIZATION_COOKIES_NAME]);

					GLOB::$AUTHORIZATION["authorization"] = true;
					GLOB::$AUTHORIZATION["email"] = $objMUser->getEmail($userId);
					GLOB::$AUTHORIZATION["userId"] = (int)$userId;

					//Обновляем время последеней активности
					$objMUserSession->updateRefreshTime($_COOKIE[GLOB::$AUTHORIZATION_COOKIES_NAME]);
				}
				else
				{
					//Удаляем сесионный кукис
					$objMUserSession->deleteCookie();
				}
			}
			else
			{
				//Удаляем сесионный кукис
				$objMUserSession->deleteCookie();
			}
		}
 	}

	/*********************************************************************************/

}

?>