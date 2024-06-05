<?php

class MArticle extends Model
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
			self::$obj = new MArticle();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($articleId)
	{
		if (0 === $this->objMySQL->count(DB_article, "`id`='".Func::bb($articleId)."'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isShow($articleId)
	{
		if (0 === $this->objMySQL->count(DB_article, "`id`='".Func::bb($articleId)."' AND `showKey`='1' "))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByArticleCatalogId($articleCatalogId)
	{
		$query =
			"
			SELECT
    			COUNT(`".DB_article."`.`id`) AS `count`
			FROM
				`".DB_article."`
			WHERE
			(
				`".DB_article."`.`articleCatalog_id` = '".Func::res($articleCatalogId)."'
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

	public function isAttachedToCatalog($articleId, $articleCatalogId)
	{
		$query =
			"
			SELECT
    			COUNT(`".DB_article."`.`id`) AS `count`
			FROM
				`".DB_article."`
			WHERE
			(
				`".DB_article."`.`id` = '".Func::res($articleId)."'
				AND
				`".DB_article."`.`articleCatalog_id` = '".Func::res($articleCatalogId)."'
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

	public function isExistByDevName($devName, $excludeArticleId = null)
	{
		$excludeMySQLWhere = "";

		if (!is_null($excludeArticleId))
		{
			$excludeMySQLWhere = " AND `article_id` != '".Func::bb($excludeArticleId)."'";
		}

		$query =
			"
			SELECT
    			COUNT(`".DB_article."`.`id`) AS `count`
			FROM
				`".DB_article."`,
				`".DB_articleLang."`
			WHERE
			(
				`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
			AND
			(
				`".DB_article."`.`devName` = '".Func::res($devName)."'
				AND
				`".DB_articleLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
			)
			".$excludeMySQLWhere."
		";

		$res = $this->objMySQL->query($query);

		if (0 === (int)$res[0]["count"])
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByUrlName($urlName, $excludeArticleId = null)
	{
		$excludeMySQLWhere = "";

		if (!is_null($excludeArticleId))
		{
			$excludeMySQLWhere = " AND `article_id` != '".Func::bb($excludeArticleId)."'";
		}

		$query =
			"
			SELECT
    			COUNT(`".DB_article."`.`id`) AS `count`
			FROM
				`".DB_article."`,
				`".DB_articleLang."`
			WHERE
			(
				`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
			AND
			(
				`".DB_article."`.`urlName` = '".Func::res($urlName)."'
				AND
				`".DB_articleLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
			)
			".$excludeMySQLWhere."
		";

		$res = $this->objMySQL->query($query);

		if (0 === (int)$res[0]["count"])
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByTitle($title, $excludeArticleId = null, $articleCatalogId = null)
	{
		$excludeMySQLWhere1 = "";
		$excludeMySQLWhere2 = "";

		if (!is_null($excludeArticleId))
		{
			$excludeMySQLWhere1 = " AND `".DB_article."`.`id` != '".Func::bb($excludeArticleId)."'";
		}

		if (!is_null($articleCatalogId))
		{
			$excludeMySQLWhere2 = " AND `".DB_article."`.`articleCatalog_id` = '".Func::bb($articleCatalogId)."'";
		}

		$query =
			"
			SELECT
    			COUNT(`".DB_article."`.`id`) AS `count`
			FROM
				`".DB_article."`,
				`".DB_articleLang."`
			WHERE
			(
				`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
			AND
			(
				`".DB_articleLang."`.`title` = '".Func::res($title)."'
				AND
				`".DB_articleLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
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

	public function isExistByFileName3($fileName3, $excludeArticleId = null)
	{
		$excludeMySQLWhere = "";

		if (!is_null($excludeArticleId))
		{
			$excludeMySQLWhere = " AND `".DB_article."`.`id` != '".Func::bb($excludeArticleId)."'";
		}

		$query =
			"
			SELECT
    			COUNT(`".DB_article."`.`id`) AS `count`
			FROM
				`".DB_article."`,
				`".DB_articleLang."`
			WHERE
			(
				`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
			AND
			(
				`".DB_articleLang."`.`fileName3` = '".Func::res($fileName3)."'
				AND
				`".DB_articleLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
			)
			".$excludeMySQLWhere."
		";

		$res = $this->objMySQL->query($query);

		if (0 === (int)$res[0]["count"])
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	/**
	 * Достает id статьи по devName
	 *
	 * @param $devName - devName
	 *
	 * @return int
	 * */
	public function getIdByDevName($devName)
	{
		$query =
			"
			SELECT
    			`".DB_article."`.`id` AS `id`
			FROM
				`".DB_article."`,
				`".DB_articleLang."`
			WHERE
			(
				`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
			AND
			(
				`".DB_article."`.`devName` = '".Func::res($devName)."'
				AND
				`".DB_articleLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	//*********************************************************************************

	/**
	 * Достает id статьи по urlName
	 *
	 * @param $urlName - urlName
	 *
	 * @return int
	 * */
	public function getIdByUrlName($urlName)
	{
		$query =
			"
			SELECT
    			`".DB_article."`.`id` AS `id`
			FROM
				`".DB_article."`,
				`".DB_articleLang."`
			WHERE
			(
				`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
			AND
			(
				`".DB_article."`.`urlName` = '".Func::res($urlName)."'
				AND
				`".DB_articleLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	//*********************************************************************************

	/**
	 * Достает urlName по id статьи
	 *
	 * @param $id - id статьи
	 *
	 * @return int
	 * */
	public function getUrlNameById($id)
	{
		$query =
			"
			SELECT
    			`".DB_article."`.`urlName` AS `urlName`
			FROM
				`".DB_article."`
			WHERE
			(
				`".DB_article."`.`id` = '".Func::res($id)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return (string)$res[0]["urlName"];
	}

	//*********************************************************************************

	/**
	 * Достает id статьи по наименованию статьи
	 *
	 * @param $title - наименование статьи
	 *
	 * @return int
	 * */
	public function getIdByTitle($title)
	{
		$query =
			"
			SELECT
    			`".DB_article."`.`id` AS `id`
			FROM
				`".DB_article."`,
				`".DB_articleLang."`
			WHERE
			(
				`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
			AND
			(
				`".DB_articleLang."`.`title` = '".Func::res($title)."'
				AND
				`".DB_articleLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	//*********************************************************************************

	/**
	 * Достает id каталога
	 *
	 * @param $id - id
	 *
	 * @return int
	 * */
	public function getArticleCatalogId($articleId)
	{
		$query =
			"
			SELECT
    			`".DB_article."`.`articleCatalog_id` AS `articleCatalogId`
			FROM
				`".DB_article."`
			WHERE
			(
				`".DB_article."`.`id` = '".Func::res($articleId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["articleCatalogId"];
	}

	//*********************************************************************************

	/**
	 * Достает id devName
	 *
	 * @param $id - id
	 *
	 * @return int
	 * */
	public function getDevName($articleId)
	{
		$query =
		"
			SELECT
    			`".DB_article."`.`devName` AS `devName`
			FROM
				`".DB_article."`
			WHERE
			(
				`".DB_article."`.`id` = '".Func::res($articleId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res[0]["devName"];
	}

	//*********************************************************************************

	public function getMaxPosition($articleCatalogId)
	{
		$query =
			"
			SELECT
    			MAX(`".DB_article."`.`position`) AS `position`
			FROM
				`".DB_article."`,
				`".DB_articleLang."`
			WHERE
			(
				`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
			AND
			(
				`".DB_article."`.`articleCatalog_id` = '".Func::res($articleCatalogId)."'
				AND
				`".DB_articleLang."`.`lang_id` = '".Func::res(GLOB::$langId)."'
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

	//Вовзращает наименование статьи
	public function getTitle($articleId)
	{
		$query =
			"
			SELECT
    			`".DB_articleLang."`.`title` AS `title`
			FROM
				`".DB_article."`,
				`".DB_articleLang."`
			WHERE
			(
				`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
				AND
			(
				`".DB_article."`.`id` = '".Func::res($articleId)."'
					AND
				`".DB_articleLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
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

	//Возвращает количество товаров
	public function getAmount($parameterArray = null)
	{
		$mysqlFrom = $this->getMysqlFrom($parameterArray);
		$mysqlWhere1 = $this->getMysqlWhere1($parameterArray);
		$mysqlWhere2 = $this->getMysqlWhere2($parameterArray);

		$query =
			"
			SELECT
				COUNT(`".DB_article."`.`id`) AS `count`
			FROM
				`".DB_articleLang."`,
				`".DB_article."`
				".$mysqlFrom."
			WHERE
			(
    			`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
    			".$mysqlWhere1."
			)
				AND
			(
				`".DB_articleLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
			".$mysqlWhere2."
		";

		$res = $this->objMySQL->query($query);

		return (int)$res[0]["count"];
	}

	//*********************************************************************************

	//Возвращает список товаров
	public function getList($parameterArray = null)
	{
		$start = (isset($parameterArray["start"])) ? (int)$parameterArray["start"] : 0;
		$amount = (isset($parameterArray["amount"])) ? (int)$parameterArray["amount"] : null;
		$orderType = (isset($parameterArray["orderType"])) ? $parameterArray["orderType"] : EOrderInArticleCatalogType::position;

		$mysqlFrom = $this->getMysqlFrom($parameterArray);
		$mysqlWhere1 = $this->getMysqlWhere1($parameterArray);
		$mysqlWhere2 = $this->getMysqlWhere2($parameterArray);
		$mysqlOrderBy = $this->getMysqlOrderBy($orderType);
		$mysqlLimit = $this->getMysqlWhereForLimit($start, $amount);

		$query =
		"
			SELECT
				`".DB_article."`.`id` AS `id`,
				`".DB_article."`.`articleCatalog_id` AS `articleCatalogId`,
				`".DB_article."`.`devName` AS `devName`,
				`".DB_article."`.`urlName` AS `urlName`,
				`".DB_article."`.`position` AS `position`,
				`".DB_article."`.`linkToCompany` AS `linkToCompany`,
				`".DB_article."`.`time` AS `time`,
				`".DB_article."`.`date` AS `date`,
				`".DB_article."`.`view` AS `view`,
				`".DB_article."`.`addField_1` AS `addField_1`,
				`".DB_article."`.`addField_2` AS `addField_2`,
				`".DB_article."`.`addField_3` AS `addField_3`,
				`".DB_article."`.`addField_4` AS `addField_4`,
				`".DB_article."`.`addField_5` AS `addField_5`,
				`".DB_article."`.`addField_6` AS `addField_6`,
				`".DB_article."`.`showKey` AS `showKey`,
				`".DB_articleLang."`.`fileName1` AS `fileName1`,
				`".DB_articleLang."`.`fileName2` AS `fileName2`,
				`".DB_articleLang."`.`fileName3` AS `fileName3`,
				`".DB_articleLang."`.`title` AS `title`,
				`".DB_articleLang."`.`description` AS `description`,
				`".DB_articleLang."`.`text` AS `text`,
				`".DB_articleLang."`.`tag` AS `tag`,
				`".DB_articleLang."`.`addField_lang_1` AS `addField_lang_1`,
				`".DB_articleLang."`.`addField_lang_2` AS `addField_lang_2`,
				`".DB_articleLang."`.`addField_lang_3` AS `addField_lang_3`,
				`".DB_articleLang."`.`addField_lang_4` AS `addField_lang_4`,
				`".DB_articleLang."`.`addField_lang_5` AS `addField_lang_5`,
				`".DB_articleLang."`.`addField_lang_6` AS `addField_lang_6`,
				`".DB_articleLang."`.`pageTitle` AS `pageTitle`
			FROM
				`".DB_articleLang."`,
				`".DB_article."`
				".$mysqlFrom."
			WHERE
			(
    			`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
				".$mysqlWhere1."
			)
			AND
			(
				`".DB_articleLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
			".$mysqlWhere2."
			GROUP BY `".DB_article."`.`id`
			".$mysqlOrderBy."
			".$mysqlLimit."
		";

		//Выполянем запрос
		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	//Возвращает список товаров
	public function getList_byIdArray($articleIdArray, $orderType = EOrderInArticleCatalogType::titleDESC)
	{
		$idList = "";
		$mysqlWhere = "";
		$mysqlOrderBy = $this->getMysqlOrderBy($orderType);

		if (!is_array($articleIdArray))
		{
			$articleIdArray = [$articleIdArray];
		}

		foreach($articleIdArray AS $id)
		{
			if (!is_null($id) and (int)$id > 0)
			{
				$idList .= ", ".Func::res((int)$id);
			}
		}

		if (mb_strlen($idList) > 0)
		{
			$idList = substr($idList, 2);
			$mysqlWhere .= " AND (`".DB_article."`.`id` IN (".$idList.")) ";
		}

		$query =
			"
			SELECT
				`".DB_article."`.`id` AS `id`,
				`".DB_article."`.`articleCatalog_id` AS `articleCatalogId`,
				`".DB_article."`.`devName` AS `devName`,
				`".DB_article."`.`urlName` AS `urlName`,
				`".DB_article."`.`position` AS `position`,
				`".DB_article."`.`linkToCompany` AS `linkToCompany`,
				`".DB_article."`.`time` AS `time`,
				`".DB_article."`.`date` AS `date`,
				`".DB_article."`.`view` AS `view`,
				`".DB_article."`.`addField_1` AS `addField_1`,
				`".DB_article."`.`addField_2` AS `addField_2`,
				`".DB_article."`.`addField_3` AS `addField_3`,
				`".DB_article."`.`addField_4` AS `addField_4`,
				`".DB_article."`.`addField_5` AS `addField_5`,
				`".DB_article."`.`addField_6` AS `addField_6`,
				`".DB_article."`.`showKey` AS `showKey`,
				`".DB_articleLang."`.`fileName1` AS `fileName1`,
				`".DB_articleLang."`.`fileName2` AS `fileName2`,
				`".DB_articleLang."`.`fileName3` AS `fileName3`,
				`".DB_articleLang."`.`title` AS `title`,
				`".DB_articleLang."`.`description` AS `description`,
				`".DB_articleLang."`.`text` AS `text`,
				`".DB_articleLang."`.`tag` AS `tag`,
				`".DB_articleLang."`.`addField_lang_1` AS `addField_lang_1`,
				`".DB_articleLang."`.`addField_lang_2` AS `addField_lang_2`,
				`".DB_articleLang."`.`addField_lang_3` AS `addField_lang_3`,
				`".DB_articleLang."`.`addField_lang_4` AS `addField_lang_4`,
				`".DB_articleLang."`.`addField_lang_5` AS `addField_lang_5`,
				`".DB_articleLang."`.`addField_lang_6` AS `addField_lang_6`,
				`".DB_articleLang."`.`pageTitle` AS `pageTitle`
			FROM
				`".DB_articleLang."`,
				`".DB_article."`
			WHERE
			(
    			`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
			AND
			(
				`".DB_articleLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
			".$mysqlWhere."
			GROUP BY `".DB_article."`.`id`
			".$mysqlOrderBy."
		";

		//Выполянем запрос
		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	public function getList_tag($articleCatalogIdArray, $parameterArray = null)
	{
		$mysqlWhere = $this->getMysqlWhere2($articleCatalogIdArray, $parameterArray);

		$query =
			("
			SELECT
				DISTINCT(`".DB_articleLang."`.`tag`) AS `tag`
			FROM
				`".DB_articleLang."`,
				`".DB_article."`
			WHERE
			(
    			`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
			AND
			(
				`".DB_articleLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
			".$mysqlWhere."
			ORDER BY
				`".DB_articleLang."`.`tag` ASC
		");

		//Выполянем запрос
		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	//Вовзращает список ID статей
	public function getList_id($articleCatalogIdArray, $orderType = EArticleCatalogOrderType::position, $amount = null, $parameterArray = null)
	{
		$query = "";
		$mysqlLimit = "";
		$mysqlWhere = $this->getMysqlWhere2($articleCatalogIdArray, $parameterArray);

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
    			`".DB_article."`.`id` AS `id`
			FROM
				`".DB_article."`,
				`".DB_articleLang."`
			WHERE
			(
				`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
			AND
			(
				`".DB_articleLang."`.`lang_id` = '".Func::bb(GLOB::$langId)."'
			)
			".$mysqlWhere."
			".$this->getMySQLOrderBy($orderType)."
			".$mysqlLimit."
		";

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

	/*********************************************************************************/

	//Возвращает информацию о товаре
	public function getInfo($articleId)
	{
		$query =
		"
			SELECT
				`".DB_article."`.`id` AS `id`,
				`".DB_article."`.`articleCatalog_id` AS `articleCatalogId`,
				`".DB_article."`.`devName` AS `devName`,
				`".DB_article."`.`urlName` AS `urlName`,
				`".DB_article."`.`position` AS `position`,
				`".DB_article."`.`linkToCompany` AS `linkToCompany`,
				`".DB_article."`.`time` AS `time`,
				`".DB_article."`.`date` AS `date`,
				`".DB_article."`.`view` AS `view`,
				`".DB_article."`.`addField_1` AS `addField_1`,
				`".DB_article."`.`addField_2` AS `addField_2`,
				`".DB_article."`.`addField_3` AS `addField_3`,
				`".DB_article."`.`addField_4` AS `addField_4`,
				`".DB_article."`.`addField_5` AS `addField_5`,
				`".DB_article."`.`addField_6` AS `addField_6`,
				`".DB_article."`.`showKey` AS `showKey`,
				`".DB_articleLang."`.`fileName1` AS `fileName1`,
				`".DB_articleLang."`.`fileName2` AS `fileName2`,
				`".DB_articleLang."`.`fileName3` AS `fileName3`,
				`".DB_articleLang."`.`title` AS `title`,
				`".DB_articleLang."`.`description` AS `description`,
				`".DB_articleLang."`.`text` AS `text`,
				`".DB_articleLang."`.`tag` AS `tag`,
				`".DB_articleLang."`.`addField_lang_1` AS `addField_lang_1`,
				`".DB_articleLang."`.`addField_lang_2` AS `addField_lang_2`,
				`".DB_articleLang."`.`addField_lang_3` AS `addField_lang_3`,
				`".DB_articleLang."`.`addField_lang_4` AS `addField_lang_4`,
				`".DB_articleLang."`.`addField_lang_5` AS `addField_lang_5`,
				`".DB_articleLang."`.`addField_lang_6` AS `addField_lang_6`,
				`".DB_articleLang."`.`pageTitle` AS `pageTitle`,
				`".DB_articleLang."`.`metaTitle` AS `metaTitle`,
				`".DB_articleLang."`.`metaKeywords` AS `metaKeywords`,
				`".DB_articleLang."`.`metaDescription` AS `metaDescription`
			FROM
				`".DB_article."`,
				`".DB_articleLang."`
			WHERE
			(
    			`".DB_articleLang."`.`article_id` = `".DB_article."`.`id`
			)
				AND
			(
				`".DB_article."`.`id` = '".Func::res($articleId)."'
					AND
				`".DB_articleLang."`.`lang_id` = '".GLOB::$langId."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res[0];
	}

	/*********************************************************************************/

	private function getMysqlFrom($parameterArray)
	{
		$mysqlFrom = "";

		if (isset($parameterArray["articleParameterValueIdArray"]) AND !is_null($parameterArray["articleParameterValueIdArray"]))
		{
			$mysqlFrom .= ", `".DB_articleParameterValueArticle."`";
		}

		return $mysqlFrom;
	}

	/*********************************************************************************/

	private function getMysqlWhere1($parameterArray)
	{
		$mysqlWhere = "";

		if (isset($parameterArray["articleParameterValueIdArray"]) AND !is_null($parameterArray["articleParameterValueIdArray"]))
		{
			$mysqlWhere .= " AND `".DB_articleParameterValueArticle."`.`article_id` = `".DB_article."`.`id`";
		}

		return $mysqlWhere;
	}

	/*********************************************************************************/

	private function getMysqlWhere2($parameterArray)
	{
		$mysqlWhere = "";

		if (!is_null($parameterArray))
		{
			if (isset($parameterArray["articleCatalogIdArray"]) AND !is_null($parameterArray["articleCatalogIdArray"]))
			{
				$idList = "";
				if (!is_array($parameterArray["articleCatalogIdArray"]))
				{
					$parameterArray["articleCatalogIdArray"] = array($parameterArray["articleCatalogIdArray"]);
				}

				foreach($parameterArray["articleCatalogIdArray"] AS $id)
				{
					if (!is_null($id) and (int)$id > 0)
					{
						$idList .= ", ".Func::res((int)$id);
					}
				}

				if (mb_strlen($idList) > 0)
				{
					$idList = substr($idList, 2);
					$mysqlWhere .= " AND (`".DB_article."`.`articleCatalog_id` IN (".$idList.")) ";
				}
			}

			if (isset($parameterArray["articleParameterValueIdArray"]) AND !is_null($parameterArray["articleParameterValueIdArray"]))
			{
				$idList = "";
				if (!is_array($parameterArray["articleParameterValueIdArray"]))
				{
					$parameterArray["articleParameterValueIdArray"] = array($parameterArray["articleParameterValueIdArray"]);
				}

				foreach($parameterArray["articleParameterValueIdArray"] AS $id)
				{
					if (!is_null($id) and (int)$id > 0)
					{
						$idList .= ", ".Func::res((int)$id);
					}
				}

				if (mb_strlen($idList) > 0)
				{
					$idList = substr($idList, 2);
					$mysqlWhere .= " AND (`".DB_articleParameterValueArticle."`.`articleParameterValue_id` IN (".$idList.")) ";
				}
			}

			if (isset($parameterArray["tagName"]) AND mb_strlen($parameterArray["tagName"]) !== 0)
			{
				$mysqlWhere .= " AND (`".DB_articleLang."`.`tag` LIKE '%".Func::res($parameterArray["tagName"])."%')";
			}

			if (isset($parameterArray["searchString"]) AND mb_strlen($parameterArray["searchString"]) !== 0)
			{
				$mysqlWhere .= " AND (`".DB_articleLang."`.`title` LIKE '%".Func::res($parameterArray["searchString"])."%')";
			}

			if (isset($parameterArray["showKey"]) AND (0 === (int)$parameterArray["showKey"] OR 1 === (int)$parameterArray["showKey"]))
			{
				$mysqlWhere .= " AND (`".DB_article."`.`showKey` = '".Func::res($parameterArray["showKey"])."')";
			}

			if (isset($parameterArray["excludeArticleId"]) AND !is_null($parameterArray["excludeArticleId"]))
			{
				$mysqlWhere .= " AND (`".DB_article."`.`id` != '".Func::bb($parameterArray["excludeArticleId"])."')";
			}
		}

		return $mysqlWhere;
	}

	/*********************************************************************************/

	//Возвращает ORDER BY часть запроса
	private function getMysqlOrderBy($orderType)
	{
		$mysqlOrderBy = "";

		switch($orderType)
		{
			case EOrderInArticleCatalogType::dateDESC:
			{
				$mysqlOrderBy = " ORDER BY `".DB_article."`.`time` DESC";
				break;
			}

			case EOrderInArticleCatalogType::date:
			{
				$mysqlOrderBy = " ORDER BY `".DB_article."`.`time` ASC";
				break;
			}

			case EOrderInArticleCatalogType::position:
			{
				$mysqlOrderBy = " ORDER BY `".DB_article."`.`position` ASC";
				break;
			}

			case EOrderInArticleCatalogType::positionDESC:
			{
				$mysqlOrderBy = " ORDER BY `".DB_article."`.`position` DESC";
				break;
			}
			case EOrderInArticleCatalogType::view:
			{
				$mysqlOrderBy = " ORDER BY `".DB_article."`.`view` ASC";
				break;
			}

			case EOrderInArticleCatalogType::viewDESC:
			{
				$mysqlOrderBy = " ORDER BY `".DB_article."`.`view` DESC";
				break;
			}
			case EOrderInArticleCatalogType::title:
			{
				$mysqlOrderBy = " ORDER BY `".DB_articleLang."`.`title` ASC";
				break;
			}

			case EOrderInArticleCatalogType::titleDESC:
			{
				$mysqlOrderBy = " ORDER BY `".DB_articleLang."`.`title` DESC";
				break;
			}

			case EOrderInArticleCatalogType::rand:
			{
				$mysqlOrderBy = " ORDER BY RAND()";
				break;
			}

			default:
			{
				$mysqlOrderBy = " ORDER BY `".DB_article."`.`time` DESC";
			}
		}

		return $mysqlOrderBy;
	}

	/*********************************************************************************/

	//WHERE часть запроса для LIMIT
	private function getMysqlWhereForLimit($start = 0, $amount)
	{
		$mysqlWhere = "";

		//Формируем mysqlLimit для запроса
		if(!is_null($amount) AND (int)$amount > 0)
		{
			$mysqlWhere = " LIMIT ".Func::bb($start).", ".Func::bb($amount);
		}

		return $mysqlWhere;
	}

	/*********************************************************************************/

	//Увеличивает список кол-во просмотров
	public function addView($articleId)
	{
		$query =
		"
			UPDATE
				`".DB_article."`
			SET
				`view` = `view` + 1
			WHERE
			(
				`id` = '".Func::bb($articleId)."'
			)
		";

		$this->objMySQL->query($query);
		return true;
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_article, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function addLang($data)
	{
		return $this->objMySQL->insert(DB_articleLang, $data);
	}

	//*********************************************************************************

	public function edit($articleId, $data)
	{
		return $this->objMySQL->update(DB_article, $data, "`id`='".Func::bb($articleId)."'");
	}

	//*********************************************************************************

	public function editLang($articleId, $data)
	{
		return $this->objMySQL->update(DB_articleLang, $data, "`article_id`='".Func::bb($articleId)."' AND `lang_id` = '".Func::bb(GLOB::$langId)."'");
	}

	//*********************************************************************************

	public function delete($articleId)
	{
		return $this->objMySQL->delete(DB_article, "`id`='".Func::bb($articleId)."'", 1);
	}

	//*********************************************************************************
}

?>
