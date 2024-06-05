<?php

class CAGetMobileMenu extends CAjaxInit
{
	//*********************************************************************************
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->init();
	}

	//*********************************************************************************

 	private function init()
 	{
	    $objStaticHtml = StaticHtml::getInstance();

	    $data =
	    [
		    "phone1" => Convert::textUnescape(GLOB::$SETTINGS["phone1"], false),
		    "phone1A" => Func::toTelephoneSearch(GLOB::$SETTINGS["phone1"]),
		    "phone2" => Convert::textUnescape(GLOB::$SETTINGS["phone2"], false),
		    "phone2A" => Func::toTelephoneSearch(GLOB::$SETTINGS["phone2"]),
		    "email1" => Convert::textUnescape(GLOB::$SETTINGS["email1"], false),
		    "socialNetworkList" => $this->getHtml_socialNetworkListItem(),
	    ];

		$data =
  		[
		    "html" => $objStaticHtml->replaceInString($this->objSTemplate->getHtml("header", "mobileMenuBlock", $data)),
  		];

  		$this->objSOutput->ok("Ok", $data);
 	}

	//*********************************************************************************

	private function getHtml_socialNetworkListItem()
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

			$html .= $this->objSTemplate->getHtml("header", "socialNetworkListItem", $data);
		}

		return $html;
	}

	//*********************************************************************************
}

?>