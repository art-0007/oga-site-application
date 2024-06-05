<?php

class CSearch extends CMainInit
{
	/*********************************************************************************/
	/*********************************************************************************/

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		$this->setJavaScript();
		$this->init();
	}

	/*********************************************************************************/

 	private function init()
 	{
		$data = array
		(
			"productListBlock" => $this->getProductListBlockHtml(),
			//"searchPageListBlock" => $this->getSearchListPageBlockHtml(),
		);

		//Page Title
		$this->html["pageTitle"] = $this->getPageTitle();
		//Выводим контент страницы
 		$this->html["content"] = $this->objSTemplate->getHtml("search", "content", $data);
 	}

	//*********************************************************************************

	private function getPageTitle()
	{
		$data = array
  		(
  			"id" => 0,
  			"pageTitle" => "Результаты поиска по фразе \"".$this->vars["searchString"]."\"",
  			"controllerId" => 0,
  		);

  		return $this->objSTemplate->getHtml("pageTitle", "content", $data);
	}

	//*********************************************************************************

	private function getProductListBlockHtml()
	{
		$objSearch = Search::getInstance();
		$objDataList = OfferList::getInstance();
		$html = "";

		if (false === ($res = $objSearch->getDataList($this->vars["searchString"])))
		{
			return $this->objSTemplate->getHtml("data", "productList_empty");
		}

		return $objDataList->getDataListHtml($res);
	}

	//*********************************************************************************

	private function setJavaScript()
	{
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$this->objValidation->vars["searchString"] = "";

		if (isset($_GET["searchString"]))
		{
			$this->objValidation->vars["searchString"] = $_GET["searchString"];
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	/*********************************************************************************/
}

?>