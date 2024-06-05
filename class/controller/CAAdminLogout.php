<?php

class CAAdminLogout extends CAjaxALoginInit
{
	//*********************************************************************************
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();
		$this->init();
	}

	//*********************************************************************************

 	private function init()
 	{
		$objAdminUser = AdminUser::getInstance();
		$objMAdminUserSession = MAdminUserSession::getInstance();

		//Проверяем существует ли в кукисах идентификатор сессии (а также проверяется его корректность)
		if($objAdminUser->isAuthorized())
		{
			//В кукисах есть ключ, значит сносим такую сессию в базе
			$objMAdminUserSession->delete(GLOB::$ADMIN_USER["id"]);
		}
		else
		{
			//Также удаляем кукисы сессии
			$objMAdminUserSession->deleteCookie();
		}

		$this->objSOutput->ok("Ok");
 	}

	//*********************************************************************************

}

?>