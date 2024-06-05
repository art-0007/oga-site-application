<?php

class MUser extends Model
{
	private static $obj = null;

	/*********************************************************************************/

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
			self::$obj = new MUser();
		}

		return self::$obj;
	}

	/*********************************************************************************/

	/**
	 * Проверяет существует ли пользователь в БД
	 *
	 * @param $userId - ID пользователя
	 *
	 * @return bool
	 * */
 	public function isExist($userId)
 	{
		$query =
		"
			SELECT
    			COUNT(*) AS `count`
			FROM
				`".DB_user."`
			WHERE
			(
				`".DB_user."`.`id` = '".Func::bb($userId)."'
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
	 * Проверяет существует ли e-mail в БД
	 *
	 * @param $email - e-mail адрес
	 *
	 * @return bool
	 * */
 	public function isExistByEmail($email, $excludeUserId = null)
 	{
		$excludeMySQLWhere = "";

		if (!is_null($excludeUserId))
		{
			$excludeMySQLWhere = " AND `".DB_user."`.`id` != '".Func::bb($excludeUserId)."'";
		}

		$query =
		"
			SELECT
    			COUNT(*) AS `count`
			FROM
				`".DB_user."`
			WHERE
			(
				`".DB_user."`.`email` = '".Func::bb($email)."'
			)
			".$excludeMySQLWhere."
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
	 * Проверяет существует ли пользователь с соответсвующим userId и паролем
	 *
	 * @param $userId - id пользователя
	 * @param $password - md5 пароля
	 *
	 * @return bool
	 * */
 	public function isExistByUserIdAndPasswordHash($userId, $password)
 	{
		$query =
		"
			SELECT
    			COUNT(*) AS `count`
			FROM
				`".DB_user."`
			WHERE
			(
				`".DB_user."`.`id` = '".Func::bb($userId)."'
					AND
				`".DB_user."`.`password` = '".Func::bb($password)."'
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
	 * Проверяет активированна ли учетная запись пользователя
	 *
	 * @param $userId - id пользователя
	 *
	 * @return bool
	 * */
 	public function isActivated($userId)
 	{
		$query =
		"
			SELECT
    			`".DB_user."`.`activeKey` AS `activeKey`
			FROM
				`".DB_user."`
			WHERE
			(
				`".DB_user."`.`id` = '".$userId."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		if(1 === (int)$res[0]["activeKey"])
		{
			return true;
		}

		return false;
 	}

	/*********************************************************************************/

	/**
	 * Проверяет подтвержден ли емайл пользователя
	 *
	 * @param $userId - id пользователя
	 *
	 * @return bool
	 * */
 	public function isEmailConfirm($userId)
 	{
		$query =
		"
			SELECT
    			`".DB_user."`.`emailConfirmKey` AS `emailConfirmKey`
			FROM
				`".DB_user."`
			WHERE
			(
				`".DB_user."`.`id` = '".$userId."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		if(1 === (int)$res[0]["emailConfirmKey"])
		{
			return true;
		}

	    return false;
 	}

	/*********************************************************************************/

	/**
	 * Формирует уникальный код подтверждения регистрации
	 *
	 * @return string
	 * */
 	public function getNewActivationUniqueKey()
 	{
		return Func::uniqueIdForDB(DB_user, "activationUniqueKey", 25);
 	}

	/*********************************************************************************/

	/**
	 * Возвращает код подтверждения E-mail
	 *
	 * @return string
	 * */
 	public function getEmailConfirmKey($email)
 	{
		return hash("sha256", $email.GLOB::$SETTINGS["front_signatureSecretKey"]);
 	}

	/*********************************************************************************/

	/**
	 * Достает email пользоватея по его id
	 *
	 * @param $userId - id пользователя
	 *
	 * @return string email или false если пользвоателя не существует
	 * */
 	public function getEmail($userId)
 	{
		$query =
		"
			SELECT
    			`".DB_user."`.`email` AS `email`
			FROM
				`".DB_user."`
			WHERE
			(
				`".DB_user."`.`id` = '".$userId."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return $res[0]["email"];
 	}

	/*********************************************************************************/

	/**
	 * Достает userId с заданым $email
	 *
	 * @param $email - e-mail пользователя
	 *
	 * @return (int)userId или 0 если пользвоателя с таким $referalId не существует
	 * */
 	public function getIdByEmail($email)
 	{
		$query =
		"
			SELECT
    			`".DB_user."`.`id` AS `id`
			FROM
				`".DB_user."`
			WHERE
			(
				`".DB_user."`.`email` = '".Func::res($email)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return (int)$res[0]["id"];
 	}

	/*********************************************************************************/

	public function getMaxDiscount($userId)
	{
		$query =
		"
			SELECT
    			`".DB_user."`.`discount` AS `discount`
			FROM
				`".DB_user."`
			WHERE
			(
				`".DB_user."`.`id` = '".$userId."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return (float)$res[0]["discount"];
	}

	/*********************************************************************************/

	/**
	 * Достает ифнормацию о пользователе
	 *
	 * @param int $userId - id пользователя
	 *
	 * @return array
	 * */
	public function getInfo($userId)
	{
		$query =
		"
			SELECT
    			*
			FROM
				`".DB_user."`
			WHERE
			(
				`".DB_user."`.`id` = '".Func::res($userId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res[0];
	}

	/*********************************************************************************/

	//Достаем список пользователей
	public function getList()
	{
		$query =
		"
			SELECT
    			*
			FROM
				`".DB_user."`
			ORDER BY
				`".DB_user."`.`lastName`,
				`".DB_user."`.`firstName`,
				`".DB_user."`.`middleName`
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res;
	}

	/*********************************************************************************/

	/**
	 * Активирует учетную запись и удаляет ключ активации
	 *
	 * @return bool
	 *
	 * */

	public function activateUser($userId)
	{
		$data =
		[
			"activeKey" => 1,
		];

		//Активируем пользоватедя
		return $this->objMySQL->update(DB_user, $data, "`".DB_user."`.`id` = '".$userId."'");
	}

	/*********************************************************************************/

	/**
	 * Подтверждение емайл
	 *
	 * @return bool
	 *
	 * */

	public function emailConfirm($userId)
	{
		$data =
		[
			"emailConfirmKey" => 1,
		];

		//Активируем пользоватедя
		return $this->objMySQL->update(DB_user, $data, "`".DB_user."`.`id` = '".$userId."'");
	}

	/*********************************************************************************/

	/**
	 * Устанавливает пользователю новый пароль
	 *
	 * @param $userId - id пользователя
	 * @param $newPassword - md5 пароля
	 *
	 * @return string
	 * */

	public function updatePassword($userId, $password)
	{
		//Устанавлвиаем новый пароль
		$data["password"] = md5($password);
		$this->objMySQL->update(DB_user, $data, "`".DB_user."`.`id` = '".$userId."'");

		return true;
	}


	/*********************************************************************************/

	/**
	 * Добавляет нового пользователя в БД
	 *
	 * @param $data = массив данных о пользователе
	 *
	 *
	 * @return (int)userId - пользователя или false - в случае ошибки
	 * */

	public function addAndReturnId($data)
	{
		//Вставляем новую запись
		if (false === ($res = $this->objMySQL->insert(DB_user, $data)))
		{
			return false;
		}

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function edit($userId, $data)
	{
		return $this->objMySQL->update(DB_user, $data, "`id`='".Func::bb($userId)."'");
	}

	//*********************************************************************************

	public function delete($userId)
	{
		$this->objMySQL->delete(DB_user, "`id`='".Func::bb($userId)."'", 1);
	}

	/*********************************************************************************/
}

?>