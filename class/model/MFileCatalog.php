<?php

class MFileCatalog extends Model
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
			self::$obj = new MFileCatalog;
		}

		return self::$obj;
	}

	/*********************************************************************************/

	public function isExist($fileCatalogId)
	{
		$res = $this->objMySQL->count(DB_fileCatalog, "`id` = '".Func::bb($fileCatalogId)."'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
	}

	/*********************************************************************************/

	public function isBase($fileCatalogId)
	{
		$res = $this->objMySQL->count(DB_fileCatalog, "`id` = '".Func::bb($fileCatalogId)."' AND `baseKey` = '1'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
	}

 	//*********************************************************************************

	public function isExistByTitle($title, $excludeFileId = null)
	{
		if (0 === $this->objMySQL->count(DB_fileCatalog,
		"`title`='".Func::bb($title)."'
		".(
			(is_null($excludeFileId))
			?
				""
			:
				" AND `id` != '".Func::bb($excludeFileId)."'"
		)))
		{
			return false;
		}

		return true;
	}


	//*********************************************************************************

	//Проверяет, есть ли у каталога дочерние
 	public function hasChild($fileCatalogId)
 	{
		$query =
		("
			SELECT
				COUNT(`".DB_fileCatalog."`.`id`) AS `count`
			FROM
				`".DB_fileCatalog."`
			WHERE
			(
				`".DB_fileCatalog."`.`fileCatalog_id` = '".Func::res($fileCatalogId)."'
			)
		");

		$res = $this->objMySQL->query($query);

		if((int)$res[0]["count"] > 0)
		{
			return true;
		}

		return false;
 	}

	/*********************************************************************************/

	public function getId_base()
	{
  		$query =
		"
			SELECT
				`".DB_fileCatalog."`.`id` AS `id`
			FROM
				`".DB_fileCatalog."`
			WHERE
			(
				`".DB_fileCatalog."`.`baseKey` = '1'
			)
			LIMIT 1
		";

		$res = $this->objMySQL->query($query);
		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	/*********************************************************************************/

	public function getIdByDevName($devName)
	{
  		$query =
		"
			SELECT
				`".DB_fileCatalog."`.`id` AS `id`
			FROM
				`".DB_fileCatalog."`
			WHERE
			(
				`".DB_fileCatalog."`.`devName` = '".Func::bb($devName)."'
			)
			LIMIT 1
		";

		$res = $this->objMySQL->query($query);
		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	//*********************************************************************************

	public function getList($fileCatalogId)
	{
		$query =
		"
			SELECT
    			*
			FROM
				`".DB_fileCatalog."`
			WHERE
			(
				`".DB_fileCatalog."`.`fileCatalog_id` = '".Func::bb($fileCatalogId)."'
			)
			ORDER BY
				`".DB_fileCatalog."`.`title`,
				`".DB_fileCatalog."`.`time` DESC
		";

		$res = $this->objMySQL->query($query);
		if (0 === count($res))
		{
			return false;
		}

		return $res;
	}

	/*********************************************************************************/

	public function getInfo($fileCatalogId)
	{
  		$query =
		"
			SELECT
				*
			FROM
				`".DB_fileCatalog."`
			WHERE
			(
				`".DB_fileCatalog."`.`id` = '".Func::bb($fileCatalogId)."'
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

	public function add($data)
	{
		return $this->objMySQL->insert(DB_fileCatalog, $data);
	}

	//*********************************************************************************

	public function edit($fileCatalogId, $data)
	{
		return $this->objMySQL->update(DB_fileCatalog, $data, "`id`='".Func::bb($fileCatalogId)."'");
	}

	//*********************************************************************************

	public function delete($fileCatalogId)
	{
		return $this->objMySQL->delete(DB_fileCatalog, "`id`='".Func::bb($fileCatalogId)."'", 1);
	}

	/*********************************************************************************/
}

?>
