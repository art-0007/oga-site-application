<?php

class MDataMarkData extends Model
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
			self::$obj = new MDataMarkData();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExistByDataIdAndDataMarkId($dataId, $dataMarkId)
	{
		if (0 === $this->objMySQL->count(DB_dataMarkData, "`data_id`='".Func::bb($dataId)."' AND `dataMark_id` = '".Func::bb($dataMarkId)."'"))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	//*********************************************************************************

	public function getDataMarkListByDataId($dataId, $parameterArray = null)
	{
		$mysqlWhere = $this->getMysqlWhere($parameterArray);

		$query =
		("
			SELECT
				`".DB_dataMark."`.`id` AS `id`,
				`".DB_dataMark."`.`devName` AS `devName`,
				`".DB_dataMark."`.`position` AS `position`,
				`".DB_dataMark."`.`showKey` AS `showKey`,
				`".DB_dataMarkLang."`.`title` AS `title`,
				`".DB_dataMarkLang."`.`dataImagePosition` AS `dataImagePosition`,
				`".DB_dataMarkLang."`.`fileName` AS `fileName`,
				`".DB_dataMarkLang."`.`dataImageMarginX` AS `dataImageMarginX`,
				`".DB_dataMarkLang."`.`dataImageMarginY` AS `dataImageMarginY`,
				`".DB_dataMarkLang."`.`dataImageWidth` AS `dataImageWidth`,
				`".DB_dataMarkLang."`.`dataImageHeight` AS `dataImageHeight`
			FROM
				`".DB_dataMark."`,
				`".DB_dataMarkLang."`,
				`".DB_dataMarkData."`
			WHERE
			(
				`".DB_dataMarkLang."`.`dataMark_id` = `".DB_dataMark."`.`id`
				AND
				`".DB_dataMarkData."`.`dataMark_id` = `".DB_dataMark."`.`id`
			)
			AND
			(
				`".DB_dataMarkData."`.`data_id` = '".Func::bb($dataId)."'
				AND
				`".DB_dataMarkLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
            ".$mysqlWhere."
			ORDER BY `".DB_dataMark."`.`position`
		");

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	public function getDataMarkIdListByDataId($dataId)
	{
		$query =
		("
			SELECT
				`".DB_dataMarkData."`.`dataMark_id` AS `dataMarkId`
			FROM
				`".DB_dataMarkData."`
			WHERE
			(
				`".DB_dataMarkData."`.`data_id` = '".Func::bb($dataId)."'
			)
		");

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	//Вовзражает MySQL WHERE часть запроса
	private function getMySQLWhere($parameterArray)
	{
		$mysqlWhere = "";

		if (!is_null($parameterArray))
		{
			if (isset($parameterArray["showKey"]) AND (0 === (int)$parameterArray["showKey"] OR 1 === (int)$parameterArray["showKey"]))
			{
				$mysqlWhere .= " AND (`".DB_dataMark."`.`showKey` = '".Func::res($parameterArray["showKey"])."') ";
			}
		}

		return $mysqlWhere;
	}

	//*********************************************************************************

	public function add($data)
	{
		return $this->objMySQL->insert(DB_dataMarkData, $data);
	}

	//*********************************************************************************

	public function delete($dataId, $dataMarkId)
	{
		return $this->objMySQL->delete(DB_dataMarkData, "`data_id` = '".Func::bb($dataId)."' AND `dataMark_id` = '".Func::bb($dataMarkId)."'");
	}

	//*********************************************************************************

	public function deleteByDataId($dataId)
	{
		return $this->objMySQL->delete(DB_dataMarkData, "`data_id` = '".Func::bb($dataId)."'");
	}

	//*********************************************************************************

}

?>