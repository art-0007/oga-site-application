<?php

class Footer extends Base
{
	private static $obj = null;

	private $html = "";

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
			self::$obj = new Footer();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function getHtml()
	{
		return $this->html;
	}

	//*********************************************************************************

	private function init()
	{
		$data =
		[
			"socialNetworkList" => $this->getHtml_socialNetworkList(),
			"contactsAddTaxtBlock" => $this->getHtml_contactsAddTaxtBlock(),
			"curentYear" => date("Y"),
		];

		$this->html = $this->objSTemplate->getHtml("footer", "content", $data);
	}

	//*********************************************************************************

	private function getHtml_socialNetworkList()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("socialNetwork"));

		if (false === $articleCatalogInfo)
		{
			return "";
		}

		$parameterArray =
		[
			"articleCatalogIdArray" => $articleCatalogInfo["id"],
			"orderType" => $articleCatalogInfo["orderInCatalog"],
			"showKey" => 1,
		];

		if (false === ($res = $objMArticle->getList($parameterArray)))
		{
			return "";
		}

		$counter = 0;
		foreach($res AS $row)
		{
			$counter++;

			$data =
			[
				"id" => $row["id"],
				"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
				"imgSrc2" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName2"],
				"title" => Convert::textUnescape($row["title"]),
				"href" => Convert::textUnescape($row["addField_1"], true),
			];

			$html .= $this->objSTemplate->getHtml("footer", "socialNetworkListItem", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_contactsAddTaxtBlock()
	{
		$objMPage = MPage::getInstance();

		if (false === ($pageInfo = $objMPage->getInfo($objMPage->getIdByDevName("contacts"))))
		{
			return "11111111111";
		}

		if (Func::isEmpty($pageInfo["description"]))
		{
			return "22222222222222";
		}

		$data =
		[
			"description" => Convert::textUnescape($pageInfo["description"]),
		];

		return $this->objSTemplate->getHtml("footer", "contactsAddTaxtBlock", $data);
	}

	//*********************************************************************************

}


?>