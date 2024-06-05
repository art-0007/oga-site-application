<?php

class MDataSize extends Model
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
			self::$obj = new MDataSize();
		}

		return self::$obj;
	}

 	//*********************************************************************************

	public function isExist($dataSizeId)
	{
		if (0 === $this->objMySQL->count(DB_dataSize, "`id`='".Func::bb($dataSizeId)."'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByTitle($title, $excludeDataSizeId = null)
	{
		if (0 === $this->objMySQL->count(DB_dataSizeLang,
		"`".DB_dataSizeLang."`.`title`='".Func::bb($title)."'
		".(
			(is_null($excludeDataSizeId))
			?
				""
			:
				" AND `".DB_dataSizeLang."`.`dataSize_id` != '".Func::bb($excludeDataSizeId)."'"
		)))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	//Вовзращает инфомарцию есть ли размеры в товаре
	public function isExistByDataId($dataId)
	{
		$query =
		"
			SELECT
    			COUNT(`".DB_dataSize."`.`id`) AS `count`
			FROM
				`".DB_dataSize."`,
				`".DB_dataSizeLang."`
			WHERE
			(
				`".DB_dataSizeLang."`.`dataSize_id` = `".DB_dataSize."`.`id`
			)
			AND
			(
				`".DB_dataSize."`.`data_id` = '".Func::res($dataId)."'
					AND
				`".DB_dataSizeLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if((int)$res[0]["count"] === 0)
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function getMaxPosition($dataId)
	{
		$query =
		"
			SELECT
    			MAX(`".DB_dataSize."`.`position`) AS `position`
			FROM
				`".DB_dataSize."`,
				`".DB_dataSizeLang."`
			WHERE
			(
				`".DB_dataSizeLang."`.`dataSize_id` = `".DB_dataSize."`.`id`
			)
			AND
			(
				`".DB_dataSize."`.`data_id` = '".Func::res($dataId)."'
				AND
				`".DB_dataSizeLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["position"];
	}

	//*********************************************************************************

	//Вовзращает Ид первого размера
	public function getFirstSizeId($dataId)
	{
		$query =
		"
			SELECT
    			`".DB_dataSize."`.`id` AS `id`
			FROM
				`".DB_dataSize."`
			WHERE
			(
				`".DB_dataSize."`.`data_id` = '".Func::res($dataId)."'
			)
			ORDER BY
				`".DB_dataSize."`.`position`
			LIMIT 0,1
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return $res[0]["id"];
	}

	//*********************************************************************************

	//Вовзращает список размеров в товаре
	public function getList($dataId)
	{
		$query =
		"
			SELECT
    			`".DB_dataSize."`.`id` AS `id`,
    			`".DB_dataSize."`.`data_id` AS `dataId`,
    			`".DB_dataSize."`.`position` AS `position`,
    			`".DB_dataSizeLang."`.`title` AS `title`
			FROM
				`".DB_dataSize."`,
				`".DB_dataSizeLang."`
			WHERE
			(
				`".DB_dataSizeLang."`.`dataSize_id` = `".DB_dataSize."`.`id`
			)
				AND
			(
				`".DB_dataSize."`.`data_id` = '".Func::res($dataId)."'
					AND
				`".DB_dataSizeLang."`.`lang_id` = '".GLOB::$langId."'
			)
			ORDER BY
				`".DB_dataSize."`.`position`
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	//Вовзращает инфомарцию о размере
	public function getInfo($dataSizeId)
	{
		$query =
		"
			SELECT
    			`".DB_dataSize."`.`id` AS `id`,
    			`".DB_dataSize."`.`data_id` AS `dataId`,
    			`".DB_dataSize."`.`position` AS `position`,
    			`".DB_dataSizeLang."`.`title` AS `title`
			FROM
				`".DB_dataSize."`,
				`".DB_dataSizeLang."`
			WHERE
			(
				`".DB_dataSizeLang."`.`dataSize_id` = `".DB_dataSize."`.`id`
			)
				AND
			(
				`".DB_dataSize."`.`id` = '".Func::res($dataSizeId)."'
					AND
				`".DB_dataSizeLang."`.`lang_id` = '".GLOB::$langId."'
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

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_dataSize, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function addLang($data)
	{
		return $this->objMySQL->insert(DB_dataSizeLang, $data);
	}

	//*********************************************************************************

	public function edit($dataSizeId, $data)
	{
		return $this->objMySQL->update(DB_dataSize, $data, "`id`='".Func::bb($dataSizeId)."'");
	}

	//*********************************************************************************

	public function editLang($dataSizeId, $data)
	{
		return $this->objMySQL->update(DB_dataSizeLang, $data, "`dataSize_id`='".Func::bb($dataSizeId)."' AND `lang_id`='".GLOB::$langId."'");
	}

	//*********************************************************************************

	public function delete($dataSizeId)
	{
		return $this->objMySQL->delete(DB_dataSize, "`id`='".Func::bb($dataSizeId)."'", 1);
	}

	//*********************************************************************************
}

?>