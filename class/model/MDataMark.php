<?php

class MDataMark extends Model
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
			self::$obj = new MDataMark();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($dataMarkId)
	{
		if (0 === $this->objMySQL->count(DB_dataMark, "`id` = '".Func::bb($dataMarkId)."'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isShowOnIndex($dataMarkId)
	{
		if (0 === $this->objMySQL->count(DB_dataMark, "`id` = '".Func::bb($dataMarkId)."' AND `showDataMarkOnIndexKey` = '1'"))
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
				COUNT(`".DB_dataMark."`.`id`) AS `count`
			FROM
				`".DB_dataMark."`
			WHERE
			(
				`".DB_dataMark."`.`devName` = '".Func::bb($devName)."'
				".((is_null($excludeDataMarkId))
				?
				""
				:
				" AND `".DB_dataMark."`.`id`!='".Func::bb($excludeDataMarkId)."'")."
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
				COUNT(`".DB_dataMark."`.`id`) AS `count`
			FROM
				`".DB_dataMark."`,
				`".DB_dataMarkLang."`
			WHERE
			(
				`".DB_dataMarkLang."`.`dataMark_id` = `".DB_dataMark."`.`id`
			)
			AND
			(
				`".DB_dataMarkLang."`.`title` = '".Func::bb($title)."'
				AND
				`".DB_dataMarkLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'"
				.((is_null($excludeDataMarkId))
				?
				""
				:
				" AND `".DB_dataMark."`.`id`!='".Func::bb($excludeDataMarkId)."'")."
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

 	public function isExistByBlockTitle($blockTitle, $excludeDataMarkId = null)
 	{
		$query =
		"
			SELECT
				COUNT(`".DB_dataMark."`.`id`) AS `count`
			FROM
				`".DB_dataMark."`,
				`".DB_dataMarkLang."`
			WHERE
			(
				`".DB_dataMarkLang."`.`dataMark_id` = `".DB_dataMark."`.`id`
			)
			AND
			(
				`".DB_dataMarkLang."`.`blockTitle` = '".Func::bb($blockTitle)."'
				AND
				`".DB_dataMarkLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'"
				.((is_null($excludeDataMarkId))
				?
				""
				:
				" AND `".DB_dataMark."`.`id`!='".Func::bb($excludeDataMarkId)."'")."
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
		("
			SELECT
				MAX(`".DB_dataMark."`.`position`) AS `position`
			FROM
				`".DB_dataMark."`
		");

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return 0;
		}

		return $res[0]["position"];
	}

	//*********************************************************************************

	public function getList($parameterArray = null, $orderType = EDataMarkType::position)
	{
		$mysqlFrom = "";

		$mysqlWhere = $this->getMysqlWhere($parameterArray);
		$mysqlOrderBy = $this->getMysqlOrderBy($orderType);

		if (!is_null($parameterArray) AND isset($parameterArray["dataId"]) AND !is_null($parameterArray["dataId"]))
		{
			$mysqlFrom = "LEFT JOIN `".DB_dataMarkData."` ON `".DB_dataMarkData."`.`dataMark_id` = `".DB_dataMark."`.`id`";
		}

		$query =
		("
			SELECT
				`".DB_dataMark."`.`id` AS `id`,
				`".DB_dataMark."`.`devName` AS `devName`,
				`".DB_dataMark."`.`position` AS `position`,
				`".DB_dataMark."`.`showDataMarkOnIndexKey` AS `showDataMarkOnIndexKey`,
				`".DB_dataMark."`.`dataImageKey` AS `dataImageKey`,
				`".DB_dataMarkLang."`.`title` AS `title`,
				`".DB_dataMarkLang."`.`blockTitle` AS `blockTitle`,
				`".DB_dataMarkLang."`.`dataImagePosition` AS `dataImagePosition`,
				`".DB_dataMarkLang."`.`fileName` AS `fileName`,
				`".DB_dataMarkLang."`.`dataImageMarginX` AS `dataImageMarginX`,
				`".DB_dataMarkLang."`.`dataImageMarginY` AS `dataImageMarginY`,
				`".DB_dataMarkLang."`.`dataImageWidth` AS `dataImageWidth`,
				`".DB_dataMarkLang."`.`dataImageHeight` AS `dataImageHeight`
			FROM
				`".DB_dataMarkLang."`,
				`".DB_dataMark."`
				".$mysqlFrom."
			WHERE
			(
				`".DB_dataMarkLang."`.`dataMark_id` = `".DB_dataMark."`.`id`
			)
			AND
			(
				`".DB_dataMarkLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
            ".$mysqlWhere."
            ".$mysqlOrderBy."
		");

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	public function getList_id($parameterArray = null, $orderType = EDataMarkType::position)
	{
		$mysqlFrom = "";

		$mysqlWhere = $this->getMysqlWhere($parameterArray);
		$mysqlOrderBy = $this->getMysqlOrderBy($orderType);

		if (!is_null($parameterArray) AND isset($parameterArray["dataId"]) AND !is_null($parameterArray["dataId"]))
		{
			$mysqlFrom = "LEFT JOIN `".DB_dataMarkData."` ON `".DB_dataMarkData."`.`dataMark_id` = `".DB_dataMark."`.`id`";
		}

		$query =
		("
			SELECT
				`".DB_dataMark."`.`id` AS `id`
			FROM
				`".DB_dataMarkLang."`,
				`".DB_dataMark."`
				".$mysqlFrom."
			WHERE
			(
				`".DB_dataMarkLang."`.`dataMark_id` = `".DB_dataMark."`.`id`
			)
			AND
			(
				`".DB_dataMarkLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
            ".$mysqlWhere."
            ".$mysqlOrderBy."
		");

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		$data = array();

		foreach($res AS $row)
  		{
			$data[] = $row["id"];
  		}

		return $data;
	}

	//*********************************************************************************

	public function getInfo($dataMarkId)
	{
		$query =
		"
			SELECT
				`".DB_dataMark."`.`id` AS `id`,
				`".DB_dataMark."`.`devName` AS `devName`,
				`".DB_dataMark."`.`position` AS `position`,
				`".DB_dataMark."`.`showDataMarkOnIndexKey` AS `showDataMarkOnIndexKey`,
				`".DB_dataMark."`.`dataImageKey` AS `dataImageKey`,
				`".DB_dataMarkLang."`.`title` AS `title`,
				`".DB_dataMarkLang."`.`blockTitle` AS `blockTitle`,
				`".DB_dataMarkLang."`.`dataImagePosition` AS `dataImagePosition`,
				`".DB_dataMarkLang."`.`fileName` AS `fileName`,
				`".DB_dataMarkLang."`.`dataImageMarginX` AS `dataImageMarginX`,
				`".DB_dataMarkLang."`.`dataImageMarginY` AS `dataImageMarginY`,
				`".DB_dataMarkLang."`.`dataImageWidth` AS `dataImageWidth`,
				`".DB_dataMarkLang."`.`dataImageHeight` AS `dataImageHeight`
			FROM
				`".DB_dataMark."`,
				`".DB_dataMarkLang."`
			WHERE
			(
				`".DB_dataMarkLang."`.`dataMark_id` = `".DB_dataMark."`.`id`
			)
			AND
			(
				`".DB_dataMark."`.`id` = '".Func::bb($dataMarkId)."'
				AND
				`".DB_dataMarkLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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
			if (isset($parameterArray["dataId"]) AND !is_null($parameterArray["dataId"]))
			{
				$mysqlWhere .= " AND (`".DB_dataMarkData."`.`data_id` = '".Func::res((int)$parameterArray["dataId"])."') ";
			}

			if (isset($parameterArray["showDataMarkOnIndexKey"]) AND (0 === (int)$parameterArray["showDataMarkOnIndexKey"] OR 1 === (int)$parameterArray["showDataMarkOnIndexKey"]))
			{
				$mysqlWhere .= " AND (`".DB_dataMark."`.`showDataMarkOnIndexKey` = '".Func::res($parameterArray["showDataMarkOnIndexKey"])."') ";
			}

			if (isset($parameterArray["dataImageKey"]) AND (0 === (int)$parameterArray["dataImageKey"] OR 1 === (int)$parameterArray["dataImageKey"]))
			{
				$mysqlWhere .= " AND (`".DB_dataMark."`.`dataImageKey` = '".Func::res($parameterArray["dataImageKey"])."') ";
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
			//Сортировка по имени
			case EDataMarkType::title:
			{
				$mysqlOrderBy = " ORDER BY `".DB_dataMarkLang."`.`title`";

				break;
			}

			//Сортировка по позиции
			case EDataMarkType::position:
			{
				$mysqlOrderBy = " ORDER BY `".DB_dataMark."`.`position`";

				break;
			}

			default:
			{
				$mysqlOrderBy = " ORDER BY `".DB_dataMarkLang."`.`title`";
				break;
			}
		}

		return $mysqlOrderBy;
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_dataMark, $data);
		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function edit($dataMarkId, $data)
	{
		return $this->objMySQL->update(DB_dataMark, $data, "`id` = '".Func::bb($dataMarkId)."'");
	}

	//*********************************************************************************

	public function editLang($dataMarkId, $data)
	{
		return $this->objMySQL->update(DB_dataMarkLang, $data, "`dataMark_id`='".Func::bb($dataMarkId)."' AND `lang_id`='".Func::bb(GLOB::$langId)."'");
	}

	//*********************************************************************************

	public function delete($dataMarkId)
	{
		return $this->objMySQL->delete(DB_dataMark, "`id` = '".Func::bb($dataMarkId)."'", 1);
	}

	//*********************************************************************************

}

?>