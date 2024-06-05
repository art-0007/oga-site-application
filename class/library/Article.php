<?php

class Article extends Base
{
	/** @var Article */
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
			self::$obj = new Article();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function getHtml_interestingBlock()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$articleCatalogInfo_blog = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("article"));

		$parameterArray =
		[
			"articleCatalogIdArray" => $articleCatalogInfo_blog["id"],
			"start" => 0,
			"amount" => GLOB::$SETTINGS["entityAmountInInterestingBlock"],
			"showKey" => 1,
		];

		$data =
		[
			"articleList" => $this->getHtml_articleList($parameterArray),
		];

		return $this->objSTemplate->getHtml("article", "interestingBlock", $data);
	}

	/*********************************************************************************/

	/**
	 * Возвращает html списка статей
	 *
	 * @param array [$parameterArray] Номер страницы
	 *
	 * @return string Сппсок статей
	 */
	public function getHtml_articleList($parameterArray)
	{
		$objMArticle = MArticle::getInstance();
		$html = "";

		if (false === ($res = $objMArticle->getList($parameterArray)))
		{
			return $this->objSTemplate->getHtml("article", "articleList_empty");
		}

		foreach ($res AS $row)
		{
			$data = array
			(
				"id" => $row["id"],
				"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
				"imgSrc2" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName2"],
				"href" => "/artile/".$row["urlName"]."/",
				"title" => Convert::textUnescape($row["title"], false),
				"altTitle" => Convert::textUnescape($row["title"], true),
				"date" => date("d.m.Y", $row["time"]),
				"description" => Convert::textUnescape($row["description"], false),
			);

			$html .= $this->objSTemplate->getHtml("article", "articleListItem", $data);
		}

		return $html;
	}

	/*********************************************************************************/

	/**
	 * Возвращает информацию о шаблоне мета данных
	 *
	 * @param int $countryId ИД странны
	 * @param int $entityId ИД сущности
	 * @param array $countryInfo Массив информации о стране
	 *
	 * @return array
	 */
	public function getCountryMetaTemplateInfo($countryId, $entityId, $countryInfo = null)
	{
		$objMCountryMetaTemplate = MCountryMetaTemplate::getInstance();

		if (is_null($countryInfo))
		{
			$objMCountry = MCountry::getInstance();

			if (false === ($countryInfo = $objMCountry->getInfo($countryId)))
			{
				return array
				(
					"id" => 0,
					"countryId" => 0,
					"entityId" => 0,
					"title" => "",
					"description" => "",
					"text" => "",
					"pageTitle" => "",
					"metaTitle" => "",
					"metaKeywords" => "",
					"metaDescription" => "",
				);
			}
		}

		$countryMetaTemplateId = $objMCountryMetaTemplate->getIdByByCountryIdAndEntityId($countryId, $entityId);

		if (false === ($countryMetaTemplateInfo = $objMCountryMetaTemplate->getInfo($countryMetaTemplateId)))
		{
			$countryMetaTemplateInfo = array
			(
				"id" => 0,
				"countryId" => $countryId,
				"entityId" => $entityId,
				"title" => EEntity::$entityTitleArray[$entityId],
				"description" => "",
				"text" => "",
				"pageTitle" => Convert::textUnescape($countryInfo["title"], false).". ". EEntity::$entityTitleArray[$entityId],
				"metaTitle" => Convert::textUnescape($countryInfo["title"], false).". ". EEntity::$entityTitleArray[$entityId],
				"metaKeywords" => "",
				"metaDescription" => "",
			);
		}

		return $countryMetaTemplateInfo;
	}

	/*********************************************************************************/
}

?>