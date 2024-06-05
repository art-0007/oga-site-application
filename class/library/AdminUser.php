<?php

class AdminUser extends Base
{
	private static $obj = null;

	/*********************************************************************************/

	protected function __construct()
	{
		parent::__construct();
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
			self::$obj = new AdminUser();
		}

		return self::$obj;
	}

	/*********************************************************************************/

	//Проверяет авторизирован ли пользователь админпанели
	public static function isAuthorized()
	{
		return GLOB::$ADMIN_USER["authorizedKey"];
	}

	/*********************************************************************************/
}

?>