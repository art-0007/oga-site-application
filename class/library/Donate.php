<?php

class Donate extends Base
{
	/** @var Donate */
	private static $obj = null;

	/*********************************************************************************/

	protected function __construct()
	{
		parent::__construct();
	}

	/*********************************************************************************/

	private function __clone()
	{
	}

	/*********************************************************************************/

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new Donate();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function getHtml_donateBlock()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("donate"));

		if (false === $articleCatalogInfo OR 0 === (int)$articleCatalogInfo["showKey"])
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

		foreach($res AS $row)
		{
			if (0 === (int)$row["addField_2"])
			{
				continue;
			}

			$data =
			[
				"id" => $row["id"],
				"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
				"altTitle" => Convert::textUnescape($row["title"], true),
				"title" => Convert::textUnescape($row["title"]),
				"href" => Convert::textUnescape($row["addField_lang_1"]),
			];

			$html .= $this->objSTemplate->getHtml("donate", "donateListItem", $data);
		}

		$data =
		[
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
			"donateList" => $html,
		];

		return $this->objSTemplate->getHtml("donate", "donateBlock", $data);
	}

	//*********************************************************************************

	public function getHtml_donateBlock2()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("donate"));

		if (false === $articleCatalogInfo OR 0 === (int)$articleCatalogInfo["showKey"])
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

		foreach($res AS $row)
		{
			if (0 === (int)$row["addField_2"])
			{
				continue;
			}

			$data =
			[
				"id" => $row["id"],
				"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
				"altTitle" => Convert::textUnescape($row["title"], true),
				"title" => Convert::textUnescape($row["title"]),
				"href" => Convert::textUnescape($row["addField_lang_1"]),
			];

			$html .= $this->objSTemplate->getHtml("donate", "donateListItem2", $data);
		}

		$data =
		[
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
			"donateList" => $html,
		];

		return $this->objSTemplate->getHtml("donate", "donateBlock2", $data);
	}

	/*********************************************************************************/
}

?>