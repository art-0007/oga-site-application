<?php

class MArticleCatalog extends Model
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
			self::$obj = new MArticleCatalog();
		}

		return self::$obj;
	}

	//*********************************************************************************

	//Проверяет, есть ли каталог
 	public function isExist($articleCatalogId)
 	{
		$res = $this->objMySQL->count(DB_articleCatalog, "`id` = '".Func::res($articleCatalogId)."'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
 	}

	//*********************************************************************************

	public function isShow($articleCatalogId)
	{
		if (0 === $this->objMySQL->count(DB_articleCatalog, "`id`='".Func::bb($articleCatalogId)."' AND `showKey`='1' "))
		{
			return false;
		}

		return true;
	}

	/*********************************************************************************/

	public function isBase($articleCatalogId)
	{
		$res = $this->objMySQL->count(DB_articleCatalog, "`id` = '".Func::bb($articleCatalogId)."' AND `baseKey` = '1'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
	}

 	//*********************************************************************************

	public function isExistByUrlName($urlName, $excludeArticleCatalogId = null)
	{
		if (0 === $this->objMySQL->count(DB_articleCatalog,
		"`urlName`='".Func::bb($urlName)."'
		".(
			(is_null($excludeArticleCatalogId))
			?
				""
			:
				" AND `id` != '".Func::bb($excludeArticleCatalogId)."'"
		)))
		{
			return false;
		}

		return true;
	}

 	//*********************************************************************************

	public function isExistByDevName($devName, $excludeArticleCatalogId = null)
	{
		if (0 === $this->objMySQL->count(DB_articleCatalog,
		"`devName`='".Func::bb($devName)."'
		".(
			(is_null($excludeArticleCatalogId))
			?
				""
			:
				" AND `id` != '".Func::bb($excludeArticleCatalogId)."'"
		)))
		{
			return false;
		}

		return true;
	}

 	//*********************************************************************************

	public function isExistByTitle($title, $excludeArticleCatalogId = null, $parentArticleCatalogId = null)
	{
		$excludeMySQLWhere1 = "";
		$excludeMySQLWhere2 = "";

		if (!is_null($excludeArticleCatalogId))
		{
			$excludeMySQLWhere1 = " AND `".DB_articleCatalog."`.`id` != '".Func::bb($excludeArticleCatalogId)."'";
		}

		if (!is_null($parentArticleCatalogId))
		{
			$excludeMySQLWhere2 = " AND `".DB_articleCatalog."`.`articleCatalog_id` = '".Func::bb($parentArticleCatalogId)."'";
		}

		$query =
		"
			SELECT
    			COUNT(`".DB_articleCatalog."`.`id`) AS `count`
			FROM
				`".DB_articleCatalog."`,
				`".DB_articleCatalogLang."`
			WHERE
			(
				`".DB_articleCatalogLang."`.`articleCatalog_id` = `".DB_articleCatalog."`.`id`
			)
			AND
			(
				`".DB_articleCatalogLang."`.`title` = '".Func::res($title)."'
				AND
				`".DB_articleCatalogLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
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

	//Проверяет, есть ли у каталога дочерние
 	public function hasChild($articleCatalogId)
 	{
		$query =
		("
			SELECT
				COUNT(`".DB_articleCatalog."`.`id`) AS `count`
			FROM
				`".DB_articleCatalog."`,
				`".DB_articleCatalogLang."`
			WHERE
			(
				`".DB_articleCatalogLang."`.`articleCatalog_id` = `".DB_articleCatalog."`.`id`
			)
				AND
			(
				`".DB_articleCatalog."`.`articleCatalog_id` = '".Func::res($articleCatalogId)."'
					AND
				`".DB_articleCatalogLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
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

	public function getMaxPosition($articleCatalogId)
	{
		$query =
		"
			SELECT
    			MAX(`".DB_articleCatalog."`.`position`) AS `position`
			FROM
				`".DB_articleCatalog."`
			WHERE
			(
				`".DB_articleCatalog."`.`articleCatalog_id` = '".Func::res($articleCatalogId)."'
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
	public function getParentId($articleCatalogId)
	{
		$query =
		"
			SELECT
    			`".DB_articleCatalog."`.`articleCatalog_id` AS `articleCatalogId`
			FROM
				`".DB_articleCatalog."`
			WHERE
			(
				`".DB_articleCatalog."`.`id` = '".Func::res($articleCatalogId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["articleCatalogId"];
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
    			`".DB_articleCatalog."`.`id` AS `id`
			FROM
				`".DB_articleCatalog."`
			WHERE
			(
				`".DB_articleCatalog."`.`urlName` = '".Func::res($urlName)."'
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
	 * Достает id каталога по его devName
	 * */
	public function getIdByDevName($devName)
	{
		$query =
		"
			SELECT
    			`".DB_articleCatalog."`.`id` AS `id`
			FROM
				`".DB_articleCatalog."`
			WHERE
			(
				`".DB_articleCatalog."`.`devName` = '".Func::res($devName)."'
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

	//Вовзращает наименование каталога
	public function getTitle($articleCatalogId)
	{
		$query =
		"
			SELECT
    			`".DB_articleCatalogLang."`.`title` AS `title`
			FROM
				`".DB_articleCatalog."`,
				`".DB_articleCatalogLang."`
			WHERE
			(
				`".DB_articleCatalogLang."`.`articleCatalog_id` = `".DB_articleCatalog."`.`id`
			)
				AND
			(
				`".DB_articleCatalog."`.`id` = '".Func::res($articleCatalogId)."'
					AND
				`".DB_articleCatalogLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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

	//Вовзращает наименование каталога
	public function getDevName($articleCatalogId)
	{
		$query =
		"
			SELECT
    			`".DB_articleCatalog."`.`devName` AS `devName`
			FROM
				`".DB_articleCatalog."`
			WHERE
			(
				`".DB_articleCatalog."`.`id` = '".Func::res($articleCatalogId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return $res[0]["devName"];
	}

	//*********************************************************************************

	//Вовзращает наименование каталога
	public function getFileName($articleCatalogId)
	{
		$query =
		"
			SELECT
 				`".DB_articleCatalogLang."`.`fileName1` AS `fileName1`,
				`".DB_articleCatalogLang."`.`fileName2` AS `fileName2`,
				`".DB_articleCatalogLang."`.`fileName3` AS `fileName3`
			FROM
				`".DB_articleCatalogLang."`
			WHERE
			(
				`".DB_articleCatalogLang."`.`articleCatalog_id` = '".Func::res($articleCatalogId)."'
				AND
				`".DB_articleCatalogLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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

	//Возвращает количество
	public function getAmount($parameterArray)
	{
		$mysqlWhere = $this->getMysqlWhere($parameterArray);

		$query =
		"
			SELECT
				COUNT(`".DB_articleCatalog."`.`id`) AS `count`
			FROM
				`".DB_articleCatalog."`,
				`".DB_articleCatalogLang."`
			WHERE
			(
				`".DB_articleCatalogLang."`.`articleCatalog_id` = `".DB_articleCatalog."`.`id`
			)
				AND
			(
				`".DB_articleCatalogLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
			".$mysqlWhere."
		";

		$res = $this->objMySQL->query($query);

		return (int)$res[0]["count"];
	}

	//*********************************************************************************

	//Вовзращает список родительских каталогов первого уровня
	public function getList($parameterArray = null)
	{
		$start = (isset($parameterArray["start"])) ? (int)$parameterArray["start"] : null;
		$amount = (isset($parameterArray["amount"])) ? (int)$parameterArray["amount"] : null;
		$orderType = (isset($parameterArray["orderType"])) ? $parameterArray["orderType"] : EArticleCatalogOrderType::position;

		$mysqlWhere = $this->getMysqlWhere($parameterArray);
		$mysqlOrderBy = $this->getMysqlOrderBy($orderType);
		$mysqlLimit = $this->getMysqlWhereForLimit($start, $amount);

		$query =
		"
			SELECT
    			`".DB_articleCatalog."`.`id` AS `id`,
    			`".DB_articleCatalog."`.`articleCatalog_id` AS `articleCatalog_id`,
    			`".DB_articleCatalog."`.`articleParameter_id` AS `articleParameterId`,
				`".DB_articleCatalog."`.`urlName` AS `urlName`,
				`".DB_articleCatalog."`.`devName` AS `devName`,
				`".DB_articleCatalog."`.`position` AS `position`,
				`".DB_articleCatalog."`.`orderInCatalog` AS `orderInCatalog`,
				`".DB_articleCatalog."`.`designType` AS `designType`,
				`".DB_articleCatalog."`.`showKey` AS `showKey`,
				`".DB_articleCatalog."`.`addField_1` AS `addField_1`,
				`".DB_articleCatalog."`.`addField_2` AS `addField_2`,
				`".DB_articleCatalog."`.`addField_3` AS `addField_3`,
				`".DB_articleCatalog."`.`addField_4` AS `addField_4`,
				`".DB_articleCatalog."`.`addField_5` AS `addField_5`,
				`".DB_articleCatalog."`.`addField_6` AS `addField_6`,
				`".DB_articleCatalogLang."`.`fileName1` AS `fileName1`,
				`".DB_articleCatalogLang."`.`fileName2` AS `fileName2`,
				`".DB_articleCatalogLang."`.`fileName3` AS `fileName3`,
    			`".DB_articleCatalogLang."`.`title` AS `title`,
				`".DB_articleCatalogLang."`.`description` AS `description`,
    			`".DB_articleCatalogLang."`.`text` AS `text`,
 				`".DB_articleCatalogLang."`.`addField_lang_1` AS `addField_lang_1`,
				`".DB_articleCatalogLang."`.`addField_lang_2` AS `addField_lang_2`,
				`".DB_articleCatalogLang."`.`addField_lang_3` AS `addField_lang_3`,
				`".DB_articleCatalogLang."`.`addField_lang_4` AS `addField_lang_4`,
				`".DB_articleCatalogLang."`.`addField_lang_5` AS `addField_lang_5`,
				`".DB_articleCatalogLang."`.`addField_lang_6` AS `addField_lang_6`,
   			    `".DB_articleCatalogLang."`.`pageTitle` AS `pageTitle`,
    			`".DB_articleCatalogLang."`.`metaTitle` AS `metaTitle`
			FROM
				`".DB_articleCatalog."`,
				`".DB_articleCatalogLang."`
			WHERE
			(
				`".DB_articleCatalogLang."`.`articleCatalog_id` = `".DB_articleCatalog."`.`id`
			)
				AND
			(
				`".DB_articleCatalogLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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

	//Вовзращает список ИД катлогов
	public function getList_id($articleCatalogId, $orderType = EArticleCatalogOrderType::position, $amount = null)
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
    			`".DB_articleCatalog."`.`id` AS `id`
			FROM
				`".DB_articleCatalog."`,
				`".DB_articleCatalogLang."`
			WHERE
			(
				`".DB_articleCatalogLang."`.`articleCatalog_id` = `".DB_articleCatalog."`.`id`
			)
				AND
			(
				`".DB_articleCatalog."`.`articleCatalog_id` = '".Func::res($articleCatalogId)."'
					AND
				`".DB_articleCatalogLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
			".$this->getMySQLOrderBy($orderType)."
			".$mysqlLimit."
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
	public function getListForNavigationLine($articleCatalogId, $articleCatalogArray = array(), $orderType = EArticleCatalogOrderType::position)
	{
		$query =
		"
			SELECT
    			`".DB_articleCatalog."`.`id` AS `id`,
    			`".DB_articleCatalog."`.`articleCatalog_id` AS `articleCatalog_id`,
				`".DB_articleCatalog."`.`urlName` AS `urlName`,
				`".DB_articleCatalog."`.`devName` AS `devName`,
				`".DB_articleCatalog."`.`position` AS `position`,
				`".DB_articleCatalog."`.`orderInCatalog` AS `orderInCatalog`,
    			`".DB_articleCatalogLang."`.`title` AS `title`,
    			`".DB_articleCatalogLang."`.`pageTitle` AS `pageTitle`,
    			`".DB_articleCatalogLang."`.`metaTitle` AS `metaTitle`
			FROM
				`".DB_articleCatalog."`,
				`".DB_articleCatalogLang."`
			WHERE
			(
				`".DB_articleCatalogLang."`.`articleCatalog_id` = `".DB_articleCatalog."`.`id`
			)
				AND
			(
				`".DB_articleCatalog."`.`id` = '".Func::res($articleCatalogId)."'
					AND
				`".DB_articleCatalogLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
			".$this->getMySQLOrderBy($orderType)."
			LIMIT 1
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return array($this->getInfo($articleCatalogId));
		}

		$row = $res[0];

		//Добавляем информацию о текущем каталоге в массив
		$articleCatalogArray[] = array
		(
			"id" => (int)$row["id"],
			"urlName" => $row["urlName"],
			"title" => $row["title"],
			"pageTitle" => $row["pageTitle"],
		);

  		if((int)$row["articleCatalog_id"] === 0)
  		{
  			//Переворачиваем массив и возвращаем его
  			$articleCatalogArray = array_reverse($articleCatalogArray);
			return $articleCatalogArray;
  		}
  		else
  		{
  			//Двигаемся по дереву в поисках родителя
  			return $this->getListForNavigationLine($row["articleCatalog_id"], $articleCatalogArray);
  		}
	}

	//*********************************************************************************

	//Вовзращает инфомарцию о каталоге
	public function getInfo($articleCatalogId)
	{
		$query =
		"
			SELECT
    			`".DB_articleCatalog."`.`id` AS `id`,
    			`".DB_articleCatalog."`.`articleCatalog_id` AS `articleCatalog_id`,
    			`".DB_articleCatalog."`.`articleParameter_id` AS `articleParameterId`,
				`".DB_articleCatalog."`.`urlName` AS `urlName`,
				`".DB_articleCatalog."`.`devName` AS `devName`,

				`".DB_articleCatalog."`.`position` AS `position`,
				`".DB_articleCatalog."`.`orderInCatalog` AS `orderInCatalog`,
				`".DB_articleCatalog."`.`designType` AS `designType`,

				`".DB_articleCatalog."`.`catalogImgWidth_1` AS `catalogImgWidth_1`,
				`".DB_articleCatalog."`.`catalogImgHeight_1` AS `catalogImgHeight_1`,
				`".DB_articleCatalog."`.`catalogImgWidth_2` AS `catalogImgWidth_2`,
				`".DB_articleCatalog."`.`catalogImgHeight_2` AS `catalogImgHeight_2`,
				`".DB_articleCatalog."`.`catalogImgWidth_3` AS `catalogImgWidth_3`,
				`".DB_articleCatalog."`.`catalogImgHeight_3` AS `catalogImgHeight_3`,

				`".DB_articleCatalog."`.`articleImgInCatalogWidth_1` AS `articleImgInCatalogWidth_1`,
				`".DB_articleCatalog."`.`articleImgInCatalogHeight_1` AS `articleImgInCatalogHeight_1`,
				`".DB_articleCatalog."`.`articleImgInCatalogWidth_2` AS `articleImgInCatalogWidth_2`,
				`".DB_articleCatalog."`.`articleImgInCatalogHeight_2` AS `articleImgInCatalogHeight_2`,

				`".DB_articleCatalog."`.`showKey` AS `showKey`,

				`".DB_articleCatalog."`.`addField_1` AS `addField_1`,
				`".DB_articleCatalog."`.`addField_2` AS `addField_2`,
				`".DB_articleCatalog."`.`addField_3` AS `addField_3`,
				`".DB_articleCatalog."`.`addField_4` AS `addField_4`,
				`".DB_articleCatalog."`.`addField_5` AS `addField_5`,
				`".DB_articleCatalog."`.`addField_6` AS `addField_6`,

				`".DB_articleCatalogLang."`.`fileName1` AS `fileName1`,
				`".DB_articleCatalogLang."`.`fileName2` AS `fileName2`,
				`".DB_articleCatalogLang."`.`fileName3` AS `fileName3`,

    			`".DB_articleCatalogLang."`.`title` AS `title`,
    			`".DB_articleCatalogLang."`.`pageTitle` AS `pageTitle`,
				`".DB_articleCatalogLang."`.`description` AS `description`,
    			`".DB_articleCatalogLang."`.`text` AS `text`,
    			
    			`".DB_articleCatalogLang."`.`addField_lang_1` AS `addField_lang_1`,
    			`".DB_articleCatalogLang."`.`addField_lang_2` AS `addField_lang_2`,
    			`".DB_articleCatalogLang."`.`addField_lang_3` AS `addField_lang_3`,
    			`".DB_articleCatalogLang."`.`addField_lang_4` AS `addField_lang_4`,
    			`".DB_articleCatalogLang."`.`addField_lang_5` AS `addField_lang_5`,
    			`".DB_articleCatalogLang."`.`addField_lang_6` AS `addField_lang_6`,
    			
    			`".DB_articleCatalogLang."`.`metaTitle` AS `metaTitle`,
    			`".DB_articleCatalogLang."`.`metaKeywords` AS `metaKeywords`,
    			`".DB_articleCatalogLang."`.`metaDescription` AS `metaDescription`
			FROM
				`".DB_articleCatalog."`,
				`".DB_articleCatalogLang."`
			WHERE
			(
				`".DB_articleCatalogLang."`.`articleCatalog_id` = `".DB_articleCatalog."`.`id`
			)
				AND
			(
				`".DB_articleCatalog."`.`id` = '".Func::res($articleCatalogId)."'
					AND
				`".DB_articleCatalogLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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

	private function getMysqlWhere($parameterArray)
	{
		$mysqlWhere = "";
		$idList = "";

		if (!is_null($parameterArray))
		{
			if (isset($parameterArray["articleCatalogIdArray"]) AND !is_null($parameterArray["articleCatalogIdArray"]))
			{
				if (!is_array($parameterArray["articleCatalogIdArray"]))
				{
					$parameterArray["articleCatalogIdArray"] = array($parameterArray["articleCatalogIdArray"]);
				}

				foreach($parameterArray["articleCatalogIdArray"] AS $id)
		  		{
		  			if (!is_null($id))
		  			{
						$idList .= ", ".Func::res((int)$id);
		  			}
		  		}
				if (mb_strlen($idList) > 0)
				{
					$idList = substr($idList, 2);
					$mysqlWhere .= " AND (`".DB_articleCatalog."`.`articleCatalog_id` IN (".$idList.")) ";
				}
			}

			if (isset($parameterArray["showKey"]) AND (0 === (int)$parameterArray["showKey"] OR 1 === (int)$parameterArray["showKey"]))
			{
				$mysqlWhere .= " AND (`".DB_articleCatalog."`.`showKey` = '".Func::res($parameterArray["showKey"])."')";
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
			case EArticleCatalogOrderType::title:
			{
				$mysqlOrderBy =
				"
					ORDER BY
						`".DB_articleCatalogLang."`.`title`
				";

				break;
			}

			//Сортировка по позиции
			case EArticleCatalogOrderType::position:
			{
				$mysqlOrderBy =
				"
					ORDER BY
						`".DB_articleCatalog."`.`position`
				";

				break;
			}

			default:
			{
				$mysqlOrderBy =
				"
					ORDER BY
						`".DB_articleCatalog."`.`position`,
						`".DB_articleCatalogLang."`.`title`
				";
				break;
			}
		}

		return $mysqlOrderBy;
	}

	/*********************************************************************************/

	//WHERE часть запроса для LIMIT
	private function getMysqlWhereForLimit($start, $amount)
	{
		$mysqlWhere = "";

		//Формируем mysqlLimit для запроса
		if(!is_null($amount) AND (int)$amount > 0)
		{
			$mysqlWhere = " LIMIT ".$start.", ".$amount;
		}

		return $mysqlWhere;
	}

	//*********************************************************************************

	//Увеличивает список кол-во просмотров
	public function addView($articleCatalogId)
	{
		$query =
		("
			UPDATE
				`".DB_articleCatalog."`
			SET
				`view` = `view` + 1
			WHERE
			(
				`id` = '".$articleCatalogId."'
			)
		");

		$this->objMySQL->query($query);
		return true;
	}

	/*********************************************************************************/

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_articleCatalog, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function addLang($data)
	{
		return $this->objMySQL->insert(DB_articleCatalogLang, $data);
	}

	//*********************************************************************************

	public function edit($articleCatalogId, $data)
	{
		return $this->objMySQL->update(DB_articleCatalog, $data, "`id`='".Func::bb($articleCatalogId)."'");
	}

	//*********************************************************************************

	public function editLang($articleCatalogId, $data)
	{
		return $this->objMySQL->update(DB_articleCatalogLang, $data, "`articleCatalog_id`='".Func::bb($articleCatalogId)."' AND `lang_id` = '".Func::bb(GLOB::$langId)."'");
	}

	//*********************************************************************************

	public function delete($articleCatalogId)
	{
		return $this->objMySQL->delete(DB_articleCatalog, "`id`='".Func::bb($articleCatalogId)."'", 1);
	}

	//*********************************************************************************
}

?>
