<?php

class LibStripe extends OnlinePayTransaction
{
	//*********************************************************************************

	//Массив соответствий devName языка платформы, коду в системе оплаты
	private static array $langArray = [ "en" => "en", "ru" => "ru" ];

	/** @var ?LibStripe  */
	private static ?LibStripe $obj = null;

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
			self::$obj = new LibStripe();
		}

		return self::$obj;
	}

	//*********************************************************************************

	/**
	 * Возвращает информацию о сессии оплаты
	 *
	 * @param $onlinePayTransactionId
	 *
	 * @return false|array
	 */
	public function getSessionRetrieve($onlinePayTransactionId)
	{
		$objMDonate = MDonate::getInstance();
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();

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

		if( false === ($responseArray = $this->sessionRetrieveRequest($onlinePaySystemSettings, $onlinePayTransactionInfo["onlinePaySystemUId"])) )
		{
			return false;
		}

		//Проверяем обязательную переменную
		if( !isset($responseArray["status"]) )
		{
			return false;
		}

		return $responseArray;
	}

	//*********************************************************************************

	/**
	 * Возвращает ссылку на страницу оплаты Stripe
	 *
	 * @param $onlinePayTransactionId - id транзакции онлайн оплаты
	 *
	 * @return array|bool - массив данных или fasle в случае ошибки
	 */
	public function getPaySessionURL($onlinePayTransactionId)
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

		//Массив данных для создания платежа в PayPal
		$postData =
		[
			"mode" => "payment",
			"locale" => "en",
			"line_items" =>	$this->getDataArray($donateInfo),
			"success_url" => GLOB::$FRONT_URL."/online-pay/process/?opsId=".EOnlinePaySystem::stripe."&tuId=".$onlinePayTransactionInfo["uniqueId"],
		];

		if( false === ($responseArray = $this->createSessionRequest($onlinePaySystemSettings, $postData)) )
		{
			return false;
		}

		//Проверяем наличие ID и в ответе
		if( !isset($responseArray["id"]) )
		{
			return false;
		}

		//Прописываем идентификатор транзакции в системе онлайн оплаты
		$this->setOnlineSystemTransactionUId($onlinePayTransactionInfo["id"], $responseArray["id"]);

		return $responseArray["url"];
	}

	//*********************************************************************************

	/**
	 * Получает из stripe информацию о сессии оплаты
	 *
	 * @param array $onlinePayTypeSettings
	 * @param string $onlinePaySystemUId
	 *
	 * @return bool|array
	 */
	private function sessionRetrieveRequest(array $onlinePayTypeSettings, string $onlinePaySystemUId)
	{
		//Формируем канал
		$channel = curl_init();

		//Устанавливаем опции
		curl_setopt($channel, CURLOPT_URL, $this->getApiUrl()."checkout/sessions/".$onlinePaySystemUId);
		curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($channel, CURLOPT_HEADER, false);
		curl_setopt($channel, CURLOPT_FORBID_REUSE, false);
		curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($channel, CURLOPT_SSL_VERIFYSTATUS, false);
		curl_setopt($channel, CURLOPT_HTTPHEADER,
        [
            "Authorization: Bearer ".$onlinePayTypeSettings["secret_key"]
        ]);

		//Выполняем запрос
		if( false === ($response = curl_exec($channel)) )
		{
			return false;
		}

		//Закрываем соединение
		curl_close($channel);

		//Преобразуем ответ в массив
		$responseArray = @json_decode($response, true);

		if( !$responseArray )
		{
			return false;
		}

		return $responseArray;
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
	 * Отсылает запрос формирования сессии и возвращает результат запроса
	 *
	 * @param array $onlinePaySystemSettings
	 * @param array $postData
	 *
	 * @return false|array
	 */
	private function createSessionRequest(array $onlinePaySystemSettings, array $postData)
	{
		//Формируем канал
		$channel = curl_init();

		//Устанавливаем опции
		curl_setopt($channel, CURLOPT_URL, $this->getApiUrl()."checkout/sessions");
		curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($channel, CURLOPT_HEADER, false);
		curl_setopt($channel, CURLOPT_FORBID_REUSE, false);
		curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($channel, CURLOPT_SSL_VERIFYSTATUS, false);
		curl_setopt($channel, CURLOPT_HTTPHEADER,
		            [
			            "Authorization: Bearer ".$onlinePaySystemSettings["secret_key"]
		            ]);
		curl_setopt($channel, CURLOPT_POSTFIELDS, http_build_query($postData));

		//Выполняем запрос
		if( false === ($response = curl_exec($channel)) )
		{
			return false;
		}

		//Закрываем соединение
		curl_close($channel);

		//Преобразуем ответ в массив
		$responseArray = @json_decode($response, true);

		if( !$responseArray )
		{
			return false;
		}

		return $responseArray;
	}

	//*********************************************************************************

	/**
	 * Записывает ИД транзакции в системе оплаты в БД
	 *
	 * @param int $onlinePayTransactionId
	 * @param string $onlinePaySystemTransactionUId
	 *
	 * @return void
	 */
	private function setOnlineSystemTransactionUId(int $onlinePayTransactionId, string $onlinePaySystemTransactionUId): void
	{
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();

		//Заносим ID транзакции Stripe в БД
		$data =
		[
			"onlinePaySystemUId" => $onlinePaySystemTransactionUId
		];
		$objMOnlinePayTransaction->edit($onlinePayTransactionId, $data);
	}

	//*********************************************************************************

	/**
	 * Возвращает на URL API
	 *
	 * @return string ApiUrl
	 */
	private function getApiUrl()
	{
		return "https://api.stripe.com/v1/";
	}

	//*********************************************************************************

	/**
	 * Возвращает список товаров
	 *
	 * @param array $orderId
	 *
	 * @return array
	 */
	private function getDataArray(array $donateInfo): array
	{
		$objMArticle = MArticle::getInstance();
		$returnArray = [];

		//Достаем название проекта
		if( false === ($projectTitle = $objMArticle->getTitle($donateInfo["article_id"])) )
		{
			return [];
		}

		//Заполняем данные в массиве информации о товарах
		$returnArray[] =
		[
			"price_data" =>
			[
				"currency" => "usd",
				"product_data" =>
				[
					"name" => $projectTitle
				],
				"unit_amount" => Func::moneyToPrintable($donateInfo["sum"]) * 100,
			],
			"quantity" => 1,
		];

		return $returnArray;
	}

	//*********************************************************************************
}

?>