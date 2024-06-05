<?php

class CAdminOnlinePayTransactionRequestView extends CMainAdminFancyBoxInit
{
	//*********************************************************************************
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		//$this->setCSS();
		$this->setJavaScript();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$objMOnlinePayTransactionRequest = MOnlinePayTransactionRequest::getInstance();


		if (false === $onlinePayTransactionRequestInfo = $objMOnlinePayTransactionRequest->getInfo($this->vars["onlinePayTransactionRequestId"]))
		{
			$this->objSOutput->critical("Ошибка выборки информации о запросе из БД [".$this->vars["onlinePayTransactionRequestId"]."]");
		}

		$data =
		[
			"onlinePayTransactionId" => $onlinePayTransactionRequestInfo["onlinePayTransaction_id"],
		];
		$toolbarButton = $this->objSTemplate->getHtml("adminOnlinePayTransactionRequest", "toolbarButton_view", $data);

		$serverData = "-";

		//Если данные не пусты
		if (!Func::isEmpty($onlinePayTransactionRequestInfo["serverData"]))
		{
			//Если данные в корректном JSON формате, то преобразуем его массив, а за тем выводим в форматированном виде

			//Пытаем декодировать данные
			if (null !== ($serverDataArray = @json_decode(Convert::textUnescape($onlinePayTransactionRequestInfo["serverData"]), true)))
			{
				//Данные имеют корректный JSON формат
				//Преобразуем обратно в JSON, но в удобном читаемом виде
				$serverData = json_encode($serverDataArray, JSON_PRETTY_PRINT);

				//Заменяем символы перехода не следующую строку на неразрыные пробелы
				$serverData = strtr($serverData, ["\n" => "<br/ >&nbsp;&nbsp;&nbsp;&nbsp;"]);
			}
			else
			{
				//Данные НЕ имеют корректный JSON формат
				//Выводим как есть
				$serverData = $onlinePayTransactionRequestInfo["serverData"];
			}
		}

		$data =
		[
  			"pageTitleH1" => "Содержимое запроса",
		    "toolbarButton" => $toolbarButton,

  			"serverData" => $serverData,
		];

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminOnlinePayTransactionRequest", "content_view", $data);
 	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		//$this->objJavaScript->addJavaScriptFile("/js/admin/admin-slider-image.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMOnlinePayTransactionRequest = MOnlinePayTransactionRequest::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [onlinePayTransactionRequestId]",
			Validation::isNum => "Некоректные данные [onlinePayTransactionRequestId]",
		];
		$this->objValidation->checkVars("onlinePayTransactionRequestId", $rules, $_GET);

		//Проверяем существование с таким id
		if (false === $objMOnlinePayTransactionRequest->isExist($this->objValidation->vars["onlinePayTransactionRequestId"]))
		{
			$this->objSOutput->critical("Запроса транзакции с таким id не существует [".$this->objValidation->vars["onlinePayTransactionRequestId"]."]");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>