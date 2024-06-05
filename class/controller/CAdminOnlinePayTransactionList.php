<?php

class CAdminOnlinePayTransactionList extends CMainAdminFancyBoxInit
{
	//*********************************************************************************

	private static int $amountOnPage = 20;

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
		$data =
		[
  			"pageTitleH1" => "Список транзакций онлайн оплаты",
  			"toolbarButton" => $this->objSTemplate->getHtml("adminOnlinePayTransaction", "toolbarButton"),
  			"onlinePayTransactionList" => $this->getHtml_onlinePayTransactionList(),
		    "paginationList" => $this->getPaginationListHtml(),
		];

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminOnlinePayTransaction", "content", $data);
 	}

	//*********************************************************************************

	private function getHtml_onlinePayTransactionList()
	{
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();
		$objMOnlinePayTransactionRequest = MOnlinePayTransactionRequest::getInstance();
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$parameterArray =
		[
			"donateIdArray" => [$this->vars["donateId"]],
			"start" => ($this->vars["page"] - 1) * self::$amountOnPage,
			"amount" => self::$amountOnPage,
		];

		if (false === ($res = $objMOnlinePayTransaction->getList($parameterArray)))
		{
			return $this->objSTemplate->getHtml("adminOnlinePayTransaction", "onlinePayTransactionList_empty");
		}

		$count = 0;
		foreach ($res AS $row)
		{
			$count++;

			$data =
	   		[
			    "zebra" => (0 === ($count % 2)) ? "zebra" : "",
			    "id" => $row["id"],
			    "uniqueId" => Convert::textUnescape($row["uniqueId"]),
			    "status" => EOnlinePayTransactionStatus::titleArray[$row["status"]],
	   			"date" => date("Y-m-d / H:i:s", $row["time"]),
	   			"requestAmount" => $objMOnlinePayTransactionRequest->getAmountByOnlinePayTransactionId($row["id"]),
	   		];
	   		$html .= $this->objSTemplate->getHtml("adminOnlinePayTransaction", "onlinePayTransactionListItem", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function getPaginationListHtml()
	{
		$objMOnlinePayTransaction = MOnlinePayTransaction::getInstance();
		$objPagination = Pagination::getInstance();

		$parameterArray =
		[
			"donateIdArray" => [$this->vars["donateId"]],
		];

		$pageAmount = (int)ceil($objMOnlinePayTransaction->getAmount($parameterArray) / self::$amountOnPage);

		return $objPagination->getPaginationList("/admin/online-pay-transaction/list/", $this->vars["page"], $pageAmount);
	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-online-pay-transaction-list.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMDonate = MDonate::getInstance();
		$this->objValidation->newCheck();

		$this->objValidation->vars["page"] = 1;

		//-------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [donateId]",
			Validation::isNum => "Некоректные данные [donateId]",
		];
		$this->objValidation->checkVars("donateId", $rules, $_GET);

		//Проверяем существование с таким id
		if (false === $objMDonate->isExist($this->objValidation->vars["donateId"]))
		{
			$this->objSOutput->critical("Доната с таким id не существует [".$this->objValidation->vars["donateId"]."]");
		}

		//-----------------------------------------------------------------------------------

		if (isset($_GET["page"]))
		{
			$this->objValidation->vars["page"] = $_GET["page"];
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>