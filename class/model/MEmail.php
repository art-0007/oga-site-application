<?php

class MEmail extends Model
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
			self::$obj = new MEmail();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($emailId)
	{
		if (0 === $this->objMySQL->count(DB_email, "`id`='".Func::bb($emailId)."'"))
		{
			return false;
		}

		return true;
	}

	/*********************************************************************************/

	/**
	 * Достает id E-mail по email
	 *
	 * @param $email - email E-mail
	 *
	 * @return int
	 * */
	public function getIdByEmail($email)
	{
		$query =
		"
			SELECT
    			`".DB_email."`.`id` AS `id`
			FROM
				`".DB_email."`
			WHERE
			(
				`".DB_email."`.`email` = '".Func::bb($email)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	/*********************************************************************************/

	/**
	 * Достает список E-mail
	 *
	 * @return array
	 * */
	public function getList()
	{
		$query =
		"
			SELECT
    			*
			FROM
				`".DB_email."`
			ORDER BY
				`".DB_email."`.`id` DESC
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
	 * Достает информацию о E-mail
	 *
	 * @param $emailId - id E-mail
	 *
	 * @return array
	 * */
	public function getInfo($emailId)
	{
		$query =
		"
			SELECT
    			*
			FROM
				`".DB_email."`
			WHERE
			(
				`".DB_email."`.`id` = '".Func::bb($emailId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return $res[0];
	}

	//*********************************************************************************

	public function add($data)
	{
		$this->objMySQL->insert(DB_email, $data);
	}

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_email, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function edit($emailId, $data)
	{
		return $this->objMySQL->update(DB_email, $data, "`id`='".Func::bb($emailId)."'");
	}

	//*********************************************************************************

	public function delete($emailId)
	{
		return $this->objMySQL->delete(DB_email, "`id`='".Func::bb($emailId)."'", 1);
	}

	/*********************************************************************************/
}

?>
