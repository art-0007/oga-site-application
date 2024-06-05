<?php

class MOrderDeliveryType extends Model
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
			self::$obj = new MOrderDeliveryType();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($orderDeliveryTypeId)
	{
		if (0 === $this->objMySQL->count(DB_orderDeliveryType, "`id` = '".Func::bb($orderDeliveryTypeId)."'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isBase($orderDeliveryTypeId)
	{
		if (0 === $this->objMySQL->count(DB_orderDeliveryType, "`id` = '".Func::bb($orderDeliveryTypeId)."' AND `baseKey` = '1'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

 	public function isExistByDevName($devName, $excludeDataMarkId = null)
 	{
		$query =
		"
			SELECT
				COUNT(`".DB_orderDeliveryType."`.`id`) AS `count`
			FROM
				`".DB_orderDeliveryType."`
			WHERE
			(
				`".DB_orderDeliveryType."`.`devName` = '".Func::bb($devName)."'
				".((is_null($excludeDataMarkId))
				?
				""
				:
				" AND `".DB_orderDeliveryType."`.`id`!='".Func::bb($excludeDataMarkId)."'")."
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === (int)$res[0]["count"])
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

 	public function isExistByTitle($title, $excludeDataMarkId = null)
 	{
		$query =
		"
			SELECT
				COUNT(`".DB_orderDeliveryType."`.`id`) AS `count`
			FROM
				`".DB_orderDeliveryType."`,
				`".DB_orderDeliveryTypeLang."`
			WHERE
			(
				`".DB_orderDeliveryTypeLang."`.`orderDeliveryType_id` = `".DB_orderDeliveryType."`.`id`
			)
			AND
			(
				`".DB_orderDeliveryTypeLang."`.`title` = '".Func::bb($title)."'
				AND
				`".DB_orderDeliveryTypeLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'"
				.((is_null($excludeDataMarkId))
				?
				""
				:
				" AND `".DB_orderDeliveryType."`.`id`!='".Func::bb($excludeDataMarkId)."'")."
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === (int)$res[0]["count"])
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function getMaxPosition()
	{
		$query =
		"
			SELECT
				MAX(`".DB_orderDeliveryType."`.`position`) AS `position`
			FROM
				`".DB_orderDeliveryType."`
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return 0;
		}

		return $res[0]["position"];
	}

	//*********************************************************************************

	public function getTitle($orderDeliveryTypeId)
	{
		$query =
		"
			SELECT
				`".DB_orderDeliveryTypeLang."`.`title` AS `title`
			FROM
				`".DB_orderDeliveryType."`,
				`".DB_orderDeliveryTypeLang."`
			WHERE
			(
				`".DB_orderDeliveryTypeLang."`.`orderDeliveryType_id` = `".DB_orderDeliveryType."`.`id`
			)
			AND
			(
				`".DB_orderDeliveryType."`.`id` = '".Func::bb($orderDeliveryTypeId)."'
				AND
				`".DB_orderDeliveryTypeLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return false;
		}

		return $res[0]["title"];
	}

	//*********************************************************************************

	public function getList($parameterArray = null)
	{
		$mysqlWhere = $this->getMysqlWhere($parameterArray);

		$query =
		"
			SELECT
				`".DB_orderDeliveryType."`.`id` AS `id`,
				`".DB_orderDeliveryType."`.`devName` AS `devName`,
				`".DB_orderDeliveryType."`.`position` AS `position`,
				`".DB_orderDeliveryType."`.`baseKey` AS `baseKey`,
				`".DB_orderDeliveryTypeLang."`.`title` AS `title`
			FROM
				`".DB_orderDeliveryType."`,
				`".DB_orderDeliveryTypeLang."`
			WHERE
			(
				`".DB_orderDeliveryTypeLang."`.`orderDeliveryType_id` = `".DB_orderDeliveryType."`.`id`
			)
			AND
			(
				`".DB_orderDeliveryTypeLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
            ".$mysqlWhere."
            ORDER BY
                `".DB_orderDeliveryType."`.`position`
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	public function getList_id($parameterArray = null)
	{
		$mysqlWhere = $this->getMysqlWhere($parameterArray);

		$query =
		"
			SELECT
				`".DB_orderDeliveryType."`.`id` AS `id`
			FROM
				`".DB_orderDeliveryType."`,
				`".DB_orderDeliveryTypeLang."`
			WHERE
			(
				`".DB_orderDeliveryTypeLang."`.`orderDeliveryType_id` = `".DB_orderDeliveryType."`.`id`
			)
			AND
			(
				`".DB_orderDeliveryTypeLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
            ".$mysqlWhere."
            ORDER BY
                `".DB_orderDeliveryType."`.`position`
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		$data = [];

		foreach($res AS $row)
  		{
			$data[] = $row["id"];
  		}

		return $data;
	}

	//*********************************************************************************

	public function getInfo($orderDeliveryTypeId)
	{
		$query =
		"
			SELECT
				`".DB_orderDeliveryType."`.`id` AS `id`,
				`".DB_orderDeliveryType."`.`devName` AS `devName`,
				`".DB_orderDeliveryType."`.`position` AS `position`,
				`".DB_orderDeliveryType."`.`baseKey` AS `baseKey`,
				`".DB_orderDeliveryTypeLang."`.`title` AS `title`
			FROM
				`".DB_orderDeliveryType."`,
				`".DB_orderDeliveryTypeLang."`
			WHERE
			(
				`".DB_orderDeliveryTypeLang."`.`orderDeliveryType_id` = `".DB_orderDeliveryType."`.`id`
			)
			AND
			(
				`".DB_orderDeliveryType."`.`id` = '".Func::bb($orderDeliveryTypeId)."'
				AND
				`".DB_orderDeliveryTypeLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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

	//Вовзражает MySQL WHERE часть запроса
	private function getMySQLWhere($parameterArray)
	{
		$mysqlWhere = "";

		if (!is_null($parameterArray))
		{
			if (isset($parameterArray["baseKey"]) AND (0 === (int)$parameterArray["baseKey"] OR 1 === (int)$parameterArray["baseKey"]))
			{
				$mysqlWhere .= " AND (`".DB_orderDeliveryType."`.`baseKey` = '".Func::res($parameterArray["baseKey"])."') ";
			}
		}

		return $mysqlWhere;
	}

	//*********************************************************************************

	//Возвражает MySQL ORDER BY часть запроса
	private function getMySQLOrderBy($orderType)
	{
		$mysqlOrderBy = "";

		//Вовзращает часть запроса с сортировкой
		switch($orderType)
		{
			default:
			{
				$mysqlOrderBy =
					"
					ORDER BY
						`".DB_orderDeliveryType."`.`position`,
						`".DB_orderDeliveryTypeLang."`.`title`
					";
				break;
			}
		}

		return $mysqlOrderBy;
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_orderDeliveryType, $data);
		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function edit($orderDeliveryTypeId, $data)
	{
		return $this->objMySQL->update(DB_orderDeliveryType, $data, "`id` = '".Func::bb($orderDeliveryTypeId)."'");
	}

	//*********************************************************************************

	public function editLang($orderDeliveryTypeId, $data)
	{
		return $this->objMySQL->update(DB_orderDeliveryTypeLang, $data, "`orderDeliveryType_id`='".Func::bb($orderDeliveryTypeId)."' AND `lang_id`='".Func::bb(GLOB::$langId)."'");
	}

	//*********************************************************************************

	public function delete($orderDeliveryTypeId)
	{
		return $this->objMySQL->delete(DB_orderDeliveryType, "`id` = '".Func::bb($orderDeliveryTypeId)."'", 1);
	}

	//*********************************************************************************

}

?>