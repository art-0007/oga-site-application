<?php

class MDataImage extends Model
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
			self::$obj = new MDataImage();
		}

		return self::$obj;
	}

 	//*********************************************************************************

	public function isExist($dataImageId)
	{
		if (0 === $this->objMySQL->count(DB_dataImage, "`id`='".Func::bb($dataImageId)."'"))
		{
			return false;
		}

		return true;
	}

 	//*********************************************************************************

	public function isDefault($dataImageId)
	{
		if (0 === $this->objMySQL->count(DB_dataImage, "`id`='".Func::bb($dataImageId)."' AND `defaultKey`='1'"))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function getMaxPosition($dataId)
	{
		$query =
		"
			SELECT
    			MAX(`".DB_dataImage."`.`position`) AS `position`
			FROM
				`".DB_dataImage."`
			WHERE
			(
				`".DB_dataImage."`.`data_id` = '".Func::res($dataId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["position"];
	}

	/*********************************************************************************/

	//Возвращает список всех изображений товара
	public function getAmount($dataId)
	{
		$query =
		("
			SELECT
				COUNT(`".DB_dataImage."`.`id`) AS `count`
			FROM
				`".DB_dataImage."`
			WHERE
			(
				`".DB_dataImage."`.`data_id` = '".Func::bb($dataId)."'
			)
		");

		$res = $this->objMySQL->query($query);

		//Обновляем рейтинг товара в БД
		return (int)$res[0]["count"];
	}

	/*********************************************************************************/

	//Возвращает список всех изображений товара
	public function getList($dataId)
	{
		$query =
		("
			SELECT
				*
			FROM
				`".DB_dataImage."`
			WHERE
			(
				`".DB_dataImage."`.`data_id` = '".Func::bb($dataId)."'
			)
			ORDER BY
				`".DB_dataImage."`.`position`
		");

		$res = $this->objMySQL->query($query);

		//Обновляем рейтинг товара в БД
		if(count($res) === 0)
		{
			return false;
		}
		else
		{
			return $res;
		}
	}

	/*********************************************************************************/

	//Возвращает информацию об изображений товара
	public function getInfo($dataImageId)
	{
		$query =
		("
			SELECT
				*
			FROM
				`".DB_dataImage."`
			WHERE
			(
				`".DB_dataImage."`.`id` = '".Func::bb($dataImageId)."'
			)
		");

		$res = $this->objMySQL->query($query);

		//Обновляем рейтинг товара в БД
		if(count($res) === 0)
		{
			return false;
		}
		else
		{
			return $res[0];
		}
	}

	/*********************************************************************************/

	//Возвращает список всех изображений товара
	public function getDefaultImageByDataId($dataId)
	{
		$query =
		("
			SELECT
				`".DB_dataImage."`.`fileName` as `fileName`
			FROM
				`".DB_dataImage."`
			WHERE
			(
				`".DB_dataImage."`.`data_id` = '".Func::bb($dataId)."'
				AND
				`".DB_dataImage."`.`defaultKey` = '1'
			)
		");

		$res = $this->objMySQL->query($query);

		//Обновляем рейтинг товара в БД
		if(count($res) === 0)
		{
			return false;
		}
		else
		{
			return $res[0]["fileName"];
		}
	}

	/*********************************************************************************/

	//Устанавливает ключ в ноль
	public function setDefaultKey_all($dataId, $data)
	{
		return $this->objMySQL->update(DB_dataImage, $data, "`data_id`='".Func::bb($dataId)."'");
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_dataImage, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function edit($dataImageId, $data)
	{
		return $this->objMySQL->update(DB_dataImage, $data, "`id`='".Func::bb($dataImageId)."'");
	}

	//*********************************************************************************

	public function delete($dataImageId)
	{
		return $this->objMySQL->delete(DB_dataImage, "`id`='".Func::bb($dataImageId)."'", 1);
	}

	/*********************************************************************************/
}

?>