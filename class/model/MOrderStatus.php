<?php

class MOrderStatus extends Model
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
			self::$obj = new MOrderStatus();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($orderStatusId)
	{
		if (0 === $this->objMySQL->count(DB_orderStatus, "`id` = '".Func::bb($orderStatusId)."'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isBase($orderStatusId)
	{
		if (0 === $this->objMySQL->count(DB_orderStatus, "`id` = '".Func::bb($orderStatusId)."' AND `baseKey` = '1'"))
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
				COUNT(`".DB_orderStatus."`.`id`) AS `count`
			FROM
				`".DB_orderStatus."`
			WHERE
			(
				`".DB_orderStatus."`.`devName` = '".Func::bb($devName)."'
				".((is_null($excludeDataMarkId))
				?
				""
				:
				" AND `".DB_orderStatus."`.`id`!='".Func::bb($excludeDataMarkId)."'")."
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
				COUNT(`".DB_orderStatus."`.`id`) AS `count`
			FROM
				`".DB_orderStatus."`,
				`".DB_orderStatusLang."`
			WHERE
			(
				`".DB_orderStatusLang."`.`orderStatus_id` = `".DB_orderStatus."`.`id`
			)
			AND
			(
				`".DB_orderStatusLang."`.`title` = '".Func::bb($title)."'
				AND
				`".DB_orderStatusLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'"
				.((is_null($excludeDataMarkId))
				?
				""
				:
				" AND `".DB_orderStatus."`.`id`!='".Func::bb($excludeDataMarkId)."'")."
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
				MAX(`".DB_orderStatus."`.`position`) AS `position`
			FROM
				`".DB_orderStatus."`
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return 0;
		}

		return $res[0]["position"];
	}

	//*********************************************************************************

	public function getId_baseAndNew()
	{
		$query =
		"
			SELECT
				`".DB_orderStatus."`.`id` AS `id`
			FROM
				`".DB_orderStatus."`
			WHERE
			(
				`".DB_orderStatus."`.`devName` = 'new'
				AND
				`".DB_orderStatus."`.`baseKey` = '1'
			)
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	//*********************************************************************************

	public function getTitle($orderStatusId)
	{
		$query =
		"
			SELECT
				`".DB_orderStatusLang."`.`title` AS `title`
			FROM
				`".DB_orderStatus."`,
				`".DB_orderStatusLang."`
			WHERE
			(
				`".DB_orderStatusLang."`.`orderStatus_id` = `".DB_orderStatus."`.`id`
			)
			AND
			(
				`".DB_orderStatus."`.`id` = '".Func::bb($orderStatusId)."'
				AND
				`".DB_orderStatusLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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
				`".DB_orderStatus."`.`id` AS `id`,
				`".DB_orderStatus."`.`devName` AS `devName`,
				`".DB_orderStatus."`.`position` AS `position`,
				`".DB_orderStatus."`.`quantityOperationKey` AS `quantityOperationKey`,
				`".DB_orderStatus."`.`baseKey` AS `baseKey`,
				`".DB_orderStatusLang."`.`title` AS `title`
			FROM
				`".DB_orderStatus."`,
				`".DB_orderStatusLang."`
			WHERE
			(
				`".DB_orderStatusLang."`.`orderStatus_id` = `".DB_orderStatus."`.`id`
			)
			AND
			(
				`".DB_orderStatusLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
            ".$mysqlWhere."
            ORDER BY
                `".DB_orderStatus."`.`position`
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
				`".DB_orderStatus."`.`id` AS `id`
			FROM
				`".DB_orderStatus."`,
				`".DB_orderStatusLang."`
			WHERE
			(
				`".DB_orderStatusLang."`.`orderStatus_id` = `".DB_orderStatus."`.`id`
			)
			AND
			(
				`".DB_orderStatusLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
            ".$mysqlWhere."
            ORDER BY
                `".DB_orderStatus."`.`position`
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

	public function getInfo($orderStatusId)
	{
		$query =
		"
			SELECT
				`".DB_orderStatus."`.`id` AS `id`,
				`".DB_orderStatus."`.`devName` AS `devName`,
				`".DB_orderStatus."`.`position` AS `position`,
				`".DB_orderStatus."`.`quantityOperationKey` AS `quantityOperationKey`,
				`".DB_orderStatus."`.`baseKey` AS `baseKey`,
				`".DB_orderStatusLang."`.`title` AS `title`
			FROM
				`".DB_orderStatus."`,
				`".DB_orderStatusLang."`
			WHERE
			(
				`".DB_orderStatusLang."`.`orderStatus_id` = `".DB_orderStatus."`.`id`
			)
			AND
			(
				`".DB_orderStatus."`.`id` = '".Func::bb($orderStatusId)."'
				AND
				`".DB_orderStatusLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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
				$mysqlWhere .= " AND (`".DB_orderStatus."`.`baseKey` = '".Func::res($parameterArray["baseKey"])."') ";
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
						`".DB_orderStatus."`.`position`,
						`".DB_orderStatusLang."`.`title`
					";
				break;
			}
		}

		return $mysqlOrderBy;
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_orderStatus, $data);
		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function edit($orderStatusId, $data)
	{
		return $this->objMySQL->update(DB_orderStatus, $data, "`id` = '".Func::bb($orderStatusId)."'");
	}

	//*********************************************************************************

	public function editLang($orderStatusId, $data)
	{
		return $this->objMySQL->update(DB_orderStatusLang, $data, "`orderStatus_id`='".Func::bb($orderStatusId)."' AND `lang_id`='".Func::bb(GLOB::$langId)."'");
	}

	//*********************************************************************************

	public function delete($orderStatusId)
	{
		return $this->objMySQL->delete(DB_orderStatus, "`id` = '".Func::bb($orderStatusId)."'", 1);
	}

	//*********************************************************************************

}

?>