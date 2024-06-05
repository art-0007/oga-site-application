<?php

class MArticleCatalogArticle extends Model
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
			self::$obj = new MArticleCatalogArticle();
		}

		return self::$obj;
	}

	//*********************************************************************************

	//Проверяет, есть ли
	public function isExist($articleCatalogId, $articleId)
	{
		$res = $this->objMySQL->count(DB_articleCatalogArticle, "`articleCatalog_id`='".Func::bb($articleCatalogId)."' AND `article_id`='".Func::bb($articleId)."'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	//Проверяет, есть ли
	public function isExistByArticleCatalog($articleCatalogId)
	{
		$res = $this->objMySQL->count(DB_articleCatalogArticle, "`articleCatalog_id`='".Func::bb($articleCatalogId)."'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	//Проверяет, есть ли
	public function isExistByArticle($articleId)
	{
		$res = $this->objMySQL->count(DB_articleCatalogArticle, "`article_id`='".Func::bb($articleId)."'");
		if ($res !== 0)
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	//Возвращает список товаров
	public function getList($parameterArray = null)
	{
		$mysqlWhere = $this->getMysqlWhere($parameterArray);

		if (0 !== mb_strlen($mysqlWhere))
		{
			$mysqlWhere = substr($mysqlWhere, 4);

			$mysqlWhere = " WHERE (".$mysqlWhere." )";
		}

		$query =
		"
			SELECT
				`".DB_articleCatalogArticle."`.`articleCatalog_id` AS `articleCatalogId`,
				`".DB_articleCatalogArticle."`.`article_id` AS `article_id`
			FROM
				`".DB_articleCatalogArticle."`
			".$mysqlWhere."
		";

		//Выполянем запрос
		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res;
	}

	/*********************************************************************************/

	private function getMysqlWhere($parameterArray)
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
					$mysqlWhere .= " AND (`".DB_articleCatalogArticle."`.`articleCatalog_id` IN (".$idList.")) ";
				}
			}

			if (isset($parameterArray["articleIdArray"]) AND !is_null($parameterArray["articleIdArray"]))
			{
				$idList = "";
				if (!is_array($parameterArray["articleIdArray"]))
				{
					$parameterArray["articleIdArray"] = array($parameterArray["articleIdArray"]);
				}

				foreach($parameterArray["articleIdArray"] AS $id)
				{
					if (!is_null($id) and (int)$id > 0)
					{
						$idList .= ", ".Func::res((int)$id);
					}
				}

				if (mb_strlen($idList) > 0)
				{
					$idList = substr($idList, 2);
					$mysqlWhere .= " AND (`".DB_articleCatalogArticle."`.`article_id` IN (".$idList.")) ";
				}
			}
		}

		return $mysqlWhere;
	}

	/*********************************************************************************/

	public function add($data)
	{
		$this->objMySQL->insert(DB_articleCatalogArticle, $data);
	}

	/*********************************************************************************/

	public function addGroup($data)
	{
		$this->objMySQL->insertGroup(DB_articleCatalogArticle, $data);
	}

	//*********************************************************************************

	public function delete($articleCatalogId, $articleId)
	{
		return $this->objMySQL->delete(DB_articleCatalogArticle, "`articleCatalog_id`='".Func::bb($articleCatalogId)."' AND `article_id`='".Func::bb($articleId)."'", 1);
	}

	//*********************************************************************************

	public function deleteByArticle($articleId)
	{
		return $this->objMySQL->delete(DB_articleCatalogArticle, "`article_id`='".Func::bb($articleId)."'");
	}

	//*********************************************************************************
}

?>