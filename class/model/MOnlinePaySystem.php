<?php

class MOnlinePaySystem extends Model
{
	//*********************************************************************************

	/** @var MOnlinePaySystem */
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
			self::$obj = new MOnlinePaySystem();
		}

		return self::$obj;
	}

	//*********************************************************************************

 	public function isExist($onlinePaySystemId)
 	{
		return !Func::isZero($this->objMySQL->count(DB_onlinePaySystem, "`id`='".Func::bb($onlinePaySystemId)."'"));
 	}

	//*********************************************************************************

	/**
	 * Возвращает наименование системы оплаты
	 *
	 * @param int $id ИД системы оплаты
	 *
	 * @return string
	 */
	public function getTitle($id)
	{
		$query =
		"
			SELECT
    			`".DB_onlinePaySystem."`.`title` AS `title`
			FROM
				`".DB_onlinePaySystem."`
			WHERE
			(
				`".DB_onlinePaySystem."`.`id` = '".Func::res($id)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return $res[0]["title"];
	}

	//*********************************************************************************

	/**
	 * Возвращает настройки системы оплаты
	 *
	 * @param int $id ИД системы оплаты
	 *
	 * @return string
	 */
	public function getSettings($id)
	{
		$query =
		"
			SELECT
				`".DB_onlinePaySystem."`.`settings` AS `settings`
			FROM
				`".DB_onlinePaySystem."`
			WHERE
			(
				`".DB_onlinePaySystem."`.`id` = '".Func::bb($id)."'
			)
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return false;
		}

		return $res[0]["settings"];
	}

	//*********************************************************************************

	public function getMaxPosition()
	{
		$query =
		"
			SELECT
    			MAX(`".DB_onlinePaySystem."`.`position`) AS `position`
			FROM
				`".DB_onlinePaySystem."`
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["position"];
	}

	//*********************************************************************************

	public function getList_forSelect()
	{
		$query =
		"
			SELECT
				`".DB_onlinePaySystem."`.`id` AS `id`,
				`".DB_onlinePaySystem."`.`title` AS `name`
			FROM
				`".DB_onlinePaySystem."`
			ORDER BY
				`".DB_onlinePaySystem."`.`title`
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	public function getList()
	{
		$query =
		"
			SELECT
				`".DB_onlinePaySystem."`.`id` AS `id`,
				`".DB_onlinePaySystem."`.`title` AS `title`,
				`".DB_onlinePaySystem."`.`devName` AS `devName`,
				`".DB_onlinePaySystem."`.`settings` AS `settings`,
				`".DB_onlinePaySystem."`.`position` AS `position`
			FROM
				`".DB_onlinePaySystem."`
			ORDER BY
				`".DB_onlinePaySystem."`.`position`,
				`".DB_onlinePaySystem."`.`title`
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	/**
	 * Достает ифнормацию о системе онлайн оплаты
	 *
	 * @param $id - id системы
	 *
	 * @return array
	 * */
	public function getInfo($id)
	{
		$query =
		"
			SELECT
				`".DB_onlinePaySystem."`.`id` AS `id`,
				`".DB_onlinePaySystem."`.`title` AS `title`,
				`".DB_onlinePaySystem."`.`devName` AS `devName`,
				`".DB_onlinePaySystem."`.`settings` AS `settings`,
				`".DB_onlinePaySystem."`.`position` AS `position`
			FROM
				`".DB_onlinePaySystem."`
			WHERE
			(
				`".DB_onlinePaySystem."`.`id` = '".Func::bb($id)."'
			)
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return false;
		}

		return $res[0];
	}

	//*********************************************************************************

	public function edit($id, $data)
	{
		return $this->objMySQL->update(DB_onlinePaySystem, $data, "`id` = '".Func::bb($id)."'");
	}

	//*********************************************************************************

}

?>