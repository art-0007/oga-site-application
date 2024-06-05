<?php

class MStaticHtml extends Model
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
			self::$obj = new MStaticHtml();
		}

		return self::$obj;
	}

	//*********************************************************************************

 	public function isExist($staticHtmlId)
 	{
		if (0 === $this->objMySQL->count(DB_staticHtml, "`id`='".Func::bb($staticHtmlId)."'"))
		{
			return false;
		}

		return true;
 	}

	//*********************************************************************************

 	public function isExistByName($name, $excludeStaticHtmlId = null)
 	{
		if (0 === $this->objMySQL->count(DB_staticHtml,
		"`name`='".Func::bb($name)."'
		".(
			(is_null($excludeStaticHtmlId))
			?
				""
			:
				" AND `id` != '".Func::bb($excludeStaticHtmlId)."'"
		)))
		{
			return false;
		}

		return true;
 	}

	//*********************************************************************************

	public function getList($autoReplaceKey = false)
	{
		$mySqlWhere = "";

		if ($autoReplaceKey)
		{
			$mySqlWhere = " AND `".DB_staticHtml."`.`autoReplaceKey` = '1'";
		}

		$query =
		"
			SELECT
				`".DB_staticHtml."`.`id` AS `staticHtmlId`,
				`".DB_staticHtml."`.`name` AS `name`,
				`".DB_staticHtml."`.`autoReplaceKey` AS `autoReplaceKey`,
				`".DB_staticHtmlLang."`.`html` AS `html`
			FROM
				`".DB_staticHtml."`,
				`".DB_staticHtmlLang."`
			WHERE
			(
				`".DB_staticHtmlLang."`.`staticHtml_id` = `".DB_staticHtml."`.`id`
			)
			AND
			(
				`".DB_staticHtmlLang."`.`lang_id` = '".GLOB::$langId."'
			)
			".$mySqlWhere."
			ORDER BY
				`".DB_staticHtml."`.`name`
		";

		$res = $this->objMySQL->query($query);
		if (0 === count($res))
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	public function getInfo($staticHtmlId, $langId)
	{
		$query =
		("
			SELECT
				`".DB_staticHtml."`.`id` AS `staticHtmlId`,
				`".DB_staticHtml."`.`name` AS `name`,
				`".DB_staticHtml."`.`autoReplaceKey` AS `autoReplaceKey`,
				`".DB_staticHtmlLang."`.`html` AS `html`
			FROM
				`".DB_staticHtml."`,
				`".DB_staticHtmlLang."`
			WHERE
			(
				`".DB_staticHtmlLang."`.`staticHtml_id` = `".DB_staticHtml."`.`id`
			)
			AND
			(
				`".DB_staticHtmlLang."`.`lang_id` = '".Func::bb($langId)."'
				AND
				`".DB_staticHtml."`.`id` = '".Func::bb($staticHtmlId)."'
			)
		");

		$res = $this->objMySQL->query($query);
		if (0 === count($res))
		{
			return false;
		}

		return $res[0];
	}

	//*********************************************************************************

	public function getHtmlByName($name)
	{
		$query =
		("
			SELECT
				`".DB_staticHtmlLang."`.`html` AS `html`
			FROM
				`".DB_staticHtml."`,
				`".DB_staticHtmlLang."`
			WHERE
			(
				`".DB_staticHtmlLang."`.`staticHtml_id` = `".DB_staticHtml."`.`id`
			)
			AND
			(
				`".DB_staticHtmlLang."`.`lang_id` = '".GLOB::$langId."'
				AND
				`".DB_staticHtml."`.`name` = '".Func::bb($name)."'
			)
		");

		$res = $this->objMySQL->query($query);
		if (0 === count($res))
		{
			return false;
		}

		return $res[0]["html"];
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_staticHtml, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function addLang($data)
	{
		return $this->objMySQL->insert(DB_staticHtmlLang, $data);
	}

	//*********************************************************************************

	public function edit($staticHtmlId, $data)
	{
		return $this->objMySQL->update(DB_staticHtml, $data, "`id`='".Func::bb($staticHtmlId)."'");
	}

	//*********************************************************************************

	public function editLang($staticHtmlId, $langId, $data)
	{
		return $this->objMySQL->update(DB_staticHtmlLang, $data, "`staticHtml_id`='".Func::bb($staticHtmlId)."' AND `lang_id`='".Func::bb($langId)."'");
	}

	//*********************************************************************************

	public function delete($staticHtmlId)
	{
		return $this->objMySQL->delete(DB_staticHtml, "`id`='".Func::bb($staticHtmlId)."'", 1);
	}

	//*********************************************************************************

}

?>