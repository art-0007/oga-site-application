<?php

class Form extends Base
{
	private static $obj = null;

	private $pageClass = "";

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
			self::$obj = new Form();
		}

		return self::$obj;
	}

	//*********************************************************************************

	private function init()
	{
		$this->pageClass = strtolower(mb_substr($this->objSRouter->className, 1));
	}

	//*********************************************************************************

	public function getHtml_authorizationForm($selector = "")
	{
		$data =
		[
			"selector" => $selector,
			"pageClass" => $this->pageClass,
		];

		return $this->objSTemplate->getHtml("form", "authorizationForm", $data);
	}

	//*********************************************************************************

	public function getHtml_registrationForm($selector = "")
	{
		$data =
		[
			"selector" => $selector,
			"pageClass" => $this->pageClass,
		];

		return $this->objSTemplate->getHtml("form", "registrationForm", $data);
	}

	//*********************************************************************************

	public function getHtml_contactUsForm($selector = "")
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("selectRequest"));

		if (false !== $articleCatalogInfo)
		{
			$parameterArray =
			[
				"articleCatalogIdArray" => $articleCatalogInfo["id"],
				"orderType" => $articleCatalogInfo["orderInCatalog"],
				"showKey" => 1,
			];

			if (false !== ($res = $objMArticle->getList($parameterArray)))
			{
				foreach($res AS $row)
				{
					$html .= "<option value='".$row["id"]."'>".Convert::textUnescape($row["title"])."</option>";
				}
			}
		}

		$data =
		[
			"selector" => $selector,
			"pageClass" => $this->pageClass,
			"selectRequestList" => $html,
		];

		return $this->objSTemplate->getHtml("form", "contactUsForm", $data);
	}

	//*********************************************************************************

	public function getHtml_registerForEventForm($selector = "", $articleId = 0)
	{
		$data =
		[
			"selector" => $selector,
			"articleId" => $articleId,
			"pageClass" => $this->pageClass,
		];

		return $this->objSTemplate->getHtml("form", "registerForEventForm", $data);
	}

	//*********************************************************************************

	public function getHtml_subscribeForm($selector = "")
	{
		$data =
		[
			"selector" => $selector,
			"pageClass" => $this->pageClass,
		];

		return $this->objSTemplate->getHtml("form", "subscribeForm", $data);
	}

	//*********************************************************************************
}
?>