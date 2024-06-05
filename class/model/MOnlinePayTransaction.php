<?php

class MOnlinePayTransaction extends Model
{
	/*********************************************************************************/
	
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
			self::$obj = new MOnlinePayTransaction();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($id)
	{
		$query =
			"
			SELECT
				COUNT(*) AS `count`
			FROM
				`".DB_onlinePayTransaction."`
			WHERE
			(
				`".DB_onlinePayTransaction."`.`id` = '".Func::res($id)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if( (int)$res[0]["count"] > 0 )
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	public function isExistByDonateId($donateId)
	{
		$query =
		"
			SELECT
				COUNT(*) AS `count`
			FROM
				`".DB_onlinePayTransaction."`
			WHERE
			(
				`".DB_onlinePayTransaction."`.`donate_id` = '".Func::res($donateId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if( (int)$res[0]["count"] > 0 )
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	public function isExistByDonateIdAndStatus($donateId, $status)
	{
		$query =
			"
			SELECT
				COUNT(*) AS `count`
			FROM
				`".DB_onlinePayTransaction."`
			WHERE
			(
				`".DB_onlinePayTransaction."`.`donate_id` = '".Func::res($donateId)."'
					AND
				`".DB_onlinePayTransaction."`.`status` = '".Func::res($status)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if( (int)$res[0]["count"] > 0 )
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	/**
	 * Возвращает ID транзакции онлайн оплаты по ID статьи
	 *
	 * @param $articleId - ID статьи
	 *
	 * @return int|bool ID транзакции онлайн оплаты или false - в случае ошибки
	 */
	public function getIdByArticleId($articleId)
	{
		$query =
		"
			SELECT
				`".DB_onlinePayTransaction."`.`id` AS `id`
			FROM
				`".DB_onlinePayTransaction."`
			WHERE
			(
				`".DB_onlinePayTransaction."`.`donate_id` = '".Func::res($articleId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if( 0 === count($res) )
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	//*********************************************************************************

	/**
	 * Возвращает ID транзакции онлайн оплаты по ее уникальному идентификатору
	 *
	 * @param $uniqueId - уникальный идентификатор транзакции онлайн оплаты
	 *
	 * @return int|bool ID транзакции онлайн оплаты или false - в случае ошибки
	 */
	public function getIdByUniqueId($uniqueId)
	{
		$query =
		"
			SELECT
				`".DB_onlinePayTransaction."`.`id` AS `id`
			FROM
				`".DB_onlinePayTransaction."`
			WHERE
			(
				`".DB_onlinePayTransaction."`.`uniqueId` = '".Func::res($uniqueId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if( 0 === count($res) )
		{
			return false;
		}

		return (int)$res[0]["id"];
	}

	//*********************************************************************************

	public function getDonateId($id)
	{
		$query =
		"
			SELECT
				`".DB_onlinePayTransaction."`.`donate_id` AS `donate_id`
			FROM
				`".DB_onlinePayTransaction."`
			WHERE
			(
				`".DB_onlinePayTransaction."`.`id` = '".Func::res($id)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if( 0 === count($res) )
		{
			return false;
		}

		return (int)$res[0]["donate_id"];
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
			$mysqlWhere =
			"
			WHERE
				(".$mysqlWhere1.")
				".$mysqlWhere2."
			";
		}
		else
		{
			if (!Func::isEmpty($mysqlWhere1))
			{
				$mysqlWhere =
				"
				WHERE
					(".$mysqlWhere1.")
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
				COUNT(`".DB_onlinePayTransaction."`.`id`) AS `count`
			FROM
				`".DB_onlinePayTransaction."`
				".$mysqlFrom."
			".$mysqlWhere."
		";

		$res = $this->objMySQL->query($query);

		return (int)$res[0]["count"];
	}

	//*********************************************************************************
	
	public function getList($parameterArray = null)
	{
		$start = (isset($parameterArray["start"])) ? (int)$parameterArray["start"] : 0;
		$amount = (isset($parameterArray["amount"])) ? (int)$parameterArray["amount"] : null;
		$orderType = (isset($parameterArray["orderType"])) ? $parameterArray["orderType"] : "time";

		$mysqlFrom = $this->getMysqlFrom($parameterArray);
		$mysqlWhere1 = $this->getMysqlWhere1($parameterArray);
		$mysqlWhere2 = $this->getMysqlWhere2($parameterArray);
		$mysqlOrderBy = $this->getMysqlOrderBy($orderType);
		$mysqlLimit = $this->getMysqlWhereForLimit($start, $amount);

		$mysqlWhere = "";

		if (!Func::isEmpty($mysqlWhere1) AND !Func::isEmpty($mysqlWhere2))
		{
			$mysqlWhere =
			"
			WHERE
				(".$mysqlWhere1.")
				".$mysqlWhere2."
			";
		}
		else
		{
			if (!Func::isEmpty($mysqlWhere1))
			{
				$mysqlWhere =
				"
				WHERE
					(".$mysqlWhere1.")
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
				`".DB_onlinePayTransaction."`.`id` AS `id`,
				`".DB_onlinePayTransaction."`.`donate_id` AS `donate_id`,
				`".DB_onlinePayTransaction."`.`uniqueId` AS `uniqueId`,
				`".DB_onlinePayTransaction."`.`onlinePaySystemUId` AS `onlinePaySystemUId`,
				`".DB_onlinePayTransaction."`.`status` AS `status`,
				`".DB_onlinePayTransaction."`.`time` AS `time`
			FROM
				`".DB_onlinePayTransaction."`
				".$mysqlFrom."
			".$mysqlWhere."
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

	public function getInfo($id)
	{
		$query =
		"
			SELECT
				`".DB_onlinePayTransaction."`.`id` AS `id`,
				`".DB_onlinePayTransaction."`.`donate_id` AS `donate_id`,
				`".DB_onlinePayTransaction."`.`uniqueId` AS `uniqueId`,
				`".DB_onlinePayTransaction."`.`onlinePaySystemUId` AS `onlinePaySystemUId`,
				`".DB_onlinePayTransaction."`.`status` AS `status`,
				`".DB_onlinePayTransaction."`.`time` AS `time`
			FROM
				`".DB_onlinePayTransaction."`
			WHERE
			(
				`".DB_onlinePayTransaction."`.`id` = '".Func::res($id)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if( 0 === count($res) )
		{
			return false;
		}

		return $res[0];
	}

	/*********************************************************************************/

	private function getMysqlFrom($parameterArray)
	{
		$mysqlFrom = "";
		//
		//if (isset($parameterArray["donateIdArray"]) AND !is_null($parameterArray["donateIdArray"]))
		//{
		//	$mysqlFrom .= ", `".DB_donate."`";
		//}

		return $mysqlFrom;
	}

	/*********************************************************************************/

	private function getMysqlWhere1($parameterArray)
	{
		$mysqlWhere = "";

		//if (isset($parameterArray["donateIdArray"]) AND !is_null($parameterArray["donateIdArray"]))
		//{
		//	$mysqlWhere .= " AND `".DB_onlinePayTransaction."`.`donate_id` = `".DB_donate."`.`id`";
		//}
		//
		//$mysqlWhere = substr($mysqlWhere, 4);

		return $mysqlWhere;
	}

	/*********************************************************************************/

	private function getMysqlWhere2($parameterArray)
	{
		$mysqlWhere = "";

		if (!is_null($parameterArray))
		{
			if (isset($parameterArray["donateIdArray"]) AND !is_null($parameterArray["donateIdArray"]))
			{
				$idList = "";
				if (!is_array($parameterArray["donateIdArray"]))
				{
					$parameterArray["donateIdArray"] = array($parameterArray["donateIdArray"]);
				}

				foreach($parameterArray["donateIdArray"] AS $id)
				{
					if (!is_null($id) and (int)$id > 0)
					{
						$idList .= ", ".Func::res((int)$id);
					}
				}

				if (mb_strlen($idList) > 0)
				{
					$idList = substr($idList, 2);
					$mysqlWhere .= " AND (`".DB_onlinePayTransaction."`.`donate_id` IN (".$idList.")) ";
				}
			}

			if (isset($parameterArray["uniqueId"]) AND mb_strlen($parameterArray["uniqueId"]) !== 0)
			{
				$mysqlWhere .= " AND (`".DB_onlinePayTransaction."`.`uniqueId` = '".Func::res($parameterArray["uniqueId"])."')";
			}

			if (isset($parameterArray["status"]) AND mb_strlen($parameterArray["status"]) !== 0)
			{
				$mysqlWhere .= " AND (`".DB_onlinePayTransaction."`.`status` = '".Func::res($parameterArray["status"])."')";
			}

			if (isset($parameterArray["excludeId"]) AND !is_null($parameterArray["excludeId"]))
			{
				$mysqlWhere .= " AND (`".DB_onlinePayTransaction."`.`id` != '".Func::bb($parameterArray["excludeId"])."')";
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
				$mysqlOrderBy = " ORDER BY `".DB_onlinePayTransaction."`.`time`";
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

	/*********************************************************************************/
	
	/**
	 * Добавляет новую транакцию в БД и возвращает ее идентификатор
	 *
	 * @param array $data - массив данных для вставки в БД
	 *
	 * @return int|bool - id транзакции, false - в случае ошибки
	 */
	public function add($data)
	{
		//Добавляем основную информацию о заказе
		if( false === ($res = $this->objMySQL->insert(DB_onlinePayTransaction, $data)) )
		{
			return false;
		}
		
		//Получаем ID заказа
		if( false === ($id = $this->objMySQL->getLastInsertId()) )
		{
			return false;
		}
		
		return (int)$id;
	}
	
	//*********************************************************************************
	
	public function edit($id, $data)
	{
		return $this->objMySQL->update(DB_onlinePayTransaction, $data, "`id`='".Func::res($id)."'");
	}
	
	/*********************************************************************************/
	
}

?>