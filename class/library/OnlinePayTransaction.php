<?php

class OnlinePayTransaction extends Base
{
	//*********************************************************************************
	
	/** @var ?OnlinePayTransaction  */
	private static ?OnlinePayTransaction $obj = null;
	
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
			self::$obj = new OnlinePayTransaction();
		}

		return self::$obj;
	}

	//*********************************************************************************

	/**
	 * Установка статуса успешной оплаты
	 *
	 * @param int $onlinePayTransactionId ИД транзакции онлайн оплаты
	 *
	 * @return void
	 */
	public function setCompleteStatus(int $onlinePayTransactionId)
	{
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();

		$data =
		[
			"status" => EOnlinePayTransactionStatus::ok,
		];

		$objMOnlinePayTransaction->edit($onlinePayTransactionId, $data);
	}

	//*********************************************************************************
}

?>