<?php

class MOrderPayType extends Model
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
			self::$obj = new MOrderPayType();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($orderPayTypeId)
	{
		if (0 === $this->objMySQL->count(DB_orderPayType, "`id` = '".Func::bb($orderPayTypeId)."'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isBase($orderPayTypeId)
	{
		if (0 === $this->objMySQL->count(DB_orderPayType, "`id` = '".Func::bb($orderPayTypeId)."' AND `baseKey` = '1'"))
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
				COUNT(`".DB_orderPayType."`.`id`) AS `count`
			FROM
				`".DB_orderPayType."`
			WHERE
			(
				`".DB_orderPayType."`.`devName` = '".Func::bb($devName)."'
				".((is_null($excludeDataMarkId))
				?
				""
				:
				" AND `".DB_orderPayType."`.`id`!='".Func::bb($excludeDataMarkId)."'")."
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
				COUNT(`".DB_orderPayType."`.`id`) AS `count`
			FROM
				`".DB_orderPayType."`,
				`".DB_orderPayTypeLang."`
			WHERE
			(
				`".DB_orderPayTypeLang."`.`orderPayType_id` = `".DB_orderPayType."`.`id`
			)
			AND
			(
				`".DB_orderPayTypeLang."`.`title` = '".Func::bb($title)."'
				AND
				`".DB_orderPayTypeLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'"
				.((is_null($excludeDataMarkId))
				?
				""
				:
				" AND `".DB_orderPayType."`.`id`!='".Func::bb($excludeDataMarkId)."'")."
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
				MAX(`".DB_orderPayType."`.`position`) AS `position`
			FROM
				`".DB_orderPayType."`
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return 0;
		}

		return $res[0]["position"];
	}

	//*********************************************************************************

	public function getTitle($orderPayTypeId)
	{
		$query =
		"
			SELECT
				`".DB_orderPayTypeLang."`.`title` AS `title`
			FROM
				`".DB_orderPayType."`,
				`".DB_orderPayTypeLang."`
			WHERE
			(
				`".DB_orderPayTypeLang."`.`orderPayType_id` = `".DB_orderPayType."`.`id`
			)
			AND
			(
				`".DB_orderPayType."`.`id` = '".Func::bb($orderPayTypeId)."'
				AND
				`".DB_orderPayTypeLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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
				`".DB_orderPayType."`.`id` AS `id`,
				`".DB_orderPayType."`.`devName` AS `devName`,
				`".DB_orderPayType."`.`position` AS `position`,
				`".DB_orderPayType."`.`baseKey` AS `baseKey`,
				`".DB_orderPayTypeLang."`.`title` AS `title`
			FROM
				`".DB_orderPayType."`,
				`".DB_orderPayTypeLang."`
			WHERE
			(
				`".DB_orderPayTypeLang."`.`orderPayType_id` = `".DB_orderPayType."`.`id`
			)
			AND
			(
				`".DB_orderPayTypeLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
            ".$mysqlWhere."
            ORDER BY
                `".DB_orderPayType."`.`position`
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
				`".DB_orderPayType."`.`id` AS `id`
			FROM
				`".DB_orderPayType."`,
				`".DB_orderPayTypeLang."`
			WHERE
			(
				`".DB_orderPayTypeLang."`.`orderPayType_id` = `".DB_orderPayType."`.`id`
			)
			AND
			(
				`".DB_orderPayTypeLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
            ".$mysqlWhere."
            ORDER BY
                `".DB_orderPayType."`.`position`
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

	public function getInfo($orderPayTypeId)
	{
		$query =
		"
			SELECT
				`".DB_orderPayType."`.`id` AS `id`,
				`".DB_orderPayType."`.`devName` AS `devName`,
				`".DB_orderPayType."`.`position` AS `position`,
				`".DB_orderPayType."`.`baseKey` AS `baseKey`,
				`".DB_orderPayTypeLang."`.`title` AS `title`
			FROM
				`".DB_orderPayType."`,
				`".DB_orderPayTypeLang."`
			WHERE
			(
				`".DB_orderPayTypeLang."`.`orderPayType_id` = `".DB_orderPayType."`.`id`
			)
			AND
			(
				`".DB_orderPayType."`.`id` = '".Func::bb($orderPayTypeId)."'
				AND
				`".DB_orderPayTypeLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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
				$mysqlWhere .= " AND (`".DB_orderPayType."`.`baseKey` = '".Func::res($parameterArray["baseKey"])."') ";
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
						`".DB_orderPayType."`.`position`,
						`".DB_orderPayTypeLang."`.`title`
					";
				break;
			}
		}

		return $mysqlOrderBy;
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_orderPayType, $data);
		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function edit($orderPayTypeId, $data)
	{
		return $this->objMySQL->update(DB_orderPayType, $data, "`id` = '".Func::bb($orderPayTypeId)."'");
	}

	//*********************************************************************************

	public function editLang($orderPayTypeId, $data)
	{
		return $this->objMySQL->update(DB_orderPayTypeLang, $data, "`orderPayType_id`='".Func::bb($orderPayTypeId)."' AND `lang_id`='".Func::bb(GLOB::$langId)."'");
	}

	//*********************************************************************************

	public function delete($orderPayTypeId)
	{
		return $this->objMySQL->delete(DB_orderPayType, "`id` = '".Func::bb($orderPayTypeId)."'", 1);
	}

	//*********************************************************************************

}

?>