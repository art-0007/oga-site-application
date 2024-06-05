<?php

class MPage extends Model
{
	private static $obj = null;

	/*********************************************************************************/

	protected function __construct()
	{
		parent::__construct();
	}

	/*********************************************************************************/

	protected function __clone()
	{
	}

	/*********************************************************************************/

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new MPage();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($pageId)
	{
		if (0 === $this->objMySQL->count(DB_page, "`id`='".Func::bb($pageId)."'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isBase($pageId)
	{
		if (0 === $this->objMySQL->count(DB_page, "`id`='".Func::bb($pageId)."' AND `baseKey`='1'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByDevName($devName, $excludePageId = null)
	{
		if (0 === $this->objMySQL->count(DB_page,
		"`devName`='".Func::bb($devName)."'
		".(
			(is_null($excludePageId))
			?
				""
			:
				" AND `id` != '".Func::bb($excludePageId)."'"
		)))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByUrlName($urlName, $excludePageId = null)
	{
		if (0 === $this->objMySQL->count(DB_page,
		"`urlName`='".Func::bb($urlName)."'
		".(
			(is_null($excludePageId))
			?
				""
			:
				" AND `id` != '".Func::bb($excludePageId)."'"
		)))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByTitle($title, $excludePageId = null)
	{
		if (0 === $this->objMySQL->count(DB_pageLang,
		"`title`='".Func::bb($title)."'
		".(
			(is_null($excludePageId))
			?
				""
			:
				" AND `page_id` != '".Func::bb($excludePageId)."'"
		)))
		{
			return false;
		}

		return true;
	}

	/*********************************************************************************/

	/**
	 * Достает id страницы по devName
	 *
	 * @param $devName - devName страницы
	 *
	 * @return int
	 * */
	public function getIdByDevName($devName)
	{
		$query =
		"
			SELECT
    			`".DB_page."`.`id` AS `id`
			FROM
				`".DB_page."`
			WHERE
			(
				`".DB_page."`.`devName` = '".Func::bb($devName)."'
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
	public function getDevName($id)
	{
		$query =
		"
			SELECT
    			`".DB_page."`.`devName` AS `devName`
			FROM
				`".DB_page."`
			WHERE
			(
				`".DB_page."`.`id` = '".Func::bb($id)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return $res[0]["devName"];
	}

	/*********************************************************************************/

	/**
	 * Достает id страницы по urlName
	 *
	 * @param $urlName - urlName страницы
	 *
	 * @return int
	 * */
	public function getIdByUrlName($urlName)
	{
		$query =
		"
			SELECT
    			`".DB_page."`.`id` AS `id`
			FROM
				`".DB_page."`
			WHERE
			(
				`".DB_page."`.`urlName` = '".Func::bb($urlName)."'
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

	/**
	 * Достает максимальное значение позиции
	 *
	 * @return int
	 * */
	public function getMaxPosition()
	{
		$query =
		"
			SELECT
    			MAX(`".DB_page."`.`position`) AS `position`
			FROM
				`".DB_page."`
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["position"];
	}

	/*********************************************************************************/

	/**
	 * Достает список страниц
	 *
	 * @return array
	 * */
	public function getList()
	{
		$query =
		"
			SELECT
    			`".DB_page."`.`id` AS `id`,
    			`".DB_page."`.`devName` AS `devName`,
    			`".DB_page."`.`urlName` AS `urlName`,
    			`".DB_page."`.`fileName1` AS `fileName1`,
    			`".DB_page."`.`imgWidth_1` AS `imgWidth_1`,
    			`".DB_page."`.`imgHeight_1` AS `imgHeight_1`,
    			`".DB_page."`.`position` AS `position`,
    			`".DB_pageLang."`.`title` AS `title`,
    			`".DB_pageLang."`.`pageTitle` AS `pageTitle`
			FROM
				`".DB_page."`,
				`".DB_pageLang."`
			WHERE
			(
				`".DB_pageLang."`.`page_id` = `".DB_page."`.`id`
			)
			AND
			(
				`".DB_pageLang."`.`lang_id` = '".GLOB::$langId."'
			)
			ORDER BY
				`".DB_page."`.`position`,
				`".DB_pageLang."`.`title`
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res;
	}

	/*********************************************************************************/

	/**
	 * Достает информацию о странице
	 *
	 * @param $pageId - id страницы, информацию о которой нужно достать
	 *
	 * @return array
	 * */
	public function getInfo($pageId)
	{
		$query =
		"
			SELECT
    			`".DB_page."`.`id` AS `id`,
    			`".DB_page."`.`devName` AS `devName`,
    			`".DB_page."`.`urlName` AS `urlName`,
    			`".DB_page."`.`fileName1` AS `fileName1`,
    			`".DB_page."`.`imgWidth_1` AS `imgWidth_1`,
    			`".DB_page."`.`imgHeight_1` AS `imgHeight_1`,
    			`".DB_page."`.`position` AS `position`,
    			`".DB_pageLang."`.`title` AS `title`,
    			`".DB_pageLang."`.`pageTitle` AS `pageTitle`,
    			`".DB_pageLang."`.`description` AS `description`,
    			`".DB_pageLang."`.`text` AS `text`,
    			`".DB_pageLang."`.`map` AS `map`,
    			`".DB_pageLang."`.`addField_lang_1` AS `addField_lang_1`,
    			`".DB_pageLang."`.`metaTitle` AS `metaTitle`,
    			`".DB_pageLang."`.`metaKeywords` AS `metaKeywords`,
    			`".DB_pageLang."`.`metaDescription` AS `metaDescription`
			FROM
				`".DB_page."`,
				`".DB_pageLang."`
			WHERE
			(
				`".DB_pageLang."`.`page_id` = `".DB_page."`.`id`
			)
				AND
			(
				`".DB_page."`.`id` = '".Func::bb($pageId)."'
					AND
				`".DB_pageLang."`.`lang_id` = '".GLOB::$langId."'
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
		$this->objMySQL->insert(DB_page, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function edit($pageId, $data)
	{
		return $this->objMySQL->update(DB_page, $data, "`id`='".Func::bb($pageId)."'");
	}

	//*********************************************************************************

	public function editLang($pageId, $data)
	{
		return $this->objMySQL->update(DB_pageLang, $data, "`page_id`='".Func::bb($pageId)."' AND `lang_id`='".GLOB::$langId."'");
	}

	//*********************************************************************************

	public function delete($pageId)
	{
		return $this->objMySQL->delete(DB_page, "`id`='".Func::bb($pageId)."'", 1);
	}

	/*********************************************************************************/
}

?>
