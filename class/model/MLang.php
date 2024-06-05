<?php

class MLang extends Model
{
	//*********************************************************************************

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
			self::$obj = new MLang();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($langId)
	{
		if (0 === $this->objMySQL->count(DB_lang, "`id`='".Func::bb($langId)."'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isDefault($langId)
	{
		if (0 === $this->objMySQL->count(DB_lang, "`id`='".Func::bb($langId)."' AND `defaultKey` = '1'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByName($title, $excludeLangId = null)
	{
		$excludeMySQLWhere1 = "";

		if (!is_null($excludeLangId))
		{
			$excludeMySQLWhere1 = " AND `".DB_lang."`.`id` != '".Func::bb($excludeLangId)."'";
		}

		$query =
			"
			SELECT
    			COUNT(`".DB_lang."`.`id`) AS `count`
			FROM
				`".DB_lang."`
			WHERE
			(
				`".DB_lang."`.`name` = '".Func::res($title)."'
			)
			".$excludeMySQLWhere1."
		";

		$res = $this->objMySQL->query($query);

		if (0 === (int)$res[0]["count"])
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByCode($title, $excludeLangId = null)
	{
		$excludeMySQLWhere1 = "";

		if (!is_null($excludeLangId))
		{
			$excludeMySQLWhere1 = " AND `".DB_lang."`.`id` != '".Func::bb($excludeLangId)."'";
		}

		$query =
			"
			SELECT
    			COUNT(`".DB_lang."`.`id`) AS `count`
			FROM
				`".DB_lang."`
			WHERE
			(
				`".DB_lang."`.`code` = '".Func::res($title)."'
			)
			".$excludeMySQLWhere1."
		";

		$res = $this->objMySQL->query($query);

		if (0 === (int)$res[0]["count"])
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	//Возвращает ID языка по умолчанию
	public function getDefaultId()
	{
		$query =
			("
			SELECT
				`".DB_lang."`.`id` AS `id`
			FROM
				`".DB_lang."`
			WHERE
			(
				`".DB_lang."`.`defaultKey` = '1'
			)
		");

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	//*********************************************************************************

	//Возвращает ID языка по умолчанию
	public function getIdByCode($code)
	{
		$query =
			("
			SELECT
				`".DB_lang."`.`id` AS `id`
			FROM
				`".DB_lang."`
			WHERE
			(
				`".DB_lang."`.`code` = '".Func::res($code)."'
			)
		");

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	//*********************************************************************************

	//Возвращает ID языка по умолчанию
	public function getCode($id)
	{
		$query =
			("
			SELECT
				`".DB_lang."`.`code` AS `code`
			FROM
				`".DB_lang."`
			WHERE
			(
				`".DB_lang."`.`id` = '".Func::res($id)."'
			)
		");

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return $res[0]["code"];
	}

	//*********************************************************************************

	public function getMaxPosition()
	{
		$query =
		"
			SELECT
				MAX(`".DB_lang."`.`position`) AS `position`
			FROM
				`".DB_lang."`
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return 0;
		}

		return $res[0]["position"];
	}

	//*********************************************************************************

	public function getList()
	{
		$query =
			"
			SELECT
				`".DB_lang."`.`id` AS `id`,
				`".DB_lang."`.`name` AS `name`,
				`".DB_lang."`.`code` AS `code`,
				`".DB_lang."`.`img` AS `img`,
				`".DB_lang."`.`imgBig` AS `imgBig`,
				`".DB_lang."`.`position` AS `position`,
				`".DB_lang."`.`defaultKey` AS `defaultKey`
			FROM
				`".DB_lang."`
			ORDER BY
				`".DB_lang."`.`defaultKey` DESC
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	public function getInfo($langId)
	{
		$query =
			"
			SELECT
				`".DB_lang."`.`id` AS `id`,
				`".DB_lang."`.`name` AS `name`,
				`".DB_lang."`.`code` AS `code`,
				`".DB_lang."`.`img` AS `img`,
				`".DB_lang."`.`imgBig` AS `imgBig`,
				`".DB_lang."`.`position` AS `position`,
				`".DB_lang."`.`defaultKey` AS `defaultKey`
			FROM
				`".DB_lang."`
			WHERE
			(
				`".DB_lang."`.`id` = '".Func::res($langId)."'
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

	public function setAllDefaultKeyInOne($defaultKey)
	{
		return $this->objMySQL->update(DB_lang, ["defaultKey"=>"1"]);
	}

	//*********************************************************************************

	public function setAllDefaultKeyInZero()
	{
		return $this->objMySQL->update(DB_lang, ["defaultKey"=>"0"]);
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_lang, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function edit($langId, $data)
	{
		return $this->objMySQL->update(DB_lang, $data, "`id`='".Func::bb($langId)."'");
	}

	//*********************************************************************************

	public function delete($langId)
	{
		return $this->objMySQL->delete(DB_lang, "`id`='".Func::bb($langId)."'", 1);
	}

	//*********************************************************************************
}

?>