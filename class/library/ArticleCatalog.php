<?php

class ArticleCatalog extends Base
{
	//*********************************************************************************

	private static $obj = null;

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
			self::$obj = new ArticleCatalog();
		}

		return self::$obj;
	}

	//*********************************************************************************

	private function init()
	{

	}

	//*********************************************************************************

	public function isSuitableCatalog($articleCatalogId, $devName)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

		if (0 === Func::mb_strcmp($articleCatalogInfo["devName"], $devName))
		{
			return true;
		}

		if (0 === (int)$articleCatalogInfo["articleCatalog_id"])
		{
			return false;
		}

		return $this->isSuitableCatalog($articleCatalogInfo["articleCatalog_id"], $devName);
	}

	//*********************************************************************************

}


?>