<?php

class MArticleImage extends Model
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
			self::$obj = new MArticleImage;
		}

		return self::$obj;
	}

	/*********************************************************************************/

	public function isExist($articleImageId)
	{
		$res = $this->objMySQL->count(DB_articleImage, "`id` = '".Func::bb($articleImageId)."'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
	}

 	//*********************************************************************************

	public function isExistByTitle($title, $excludeArticleImageId = null)
	{
		if (0 === $this->objMySQL->count(DB_articleImage,
		"`title`='".Func::bb($title)."'
		".(
			(is_null($excludeArticleImageId))
			?
				""
			:
				" AND `id` != '".Func::bb($excludeArticleImageId)."'"
		)))
		{
			return false;
		}

		return true;
	}

	//*********************************************************************************

	public function isExistByArticleId($articleId)
	{
		$query =
		"
			SELECT
    			COUNT(`".DB_articleImage."`.`id`) AS `count`
			FROM
				`".DB_articleImage."`
			WHERE
			(
				`".DB_articleImage."`.`article_id` = '".Func::res($articleId)."'
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

	/**
	 * Достает id статьи
	 *
	 * @param $id - id
	 *
	 * @return int
	 * */
	public function getArticleId($articleImageId)
	{
		$query =
		"
			SELECT
    			`".DB_articleImage."`.`article_id` AS `articleId`
			FROM
				`".DB_articleImage."`
			WHERE
			(
				`".DB_articleImage."`.`id` = '".Func::res($articleImageId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return (int)$res[0]["articleId"];
	}

	//*********************************************************************************

	public function getMaxPosition($articleId)
	{
		$query =
		"
			SELECT
    			MAX(`".DB_articleImage."`.`position`) AS `position`
			FROM
				`".DB_articleImage."`
			WHERE
			(
				`".DB_articleImage."`.`article_id` = '".Func::bb($articleId)."'
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

	public function getList($articleId)
	{
		$query =
		"
			SELECT
    			*
			FROM
				`".DB_articleImage."`
			WHERE
			(
				`".DB_articleImage."`.`article_id` = '".Func::bb($articleId)."'
			)
			ORDER BY
				`".DB_articleImage."`.`position`
		";

		$res = $this->objMySQL->query($query);
		if (0 === count($res))
		{
			return false;
		}

		return $res;
	}

	/*********************************************************************************/

	public function getInfo($articleImageId)
	{
  		$query =
		"
			SELECT
				*
			FROM
				`".DB_articleImage."`
			WHERE
			(
				`".DB_articleImage."`.`id` = '".Func::bb($articleImageId)."'
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
		return $this->objMySQL->insert(DB_articleImage, $data);
	}

	//*********************************************************************************

	public function edit($articleImageId, $data)
	{
		return $this->objMySQL->update(DB_articleImage, $data, "`id`='".Func::bb($articleImageId)."'");
	}

	//*********************************************************************************

	public function delete($articleImageId)
	{
		return $this->objMySQL->delete(DB_articleImage, "`id`='".Func::bb($articleImageId)."'", 1);
	}

	/*********************************************************************************/
}

?>
