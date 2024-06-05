<?php

class COnlinePayProcess extends Base
{
	//*********************************************************************************
	
	/**
	 * @var array Массив входных данных
	 */
	public $vars = [];
	
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();
		$this->setInputVars();
		
		$this->init();
	}

	//*********************************************************************************
	
	private function init()
	{
		$onlinePaySystemId = (int)$this->vars["opsId"];
		$response = [ "type" => "html", "value" => "" ];
		$html = "";
		
		$this->writeLog();
		
		switch( $onlinePaySystemId )
		{
			case EOnlinePaySystem::stripe:
			{
				//Если есть переменная tuId, то значит это не вебхук, а перенаправление пользователя
				if( isset($_GET["tuId"]) )
				{
					$response = $this->processStripeRetrieve($_GET["tuId"]);
				}
				else
				{
					/** @todo Добавить обработку запроса через WebHook */
				}
				
				break;
			}

			case EOnlinePaySystem::payPal:
			{
				$this->processPayPal();

				//В независимости от результата обработки платежа, переадресовываем
				//на страницу вывода информации о результате оплаты
				$response["value"] = GLOB::$FRONT_URL."/online-pay/result/?tuId=".$_GET["tuId"];
				$response["type"] = "redirect";

				break;
			}

			default:
			{
				$this->objSOutput->error("Error: Order payment type is not an online payment or is not supported");
				break;
			}
		}
		
		if( $response["type"] === "html" )
		{
			$html = $response["value"];
		}
		else
		{
			$this->objSResponse->redirect($response["value"]);
		}
		
		$this->objSOutput->ok($html);
	}
	
	//*********************************************************************************
	
	/**
	 * Обрабатывает пользовательское обращение методом редиректа
	 *
	 * @param string $transactionUniqueId
	 *
	 * @return bool|array
	 */
	private function processStripeRetrieve(string $transactionUniqueId)
	{
		$objLibStripe = LibStripe::getInstance();
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();
		
		//Достаем ID транзакции по ее уникальному идентификатору
		if( false === ($onlinePayTransactionId = $objMOnlinePayTransaction->getIdByUniqueId($transactionUniqueId)) )
		{
			$this->objSOutput->error("Error: No unique transaction ID");
		}
		
		//Получаем информацию о платежной сессии из stripe
		if( false === ($stripeSessionInfo = $objLibStripe->getSessionRetrieve($onlinePayTransactionId)) )
		{
			$this->objSOutput->error("Error: Unable to get payment session information");
		}
		
		$pageDevName = EPageDevName::onlinePayError;
		
		//Если платеж оплачен, то редиректим на страницу успешного платежа
		if( 0 === Func::mb_strcasecmp($stripeSessionInfo["status"], "complete") )
		{
			//Если платеж оплачен, то проставляем статус
			$objLibStripe->setCompleteStatus($onlinePayTransactionId);

			$pageDevName = EPageDevName::onlinePaySuccess;
		}
		
		return
		[
			"type" => "redirect",
			"value" => GLOB::$FRONT_URL."/online-pay/result/?tuId=".$transactionUniqueId."&pdn=".$pageDevName,
		];
	}

	//*********************************************************************************

	//Обработка платежа PayPal
	private function processPayPal()
	{
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();
		$objMOnlinePayTransactionRequest = MOnlinePayTransactionRequest::getInstance();
		$objLibPayPal = LibPayPal::getInstance();

		//Проверяем наличие обьязательных паеременных
		if( !isset($_GET["tuId"]) OR !isset($_GET["token"]) )
		{
			$this->objSOutput->error("Error: required variables not found");
		}

		//Достаем ID транзакции по ее уникальному идентификатору
		if( false === ($onlinePayTransactionId = $objMOnlinePayTransaction->getIdByUniqueId($_GET["tuId"])) )
		{
			$this->objSOutput->error("Error: No unique transaction ID");
		}

		//Проверяем совпадение ИД транзакций. PayPal передает ид транзакции в переменной token
		if( false === $objLibPayPal->checkTransactionId($onlinePayTransactionId, $_GET["token"]) )
		{
			$this->objSOutput->error("Error: Transaction ID mismatch");
		}

		//Достаем информацию о транзакции онлайн оплаты
		if( false === ($onlinePayTransactionInfo = $objMOnlinePayTransaction->getInfo($onlinePayTransactionId)) )
		{
			$this->objSOutput->error("Error: Unable to get transaction information");
		}

		//Производим списывание средств по транзакции
		if( false === ($payPalDataArray = $objLibPayPal->orderCapturePayment($onlinePayTransactionId)) )
		{
			return false;
		}

		//Преобразуем массив данных в json
		$payPalDataJson = @json_encode($payPalDataArray, JSON_UNESCAPED_UNICODE);

		//Добавляем информацию о PayPal запросе в БД
		$data =
		[
			"onlinePayTransaction_id" => $onlinePayTransactionId,
			"serverData" => $payPalDataJson,
			"time" => time()
		];
		$objMOnlinePayTransactionRequest->add($data);

		//Проверяем, была ли оплачена транзакция
		if( false === $objLibPayPal->isTransactionSuccess($payPalDataArray) )
		{
			//Устанавливаем статус онлайн тразакции в ERROR
			$data =
			[
				"status" => EOnlinePayTransactionStatus::error
			];
			$objMOnlinePayTransaction->edit($onlinePayTransactionId, $data);

			return false;
		}

		//Устанавливаем статус онлайн тразакции в OK
		$data =
		[
			"status" => EOnlinePayTransactionStatus::ok
		];
		$objMOnlinePayTransaction->edit($onlinePayTransactionId, $data);

		return true;
	}

	//*********************************************************************************
	
	private function writeLog($text = "")
	{
		$data = "=========== ".date("d-m-Y H:i:s")." =========== \r\n";
		$data .= print_r($_GET, true)."\r\n";
		$data .= print_r($_POST, true)."\r\n";
		if( !empty($text) )
		{
			$data .= $text."\r\n";
		}
		$data .= "=========== end =========== \r\n\r\n";
		
		file_put_contents(PATH."/".TMP_DIR_NAME."/onlinePayProcess.log", $data, FILE_APPEND);
		
		return true;
	}

	//*********************************************************************************
	
	/**
	 * Обрабатываем входящие данные
	 */
	private function setInputVars()
	{
		/*********************************************************************/
		
		$rules =
		[
			Validation::exist => "Ошибка: opsId",
		];
		$this->objValidation->checkVars("opsId", $rules, $_GET);
		
		$this->vars["opsId"] = $this->objValidation->vars["opsId"];
		
		/*********************************************************************/
	}

	//*********************************************************************************
}

?>