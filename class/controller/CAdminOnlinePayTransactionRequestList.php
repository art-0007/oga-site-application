<?php

class CAdminOnlinePayTransactionRequestList extends CMainAdminFancyBoxInit
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
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();
		$objMOnlinePayTransactionRequest = MOnlinePayTransactionRequest::getInstance();

		$donateId = $objMOnlinePayTransaction->getDonateId($this->vars["onlinePayTransactionId"]);

		$data =
		[
			"donateId" => $donateId,
		];
		$toolbarButton = $this->objSTemplate->getHtml("adminOnlinePayTransactionRequest", "toolbarButton", $data);

		$data =
		[
  			"pageTitleH1" => "Запросы от системы онлайн оплаты",
		    "toolbarButton" => $toolbarButton,

  			"onlinePayTransactionRequestList" => $this->getHtml_onlinePayTransactionRequestList(),
		];

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminOnlinePayTransactionRequest", "content", $data);
 	}

	//*********************************************************************************

	private function getHtml_onlinePayTransactionRequestList()
	{
		$objMOnlinePayTransactionRequest = MOnlinePayTransactionRequest::getInstance();
		$html = "";

		if (false === ($res = $objMOnlinePayTransactionRequest->getListByOnlinePayTransactionId($this->vars["onlinePayTransactionId"])))
		{
			return $this->objSTemplate->getHtml("adminOnlinePayTransactionRequest", "onlinePayTransactionRequestList_empty");
		}

		$count = 0;
		foreach ($res AS $row)
		{
			$count++;

			$data =
	   		[
	   			"id" => $row["id"],
	   			"date" => date("Y-m-d / H:i:s", $row["time"]),
	   			"zebra" => (0 === ($count % 2)) ? "zebra" : "",
	   		];

			$html .= $this->objSTemplate->getHtml("adminOnlinePayTransactionRequest", "onlinePayTransactionRequestListItem", $data);
		}

		return $html;
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
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules =
			[
				Validation::exist => "Недостаточно данных [onlinePayTransactionId]",
				Validation::isNum => "Некоректные данные [onlinePayTransactionId]",
			];
		$this->objValidation->checkVars("onlinePayTransactionId", $rules, $_GET);

		//Проверяем существование с таким id
		if (false === $objMOnlinePayTransaction->isExist($this->objValidation->vars["onlinePayTransactionId"]))
		{
			$this->objSOutput->critical("Транзакции с таким id не существует [".$this->objValidation->vars["onlinePayTransactionId"]."]");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>