<?php

class Header extends Base
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
			self::$obj = new Header();
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
		$objActiveLinkClass = ActiveLinkClass::getInstance();
		//$searchString = "";
		//
		//if (isset($_GET["searchString"]))
		//{
		//	$searchString = $_GET["searchString"];
		//}

		$data =
		[
			//"serviceSubMenuList" => $this->getHtml_serviceSubMenuList(),
			"socialBlock" => $this->getHtml_socialBlock(),
			//"profileBlock" => $this->getHtml_profileBlock(),
			//"searchString" => $searchString,
			"langBlock" => $this->getHtml_langList(),
		];

		$data = array_merge($data, $objActiveLinkClass->getActiveLinkClass());

		$this->html = $this->objSTemplate->getHtml("header", "content", $data);
	}

	//*********************************************************************************

	private function getHtml_serviceSubMenuList()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("service"));

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
				"activeClass" => "",
				"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
				"href" => "/service/".$row["urlName"]."/",
				"title" => Convert::textUnescape($row["title"]),
			];

			$html .= $this->objSTemplate->getHtml("header", "subMenuListItem", $data);
		}

		$data =
		[
			"subMenuList" => $html,
		];

		return $this->objSTemplate->getHtml("header", "subMenuListBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_socialBlock()
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

		$data =
		[
			"socialNetworkList" => $html,
		];

		return $this->objSTemplate->getHtml("header", "socialBlock", $data);
	}

	//*********************************************************************************

	private function getHtml_profileBlock()
	{
		$objAuthorizationCheck = AuthorizationCheck::getInstance();

		if($objAuthorizationCheck->isUserAuthorized())
		{
			$data = array
			(
				"userEmail" => GLOB::$AUTHORIZATION["email"],
			);

			$html = $this->objSTemplate->getHtml("header", "authorizationUser", $data);
		}
		else
		{
			$html = $this->objSTemplate->getHtml("header", "notAuthorizationUser");
		}

		$data =
		[
			"linkList" => $html,
		];

		return $this->objSTemplate->getHtml("header", "profileBlock", $data);

	}

	//*********************************************************************************

	private function getHtml_langList()
	{
		$objMLang = MLang::getInstance();

		if (false === ($res = $objMLang->getList()))
		{
			$this->objSOutput->critical("Ошибка выборки языков из базы данных (список не должен быть пустым)");
		}

		if (1 === count($res))
		{
			return "";
		}

		//Перебираем список языков и формируем их html
		$html = "";

		foreach($res AS $row)
		{
			$data =
    		[
    			"langId" => $row["id"],
    			"name" => $row["name"],
    			"code" => $row["code"],
    		];

			if((int)$row["id"] === (int)GLOB::$langId)
			{
				$html .= $this->objSTemplate->getHtml("header", "langListItem_active", $data);
			}
			else
			{
				$html .= $this->objSTemplate->getHtml("header", "langListItem", $data);
			}
		}

		$data =
		[
			"activeLangCode" => $objMLang->getCode(GLOB::$langId),
			"langList" => $html,
		];
		return $this->objSTemplate->getHtml("header", "langBlock", $data);
	}

	//*********************************************************************************

}


?>