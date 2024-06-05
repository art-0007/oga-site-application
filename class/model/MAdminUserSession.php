<?php

class MAdminUserSession extends Model
{
	//*********************************************************************************/

	private $domain = "";
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
			self::$obj = new MAdminUserSession();
		}

		return self::$obj;
	}

	/*********************************************************************************/

	private function init()
	{
		$this->domain = $_SERVER["SERVER_NAME"];
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
				`".DB_adminUserSession."`
			WHERE
			(
				`".DB_adminUserSession."`.`uniqueId` = '".Func::res($uniqueId)."'
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
				`".DB_adminUserSession."`.`adminUser_id` AS `adminUserId`
			FROM
				`".DB_adminUserSession."`
			WHERE
			(
				`".DB_adminUserSession."`.`uniqueId` = '".Func::res($uniqueId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return $res[0]["adminUserId"];
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
 		$this->objMySQL->update(DB_adminUserSession, $data, "`".DB_adminUserSession."`.`uniqueId` = '".Func::res($uniqueId)."'");
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
			"adminUser_id" => $userId,
			"refreshTime" => time()
		);

		//Добавляем новую сессию
		$this->objMySQL->insert(DB_adminUserSession, $data);
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
		$this->objMySQL->delete(DB_adminUserSession, "`".DB_adminUserSession."`.`adminUser_id` = '".$userId."'");
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
		setcookie(GLOB::$ADMIN_USER_COOKIE_NAME, $sessionUniqueId, (time() + (86400 * 365)), "/", $this->domain);
	}

	/*********************************************************************************/

	/**
	 * Удаляет кукис сессии
	 * */
	public function deleteCookie()
	{
		//Удаляем авторизационный кукис
		setcookie(GLOB::$ADMIN_USER_COOKIE_NAME, "", (time() - 3600), "/", $this->domain);
	}

	/*********************************************************************************/

	/**
	 * Генерируйет новый $uniqueId сессии
	 * */
	private function getNewUniqueId()
	{
		return Func::uniqueIdForDB(DB_adminUserSession, "uniqueId", 45);
	}

	/*********************************************************************************/
}
?>