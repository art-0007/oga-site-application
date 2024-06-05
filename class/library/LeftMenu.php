<?php

class LeftMenu extends Base
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
			self::$obj = new LeftMenu();
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
		$data = array
  		(
  			"catalogList" => $this->getHtml_catalogBlock(),
  			//"newsList" => $this->getNewsListHtml(),
  		);

		$this->html = $this->objSTemplate->getHtml("leftMenu", "content", $data);
	}

	//*********************************************************************************

	private function getHtml_catalogBlock()
	{
		return $this->getHtml_catalogList(0);
	}

	//*********************************************************************************

	private function getHtml_catalogList($catalogId)
	{
		$objMCatalog = MCatalog::getInstance();
		$html = "";
		$catalogId_get = 0;

		$parameterArray =
		[
			"catalogIdArray" => [$catalogId],
			"showKey" => 1,
		];

		if(false === ($res = $objMCatalog->getList($parameterArray)))
		{
			return $this->objSTemplate->getHtml("leftMenu", "catalogList_empty");
		}

		$parentsArray = [];

		if (isset($_GET["catalogUrlName"]))
		{
			$catalogId_get = $objMCatalog->getIdByUrlName($_GET["catalogUrlName"]);
			$parentsArray = $objMCatalog->getParents($catalogId_get);
		}

		foreach($res AS $row)
  		{
			$data =
	  		[
	  			"id" => $row["id"],
	  			"href" => "/".$row["urlName"]."/",
	  			"title" => Convert::textUnescape($row["title"], false),
	  			"activeClass" => ((int)$catalogId_get === (int)$row["id"]) ? "active" : "",
	  			"openClass" => (in_array((int)$row["id"], $parentsArray)) ? "open" : "",
	  		];

		    if ($objMCatalog->hasChild($row["id"]))
		    {
			    $data["subCatalogList"] = $this->getHtml_catalogList($row["id"]);

			    $html .= $this->objSTemplate->getHtml("leftMenu", "catalogListSubItem", $data);
		    }
		    else
		    {
			    $html .= $this->objSTemplate->getHtml("leftMenu", "catalogListItem", $data);
		    }
  		}

		return $html;
	}
	//*********************************************************************************

	private function getNewsListHtml()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("news"));

		$html = "";
		$newsId = 0;

  		if (isset($_GET["newsId"]))
  		{
  			$newsId = $_GET["newsId"];
  		}


		if
		(
			false === $articleCatalogInfo
			OR
			false === ($res = $objMArticle->getList($articleCatalogInfo["id"], 0, GLOB::$SETTINGS["newsAmountInLeftMenu"], $articleCatalogInfo["orderInCatalog"]))
		)
		{
			return $this->objSTemplate->getHtml("leftMenu", "newsList_empty");
		}
		foreach($res AS $row)
  		{
			$data = array
	  		(
	  			"id" => $row["id"],
	  			"href" => (!empty($row["urlName"])) ? "/news/".$row["urlName"]."/" : "/news/".$row["id"]."/",
	  			"title" => Convert::textUnescape($row["title"], false),
	  			"addClass" => "",
	  		);

			if ((int)$newsId === (int)$row["id"])
			{
				$data["addClass"] = "active";
			}

			$html .= $this->objSTemplate->getHtml("leftMenu", "newsListItem", $data);

  		}

		return $html;
	}


	//*********************************************************************************
}

?>