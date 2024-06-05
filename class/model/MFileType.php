<?php

class MFileType extends Model
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
			self::$obj = new MFileType;
		}

		return self::$obj;
	}

	/*********************************************************************************/

	public function isExist($fileTypeId)
	{
		$res = $this->objMySQL->count(DB_fileType, "`id` = '".Func::bb($fileTypeId)."'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
	}

	/*********************************************************************************/

	public function getIdByExtension($extension)
	{
  		$query =
		"
			SELECT
				`".DB_fileType."`.`id` AS `id`
			FROM
				`".DB_fileType."`
			WHERE
			(
				`".DB_fileType."`.`extension` LIKE '%".Func::bb($extension)."%'
			)
		";

		$res = $this->objMySQL->query($query);
		if (0 === count($res))
		{
			return (int)1;
		}

		return (int)$res[0]["id"];
	}

	/*********************************************************************************/

	public function getInfo($fileTypeId)
	{
  		$query =
		"
			SELECT
				*
			FROM
				`".DB_fileType."`
			WHERE
			(
				`".DB_fileType."`.`id` = '".Func::bb($fileTypeId)."'
			)
		";

		$res = $this->objMySQL->query($query);
		if (0 === count($res))
		{
			return false;
		}

		return $res[0];
	}

	/*********************************************************************************/
}

?>
