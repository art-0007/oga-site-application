<?php

class LibPayPal extends OnlinePayTransaction
{
	//*********************************************************************************
	
	//Массив соответсвий devName языка платформы, коду в системе оплаты
	private static $langArray = [ "ru" => "ru-RU", "ua" => "ru-UA", "en" => "en-US", "es" => "es-ES", "it" => "it-IT" ];
	
	//Типы форм для curl
	private static $formType = [];
	
	/** @var LibPayPal  */
	private static $obj = null;
	
	//*********************************************************************************

	protected function __construct()
	{
		parent::__construct();
		$this->init();
	}

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new LibPayPal();
		}

		return self::$obj;
	}

	//*********************************************************************************
	
	private function init()
	{
		self::$formType =
		[
			"applicationJson" => 1
		];
	}
	
	//*********************************************************************************
	
	/**
	 * Проверяет, получилось ли списать средства по транзакции
	 *
	 * @param $data - массив ответа paypal на запрос order capture payment
	 *
	 * @return bool
	 */
	public function isTransactionSuccess($data)
	{
		if( !isset($data["id"]) OR !isset($data["status"]) )
		{
			return false;
		}
		
		if( 0 === Func::mb_strcasecmp($data["status"], "COMPLETED") )
		{
			return true;
		}
		
		return false;
	}
	
	//*********************************************************************************
	
	/**
	 * Проверяет соответсвие ID тразакций paypal
	 *
	 * @param $onlinePayTransactionId
	 * @param $payPalToken
	 *
	 * @return bool
	 */
	public function checkTransactionId($onlinePayTransactionId, $payPalToken)
	{
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();
		
		//Достаем информацию о транзакции онлайн оплаты
		if( false === ($onlinePayTransactionInfo = $objMOnlinePayTransaction->getInfo($onlinePayTransactionId)) )
		{
			$this->objSOutput->error("Error: Unable to get transaction information");
		}
		
		//Проверяем совпадение ИД транзакций. PayPal передает ид транзакции в переменной token
		if( -1 === Func::mb_strcasecmp($onlinePayTransactionInfo["onlinePaySystemUId"], $payPalToken) )
		{
			return false;
		}
		
		return true;
	}
	
	//*********************************************************************************
	
	/**
	 * Возвращает html страницы с формой, которая автосабмитится и отправляет пользователя на страницу оплаты LiqPay
	 *
	 * @param $onlinePayTransactionId - id транзакции онлайн оплаты
	 *
	 * @return array|bool - массив данных или fasle в случае ошибки
	 */
	public function getPayApproveURL($onlinePayTransactionId)
	{
		$objMDonate = MDonate::getInstance();
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();

		//Достаем информацию о транзакции онлайн оплаты
		if( false === ($onlinePayTransactionInfo = $objMOnlinePayTransaction->getInfo($onlinePayTransactionId)) )
		{
			return false;
		}

		//Достаем информацию о донате
		if( false === ($donateInfo = $objMDonate->getInfo($onlinePayTransactionInfo["donate_id"])) )
		{
			$this->objSOutput->error("Error: donate with id ".$onlinePayTransactionInfo["donate_id"]." does not exist");
		}

		//Достаем настройки системе онлайн оплаты
		if( false === ($onlinePaySystemSettings = $objMOnlinePaySystem->getSettings($donateInfo["onlinePaySystem_id"])) )
		{
			$this->objSOutput->error("Error: onlinePaySystem with id ".$donateInfo["onlinePaySystem_id"]." does not exist");
		}

		//Получаем настройки системы оплаты
		if( false === ($onlinePaySystemSettings = $this->getOnlinePaySystemSettings($onlinePaySystemSettings)) )
		{
			return false;
		}

		//Язык страницы оплаты по умолчанию - "английский"
		$language = self::$langArray["en"];
		
		//Получаем access token
		if( false === ($accessToken = $this->getAccessToken($onlinePaySystemSettings["client_id"], $onlinePaySystemSettings["secret_key"], $onlinePaySystemSettings["sandboxKey"])) )
		{
			return false;
		}
		
		//Массив данных для создания платежа в PayPal
		$postData =
		[
			"intent" => "CAPTURE",
			"purchase_units" =>
			[
				[
					"amount" =>
					[
						"currency_code" => "USD",
						"value" => Func::moneyToPrintable($donateInfo["sum"], 2)
					],
					"invoice_id" => $onlinePayTransactionInfo["uniqueId"],
					"custom_id" => $donateInfo["code"]
				]
			],
			"application_context" =>
			[
				"brand_name" => GLOB::$SETTINGS["front_companyName"],
				"locale" => $language,
				"return_url" => GLOB::$FRONT_URL."/online-pay/process/?opsId=".EOnlinePaySystem::payPal."&tuId=".$onlinePayTransactionInfo["uniqueId"],
				"cancel_url" => GLOB::$FRONT_URL."/online-pay/result/?tuId=".$onlinePayTransactionInfo["uniqueId"],
			]
		];
		
		//Формируем канал
		$channel = curl_init();
		
		//Устанавливаем опции
		curl_setopt($channel, CURLOPT_URL, $this->getApiUrl($onlinePaySystemSettings["sandboxKey"], "v2")."checkout/orders");
		curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($channel, CURLOPT_HEADER, false);
		curl_setopt($channel, CURLOPT_FORBID_REUSE, false);
		curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($channel, CURLOPT_SSL_VERIFYSTATUS, false);
		curl_setopt($channel, CURLOPT_HTTPHEADER,
		[
			"Content-Type: application/json",
			"Authorization: Bearer ".$accessToken
		]);
		curl_setopt($channel, CURLOPT_POSTFIELDS, json_encode($postData));
		
		//Выполняем запрос
		if( false === ($response = curl_exec($channel)) )
		{
			return false;
		}
		
		//Закрываем соеденение
		curl_close($channel);
		
		//Преобразуем ответ в массив
		$responseData = @json_decode($response, true);
		
		//Проверяем наличие ID в ответе
		if( !isset($responseData["id"]) )
		{
			return false;
		}
		
		//Заносим ID транзакции в PayPal в БД
		$data =
		[
			"onlinePaySystemUId" => $responseData["id"]
		];
		$objMOnlinePayTransaction->edit($onlinePayTransactionId, $data);
		
		//Формируем URL для отправки пользователя на страницу подверждения платежа
		$returnUrl = $this->getUrl($onlinePaySystemSettings["sandboxKey"])."checkoutnow?token=".$responseData["id"];
		
		return $returnUrl;
	}

	//*********************************************************************************
	
	/**
	 * Метод производит списание средств по транзакции
	 *
	 * @param $onlinePayTransactionId
	 * @return bool|mixed
	 */
	public function orderCapturePayment($onlinePayTransactionId)
	{
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();
		$objMDonate = MDonate::getInstance();
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();

		//Достаем информацию о транзакции онлайн оплаты
		if( false === ($onlinePayTransactionInfo = $objMOnlinePayTransaction->getInfo($onlinePayTransactionId)) )
		{
			return false;
		}

		//Достаем информацию о типе оплаты
		if( false === ($donateInfo = $objMDonate->getInfo($onlinePayTransactionInfo["donate_id"])) )
		{
			return false;
		}

		//Достаем настройки системе онлайн оплаты
		if( false === ($onlinePaySystemSettings = $objMOnlinePaySystem->getSettings($donateInfo["onlinePaySystem_id"])) )
		{
			return false;
		}

		//Получаем настройки системы оплаты
		if( false === ($onlinePaySystemSettings = $this->getOnlinePaySystemSettings($onlinePaySystemSettings)) )
		{
			return false;
		}

		//Получаем access token
		if( false === ($accessToken = $this->getAccessToken($onlinePaySystemSettings["client_id"], $onlinePaySystemSettings["secret_key"], $onlinePaySystemSettings["sandboxKey"])) )
		{
			return false;
		}
		
		//Формируем канал
		$channel = curl_init();
		
		//Устанавливаем опции
		curl_setopt($channel, CURLOPT_URL, $this->getApiUrl($onlinePaySystemSettings["sandboxKey"], "v2")."checkout/orders/".$onlinePayTransactionInfo["onlinePaySystemUId"]."/capture");
		curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($channel, CURLOPT_HEADER, false);
		curl_setopt($channel, CURLOPT_FORBID_REUSE, false);
		curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($channel, CURLOPT_SSL_VERIFYSTATUS, false);
		
		curl_setopt($channel, CURLOPT_POST, true);
		curl_setopt($channel, CURLOPT_HTTPHEADER,
		[
			"Content-Type: application/json",
			"Authorization: Bearer ".$accessToken
		]);
		
		//Выполняем запрос
		if( false === ($response = curl_exec($channel)) )
		{
			return false;
		}
		
		//Закрываем соеденение
		curl_close($channel);
		
		//Преобразуем ответ в массив
		$responseData = @json_decode($response, true);
		
		return $responseData;
	}
	
	//*********************************************************************************
	
	/**
	 * @param $clientId - ID клиента в приложении PayPal
	 * @param $secretKey - секретный ключ в приложении PayPal
	 * @param $sandboxKey - Ключ включения режима sandbox
	 *
	 * @return string access token
	 */
	private function getAccessToken($clientId, $secretKey, $sandboxKey)
	{
		$url = $this->getApiUrl($sandboxKey, "v1")."oauth2/token";
		
		$postData =
		[
			"grant_type" => "client_credentials"
		];
		
		//Формируем канал
		$channel = curl_init();
		
		//Устанавливаем опции
		curl_setopt($channel, CURLOPT_URL, $url);
		curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($channel, CURLOPT_HEADER, false);
		curl_setopt($channel, CURLOPT_FORBID_REUSE, false);
		curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($channel, CURLOPT_SSL_VERIFYSTATUS, false);
		
		curl_setopt($channel, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($channel, CURLOPT_USERNAME, $clientId);
		curl_setopt($channel, CURLOPT_PASSWORD, $secretKey);
		curl_setopt($channel, CURLOPT_HTTPHEADER, [ "Content-Type: application/x-www-form-urlencoded"] );
		curl_setopt($channel, CURLOPT_POSTFIELDS, http_build_query($postData));
		
		if( false === ($response = curl_exec($channel)) )
		{
			return false;
		}
		
		//Закрываем соеденение
		curl_close($channel);
		
		//Преобразуем ответ в массив
		$data = @json_decode($response, true);
		
		//Если в ответе нет токена, значит произошла ошибка
		if( !isset($data["access_token"]) )
		{
			return false;
		}
		
		return $data["access_token"];
	}

	//*********************************************************************************

	/**
	 * Возвращает настройки системы онлайн оплаты
	 *
	 * @param string $settings
	 *
	 * @return false|array
	 */
	private function getOnlinePaySystemSettings(string $settings)
	{
		//Достаем настройки
		$settings = Convert::textUnescape($settings);
		$settings = @json_decode($settings, true);

		//Проверяем на наличие ошибок при декодировании настроек
		if( !$settings )
		{
			return false;
		}

		return $settings;
	}

	//*********************************************************************************

	/**
	 * @param $sandboxKey - Ключ включения режима sandbox
	 *
	 * @return string Url
	 */
	private function getUrl($sandboxKey)
	{
		$url = "https://www.paypal.com/";

		if (Func::isOne($sandboxKey))
		{
			$url = "https://www.sandbox.paypal.com/";
		}

		return $url;
	}

	//*********************************************************************************

	/**
	 * @param $sandboxKey - Ключ включения режима sandbox
	 * @param $v - версия api. По умолчанию: v1
	 *
	 * @return string ApiUrl
	 */
	private function getApiUrl($sandboxKey, $v = "v1")
	{
		$url = "https://api-m.paypal.com/".$v."/";

		if (Func::isOne($sandboxKey))
		{
			$url = "https://api-m.sandbox.paypal.com/".$v."/";
		}

		return $url;
	}

	//*********************************************************************************
}

?>