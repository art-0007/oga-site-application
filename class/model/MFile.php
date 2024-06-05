<?php

class MFile extends Model
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
			self::$obj = new MFile;
		}

		return self::$obj;
	}

	/*********************************************************************************/

	public function isExist($fileId)
	{
		$res = $this->objMySQL->count(DB_file, "`id` = '".Func::bb($fileId)."'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
	}

  	//*********************************************************************************

	public function isExistByNameOriginal($nameOriginal, $excludeFileId = null)
	{
		if (0 === $this->objMySQL->count(DB_file,
		"`nameOriginal`='".Func::bb($nameOriginal)."'
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

	//Вовзращает инфомарцию есть ли товары в каталоге
	public function isExistByFileCatalogId($fileCatalogId)
	{
		$query =
		"
			SELECT
    			COUNT(`".DB_file."`.`id`) AS `count`
			FROM
				`".DB_file."`
			WHERE
			(
				`".DB_file."`.`fileCatalog_id` = '".Func::res($fileCatalogId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if((int)$res[0]["count"] === 0)
		{
			return false;
		}

		return true;
	}

	/*********************************************************************************/

	public function getIdByNameOriginal($nameOriginal)
	{
  		$query =
		"
			SELECT
				`".DB_file."`.`id` AS `id`
			FROM
				`".DB_file."`
			WHERE
			(
				`".DB_file."`.`nameOriginal` = '".Func::bb($nameOriginal)."'
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

	public function getNameByNameOriginal($nameOriginal)
	{
  		$query =
		"
			SELECT
				`".DB_file."`.`name` AS `name`
			FROM
				`".DB_file."`
			WHERE
			(
				`".DB_file."`.`nameOriginal` = '".Func::bb($nameOriginal)."'
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

	public function getIdByName($name)
	{
  		$query =
		"
			SELECT
				`".DB_file."`.`id` AS `id`
			FROM
				`".DB_file."`
			WHERE
			(
				`".DB_file."`.`name` = '".Func::bb($name)."'
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

	public function getList($fileCatalogId)
	{
		$query =
		"
			SELECT
    			`".DB_file."`.`id` AS `fileId`,
    			`".DB_file."`.`fileCatalog_id` AS `fileCatalogId`,
    			`".DB_file."`.`name` AS `name`,
    			`".DB_file."`.`nameOriginal` AS `nameOriginal`,
    			`".DB_file."`.`size` AS `size`,
    			`".DB_file."`.`time` AS `time`,
    			`".DB_fileType."`.`id` AS `fileTypeId`,
    			`".DB_fileType."`.`title` AS `fileTypeTitle`,
    			`".DB_fileType."`.`extension` AS `extension`,
    			`".DB_fileType."`.`cssClass` AS `cssClass`
			FROM
				`".DB_file."`,
				`".DB_fileCatalog."`,
				`".DB_fileType."`
			WHERE
			(
				`".DB_file."`.`fileCatalog_id` = `".DB_fileCatalog."`.`id`
				AND
				`".DB_file."`.`fileType_id` = `".DB_fileType."`.`id`
			)
			AND
			(
				`".DB_file."`.`fileCatalog_id` = '".Func::bb($fileCatalogId)."'
			)
			ORDER BY
				`".DB_file."`.`nameOriginal`,
				`".DB_file."`.`time` DESC
		";

		$res = $this->objMySQL->query($query);
		if (0 === count($res))
		{
			return false;
		}

		return $res;
	}

	/*********************************************************************************/

	public function getInfo($fileId)
	{
  		$query =
		"
			SELECT
				*
			FROM
				`".DB_file."`
			WHERE
			(
				`".DB_file."`.`id` = '".Func::bb($fileId)."'
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
		return $this->objMySQL->insert(DB_file, $data);
	}

	//*********************************************************************************

	public function edit($fileId, $data)
	{
		return $this->objMySQL->update(DB_file, $data, "`id`='".Func::bb($fileId)."'");
	}

	//*********************************************************************************

	public function delete($fileId)
	{
		return $this->objMySQL->delete(DB_file, "`id`='".Func::bb($fileId)."'", 1);
	}

	/*********************************************************************************/
}

?>
