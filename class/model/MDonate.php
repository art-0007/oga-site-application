<?php

class MDonate extends Model
{
	//*********************************************************************************

	/** @var MDonate */
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
			self::$obj = new MDonate();
		}

		return self::$obj;
	}

	//*********************************************************************************

 	public function isExist($donatId)
 	{
		return !Func::isZero($this->objMySQL->count(DB_donate, "`id`='".Func::bb($donatId)."'"));
 	}

	//*********************************************************************************

	//Возвращает ID
	public function getIdByCode($code)
	{
		//Достем ID
		$query =
		"
			SELECT
				`".DB_donate."`.`id` AS `id`
			FROM
				`".DB_donate."`
			WHERE
			(
				`".DB_donate."`.`code` = '".Func::bb($code)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	//*********************************************************************************

	//Возвращает onlinePaySystem_id
	public function getOnlinePaySystemId($id)
	{
		//Достем ID
		$query =
		"
			SELECT
				`".DB_donate."`.`onlinePaySystem_id` AS `onlinePaySystem_id`
			FROM
				`".DB_donate."`
			WHERE
			(
				`".DB_donate."`.`id` = '".Func::bb($id)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return (int)$res[0]["onlinePaySystem_id"];
	}

	//*********************************************************************************

	//Возвращает количество товаров
	public function getAmount($parameterArray = null)
	{
		$mysqlFrom = $this->getMysqlFrom($parameterArray);
		$mysqlWhere1 = $this->getMysqlWhere1($parameterArray);
		$mysqlWhere2 = $this->getMysqlWhere2($parameterArray);

		$mysqlWhere = "";

		if (!Func::isEmpty($mysqlWhere1) AND !Func::isEmpty($mysqlWhere2))
		{
			$mysqlWhere2 = substr($mysqlWhere2, 4);

			$mysqlWhere =
				"
			WHERE
				(".$mysqlWhere.")
				".$mysqlWhere2."
			";
		}
		else
		{
			if (!Func::isEmpty($mysqlWhere1))
			{
				$mysqlWhere2 = substr($mysqlWhere2, 4);

				$mysqlWhere =
					"
				WHERE
					(".$mysqlWhere.")
				";
			}

			if (!Func::isEmpty($mysqlWhere2))
			{
				$mysqlWhere2 = substr($mysqlWhere2, 4);

				$mysqlWhere =
					"
				WHERE
					".$mysqlWhere2."
				";
			}
		}

		$query =
			"
			SELECT
				COUNT(`".DB_donate."`.`id`) AS `count`
			FROM
				`".DB_donate."`
				".$mysqlFrom."
			".$mysqlWhere."
            ".$mysqlWhere1."
			".$mysqlWhere2."
		";

		$res = $this->objMySQL->query($query);

		return (int)$res[0]["count"];
	}

	//*********************************************************************************

	public function getList($parameterArray = null)
	{
		$start = (isset($parameterArray["start"])) ? (int)$parameterArray["start"] : 0;
		$amount = (isset($parameterArray["amount"])) ? (int)$parameterArray["amount"] : null;
		$orderType = (isset($parameterArray["orderType"])) ? $parameterArray["orderType"] : "id";

		$mysqlFrom = $this->getMysqlFrom($parameterArray);
		$mysqlWhere1 = $this->getMysqlWhere1($parameterArray);
		$mysqlWhere2 = $this->getMysqlWhere2($parameterArray);
		$mysqlOrderBy = $this->getMysqlOrderBy($orderType);
		$mysqlLimit = $this->getMysqlWhereForLimit($start, $amount);

		$mysqlWhere = "";

		if (!Func::isEmpty($mysqlWhere1) AND !Func::isEmpty($mysqlWhere2))
		{
			$mysqlWhere2 = substr($mysqlWhere2, 4);

			$mysqlWhere =
				"
			WHERE
				(".$mysqlWhere.")
				".$mysqlWhere2."
			";
		}
		else
		{
			if (!Func::isEmpty($mysqlWhere1))
			{
				$mysqlWhere2 = substr($mysqlWhere2, 4);

				$mysqlWhere =
					"
				WHERE
					(".$mysqlWhere.")
				";
			}

			if (!Func::isEmpty($mysqlWhere2))
			{
				$mysqlWhere2 = substr($mysqlWhere2, 4);

				$mysqlWhere =
					"
				WHERE
					".$mysqlWhere2."
				";
			}
		}

		$query =
		"
			SELECT
				`".DB_donate."`.`id` AS `id`,
				`".DB_donate."`.`article_id` AS `article_id`,
				`".DB_donate."`.`onlinePaySystem_id` AS `onlinePaySystem_id`,
				`".DB_donate."`.`code` AS `code`,
				`".DB_donate."`.`sum` AS `sum`
			FROM
				`".DB_donate."`
				".$mysqlFrom."
			".$mysqlWhere."
			GROUP BY `".DB_donate."`.`id`
			".$mysqlOrderBy."
			".$mysqlLimit."
		";

		$res = $this->objMySQL->query($query);

		if( 0 === count($res) )
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	/**
	 * Достает ифнормацию о донате
	 *
	 * @param $id - id доната
	 *
	 * @return array
	 * */
	public function getInfo($id)
	{
		$query =
		"
			SELECT
				`".DB_donate."`.`id` AS `id`,
				`".DB_donate."`.`article_id` AS `article_id`,
				`".DB_donate."`.`onlinePaySystem_id` AS `onlinePaySystem_id`,
				`".DB_donate."`.`code` AS `code`,
				`".DB_donate."`.`sum` AS `sum`
			FROM
				`".DB_donate."`
			WHERE
			(
				`".DB_donate."`.`id` = '".Func::bb($id)."'
			)
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return false;
		}

		return $res[0];
	}

	/*********************************************************************************/

	private function getMysqlFrom($parameterArray)
	{
		$mysqlFrom = "";

		if (isset($parameterArray["articleParameterValueIdArray"]) AND !is_null($parameterArray["articleParameterValueIdArray"]))
		{
			$mysqlFrom .= ", `".DB_donate."`";
		}

		return $mysqlFrom;
	}

	/*********************************************************************************/

	private function getMysqlWhere1($parameterArray)
	{
		$mysqlWhere = "";

		if (isset($parameterArray["articleParameterValueIdArray"]) AND !is_null($parameterArray["articleParameterValueIdArray"]))
		{
			$mysqlWhere .= " AND `".DB_donate."`.`donate_id` = `".DB_article."`.`id`";
		}

		return $mysqlWhere;
	}

	/*********************************************************************************/

	private function getMysqlWhere2($parameterArray)
	{
		$mysqlWhere = "";

		if (!is_null($parameterArray))
		{
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
					$mysqlWhere .= " AND (`".DB_donate."`.`article_id` IN (".$idList.")) ";
				}
			}

			if (isset($parameterArray["code"]) AND mb_strlen($parameterArray["code"]) !== 0)
			{
				$mysqlWhere .= " AND (`".DB_donate."`.`code` = '".Func::res($parameterArray["code"])."')";
			}

			if (isset($parameterArray["excludeId"]) AND !is_null($parameterArray["excludeId"]))
			{
				$mysqlWhere .= " AND (`".DB_donate."`.`id` != '".Func::bb($parameterArray["excludeId"])."')";
			}
		}

		return $mysqlWhere;
	}

	/*********************************************************************************/

	//Возвращает ORDER BY часть запроса
	private function getMysqlOrderBy($orderType)
	{
		$mysqlOrderBy = "";

		switch($orderType)
		{
			default:
			{
				$mysqlOrderBy = " ORDER BY `".DB_donate."`.`id` DESC";
			}
		}

		return $mysqlOrderBy;
	}

	/*********************************************************************************/

	//WHERE часть запроса для LIMIT
	private function getMysqlWhereForLimit($start = 0, $amount)
	{
		$mysqlWhere = "";

		//Формируем mysqlLimit для запроса
		if(!is_null($amount) AND (int)$amount > 0)
		{
			$mysqlWhere = " LIMIT ".Func::bb($start).", ".Func::bb($amount);
		}

		return $mysqlWhere;
	}

	//*********************************************************************************

	public function addAndReturnId($data)
	{
		$this->objMySQL->insert(DB_donate, $data);

		return $this->objMySQL->getLastInsertId();
	}

	//*********************************************************************************

	public function edit($id, $data)
	{
		return $this->objMySQL->update(DB_donate, $data, "`id` = '".Func::bb($id)."'");
	}

	//*********************************************************************************

}

?>