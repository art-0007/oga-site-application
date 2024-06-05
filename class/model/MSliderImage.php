<?php

class MSliderImage extends Model
{
	/*********************************************************************************/

	private static $obj = null;

	/*********************************************************************************/

	protected function __construct()
	{
		parent::__construct();
	}

	//*********************************************************************************

	public static function getInstance()
	{
		if (is_null(self::$obj))
		{
			self::$obj = new MSliderImage;
		}

		return self::$obj;
	}

	/*********************************************************************************/

	public function isExist($sliderImageId)
	{
		$res = $this->objMySQL->count(DB_sliderImage, "`id` = '".Func::bb($sliderImageId)."'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	public function isShow($sliderImageId)
	{
		if (0 === $this->objMySQL->count(DB_sliderImage, "`id`='".Func::bb($sliderImageId)."' AND `showKey`='1' "))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByTitle($title, $excludeSliderImageId = null, $sliderImageCatalogId = null)
	{
		$excludeMySQLWhere1 = "";
		$excludeMySQLWhere2 = "";

		if (!is_null($excludeSliderImageId))
		{
			$excludeMySQLWhere1 = " AND `".DB_sliderImage."`.`id` != '".Func::bb($excludeSliderImageId)."'";
		}

		if (!is_null($sliderImageCatalogId))
		{
			$excludeMySQLWhere2 = " AND `".DB_sliderImage."`.`sliderImageCatalog_id` = '".Func::bb($sliderImageCatalogId)."'";
		}

		$query =
			"
			SELECT
    			COUNT(`".DB_sliderImage."`.`id`) AS `count`
			FROM
				`".DB_sliderImage."`,
				`".DB_sliderImageLang."`
			WHERE
			(
				`".DB_sliderImageLang."`.`sliderImage_id` = `".DB_sliderImage."`.`id`
			)
			AND
			(
				`".DB_sliderImageLang."`.`title` = '".Func::res($title)."'
				AND
				`".DB_sliderImageLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
			)
			".$excludeMySQLWhere1."
			".$excludeMySQLWhere2."
		";

		$res = $this->objMySQL->query($query);

		if (0 === (int)$res[0]["count"])
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistBySliderImageCatalogId($sliderImageCatalogId)
	{
		$query =
			"
			SELECT
    			COUNT(`".DB_sliderImage."`.`id`) AS `count`
			FROM
				`".DB_sliderImage."`
			WHERE
			(
				`".DB_sliderImage."`.`sliderImageCatalog_id` = '".Func::res($sliderImageCatalogId)."'
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

	/**
	 * Достает id каталога
	 *
	 * @param $id - id
	 *
	 * @return int
	 * */
	public function getSliderImageCatalogId($sliderImageId)
	{
		$query =
			"
			SELECT
    			`".DB_sliderImage."`.`sliderImageCatalog_id` AS `sliderImageCatalogId`
			FROM
				`".DB_sliderImage."`
			WHERE
			(
				`".DB_sliderImage."`.`id` = '".Func::res($sliderImageId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["sliderImageCatalogId"];
	}

	//*********************************************************************************

	public function getMaxPosition($sliderImageCatalogId)
	{
		$query =
			"
			SELECT
    			MAX(`".DB_sliderImage."`.`position`) AS `position`
			FROM
				`".DB_sliderImage."`
			WHERE
			(
				`".DB_sliderImage."`.`sliderImageCatalog_id` = '".Func::bb($sliderImageCatalogId)."'
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

	public function getList($sliderImageCatalogId, $showKey = null)
	{
		$mysqlWhere = "";

		if (!is_null($showKey) AND (0 === (int)$showKey OR 1 === (int)$showKey))
		{
			$mysqlWhere = " AND (`".DB_sliderImage."`.`showKey` = '".Func::bb($showKey)."') ";
		}

		$query =
		"
			SELECT
				`".DB_sliderImage."`.`id` AS `id`,
				`".DB_sliderImage."`.`sliderImageCatalog_id` AS `sliderImageCatalogId`,
				`".DB_sliderImage."`.`position` AS `position`,
				`".DB_sliderImage."`.`showKey` AS `showKey`,
				`".DB_sliderImageLang."`.`href` AS `href`,
				`".DB_sliderImageLang."`.`onclick` AS `onclick`,
				`".DB_sliderImageLang."`.`fileName` AS `fileName`,
				`".DB_sliderImageLang."`.`title` AS `title`,
				`".DB_sliderImageLang."`.`btnText` AS `btnText`,
				`".DB_sliderImageLang."`.`description` AS `description`,
				`".DB_sliderImageLang."`.`text` AS `text`
			FROM
				`".DB_sliderImage."`,
				`".DB_sliderImageLang."`
			WHERE
			(
    			`".DB_sliderImageLang."`.`sliderImage_id` = `".DB_sliderImage."`.`id`
			)
				AND
			(
				`".DB_sliderImage."`.`sliderImageCatalog_id` = '".Func::bb($sliderImageCatalogId)."'
				AND
				`".DB_sliderImageLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
			".$mysqlWhere."
			ORDER BY
				`".DB_sliderImage."`.`position`
		";

		$res = $this->objMySQL->query($query);
		if (0 === count($res))
		{
			return false;
		}

		return $res;
	}

	/*********************************************************************************/

	public function getInfo($sliderImageId)
	{
		$query =
		"
			SELECT
				`".DB_sliderImage."`.`id` AS `id`,
				`".DB_sliderImage."`.`sliderImageCatalog_id` AS `sliderImageCatalogId`,
				`".DB_sliderImage."`.`position` AS `position`,
				`".DB_sliderImage."`.`showKey` AS `showKey`,
				`".DB_sliderImageLang."`.`href` AS `href`,
				`".DB_sliderImageLang."`.`onclick` AS `onclick`,
				`".DB_sliderImageLang."`.`fileName` AS `fileName`,
				`".DB_sliderImageLang."`.`title` AS `title`,
				`".DB_sliderImageLang."`.`btnText` AS `btnText`,
				`".DB_sliderImageLang."`.`description` AS `description`,
				`".DB_sliderImageLang."`.`text` AS `text`
			FROM
				`".DB_sliderImage."`,
				`".DB_sliderImageLang."`
			WHERE
			(
    			`".DB_sliderImageLang."`.`sliderImage_id` = `".DB_sliderImage."`.`id`
			)
				AND
			(
				`".DB_sliderImage."`.`id` = '".Func::bb($sliderImageId)."'
				AND
				`".DB_sliderImageLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
		";

		$res = $this->objMySQL->query($query);
		if (0 === count($res))
		{
			return false;
		}

		return $res[0];
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_sliderImage, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function addLang($data)
	{
		return $this->objMySQL->insert(DB_sliderImageLang, $data);
	}

	//*********************************************************************************

	public function edit($sliderImageId, $data)
	{
		return $this->objMySQL->update(DB_sliderImage, $data, "`id`='".Func::bb($sliderImageId)."'");
	}

	//*********************************************************************************

	public function editLang($sliderImageId, $data)
	{
		return $this->objMySQL->update(DB_sliderImageLang, $data, "`sliderImage_id`='".Func::bb($sliderImageId)."' AND `lang_id` = '".Func::bb(GLOB::$langId)."'");
	}

	//*********************************************************************************

	public function delete($sliderImageId)
	{
		return $this->objMySQL->delete(DB_sliderImage, "`id`='".Func::bb($sliderImageId)."'", 1);
	}

	/*********************************************************************************/
}

?>
