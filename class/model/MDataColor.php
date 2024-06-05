<?php

class MDataColor extends Model
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
			self::$obj = new MDataColor();
		}

		return self::$obj;
	}

 	//*********************************************************************************

	public function isExist($dataColorId)
	{
		if (0 === $this->objMySQL->count(DB_dataColor, "`id`='".Func::bb($dataColorId)."'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByTitle($title, $excludeDataColorId = null)
	{
		if (0 === $this->objMySQL->count(DB_dataColorLang,
		"`".DB_dataColorLang."`.`title`='".Func::bb($title)."'
		".(
			(is_null($excludeDataColorId))
			?
				""
			:
				" AND `".DB_dataColorLang."`.`dataColor_id` != '".Func::bb($excludeDataColorId)."'"
		)))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	//Вовзращает инфомарцию есть ли размеры в товаре
	public function isExistByDataSizeId($dataSizeId)
	{
		$query =
		"
			SELECT
    			COUNT(`".DB_dataColor."`.`id`) AS `count`
			FROM
				`".DB_dataColor."`,
				`".DB_dataColorLang."`
			WHERE
			(
				`".DB_dataColorLang."`.`dataColor_id` = `".DB_dataColor."`.`id`
			)
			AND
			(
				`".DB_dataColor."`.`dataSize_id` = '".Func::res($dataSizeId)."'
					AND
				`".DB_dataColorLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
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

	public function getMaxPosition($dataSizeId)
	{
		$query =
		"
			SELECT
    			MAX(`".DB_dataColor."`.`position`) AS `position`
			FROM
				`".DB_dataColor."`,
				`".DB_dataColorLang."`
			WHERE
			(
				`".DB_dataColorLang."`.`dataColor_id` = `".DB_dataColor."`.`id`
			)
			AND
			(
				`".DB_dataColor."`.`dataSize_id` = '".Func::res($dataSizeId)."'
				AND
				`".DB_dataColorLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
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

	//Вовзращает Ид первого цвета
	public function getFirstColorId($dataColorId)
	{
		$query =
		"
			SELECT
    			`".DB_dataColor."`.`id` AS `id`
			FROM
				`".DB_dataColor."`
			WHERE
			(
				`".DB_dataColor."`.`dataSize_id` = '".Func::res($dataColorId)."'
			)
			ORDER BY
				`".DB_dataColor."`.`position`
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

	//Вовзращает список цветов в размера
	public function getList($dataSizeId)
	{
		$query =
		"
			SELECT
    			`".DB_dataColor."`.`id` AS `id`,
    			`".DB_dataColor."`.`dataSize_id` AS `dataSizeId`,
    			`".DB_dataColor."`.`fileName` AS `fileName`,
    			`".DB_dataColor."`.`position` AS `position`,
  				`".DB_dataColorLang."`.`title` AS `title`
			FROM
				`".DB_dataColor."`,
				`".DB_dataColorLang."`
			WHERE
			(
				`".DB_dataColorLang."`.`dataColor_id` = `".DB_dataColor."`.`id`
			)
				AND
			(
				`".DB_dataColor."`.`dataSize_id` = '".Func::res($dataSizeId)."'
					AND
				`".DB_dataColorLang."`.`lang_id` = '".GLOB::$langId."'
			)
			ORDER BY
				`".DB_dataColor."`.`position`
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	//Вовзращает инфомарцию о цвете
	public function getInfo($dataColorId)
	{
		$query =
		"
			SELECT
    			`".DB_dataColor."`.`id` AS `id`,
    			`".DB_dataColor."`.`dataSize_id` AS `dataSizeId`,
    			`".DB_dataColor."`.`fileName` AS `fileName`,
    			`".DB_dataColor."`.`position` AS `position`,
    			`".DB_dataColorLang."`.`title` AS `title`
			FROM
				`".DB_dataColor."`,
				`".DB_dataColorLang."`
			WHERE
			(
				`".DB_dataColorLang."`.`dataColor_id` = `".DB_dataColor."`.`id`
			)
				AND
			(
				`".DB_dataColor."`.`id` = '".Func::res($dataColorId)."'
					AND
				`".DB_dataColorLang."`.`lang_id` = '".GLOB::$langId."'
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
		$this->objMySQL->insert(DB_dataColor, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function addLang($data)
	{
		return $this->objMySQL->insert(DB_dataColorLang, $data);
	}

	//*********************************************************************************

	public function edit($dataColorId, $data)
	{
		return $this->objMySQL->update(DB_dataColor, $data, "`id`='".Func::bb($dataColorId)."'");
	}

	//*********************************************************************************

	public function editLang($dataColorId, $data)
	{
		return $this->objMySQL->update(DB_dataColorLang, $data, "`dataColor_id`='".Func::bb($dataColorId)."' AND `lang_id`='".GLOB::$langId."'");
	}

	//*********************************************************************************

	public function delete($dataColorId)
	{
		return $this->objMySQL->delete(DB_dataColor, "`id`='".Func::bb($dataColorId)."'", 1);
	}

	//*********************************************************************************
}

?>