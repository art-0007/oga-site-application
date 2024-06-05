<?php

class MAdminUser extends Model
{
	private static $obj = null;

	//*********************************************************************************

	protected function __construct()
	{
		parent::__construct();
	}

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new MAdminUser();
		}

		return self::$obj;
	}

	//*********************************************************************************

 	public function isExist($adminUserId)
 	{
		if (0 === $this->objMySQL->count(DB_adminUser, "`id`='".Func::bb($adminUserId)."'"))
		{
			return false;
		}
		else
		{
			return true;
		}
 	}

	//*********************************************************************************

 	public function isExistByEmail($email, $excludeAdminUserId = null)
 	{
		if (0 === $this->objMySQL->count(DB_adminUser, "`email`='".Func::bb($email)."'".((is_null($excludeAdminUserId)) ? "" : "AND `id`!='".Func::bb($excludeAdminUserId)."'").""))
		{
			return false;
		}
		else
		{
			return true;
		}
 	}

	//*********************************************************************************

	/**
	 * Проверяет существует ли пользователь с соответсвующим email и паролем
	 *
	 * @param $userId - Id пользователя
	 * @param $password - пароль в обычном виде
	 *
	 * @return bool TRUE - существует; FALSE - не существует
	 * */
 	public function isExistByIdAndPassword($userId, $password)
 	{
		$query =
		"
			SELECT
    			COUNT(*) AS `count`
			FROM
				`".DB_adminUser."`
			WHERE
			(
				`".DB_adminUser."`.`id` = '".Func::bb($userId)."'
					AND
				`".DB_adminUser."`.`password` = '".Func::bb($password)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if((int)$res[0]["count"] > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
 	}

	//*********************************************************************************

 	public function isRoot($adminUserId)
 	{
		if (0 === $this->objMySQL->count(DB_adminUser, "`id`='".Func::bb($adminUserId)."' AND `rootKey`='1'"))
		{
			return false;
		}

		return true;
 	}

	//*********************************************************************************

 	public function isAdmin($adminUserId)
 	{
		if (0 === $this->objMySQL->count(DB_adminUser, "`id`='".Func::bb($adminUserId)."' AND `adminKey`='1'"))
		{
			return false;
		}

		return true;
 	}

	//*********************************************************************************

 	public function isBase($adminUserId)
 	{
		if (0 === $this->objMySQL->count(DB_adminUser, "`id`='".Func::bb($adminUserId)."' AND `baseKey`='1'"))
		{
			return false;
		}

		return true;
 	}

	//*********************************************************************************

	/**
	 * Достает adminUserId с заданым email
	 *
	 * @param $email - email пользователя
	 *
	 * @return userId или false если пользвоателя с таким $email не существует
	 * */
 	public function getIdByEmail($email)
 	{
		$query =
		"
			SELECT
    			`".DB_adminUser."`.`id` AS `id`
			FROM
				`".DB_adminUser."`
			WHERE
			(
				`".DB_adminUser."`.`email` = '".Func::bb($email)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) > 0)
		{
			return $res[0]["id"];
		}
		else
		{
			return false;
		}
 	}

	//*********************************************************************************

	/**
	 * Достает ифнормацию о пользователе
	 *
	 * @param $adminUserId - id пользователя
	 *
	 * @return array
	 * */
	public function getInfo($adminUserId)
	{
		$query =
		"
			SELECT
				*
			FROM
				`".DB_adminUser."`
			WHERE
			(
				`".DB_adminUser."`.`id` = '".Func::bb($adminUserId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return $res[0];

	}

	//*********************************************************************************

	public function getEmail($adminUserId)
	{
		$query =
		"
			SELECT
    			`email` AS `email`
			FROM
				`".DB_adminUser."`
			WHERE
			(
				`".DB_adminUser."`.`id` = '".Func::bb($adminUserId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return $res[0]["email"];

	}

	//*********************************************************************************

	/**
	 * Достает список пользователей
	 *
	 * @return array
	 * */
	public function getList($rootKey = false)
	{
		$mySqlWhere = "";

		if (false === $rootKey)
		{
			$mySqlWhere = " WHERE (`".DB_adminUser."`.`rootKey` = '0') ";
		}

		$query =
		"
			SELECT
				`id` AS `id`,
				`email` AS `email`,
				`firstName` AS `firstName`,
				`middleName` AS `middleName`,
				`lastName` AS `lastName`,
				`sendEmailWhenOrderAddKey` AS `sendEmailWhenOrderAddKey`
			FROM
				`".DB_adminUser."`
			".$mySqlWhere."
			ORDER BY
				`".DB_adminUser."`.`baseKey` DESC,
				`".DB_adminUser."`.`adminKey` DESC,
				`".DB_adminUser."`.`lastName`,
				`".DB_adminUser."`.`firstName`,
				`".DB_adminUser."`.`middleName`,
				`".DB_adminUser."`.`id`
		";

		$res = $this->objMySQL->query($query);

		if (count($res) === 0)
		{
			return false;
		}

		return $res;

	}

	//*********************************************************************************

	public function add($data)
	{
		return $this->objMySQL->insert(DB_adminUser, $data);
	}

	//*********************************************************************************

	public function edit($adminUserId, $data)
	{
		return $this->objMySQL->update(DB_adminUser, $data, "`id`='".Func::bb($adminUserId)."'");
	}

	//*********************************************************************************

	public function delete($adminUserId)
	{
		$this->objMySQL->delete(DB_adminUser, "`id`='".Func::bb($adminUserId)."'", 1);
	}

	//*********************************************************************************

}

?>