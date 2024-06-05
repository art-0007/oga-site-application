<?php

class MOrderOffer extends Model
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
			self::$obj = new MOrderOffer();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function getList($orderId)
	{
		$query =
		"
			SELECT
				`".DB_orderOffer."`.*
			FROM
				`".DB_orderOffer."`
			WHERE
			(
				`".DB_orderOffer."`.`order_id` = '".Func::bb($orderId)."'
			)
		";

		$res = $this->objMySQL->query($query);
		if (count($res) === 0)
		{
			return false;
		}

		return $res;
	}

	/*********************************************************************************/
}

?>