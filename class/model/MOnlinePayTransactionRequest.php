<?php

class MOnlinePayTransactionRequest extends Model
{
	/*********************************************************************************/
	
	/** @var MOnlinePayTransactionRequest  */
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
			self::$obj = new MOnlinePayTransactionRequest();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function isExist($id)
	{
		return !Func::isZero($this->objMySQL->count(DB_onlinePayTransactionRequest, "`id` = '".Func::bb($id)."'"));
	}

	//*********************************************************************************

	public function getAmountByOnlinePayTransactionId($onlinePayTransactionId)
	{
		return (int)$this->objMySQL->count(DB_onlinePayTransactionRequest, "`onlinePayTransaction_id` = '".Func::bb($onlinePayTransactionId)."'");
	}

	//*********************************************************************************

	public function getListByOnlinePayTransactionId($onlinePayTransactionId)
	{
		$query =
		"
			SELECT
				`".DB_onlinePayTransactionRequest."`.`id` AS `id`,
				`".DB_onlinePayTransactionRequest."`.`serverData` AS `serverData`,
				`".DB_onlinePayTransactionRequest."`.`time` AS `time`
			FROM
				`".DB_onlinePayTransactionRequest."`
			WHERE
			(
				`".DB_onlinePayTransactionRequest."`.`onlinePayTransaction_id` = '".Func::bb($onlinePayTransactionId)."'
			)
			ORDER BY
				`".DB_onlinePayTransactionRequest."`.`time`
		";

		$res = $this->objMySQL->query($query);
		if (0 === count($res)) return false;

		return $res;
	}

	//*********************************************************************************

	public function getInfo($onlinePayTransactionRequestId)
	{
		$query =
		"
			SELECT
				`".DB_onlinePayTransactionRequest."`.`onlinePayTransaction_id` AS `onlinePayTransaction_id`,
				`".DB_onlinePayTransactionRequest."`.`serverData` AS `serverData`,
				`".DB_onlinePayTransactionRequest."`.`time` AS `time`
			FROM
				`".DB_onlinePayTransactionRequest."`
			WHERE
			(
				`".DB_onlinePayTransactionRequest."`.`id` = '".Func::bb($onlinePayTransactionRequestId)."'
			)
		";

		$res = $this->objMySQL->query($query);
		if (0 === count($res)) return false;

		return $res[0];
	}

	//*********************************************************************************
	
	/**
	 * Добавляет новый transaction request в БД и возвращает идентификатор записи в БД
	 *
	 * @param array $data - массив данных для вставки в БД
	 *
	 * @return int|bool - id transaction request, false - в случае ошибки
	 */
	public function add($data)
	{
		//Добавляем основную информацию о заказе
		if( false === ($res = $this->objMySQL->insert(DB_onlinePayTransactionRequest, $data)) )
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
}

?>