<?php

class MData extends Model
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
			self::$obj = new MData();
		}

		return self::$obj;
	}

 	//*********************************************************************************

	public function isExist($dataId)
	{
		if (0 === $this->objMySQL->count(DB_data, "`id`='".Func::bb($dataId)."'"))
		{
			return false;
		}

		return true;
	}

 	//*********************************************************************************

	public function isShow($dataId)
	{
		if (0 === $this->objMySQL->count(DB_data, "`id`='".Func::bb($dataId)."' AND `showKey`='1'"))
		{
			return false;
		}

		return true;
	}

 	//*********************************************************************************

	public function isAvailable($dataId)
	{
		if (0 === $this->objMySQL->count(DB_data, "`id`='".Func::bb($dataId)."' AND `notAvailableKey`='0'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByUrlName($urlName, $excludeDataId = null)
	{
		if (0 === $this->objMySQL->count(DB_data,
		"`".DB_data."`.`urlName`='".Func::bb($urlName)."'
		".(
			(is_null($excludeDataId))
			?
				""
			:
				" AND `".DB_data."`.`id` != '".Func::bb($excludeDataId)."'"
		)))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByArticle($article, $excludeDataId = null)
	{
		if (0 === $this->objMySQL->count(DB_data,
		"`".DB_data."`.`article`='".Func::bb($article)."'
		".(
			(is_null($excludeDataId))
			?
				""
			:
				" AND `".DB_data."`.`id` != '".Func::bb($excludeDataId)."'"
		)))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByTitle($title, $excludeDataId = null)
	{
		if (0 === $this->objMySQL->count(DB_dataLang,
		"`".DB_dataLang."`.`title`='".Func::bb($title)."'
		".(
			(is_null($excludeDataId))
			?
				""
			:
				" AND `".DB_dataLang."`.`data_id` != '".Func::bb($excludeDataId)."'"
		)))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	//Вовзращает инфомарцию есть ли товары в каталоге
	public function isExistByCatalogId($catalogId)
	{
		$query =
		"
			SELECT
    			COUNT(`".DB_data."`.`id`) AS `count`
			FROM
				`".DB_data."`,
				`".DB_dataLang."`
			WHERE
			(
				`".DB_dataLang."`.`data_id` = `".DB_data."`.`id`
			)
			AND
			(
				`".DB_data."`.`catalog_id` = '".Func::res($catalogId)."'
					AND
				`".DB_dataLang."`.`lang_id` = '".GLOB::$langId."'
					AND
				`".DB_data."`.`showKey` = '1'
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
	 * Достает id товара по его urlName
	 * */
	public function getIdByUrlName($urlName)
	{
		$query =
		"
			SELECT
    			`".DB_data."`.`id` AS `id`
			FROM
				`".DB_data."`
			WHERE
			(
				`".DB_data."`.`urlName` = '".Func::res($urlName)."'
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

	/**
	 * Достает id каталога товара
	 * */
	public function getCatalogId($dataId)
	{
		$query =
		"
			SELECT
    			`".DB_data."`.`catalog_id` AS `catalogId`
			FROM
				`".DB_data."`
			WHERE
			(
				`".DB_data."`.`id` = '".Func::res($dataId)."'
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
	 * Достает id предыдущего товара
	 * */
	public function getPrevId($catalogId, $dataId)
	{
		$query =
		"
			SELECT
    			`".DB_data."`.`id` AS `id`
			FROM
				`".DB_data."`
			WHERE
			(
				`".DB_data."`.`id` < '".Func::res($dataId)."'
				AND
				`".DB_data."`.`catalog_id` = '".Func::res($catalogId)."'
				AND
				`".DB_data."`.`showKey` = '1'
			)
			ORDER BY
				`".DB_data."`.`id` DESC
			LIMIT 0, 1
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

 	//*********************************************************************************

	/**
	 * Достает id следующего товара
	 * */
	public function getNextId($catalogId, $dataId)
	{
		$query =
		"
			SELECT
    			`".DB_data."`.`id` AS `id`
			FROM
				`".DB_data."`
			WHERE
			(
				`".DB_data."`.`id` > '".Func::res($dataId)."'
				AND
				`".DB_data."`.`catalog_id` = '".Func::res($catalogId)."'
				AND
				`".DB_data."`.`showKey` = '1'
			)
			ORDER BY
				`".DB_data."`.`id`
			LIMIT 0, 1
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	//*********************************************************************************

	//Вовзращает наименование статьи
	public function getTitle($dataId)
	{
		$query =
		"
			SELECT
    			`".DB_dataLang."`.`title` AS `title`
			FROM
				`".DB_data."`,
				`".DB_dataLang."`
			WHERE
			(
				`".DB_dataLang."`.`data_id` = `".DB_data."`.`id`
			)
				AND
			(
				`".DB_data."`.`id` = '".Func::res($dataId)."'
					AND
				`".DB_dataLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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

	//Вовзращает инфомарцию о товаре
	public function getPrice($dataId)
	{
		$query =
		"
			SELECT
      			`".DB_data."`.`price` AS `price`
			FROM
				`".DB_data."`
			WHERE
			(
				`".DB_data."`.`id` = '".Func::res($dataId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return (float)$res[0]["price"];
	}

	//*********************************************************************************

	//Вовзращает список товаров в каталоге
	public function getList($catalogId, $orderType = EDataOrderType::title)
	{
		$query =
		"
			SELECT
    			`".DB_data."`.`id` AS `id`,
    			`".DB_data."`.`catalog_id` AS `catalogId`,
    			`".DB_data."`.`article` AS `article`,
				`".DB_data."`.`urlName` AS `urlName`,
      			`".DB_data."`.`price` AS `price`,
    			`".DB_data."`.`priceOld` AS `priceOld`,
				`".DB_data."`.`showKey` AS `showKey`,
				`".DB_data."`.`notAvailableKey` AS `notAvailableKey`,
				`".DB_data."`.`quantity` AS `quantity`,
    			`".DB_dataLang."`.`title` AS `title`,
    			`".DB_dataLang."`.`description` AS `description`,
    			`".DB_dataLang."`.`options` AS `options`
			FROM
				`".DB_data."`,
				`".DB_dataLang."`
			WHERE
			(
				`".DB_dataLang."`.`data_id` = `".DB_data."`.`id`
			)
				AND
			(
				`".DB_data."`.`catalog_id` = '".Func::res($catalogId)."'
					AND
				`".DB_dataLang."`.`lang_id` = '".GLOB::$langId."'
			)
            GROUP BY
               `".DB_data."`.`id` 
			".$this->getMySQLOrderBy($orderType)."
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	//Вовзращает список товаров в каталоге
	public function getAmountByParameters($parameterArray = null)
	{
		$mysqlFrom = "";
		$dataMarkIdArray = null;

		$mysqlWhere = $this->getMysqlWhere($parameterArray);

		if (!is_null($parameterArray) AND isset($parameterArray["dataMarkIdArray"]) AND 0 !== count($parameterArray["dataMarkIdArray"]))
		{
			$dataMarkIdArray = $parameterArray["dataMarkIdArray"];

			$mysqlFrom = "LEFT JOIN `".DB_dataMarkData."` ON `".DB_dataMarkData."`.`data_id` = `".DB_data."`.`id`";
		}

		$query =
		"
			SELECT
    			COUNT(`".DB_data."`.`id`) AS `count`
			FROM
				`".DB_dataLang."`,
				`".DB_dataImage."`,
				`".DB_data."`,
				`".DB_catalog."`,
				`".DB_catalogLang."`
				".$mysqlFrom."
			WHERE
			(
				`".DB_catalog."`.`catalog_id` = `".DB_catalog."`.`id`
				AND
				`".DB_dataLang."`.`data_id` = `".DB_data."`.`id`
				AND
				`".DB_dataImage."`.`data_id` = `".DB_data."`.`id`
				AND
				`".DB_data."`.`catalog_id` = `".DB_catalog."`.`id`
				AND
				`".DB_catalogLang."`.`catalog_id` = `".DB_catalog."`.`id`
			)
				AND
			(
				`".DB_dataLang."`.`lang_id` = '".GLOB::$langId."'
				AND
				`".DB_dataImage."`.`defaultKey` = '1'
			)
			".$mysqlWhere."
            GROUP BY
               `".DB_data."`.`id` 
		";

		$res = $this->objMySQL->query($query);

		return (int)$res[0]["count"];
	}

	//*********************************************************************************

	//Вовзращает список товаров в каталоге
	public function getListByParameters($parameterArray = null, $start = null, $amount = null, $orderType = EDataOrderType::title)
	{
		$mysqlFrom = "";

		$mysqlWhere = $this->getMysqlWhere($parameterArray);
		$mysqlOrderBy = $this->getMySQLOrderBy($orderType, $parameterArray);
		$mysqlLimit = $this->getMySQLLimit($start, $amount);

		if (!is_null($parameterArray) AND isset($parameterArray["dataMarkIdArray"]) AND 0 !== count($parameterArray["dataMarkIdArray"]))
		{
			$mysqlFrom = "LEFT JOIN `".DB_dataMarkData."` ON `".DB_dataMarkData."`.`data_id` = `".DB_data."`.`id`";
		}

		$query =
		"
			SELECT
    			`".DB_data."`.`id` AS `id`,
    			`".DB_data."`.`catalog_id` AS `catalogId`,
    			`".DB_data."`.`article` AS `article`,
				`".DB_data."`.`urlName` AS `urlName`,
      			`".DB_data."`.`price` AS `price`,
    			`".DB_data."`.`priceOld` AS `priceOld`,
				`".DB_data."`.`showKey` AS `showKey`,
				`".DB_data."`.`notAvailableKey` AS `notAvailableKey`,
				`".DB_data."`.`quantity` AS `quantity`,
    			`".DB_dataLang."`.`title` AS `title`,
    			`".DB_dataLang."`.`description` AS `description`,
    			`".DB_dataLang."`.`options` AS `options`,
    			`".DB_dataImage."`.`fileName` AS `fileName`,
    			`".DB_catalogLang."`.`title` AS `catalogTitle`
			FROM
				`".DB_dataLang."`,
				`".DB_dataImage."`,
				`".DB_data."`,
				`".DB_catalog."`,
				`".DB_catalogLang."`
				".$mysqlFrom."
			WHERE
			(
				`".DB_dataLang."`.`data_id` = `".DB_data."`.`id`
				AND
				`".DB_dataImage."`.`data_id` = `".DB_data."`.`id`
				AND
				`".DB_data."`.`catalog_id` = `".DB_catalog."`.`id`
				AND
				`".DB_catalogLang."`.`catalog_id` = `".DB_catalog."`.`id`
			)
				AND
			(
				`".DB_dataLang."`.`lang_id` = '".GLOB::$langId."'
				AND
				`".DB_catalogLang."`.`lang_id` = '".GLOB::$langId."'
				AND
				`".DB_dataImage."`.`defaultKey` = '1'
			)
			".$mysqlWhere."
            GROUP BY
               `".DB_data."`.`id` 
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

	//Вовзращает инфомарцию о товаре
	public function getInfo($dataId)
	{
		$query =
		"
			SELECT
    			`".DB_data."`.`id` AS `id`,
    			`".DB_data."`.`catalog_id` AS `catalogId`,
    			`".DB_data."`.`article` AS `article`,
				`".DB_data."`.`urlName` AS `urlName`,
      			`".DB_data."`.`price` AS `price`,
    			`".DB_data."`.`priceOld` AS `priceOld`,
				`".DB_data."`.`showKey` AS `showKey`,
				`".DB_data."`.`notAvailableKey` AS `notAvailableKey`,
				`".DB_data."`.`quantity` AS `quantity`,
    			`".DB_dataLang."`.`title` AS `title`,
    			`".DB_dataLang."`.`pageTitle` AS `pageTitle`,
    			`".DB_dataLang."`.`metaTitle` AS `metaTitle`,
    			`".DB_dataLang."`.`metaKeywords` AS `metaKeywords`,
    			`".DB_dataLang."`.`metaDescription` AS `metaDescription`,
    			`".DB_dataLang."`.`options` AS `options`,
    			`".DB_dataLang."`.`description` AS `description`,
    			`".DB_dataLang."`.`text` AS `text`
			FROM
				`".DB_data."`,
				`".DB_dataLang."`
			WHERE
			(
				`".DB_dataLang."`.`data_id` = `".DB_data."`.`id`
			)
				AND
			(
				`".DB_data."`.`id` = '".Func::res($dataId)."'
					AND
				`".DB_dataLang."`.`lang_id` = '".GLOB::$langId."'
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

	public function plusQuantity($dataId, $dataAmount)
	{
		$query =
			"
			UPDATE
    			`".DB_data."`
			SET
				`".DB_data."`.`quantity` = `".DB_data."`.`quantity` + '".Func::bb($dataAmount)."'
			WHERE
			(
				`".DB_data."`.`id` = '".Func::res($dataId)."'
			)
		";

		return $this->objMySQL->query($query);
	}

	//*********************************************************************************

	public function minusQuantity($dataId, $dataAmount)
	{
		$query =
			"
			UPDATE
    			`".DB_data."`
			SET
				`".DB_data."`.`quantity` = `".DB_data."`.`quantity` - '".Func::bb($dataAmount)."'
			WHERE
			(
				`".DB_data."`.`id` = '".Func::res($dataId)."'
			)
		";

		return $this->objMySQL->query($query);
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
					$parameterArray["catalogIdArray"] = array($parameterArray["catalogIdArray"]);
				}

			    $catalogIdArray = $parameterArray["catalogIdArray"];

			    if (isset($parameterArray["lastLevelCatalogKey"]) AND 1 === (int)$parameterArray["lastLevelCatalogKey"])
			    {
			    	$objMCatalog = MCatalog::getInstance();

				    $catalogIdArray = $objMCatalog->getCatalogIdArray_lastLevel($catalogIdArray);
			    }

			    $idArray = "";
				foreach ($catalogIdArray as $catalogId)
				{
		  			$idArray .= ", '".Func::bb($catalogId)."'";
		  		}
	
				$idArray = mb_substr($idArray, 2);
	
				$mysqlWhere .= " AND `".DB_data."`.`catalog_id` IN(".$idArray.")";
	 		}

			if
			(
				isset($parameterArray["dataMarkIdArray"])
				AND
				!is_null($parameterArray["dataMarkIdArray"])
				AND
				(!isset($parameterArray["dataMarkOrderKey"]) OR false === $parameterArray["dataMarkOrderKey"])
			)
			{
				if (!is_array($parameterArray["dataMarkIdArray"]))
				{
					$parameterArray["dataMarkIdArray"] = array($parameterArray["dataMarkIdArray"]);
				}
				
				$idList = "";
				foreach($parameterArray["dataMarkIdArray"] AS $id)
		  		{
					$idList .= ", ".Func::res((int)$id);
		  		}

				$idList = substr($idList, 2);
				$mysqlWhere .= " AND (`".DB_dataMarkData."`.`dataMark_id` IN (".$idList.")) ";
			}

			if (isset($parameterArray["showKey"]) AND (0 === (int)$parameterArray["showKey"] OR 1 === (int)$parameterArray["showKey"]))
			{
				$mysqlWhere .= " AND (`".DB_data."`.`showKey` = '".Func::res($parameterArray["showKey"])."') ";
			}
		}
		return $mysqlWhere;
	}

	//*********************************************************************************

	//Вовзражает MySQL ORDER BY часть запроса
	private function getMySQLOrderBy($orderType, $parameterArray = null)
	{
		$mysqlOrderBy = "";

		//Вовзращает часть запроса с сортировкой
		switch($orderType)
		{
			//Сортировка по имени
			case EDataOrderType::title:
			{
				$mysqlOrderBy =
				"
					ORDER BY
						`".DB_data."`.`notAvailableKey`,
					    `".DB_dataLang."`.`title`
				 ";

				break;
			}

			//Сортировка по позиции
			case EDataOrderType::popular:
			{
				$mysqlOrderBy =
				"
					ORDER BY
					    `".DB_data."`.`notAvailableKey`,
						`".DB_data."`.`view` DESC
				";

				break;
			}

			//Сортировка по имени
			case EDataOrderType::price:
			{
				$mysqlOrderBy =
				"
					ORDER BY
					    `".DB_data."`.`notAvailableKey`,
						`".DB_data."`.`price`
				";

				break;
			}

			//Сортировка по имени
			case EDataOrderType::priceDESC:
			{
				$mysqlOrderBy =
				"
					ORDER BY
					    `".DB_data."`.`notAvailableKey`,
						`".DB_data."`.`price` DESC
				";

				break;
			}

			//Сортировка по меткам
			case EDataOrderType::byMarkKey:
			{
				$mysqlOrderBy = " ORDER BY `".DB_dataLang."`.`title`";

				if
				(
					isset($parameterArray["dataMarkIdArray"])
					AND
					!is_null($parameterArray["dataMarkIdArray"])
					AND
					(isset($parameterArray["dataMarkOrderKey"]) AND true === $parameterArray["dataMarkOrderKey"])
				)
				{
					if (!is_array($parameterArray["dataMarkIdArray"]))
					{
						$parameterArray["dataMarkIdArray"] = array($parameterArray["dataMarkIdArray"]);
					}
					$mysqlOrderByTemp = "";
					foreach($parameterArray["dataMarkIdArray"] AS $id)
			  		{
						$mysqlOrderByTemp .= "`".DB_dataMarkData."`.`dataMark_id` = ".Func::res((int)$id)." DESC, ";
			  		}
	
					$mysqlOrderBy =
					"
						ORDER BY
							".$mysqlOrderByTemp."
					        `".DB_data."`.`notAvailableKey`,
							`".DB_dataLang."`.`title`
						";
				}

				break;
			}

			default:
			{
				$mysqlOrderBy =
				"
					ORDER BY
						`".DB_data."`.`notAvailableKey`,
					    `".DB_dataLang."`.`title`
				 ";
				break;
			}
		}

		return $mysqlOrderBy;
	}

	//*********************************************************************************

	//Вовзражает MySQL ORDER BY часть запроса
	private function getMySQLLimit($start, $amount)
	{
		$mysqlLimit = "";

		if (!is_null($start) AND (int)$start >= 0)
		{
			$mysqlLimit = " LIMIT ".$start.", ".$amount;
		}

		return $mysqlLimit;
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_data, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function addLang($data)
	{
		return $this->objMySQL->insert(DB_dataLang, $data);
	}

	//*********************************************************************************

	public function edit($dataId, $data)
	{
		return $this->objMySQL->update(DB_data, $data, "`id`='".Func::bb($dataId)."'");
	}

	//*********************************************************************************

	public function editLang($dataId, $data)
	{
		return $this->objMySQL->update(DB_dataLang, $data, "`data_id`='".Func::bb($dataId)."' AND `lang_id`='".GLOB::$langId."'");
	}

	//*********************************************************************************

	public function delete($dataId)
	{
		return $this->objMySQL->delete(DB_data, "`id`='".Func::bb($dataId)."'", 1);
	}

	//*********************************************************************************
}

?>