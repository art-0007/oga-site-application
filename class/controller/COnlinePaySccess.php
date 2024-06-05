<?php

class COnlinePaySccess extends CMainInit
{
	/*********************************************************************************/
	/*********************************************************************************/

	public function __construct()
	{
		parent::__construct();

		//$this->setInputVars();
		$this->setJavaScript();
		$this->init();
	}

	/*********************************************************************************/

 	private function init()
 	{
		$objMPage = MPage::getInstance();
		//Достаем информацию о странице
		$pageInfo = $objMPage->getInfo($objMPage->getIdByDevName(EPageDevName::onlinePaySuccess));

		$data =
		[
			"id" => $pageInfo["id"],
			"text" => Convert::textUnescape($pageInfo["text"]),
		];

		//Page Title
		$this->html["pageTitle"] = $this->getPageTitle($pageInfo);
		//Выводим контент страницы
        $this->html["content"] = $this->objSTemplate->getHtml("staticPage", "content_".EPageDevName::onlinePaySuccess, $data);
 	}

	//*********************************************************************************

	private function getPageTitle($pageInfo)
	{
		$data =
		[
			"id" => $pageInfo["id"],
			"pageTitle" => (!empty($pageInfo["pageTitle"]) ? Convert::textUnescape($pageInfo["pageTitle"]) : Convert::textUnescape($pageInfo["title"])),
			"controllerId" => 2,
		];

		return $this->objSTemplate->getHtml("pageTitle", "content", $data);
	}

	//*********************************************************************************

	private function setJavaScript()
	{
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMPage = MPage::getInstance();

		//Достаем ID страници по ее pageUrlName
		$this->vars["pageId"] = $objMPage->getIdByUrlName($_GET["pageUrlName"]);

		//Если ID страницы не существует то выводим ошибку
		if
		(
			false === $this->vars["pageId"]
			OR
			0 === Func::mb_strcmp("index", $_GET["pageUrlName"])
		)
		{
			$this->showPage404Key = true;
			return;
		}
	}

	/*********************************************************************************/
}

?>