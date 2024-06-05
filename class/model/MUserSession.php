<?php

class MUserSession extends Model
{
	//*********************************************************************************/

	private static $obj = null;

	//*********************************************************************************/

	protected function __construct()
	{
		parent::__construct();
	}

	/*********************************************************************************/

	protected function __clone()
	{
	}

	/*********************************************************************************/

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new MUserSession();
		}

		return self::$obj;
	}

	/*********************************************************************************/

	private function init()
	{
	}

	/*********************************************************************************/


	/**
	 * Провряет существует ли сессия пользователя
	 *
	 * @return bool
	 * */
	public function isExist($uniqueId)
	{
		$query =
		"
			SELECT
				COUNT(*) AS `count`
			FROM
				`".DB_userSession."`
			WHERE
			(
				`".DB_userSession."`.`uniqueId` = '".Func::res($uniqueId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if((int)$res[0]["count"] > 0)
		{
			return true;
		}

		return false;
	}

	/*********************************************************************************/

	/**
	 * Достает ID пользователя
	 *
	 * $uniqueId - uniqueId сессии
	 *
	 * @return array
	 * */
	public function getUserId($uniqueId)
	{
		$query =
		"
			SELECT
				`".DB_userSession."`.`user_id` AS `userId`
			FROM
				`".DB_userSession."`
			WHERE
			(
				`".DB_userSession."`.`uniqueId` = '".Func::res($uniqueId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return $res[0]["userId"];
	}

	/*********************************************************************************/

	/**
	 * Устанавливает время активности пользователя
	 *
	 * @param $userId - id пользователя
	 * @param $password - md5 пароля
	 *
	 * @return bool
	 * */
 	public function updateRefreshTime($uniqueId)
 	{
 		$data["refreshTime"] = time();
 		$this->objMySQL->update(DB_userSession, $data, "`".DB_userSession."`.`uniqueId` = '".Func::res($uniqueId)."'");
 	}

	/*********************************************************************************/

	/**
	 * Новая авторизация пользователя
	 *
	 * @param $userId - id пользователя
	 *
	 * @return bool
	 * */
 	public function add($userId)
 	{
 		//Удаляем старые сессии
		$this->delete($userId);
		//uniqueId новой сиссии
		$sessionUniqueId = $this->getNewUniqueId();

		$data = array
		(
			"uniqueId" => $sessionUniqueId,
			"user_id" => $userId,
			"refreshTime" => time()
		);

		//Добавляем новую сессию
		$this->objMySQL->insert(DB_userSession, $data);
		//Ставим сесионный кукис
		$this->setCookie($sessionUniqueId);

		return true;
 	}

	//*********************************************************************************

	/**
	 * Удаляет сессию пользователя
	 *
	 * @param $userId - id пользователя
	 * */
	public function delete($userId)
	{
		//Удаляем сессию пользователя из БД
		$this->objMySQL->delete(DB_userSession, "`".DB_userSession."`.`user_id` = '".$userId."'");
		//Удаляем кукис
		$this->deleteCookie();
	}

	/*********************************************************************************/

	/**
	 * Устанавливает кукис сессии
	 * */
	public function setCookie($sessionUniqueId)
	{
		//Ставим кукис авторизации
		setcookie(GLOB::$AUTHORIZATION_COOKIES_NAME, $sessionUniqueId, (time() + (86400 * 365)), "/", ".".Func::getFrontDomainForCookies());
	}

	/*********************************************************************************/

	/**
	 * Удаляет кукис сессии
	 * */
	public function deleteCookie()
	{
		//Удаляем авторизационный кукис
		setcookie(GLOB::$AUTHORIZATION_COOKIES_NAME, "", (time() - 3600), "/", ".".Func::getFrontDomainForCookies());
	}

	/*********************************************************************************/

	/**
	 * Генерируйет новый $uniqueId сессии
	 * */
	private function getNewUniqueId()
	{
		return Func::uniqueIdForDB(DB_userSession, "uniqueId", 25);
	}

	/*********************************************************************************/
}
?>