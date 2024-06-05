<?php

/**
 * Используется для проверки статуса оплаты
 * Выполняется автоматически через определенный промежуток времени
 */
class COnlinePayCheckCompleteStatus extends Base
{
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		//Начало выполнения скрипта
		$this->start();
	}

	//*********************************************************************************

	private function start()
	{
		//Достаем список не оплаченных донатов и проверяем оплату
		$this->checkOnlinePayTransactionStatus();
		
		$this->exitScript();
	}

	//*********************************************************************************

	/**
	 * Проверяет список транзакций в статусе "Ожидание оплаты" на оплаченность
	 *
	 * @return void
	 */
	private function checkOnlinePayTransactionStatus()
	{
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();
		$objMDonate = MDonate::getInstance();

		$parameterArray =
		[
			"status" => EOnlinePayTransactionStatus::wait,
		];

		if (false === ($res = $objMOnlinePayTransaction->getList($parameterArray)))
		{
			return;
		}

		foreach ($res AS $row)
		{
			$onlinePaySystemId = $objMDonate->getOnlinePaySystemId($row["donate_id"]);

			switch ($onlinePaySystemId)
			{
				case EOnlinePaySystem::stripe:
				{
					$this->checkStripe($row["id"]);
					break;
				}
				default:
				{
					//$this->objSOutput->critical("OnlinePaySystemId not registered [".$onlinePaySystemId."]");
				}
			}
		}
	}
	
	//*********************************************************************************

	/**
	 * Проверяем оплачен ли платеж в системе онлайн оплаты Stripe
	 *
	 * @param int $onlinePayTransactionId ИД транзакции онлайн оплаты
	 */
	private function checkStripe($onlinePayTransactionId)
	{
		$objLibStripe = LibStripe::getInstance();

		$stripeSessionInfo = $objLibStripe->getSessionRetrieve($onlinePayTransactionId);

		//Если платеж оплачен, то проставляем статус
		if ( $stripeSessionInfo !== false AND 0 === Func::mb_strcasecmp($stripeSessionInfo["status"], "complete"))
		{
			$objLibStripe->setCompleteStatus($onlinePayTransactionId);
		}
	}

	//*********************************************************************************

	private function exitScript()
	{
		//ВНИМАНИЕ! Вывод в поток пустой строки для cron означает успешное завершение работы

		//ВНИМАНИЕ! Устанавливаем специальный ключ обработки потока вывода
		GLOB::$stdOutProcessed = true;

		//Выводим пустую строку в поток вывода, для того, чтобы cron не отправлял email
		exit();
	}

	//*********************************************************************************

}

?>