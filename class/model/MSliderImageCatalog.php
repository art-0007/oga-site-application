<?php

class MSliderImageCatalog extends Model
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
			self::$obj = new MSliderImageCatalog();
		}

		return self::$obj;
	}

	//*********************************************************************************

	//Проверяет, есть ли каталог
 	public function isExist($sliderImageCatalogId)
 	{
		$res = $this->objMySQL->count(DB_sliderImageCatalog, "`id` = '".Func::res($sliderImageCatalogId)."'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
 	}

	/*********************************************************************************/

	public function isBase($sliderImageCatalogId)
	{
		$res = $this->objMySQL->count(DB_sliderImageCatalog, "`id` = '".Func::bb($sliderImageCatalogId)."' AND `baseKey` = '1'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
	}

 	//*********************************************************************************

	public function isExistByDevName($devName, $excludeSliderImageCatalogId = null)
	{
		if (0 === $this->objMySQL->count(DB_sliderImageCatalog,
		"`devName`='".Func::bb($devName)."'
		".(
			(is_null($excludeSliderImageCatalogId))
			?
				""
			:
				" AND `id` != '".Func::bb($excludeSliderImageCatalogId)."'"
		)))
		{
			return false;
		}

		return true;
	}

 	//*********************************************************************************

	public function isExistByTitle($title, $excludeSliderImageCatalogId = null)
	{
		if (0 === $this->objMySQL->count(DB_sliderImageCatalogLang,
		"`title`='".Func::bb($title)."'
		AND
		`lang_id` = '".Func::bb(GLOB::$langId)."'
		".(
			(is_null($excludeSliderImageCatalogId))
			?
				""
			:
				" AND `sliderImageCatalog_id` != '".Func::bb($excludeSliderImageCatalogId)."'"
		)))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	//Проверяет, есть ли у каталога дочерние
 	public function hasChild($sliderImageCatalogId)
 	{
		$query =
		("
			SELECT
				COUNT(`".DB_sliderImageCatalog."`.`id`) AS `count`
			FROM
				`".DB_sliderImageCatalog."`,
				`".DB_sliderImageCatalogLang."`
			WHERE
			(
				`".DB_sliderImageCatalogLang."`.`sliderImageCatalog_id` = `".DB_sliderImageCatalog."`.`id`
			)
				AND
			(
				`".DB_sliderImageCatalog."`.`sliderImageCatalog_id` = '".Func::res($sliderImageCatalogId)."'
					AND
				`".DB_sliderImageCatalogLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
			)
		");

		$res = $this->objMySQL->query($query);

		if((int)$res[0]["count"] > 0)
		{
			return true;
		}

		return false;
 	}

	//*********************************************************************************

	public function getMaxPosition($sliderImageCatalogId)
	{
		$query =
		"
			SELECT
    			MAX(`".DB_sliderImageCatalog."`.`position`) AS `position`
			FROM
				`".DB_sliderImageCatalog."`
			WHERE
			(
				`".DB_sliderImageCatalog."`.`sliderImageCatalog_id` = '".Func::res($sliderImageCatalogId)."'
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

	/**
	 * Достает parentId каталога по его id
	 * */
	public function getParentId($sliderImageCatalogId)
	{
		$query =
		"
			SELECT
    			`".DB_sliderImageCatalog."`.`sliderImageCatalog_id` AS `sliderImageCatalogId`
			FROM
				`".DB_sliderImageCatalog."`
			WHERE
			(
				`".DB_sliderImageCatalog."`.`id` = '".Func::res($sliderImageCatalogId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["sliderImageCatalogId"];
	}


 	//*********************************************************************************

	/**
	 * Достает id каталога по его devName
	 * */
	public function getIdByDevName($devName)
	{
		$query =
		"
			SELECT
    			`".DB_sliderImageCatalog."`.`id` AS `id`
			FROM
				`".DB_sliderImageCatalog."`
			WHERE
			(
				`".DB_sliderImageCatalog."`.`devName` = '".Func::res($devName)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

 	//*********************************************************************************

	//Вовзращает список родительских каталогов первого уровня
	public function getList($sliderImageCatalogId, $orderType = ESliderImageCatalogOrderType::position, $amount = null)
	{
		$query = "";
		$mysqlLimit = "";

		if(!is_null($amount))
		{
			$mysqlLimit =
			"
				LIMIT ".Func::res($amount)."
			";
		}

		$query =
		"
			SELECT
    			`".DB_sliderImageCatalog."`.`id` AS `id`,
    			`".DB_sliderImageCatalog."`.`sliderImageCatalog_id` AS `sliderImageCatalog_id`,
				`".DB_sliderImageCatalog."`.`devName` AS `devName`,
				`".DB_sliderImageCatalog."`.`position` AS `position`,
     			`".DB_sliderImageCatalog."`.`imgWidth_1` AS `imgWidth_1`,
    			`".DB_sliderImageCatalog."`.`imgHeight_1` AS `imgHeight_1`,
	   			`".DB_sliderImageCatalogLang."`.`title` AS `title`
			FROM
				`".DB_sliderImageCatalog."`,
				`".DB_sliderImageCatalogLang."`
			WHERE
			(
				`".DB_sliderImageCatalogLang."`.`sliderImageCatalog_id` = `".DB_sliderImageCatalog."`.`id`
			)
				AND
			(
				`".DB_sliderImageCatalog."`.`sliderImageCatalog_id` = '".Func::res($sliderImageCatalogId)."'
					AND
				`".DB_sliderImageCatalogLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
			".$this->getMySQLOrderBy($orderType)."
			".$mysqlLimit."
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	//Вовзращает инфомарцию о каталоге
	public function getInfo($sliderImageCatalogId)
	{
		$query =
		"
			SELECT
    			`".DB_sliderImageCatalog."`.`id` AS `id`,
    			`".DB_sliderImageCatalog."`.`sliderImageCatalog_id` AS `sliderImageCatalog_id`,
				`".DB_sliderImageCatalog."`.`devName` AS `devName`,
				`".DB_sliderImageCatalog."`.`position` AS `position`,
    			`".DB_sliderImageCatalog."`.`imgWidth_1` AS `imgWidth_1`,
    			`".DB_sliderImageCatalog."`.`imgHeight_1` AS `imgHeight_1`,
    			`".DB_sliderImageCatalogLang."`.`title` AS `title`
			FROM
				`".DB_sliderImageCatalog."`,
				`".DB_sliderImageCatalogLang."`
			WHERE
			(
				`".DB_sliderImageCatalogLang."`.`sliderImageCatalog_id` = `".DB_sliderImageCatalog."`.`id`
			)
				AND
			(
				`".DB_sliderImageCatalog."`.`id` = '".Func::res($sliderImageCatalogId)."'
					AND
				`".DB_sliderImageCatalogLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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

	//Вовзражает MySQL ORDER BY часть запроса
	private function getMySQLOrderBy($orderType)
	{
		$mysqlOrderBy = "";

		//Вовзращает часть запроса с сортировкой
		switch($orderType)
		{
			//Сортировка по имени
			case ECatalogOrderType::title:
			{
				$mysqlOrderBy =
				"
					ORDER BY
						`".DB_sliderImageCatalogLang."`.`title`
				";

				break;
			}

			//Сортировка по позиции
			case ECatalogOrderType::position:
			{
				$mysqlOrderBy =
				"
					ORDER BY
						`".DB_sliderImageCatalog."`.`position`
				";

				break;
			}

			default:
			{
				break;
			}
		}

		return $mysqlOrderBy;
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_sliderImageCatalog, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function addLang($data)
	{
		return $this->objMySQL->insert(DB_sliderImageCatalogLang, $data);
	}

	//*********************************************************************************

	public function edit($sliderImageCatalogId, $data)
	{
		return $this->objMySQL->update(DB_sliderImageCatalog, $data, "`id`='".Func::bb($sliderImageCatalogId)."'");
	}

	//*********************************************************************************

	public function editLang($sliderImageCatalogId, $data)
	{
		return $this->objMySQL->update(DB_sliderImageCatalogLang, $data, "`sliderImageCatalog_id`='".Func::bb($sliderImageCatalogId)."' AND `lang_id` = '".Func::bb(GLOB::$langId)."'");
	}

	//*********************************************************************************

	public function delete($sliderImageCatalogId)
	{
		return $this->objMySQL->delete(DB_sliderImageCatalog, "`id`='".Func::bb($sliderImageCatalogId)."'", 1);
	}

	//*********************************************************************************
}

?>