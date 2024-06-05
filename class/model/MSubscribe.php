<?php

class MSubscribe extends Model
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
			self::$obj = new MSubscribe();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($subscribeId)
	{
		if (0 === $this->objMySQL->count(DB_subscribe, "`id`='".Func::bb($subscribeId)."'"))
		{
			return false;
		}

		return true;
	}

	/*********************************************************************************/

	/**
	 * Достает id E-mail по subscribe
	 *
	 * @param $subscribe - subscribe E-mail
	 *
	 * @return int
	 * */
	public function getIdByEmail($subscribe)
	{
		$query =
		"
			SELECT
    			`".DB_subscribe."`.`id` AS `id`
			FROM
				`".DB_subscribe."`
			WHERE
			(
				`".DB_subscribe."`.`email` = '".Func::bb($subscribe)."'
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
				`".DB_subscribe."`
			ORDER BY
				`".DB_subscribe."`.`id` DESC
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
	 * @param $subscribeId - id E-mail
	 *
	 * @return array
	 * */
	public function getInfo($subscribeId)
	{
		$query =
		"
			SELECT
    			*
			FROM
				`".DB_subscribe."`
			WHERE
			(
				`".DB_subscribe."`.`id` = '".Func::bb($subscribeId)."'
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
		$this->objMySQL->insert(DB_subscribe, $data);
	}

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_subscribe, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function edit($subscribeId, $data)
	{
		return $this->objMySQL->update(DB_subscribe, $data, "`id`='".Func::bb($subscribeId)."'");
	}

	//*********************************************************************************

	public function delete($subscribeId)
	{
		return $this->objMySQL->delete(DB_subscribe, "`id`='".Func::bb($subscribeId)."'", 1);
	}

	/*********************************************************************************/
}

?>
