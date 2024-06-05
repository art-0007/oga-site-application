<?php

class MOrder extends Model
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
			self::$obj = new MOrder();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($orderId)
	{
		$query =
		"
			SELECT
				COUNT(`".DB_order."`.`id`) AS `count`
			FROM
				`".DB_order."`
			WHERE
			(
				`".DB_order."`.`id` = '".Func::bb($orderId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if((int)$res[0]["count"] > 0)
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	public function isExistByOrderIdAndUserId($orderId, $userId)
	{
		$query =
		"
			SELECT
				COUNT(`".DB_order."`.`id`) AS `count`
			FROM
				`".DB_order."`
			WHERE
			(
				`".DB_order."`.`id` = '".Func::bb($orderId)."'
				AND
				`".DB_order."`.`user_id` = '".Func::bb($userId)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if((int)$res[0]["count"] > 0)
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	public function isExistByCode($code)
	{
		$query =
		"
			SELECT
				COUNT(`".DB_order."`.`id`) AS `count`
			FROM
				`".DB_order."`
			WHERE
			(
				`".DB_order."`.`code` = '".Func::bb($code)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if((int)$res[0]["count"] > 0)
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	//Возвращает ID заказа
	public function getIdByCode($code)
	{
		//Достем ID заказа
		$query =
			"
			SELECT
				`".DB_order."`.`id` AS `id`
			FROM
				`".DB_order."`
			WHERE
			(
				`".DB_order."`.`code` = '".Func::bb($code)."'
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

	//Возвращает ID заказа
	public function getOrderStatusId($id)
	{
		//Достем ID заказа
		$query =
		"
			SELECT
				`".DB_order."`.`orderStatus_id` AS `orderStatusId`
			FROM
				`".DB_order."`
			WHERE
			(
				`".DB_order."`.`id` = '".Func::bb($id)."'
			)
		";

		$res = $this->objMySQL->query($query);

		if(count($res) === 0)
		{
			return false;
		}

		return (int)$res[0]["orderStatusId"];
	}

	//*********************************************************************************

	//Вовзращает список товаров в каталоге
	public function getAmount($parameterArray = null)
	{
		$start = (isset($parameterArray["start"])) ? (int)$parameterArray["start"] : 0;
		$amount = (isset($parameterArray["amount"])) ? (int)$parameterArray["amount"] : null;
		$orderType = (isset($parameterArray["orderType"])) ? $parameterArray["orderType"] : "time";

		$mysqlWhere = "";
		$mysqlWhere2 = $this->getMysqlWhere2($parameterArray);
		$mysqlOrderBy = $this->getMysqlOrderBy($orderType);
		$mysqlLimit = $this->getMysqlWhereForLimit($start, $amount);

		if (0 !== mb_strlen($mysqlWhere2))
		{
			$mysqlWhere = "WHERE ";
			$mysqlWhere2 = substr($mysqlWhere2, 4);
		}

		$query =
		"
			SELECT
				COUNT(`".DB_order."`.`id`) AS `count`
			FROM
				`".DB_order."`
			".$mysqlWhere."
			".$mysqlWhere2."
			".$mysqlOrderBy."
			".$mysqlLimit."
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return 0;
		}

		return (int)$res[0]["count"];
	}

	//*********************************************************************************

	//Вовзращает список товаров в каталоге
	public function getList($parameterArray = null)
	{
		$start = (isset($parameterArray["start"])) ? (int)$parameterArray["start"] : 0;
		$amount = (isset($parameterArray["amount"])) ? (int)$parameterArray["amount"] : null;
		$orderType = (isset($parameterArray["orderType"])) ? $parameterArray["orderType"] : "time";

		$mysqlWhere = "";
		$mysqlWhere2 = $this->getMysqlWhere2($parameterArray);
		$mysqlOrderBy = $this->getMysqlOrderBy($orderType);
		$mysqlLimit = $this->getMysqlWhereForLimit($start, $amount);

		if (0 !== mb_strlen($mysqlWhere2))
		{
			$mysqlWhere = "WHERE ";
			$mysqlWhere2 = substr($mysqlWhere2, 4);
		}

		$query =
		"
			SELECT
				`".DB_order."`.*
			FROM
				`".DB_order."`
			".$mysqlWhere."
			".$mysqlWhere2."
			".$mysqlOrderBy."
			".$mysqlLimit."
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************
/*
	public function getAmountByUserId($userId)
	{
		$query =
		"
			SELECT
				COUNT(*) AS `count`
			FROM
				`".DB_order."`
			WHERE
			(
				`".DB_order."`.`user_id` = '".$userId."'
				AND
				`".DB_order."`.`trashKey` = '0'
			)
		";

		$res = $this->objMySQL->query($query);

		return (int)$res[0]["count"];
	}
*/
	//*********************************************************************************

	public function getInfo($orderId)
	{
		$query =
		"
			SELECT
				`".DB_order."`.*
			FROM
				`".DB_order."`
			WHERE
			(
				`".DB_order."`.`id` = '".Func::bb($orderId)."'
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

	/**
	 * Добавляет новый заказ из сессии пользователя
	 *
	 * @return bool
	 * */
	public function add(&$offerArray, &$data)
	{
  		//Добавляем основную информацию о заказе
		$res = $this->objMySQL->insert(DB_order, $data);

		//Добаялем товары в заказ
		return $this->addOffer($offerArray, $data["code"]);
	}

	/*********************************************************************************/

	//Заносит товары с заказа в БД
	private function addOffer(&$offerArray, $code)
	{
		$objMData = MData::getInstance();

		//Проверяем, есть ли такой заказ [last_unique_id() не используется специально, просто для уменьшения вероятности ошибки]
		if(false === ($orderId = $this->getIdByCode($code)))
		{
			return false;
		}

		//Обходим список товаров
		foreach($offerArray AS $offerId => $amount)
		{
			//Достаем инфомрацию о товаре
			$offerInfo = $objMData->getInfo($offerId);

			//Достаем информацию о товаре, если товара не существует, добавляем следующий
			if(false === $offerInfo)
			{
				continue;
			}

			//Заполняем данные о товаре
			$data =
			[
				"order_id" => $orderId,
				"offer_id" => $offerInfo["id"],
				"offerAmount" => $amount,
				"article" => Convert::textUnescape($offerInfo["article"], false),
    			"title" => Convert::textUnescape($offerInfo["title"], false),
       			"price" => round($offerInfo["price"], 2),
			];

			//Добавляем заказ в БД
			if (false === $this->objMySQL->insert(DB_orderOffer, $data))
			{
				$this->objSOutput->error("Ошибка");
			}
		}

		//Вовзращаем ID заказа
		return $orderId;
	}

	/*********************************************************************************/

	private function getMysqlWhere2($parameterArray)
	{
		$mysqlWhere = "";

		if (!is_null($parameterArray))
		{
			if (isset($parameterArray["orderStatusIdArray"]) AND !is_null($parameterArray["orderStatusIdArray"]))
			{
				$idList = "";
				if (!is_array($parameterArray["orderStatusIdArray"]))
				{
					$parameterArray["orderStatusIdArray"] = [$parameterArray["orderStatusIdArray"]];
				}

				foreach($parameterArray["orderStatusIdArray"] AS $id)
				{
					if (!is_null($id) and (int)$id > 0)
					{
						$idList .= ", ".Func::res((int)$id);
					}
				}

				if (mb_strlen($idList) > 0)
				{
					$idList = substr($idList, 2);
					$mysqlWhere .= " AND (`".DB_order."`.`orderStatus_id` IN (".$idList."))";
				}
			}

			if (isset($parameterArray["userId"]) AND !is_null($parameterArray["userId"]))
			{
				$mysqlWhere .= " AND (`".DB_order."`.`user_id` = '".Func::bb($parameterArray["userId"])."')";
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
				$mysqlOrderBy = " ORDER BY `".DB_order."`.`time` DESC";
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

	public function edit($orderId, $data)
	{
		return $this->objMySQL->update(DB_order, $data, "`id`='".Func::bb($orderId)."'");
	}

	//*********************************************************************************

	public function delete($orderId)
	{
		return $this->objMySQL->delete(DB_order, "`id`='".Func::bb($orderId)."'", 1);
	}

	/*********************************************************************************/
}

?>