<?php

class COnlinePayResult extends Base
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
		$objSTemplate = STemplate::getInstance();
		
		$this->writeLog();
		
		//Получаем devName страницы
		$pageDevName = $_GET["pdn"] ?? $this->getPageDevName($this->vars["tuId"]);
		
		if( !is_null($pageDevName) )
		{
			//Редирект на страницу success или error
			$this->objSResponse->redirect($this->getPageUrl($pageDevName), SERedirect::movedPermanently);
		}

		//Генерируем html страницы ожидания оплаты
		$html = $objSTemplate->getHtml("onlinePayResultWait", "page_content");
		
		$this->objSOutput->ok($html);
	}

	//*********************************************************************************
	
	/**
	 * Возращает devName страницы для перенаправления пользователя
	 *
	 * @param string $onlinePayTransactionUniqueId
	 *
	 * @return string|null
	 */
	private function getPageDevName(string $onlinePayTransactionUniqueId): ?string
	{
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();
		$pageDevName = null;
		
		//Получаем id транзакции по ее уникальному идентификатору
		if( false === ($onlinePayTransactionId = $objMOnlinePayTransaction->getIdByUniqueId($onlinePayTransactionUniqueId)) )
		{
			$this->objSOutput->error("Error: transaction id by its unique id not found");
		}
		
		//Достаем информацию о транзакции онлайн оплаты
		if( false === ($onlinePayTransactionInfo = $objMOnlinePayTransaction->getInfo($onlinePayTransactionId)) )
		{
			$this->objSOutput->error("Error: Unable to get transaction information");
		}
		
		if( EOnlinePayTransactionStatus::ok === (int)$onlinePayTransactionInfo["status"] )
		{
			$pageDevName = EPageDevName::onlinePaySuccess;
		}
		elseif( EOnlinePayTransactionStatus::error === (int)$onlinePayTransactionInfo["status"] )
		{
			$pageDevName = EPageDevName::onlinePayError;
		}
		
		return $pageDevName;
	}
	
	//*********************************************************************************
	
	/**
	 * Возвращает URL страницы
	 *
	 * @param $pageDevName
	 *
	 * @return string
	 */
	private function getPageURL($pageDevName): string
	{
		$objMPage = MPage::getInstance();
		
		//Достаем ID страницы по devName
		if( false === ($pageId = $objMPage->getIdByDevName($pageDevName)) )
		{
			$this->objSOutput->error("Error: Unable to get page id");
		}
		
		//Достаем информацию странице
		if( false === ($pageInfo = $objMPage->getInfo($pageId)) )
		{
			$this->objSOutput->error("Error: Unable to get page url");
		}

		return "/".$pageInfo["urlName"]."/";
	}
	
	//*********************************************************************************
	
	private function writeLog($text = "")
	{
		$data = "=========== ".date("d-m-Y H:i:s")." =========== \r\n";
		$data .= print_r($_POST, true);
		$data .= print_r($_GET, true);
		if( !empty($text) )
		{
			$data .= $text."\r\n";
		}
		$data .= "=========== end =========== \r\n\r\n";
		
		file_put_contents(PATH."/".TMP_DIR_NAME."/onlinePayResult.log", $data, FILE_APPEND);
		
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
			Validation::exist => "Ошибка: tuId",
		];
		$this->objValidation->checkVars("tuId", $rules, $_GET);
		
		$this->vars["tuId"] = $this->objValidation->vars["tuId"];
		
		/*********************************************************************/
	}

	//*********************************************************************************

}

?>