<?php

class MCatalog extends Model
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
			self::$obj = new MCatalog();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($catalogId)
	{
		if (0 === $this->objMySQL->count(DB_catalog, "`id`='".Func::bb($catalogId)."'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isShow($catalogId)
	{
		if (0 === $this->objMySQL->count(DB_catalog, "`id`='".Func::bb($catalogId)."' AND `showKey`='1'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByUrlName($urlName, $excludeCatalogId = null)
	{
		if (0 === $this->objMySQL->count(DB_catalog,
		"`urlName`='".Func::bb($urlName)."'
		".(
			(is_null($excludeCatalogId))
			?
				""
			:
				" AND `".DB_catalog."`.`id` != '".Func::bb($excludeCatalogId)."'"
		)))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByTitle($title, $excludeCatalogId = null)
	{
		if (0 === $this->objMySQL->count(DB_catalogLang,
		"`title`='".Func::bb($title)."'
		".(
			(is_null($excludeCatalogId))
			?
				""
			:
				" AND `".DB_catalogLang."`.`catalog_id` != '".Func::bb($excludeCatalogId)."'"
		)))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	//Проверяет, есть ли у каталога дочерние
 	public function hasChild($catalogId, $parameterArray = null)
 	{
	    $mysqlWhere = $this->getMysqlWhere($parameterArray);

		$query =
		"
			SELECT
				COUNT(`".DB_catalog."`.`id`) AS `count`
			FROM
				`".DB_catalog."`,
				`".DB_catalogLang."`
			WHERE
			(
				`".DB_catalogLang."`.`catalog_id` = `".DB_catalog."`.`id`
			)
				AND
			(
				`".DB_catalog."`.`catalog_id` = '".Func::res($catalogId)."'
					AND
				`".DB_catalogLang."`.`lang_id` = '".GLOB::$langId."'
			)
			".$mysqlWhere."
		";

		$res = $this->objMySQL->query($query);

		if((int)$res[0]["count"] > 0)
		{
			return true;
		}

		return false;
 	}

 	//*********************************************************************************

	//Проверяет, существуют ли товары у бренда
 	public function hasData($catalogId, $parameterArray = null)
 	{
	    $mysqlWhere = $this->getMysqlWhere($parameterArray);

		$query =
		"
			SELECT
				COUNT(`".DB_data."`.`id`) AS `count`
			FROM
				`".DB_data."`
			WHERE
			(
				`".DB_data."`.`catalog_id` = '".Func::res($catalogId)."'
			)
			".$mysqlWhere."
		";

		$res = $this->objMySQL->query($query);

		if((int)$res[0]["count"] > 0)
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	//Вовзращает наименование статьи
	public function getTitle($catalogId)
	{
		$query =
			"
			SELECT
    			`".DB_catalogLang."`.`title` AS `title`
			FROM
				`".DB_catalog."`,
				`".DB_catalogLang."`
			WHERE
			(
				`".DB_catalogLang."`.`catalog_id` = `".DB_catalog."`.`id`
			)
				AND
			(
				`".DB_catalog."`.`id` = '".Func::res($catalogId)."'
					AND
				`".DB_catalogLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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

	public function getMaxPosition($catalog_id)
	{
		$query =
		"
			SELECT
    			MAX(`".DB_catalog."`.`position`) AS `position`
			FROM
				`".DB_catalog."`
			WHERE
			(
				`".DB_catalog."`.`catalog_id` = '".Func::res($catalog_id)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return 0;
		}

		return (int)$res[0]["position"];
	}

	//*********************************************************************************

	/**
	 * Достает parentId каталога по его id
	 * */
	public function getParentId($catalogId)
	{
		$query =
			"
			SELECT
    			`".DB_catalog."`.`catalog_id` AS `catalogId`
			FROM
				`".DB_catalog."`
			WHERE
			(
				`".DB_catalog."`.`id` = '".Func::res($catalogId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["catalogId"];
	}

	//*********************************************************************************

	/**
	 * Достает id родительских каталогов
	 * */
	public function getParents($catalogId, $parentsArray = array())
	{
		$query =
		"
			SELECT
    			`".DB_catalog."`.`id` AS `id`,
    			`".DB_catalog."`.`catalog_id` AS `catalog_id`
			FROM
				`".DB_catalog."`,
				`".DB_catalogLang."`
			WHERE
			(
				`".DB_catalogLang."`.`catalog_id` = `".DB_catalog."`.`id`
			)
				AND
			(
				`".DB_catalog."`.`id` = '".$catalogId."'
					AND
				`".DB_catalogLang."`.`lang_id` = '".GLOB::$langId."'
			)
			LIMIT 1
		";

		$res = $this->objMySQL->query($query);

		$row = $res[0];

		$parentsArray[] = (int)$row["catalog_id"];

		if(0 !== (int)$row["catalog_id"])
		{
			//Двигаемся по дереву в поисках родителя
			return $this->getParents($row["catalog_id"], $parentsArray);
		}

		//Переворачиваем массив и возвращаем его
		$parentsArray = array_reverse($parentsArray);

		return $parentsArray;
	}

	//*********************************************************************************

	/**
	 * Достает id каталога по его urlName
	 * */
	public function getIdByUrlName($urlName)
	{
		$query =
		"
			SELECT
    			`".DB_catalog."`.`id` AS `id`
			FROM
				`".DB_catalog."`
			WHERE
			(
				`".DB_catalog."`.`urlName` = '".Func::res($urlName)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	/*********************************************************************************/

	//Вовзращает список родительских каталогов первого уровня
	public function getList($parameterArray = null)
	{
		$start = (isset($parameterArray["start"])) ? (int)$parameterArray["start"] : 0;
		$amount = (isset($parameterArray["amount"])) ? (int)$parameterArray["amount"] : null;
		$orderType = (isset($parameterArray["orderType"])) ? $parameterArray["orderType"] : ECatalogOrderType::position;

		$mysqlWhere = $this->getMysqlWhere($parameterArray);
		$mysqlOrderBy = $this->getMysqlOrderBy($orderType);
		$mysqlLimit = $this->getMysqlWhereForLimit($start, $amount);

		$query =
		"
			SELECT
    			`".DB_catalog."`.`id` AS `id`,
    			`".DB_catalog."`.`catalog_id` AS `catalog_id`,
				`".DB_catalog."`.`urlName` AS `urlName`,
				`".DB_catalog."`.`fileName` AS `fileName`,
				`".DB_catalog."`.`position` AS `position`,
				`".DB_catalog."`.`showKey` AS `showKey`,
    			`".DB_catalogLang."`.`title` AS `title`,
    			`".DB_catalogLang."`.`description` AS `description`,
    			`".DB_catalogLang."`.`metaTitle` AS `metaTitle`,
    			`".DB_catalogLang."`.`metaKeywords` AS `metaKeywords`,
    			`".DB_catalogLang."`.`metaDescription` AS `metaDescription`
			FROM
				`".DB_catalog."`,
				`".DB_catalogLang."`
			WHERE
			(
				`".DB_catalogLang."`.`catalog_id` = `".DB_catalog."`.`id`
			)
				AND
			(
				`".DB_catalogLang."`.`lang_id` = '".GLOB::$langId."'
			)
			".$mysqlWhere."
			".$mysqlOrderBy."
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
	public function getInfo($catalogId)
	{
		$query =
		"
			SELECT
    			`".DB_catalog."`.`id` AS `id`,
    			`".DB_catalog."`.`catalog_id` AS `catalog_id`,
				`".DB_catalog."`.`urlName` AS `urlName`,
				`".DB_catalog."`.`position` AS `position`,
				`".DB_catalog."`.`fileName` AS `fileName`,
				`".DB_catalog."`.`position` AS `position`,
				`".DB_catalog."`.`showKey` AS `showKey`,
    			`".DB_catalogLang."`.`title` AS `title`,
    			`".DB_catalogLang."`.`pageTitle` AS `pageTitle`,
    			`".DB_catalogLang."`.`description` AS `description`,
    			`".DB_catalogLang."`.`text` AS `text`,
    			`".DB_catalogLang."`.`metaTitle` AS `metaTitle`,
    			`".DB_catalogLang."`.`metaKeywords` AS `metaKeywords`,
    			`".DB_catalogLang."`.`metaDescription` AS `metaDescription`
			FROM
				`".DB_catalog."`,
				`".DB_catalogLang."`
			WHERE
			(
				`".DB_catalogLang."`.`catalog_id` = `".DB_catalog."`.`id`
			)
				AND
			(
				`".DB_catalog."`.`id` = '".Func::res($catalogId)."'
					AND
				`".DB_catalogLang."`.`lang_id` = '".GLOB::$langId."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return $res[0];
	}

	/*********************************************************************************/

	public function getChildIdArray($catalogId)
	{
		$query =
		"
			SELECT
    			`".DB_catalog."`.`id` AS `id`
			FROM
				`".DB_catalog."`,
				`".DB_catalogLang."`
			WHERE
			(
				`".DB_catalogLang."`.`catalog_id` = `".DB_catalog."`.`id`
			)
				AND
			(
				`".DB_catalog."`.`catalog_id` = '".$catalogId."'
					AND
				`".DB_catalogLang."`.`lang_id` = '".GLOB::$langId."'
			)
		";

		$res = $this->objMySQL->query($query);

		$catalogIdArray = [];

		foreach ($res AS $row)
		{
			$catalogIdArray[] = $row["id"];
		}

		return $catalogIdArray;
	}

	/*********************************************************************************/

	/**
	 * Возвращает массив каталогов
	 *
	 * @param $catalogId - id каталога, первого родителя которого нужно определить
	 * @param $catalogArray - массив, заполняется в ходе работы метода.
	 *
	 *
	 * @return array - двухиерный массив каталогов с данными о каталогах
	 * */
	public function getListForNavigationLine($catalogId, $catalogArray = array())
	{
		$query =
			"
			SELECT
    			`".DB_catalog."`.`id` AS `id`,
    			`".DB_catalog."`.`catalog_id` AS `catalog_id`,
    			`".DB_catalog."`.`urlName` AS `urlName`,
    			`".DB_catalogLang."`.`title` AS `title`
			FROM
				`".DB_catalog."`,
				`".DB_catalogLang."`
			WHERE
			(
				`".DB_catalogLang."`.`catalog_id` = `".DB_catalog."`.`id`
			)
				AND
			(
				`".DB_catalog."`.`id` = '".$catalogId."'
					AND
				`".DB_catalogLang."`.`lang_id` = '".GLOB::$langId."'
			)
			LIMIT 1
		";

		$res = $this->objMySQL->query($query);
		$row = $res[0];

		//Добавляем информацию о текущем каталоге в массив
		$catalogArray[] = array
		(
			"id" => (int)$row["id"],
			"urlName" => $row["urlName"],
			"title" => $row["title"]
		);

		if((int)$row["catalog_id"] === 0)
		{
			//Переворачиваем массив и возвращаем его
			$catalogArray = array_reverse($catalogArray);
			return $catalogArray;
		}
		else
		{
			//Двигаемся по дереву в поисках родителя
			return $this->getListForNavigationLine($row["catalog_id"], $catalogArray);
		}
	}

	/*********************************************************************************/

	/**
	 * Возвращает массив каталогов последнего уровня
	 *
	 * @param $catalogIdArray - массив id каталогов, которые являются родителями
	 * @param $lastLevelCatalogArray - массив id каталогов, последнего уровня
	 *
	 * @return array - массив id каталогов, последнего уровня
	 * */
	public function getCatalogIdArray_lastLevel($catalogIdArray, $lastLevelCatalogArray = array())
	{
		foreach ($catalogIdArray as $catalogId)
		{
			$parameterArray =
			[
				"showKey" => "1",
			];

			if ($this->hasChild($catalogId, $parameterArray))
			{
				$childIdArray = $this->getChildIdArray($catalogId);

				return $this->getCatalogIdArray_lastLevel($childIdArray, $lastLevelCatalogArray);
			}
			else
			{
				$lastLevelCatalogArray[] = $catalogId;
			}
		}

		return $lastLevelCatalogArray;
	}

	/*********************************************************************************/

	public function getInfo_first($catalogId, $catalogArray = array())
	{
		$query =
		"
			SELECT
    			`".DB_catalog."`.`id` AS `id`,
    			`".DB_catalog."`.`catalog_id` AS `catalog_id`,
    			`".DB_catalog."`.`urlName` AS `urlName`,
    			`".DB_catalogLang."`.`title` AS `title`
			FROM
				`".DB_catalog."`,
				`".DB_catalogLang."`
			WHERE
			(
				`".DB_catalogLang."`.`catalog_id` = `".DB_catalog."`.`id`
			)
				AND
			(
				`".DB_catalog."`.`id` = '".Func::bb($catalogId)."'
					AND
				`".DB_catalogLang."`.`lang_id` = '".GLOB::$langId."'
			)
			LIMIT 1
		";

		$res = $this->objMySQL->query($query);
		$row = $res[0];

  		if(0 === (int)$row["catalog_id"])
  		{
			return $row;
  		}
  		else
  		{
  			//Двигаемся по дереву в поисках родителя
  			return $this->getInfo_first($row["catalog_id"], $catalogArray);
  		}
	}

	//*********************************************************************************

	//Вовзражает MySQL WHERE часть запроса
	private function getMySQLWhere($parameterArray)
	{
		$mysqlWhere = "";

		if (!is_null($parameterArray))
		{
			if (isset($parameterArray["catalogIdArray"]) AND !is_null($parameterArray["catalogIdArray"]))
			{
				if (!is_array($parameterArray["catalogIdArray"]))
				{
					$parameterArray["catalogIdArray"] = [$parameterArray["catalogIdArray"]];
				}

				$catalogIdArray = $parameterArray["catalogIdArray"];

				if (isset($parameterArray["lastLevelCatalogKey"]) AND 1 === (int)$parameterArray["lastLevelCatalogKey"])
				{
					$catalogIdArray = $this->getCatalogIdArray_lastLevel($catalogIdArray);
				}

				$idArray = "";
				foreach ($catalogIdArray as $catalogId)
				{
					$idArray .= ", '".Func::bb($catalogId)."'";
				}

				$idArray = mb_substr($idArray, 2);
				$mysqlWhere .= " AND `".DB_catalog."`.`catalog_id` IN(".$idArray.")";
			}

			if (isset($parameterArray["showKey"]) AND (0 === (int)$parameterArray["showKey"] OR 1 === (int)$parameterArray["showKey"]))
			{
				$mysqlWhere .= " AND (`".DB_catalog."`.`showKey` = '".Func::res($parameterArray["showKey"])."') ";
			}

			if (isset($parameterArray["dataShowKey"]) AND (0 === (int)$parameterArray["dataShowKey"] OR 1 === (int)$parameterArray["dataShowKey"]))
			{
				$mysqlWhere .= " AND (`".DB_data."`.`showKey` = '".Func::res($parameterArray["dataShowKey"])."') ";
			}
		}

		return $mysqlWhere;
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
				$mysqlOrderBy = " ORDER BY `".DB_catalogLang."`.`title`";

				break;
			}

			//Сортировка по позиции
			case ECatalogOrderType::position:
			{
				$mysqlOrderBy = " ORDER BY `".DB_catalog."`.`position`";

				break;
			}

			//Сортировка по позиции
			case ECatalogOrderType::rand:
			{
				$mysqlOrderBy = " ORDER BY RAND()";

				break;
			}

			default:
			{
				$mysqlOrderBy = " ORDER BY `".DB_catalogLang."`.`title`";
				break;
			}
		}

		return $mysqlOrderBy;
	}

	/*********************************************************************************/

	//WHERE часть запроса для LIMIT
	private function getMysqlWhereForLimit($start, $articleAmount)
	{
		$mysqlWhere = "";

		//Формируем mysqlLimit для запроса
		if(!is_null($articleAmount) AND (int)$articleAmount > 0)
		{
			$mysqlWhere = " LIMIT ".$start.", ".$articleAmount;
		}

		return $mysqlWhere;
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_catalog, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function edit($catalogId, $data)
	{
		return $this->objMySQL->update(DB_catalog, $data, "`id`='".Func::bb($catalogId)."'");
	}

	//*********************************************************************************

	public function editLang($catalogId, $data)
	{
		return $this->objMySQL->update(DB_catalogLang, $data, "`catalog_id`='".Func::bb($catalogId)."' AND `lang_id`='".GLOB::$langId."'");
	}

	//*********************************************************************************

	public function delete($catalogId)
	{
		$this->objMySQL->delete(DB_catalog, "`id`='".Func::bb($catalogId)."'", 1);
	}

	//*********************************************************************************
}

?>