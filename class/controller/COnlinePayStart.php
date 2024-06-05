<?php

class COnlinePayStart extends Base
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
		$objMDonate = MDonate::getInstance();
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();
		$response = [ "type" => "html", "value" => "" ];
		$html = "";
		
		//Получаем код заказа и заодно проверяем его существование
		if( false === ($donateId = $objMDonate->getIdByCode($this->vars["donateCode"])) )
		{
			$this->objSOutput->error("Error: donation with code ".$this->vars["donateCode"]." does not exist");
		}
		
		//Провереям, есть ли тразакция со статусом "OK" для данного доната
		if( true === $objMOnlinePayTransaction->isExistByDonateIdAndStatus($donateId, EOnlinePayTransactionStatus::ok) )
		{
			$this->objSOutput->error("Error: This donation has already been paid");
		}
		
		//Достаем информацию о донате
		if( false === ($donateInfo = $objMDonate->getInfo($donateId)) )
		{
			$this->objSOutput->error("Error: donation with id ".$donateId." does not exist");
		}
		
		//Добавляем информацию о новой транзакции в БД
		$data =
		[
			"donate_id" => $donateId,
			"uniqueId" => Func::uniqueIdForDB(DB_onlinePayTransaction, "uniqueId", 10),
			"status" => EOnlinePayTransactionStatus::wait,
			"time" => time()
		];

		if( false === ($onlinePayTransactionId = $objMOnlinePayTransaction->add($data)) )
		{
			$this->objSOutput->error("Error: Unable to add transaction information to database");
		}
		
		switch( (int)$donateInfo["onlinePaySystem_id"] )
		{
			case EOnlinePaySystem::stripe:
			{
				$objLibStripe = LibStripe::getInstance();
				
				//Получаем url для перенаправления пользователя
				if( false === ($response["value"] = $objLibStripe->getPaySessionURL($onlinePayTransactionId)) )
				{
					$this->objSOutput->error("Error: Unable to generate a redirect code to the payment system");
				}
				
				//Устанавливаем тип ответа в "редирект"
				$response["type"] = "redirect";
				
				break;
			}
			
			case EOnlinePaySystem::payPal:
			{
				$objLibPayPal = LibPayPal::getInstance();

				//Получаем url для перенаправления пользователя
				if( false === ($response["value"] = $objLibPayPal->getPayApproveURL($onlinePayTransactionId)) )
				{
					$this->objSOutput->error("Error: Unable to generate a redirect code to the payment system");
				}

				//Устанавливаем тип ответа в "редирект"
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
	 * Обрабатываем входящие данные
	 */
	private function setInputVars()
	{
		/*********************************************************************/
		
		$rules =
		[
			Validation::exist => "Ошибка: donateCode",
		];
		$this->objValidation->checkVars("donateCode", $rules, $_GET);
		$this->vars["donateCode"] = $this->objValidation->vars["donateCode"];
		
		/*********************************************************************/
	}

	//*********************************************************************************

}

?>