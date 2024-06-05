<?php

class MDataImageType extends Model
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
			self::$obj = new MDataImageType();
		}

		return self::$obj;
	}

 	//*********************************************************************************

	public function isExistBySizeId($sizeId)
	{
		if (0 === $this->objMySQL->count(DB_dataImage, "`sizeId`='".Func::bb($sizeId)."'"))
		{
			return false;
		}

		return true;
	}

	/*********************************************************************************/

	//Возвращает директорию изображения по его sizeId
	public function getDirBySizeId($sizeId)
	{
		$query =
		("
			SELECT
				`".DB_dataImageType."`.`dir` as `dir`
			FROM
				`".DB_dataImageType."`
			WHERE
			(
				`".DB_dataImageType."`.`sizeId` = '".$sizeId."'
			)
		");

		$res = $this->objMySQL->query($query);

		//Обновляем рейтинг товара в БД
		if(count($res) === 0)
		{
			return false;
		}

		return $res[0]["dir"];
	}

	/*********************************************************************************/

	//Возвращает директорию изображения по его sizeId
	public function getList()
	{
		$query =
		"
			SELECT
				*
			FROM
				`".DB_dataImageType."`
			ORDER BY
				`".DB_dataImageType."`.`position`
		";

		$res = $this->objMySQL->query($query);

		//Обновляем рейтинг товара в БД
		if(count($res) === 0)
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	public function edit($data, $dataImageTypeId)
	{
		return $this->objMySQL->update(DB_dataImageType, $data, " `".DB_dataImageType."`.`id` = '".Func::bb($dataImageTypeId)."'");
	}

	/*********************************************************************************/
}

?>