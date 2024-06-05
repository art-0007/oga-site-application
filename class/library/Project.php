<?php

class Project extends Base
{
	/*********************************************************************************/

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
			self::$obj = new Project();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function getHtml_projectBlock($projectListItemTemplateType = 1, $onIndexKey = null)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("project"));

		if (false === $articleCatalogInfo OR 0 === (int)$articleCatalogInfo["showKey"])
		{
			return "";
		}

		if (false === ($articleCatalogIdArray = $objMArticleCatalog->getList_id($articleCatalogInfo["id"])))
		{
			$articleCatalogIdArray = [$articleCatalogInfo["id"]];
		}

		foreach ($articleCatalogIdArray AS $key => $articleCatalogId)
		{
			$html .= $this->getHtml_projectList_catalog($articleCatalogId, $projectListItemTemplateType, $onIndexKey);
			$html .= $this->getHtml_projectList_article($articleCatalogId, $projectListItemTemplateType, $onIndexKey);
		}

		$data =
		[
			"articleCatalogTitle" => Convert::textUnescape($articleCatalogInfo["title"]),
			"projectList" => $html,
		];

		return $this->objSTemplate->getHtml("project", "projectBlock", $data);
	}

	//*********************************************************************************

	public function getHtml_projectBlock2($articleCatalogId, $projectListItemTemplateType = 1, $onIndexKey = null, $showChildList = true)
	{
		$html = $this->getHtml_projectList($articleCatalogId, $projectListItemTemplateType, $onIndexKey, $showChildList);

		if (!Func::isEmpty($html))
		{
			$data =
			[
				"projectList" => $html,
			];

			$html = $this->objSTemplate->getHtml("project", "projectBlock2", $data);
		}

		return $html;
	}

	//*********************************************************************************

	public function getHtml_projectList($articleCatalogId, $projectListItemTemplateType = 1, $onIndexKey = null, $showChildList = true)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objArticleCatalog = ArticleCatalog::getInstance();
		$html = "";

		if (!$objArticleCatalog->isSuitableCatalog($articleCatalogId, "project"))
		{
			return "";
		}

		$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

		if (false === $articleCatalogInfo OR 0 === (int)$articleCatalogInfo["showKey"])
		{
			return "";
		}

		$articleCatalogIdArray = [$articleCatalogId];

		//Если это ИД каталога проекта до достаем список вложенных (Фильров)
		if (Func::isCmp("project", $articleCatalogInfo["devName"]))
		{
			if (false === ($articleCatalogIdArray = $objMArticleCatalog->getList_id($articleCatalogInfo["id"])))
			{
				$articleCatalogIdArray = [$articleCatalogInfo["id"]];
			}
		}

		foreach ($articleCatalogIdArray AS $key => $articleCatalogId)
		{
			if ($objMArticleCatalog->hasChild($articleCatalogId))
			{
				$html .= $this->getHtml_projectList_catalog($articleCatalogId, $projectListItemTemplateType, $onIndexKey, $showChildList);
			}
			else
			{
				$html .= $this->getHtml_projectList_article($articleCatalogId, $projectListItemTemplateType, $onIndexKey);
			}
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_projectList_catalog($articleCatalogId, $projectListItemTemplateType = 1, $onIndexKey = null, $showChildList = true)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

		$parameterArray =
		[
			"articleCatalogIdArray" => [$articleCatalogInfo["id"]],
			"orderType" => $articleCatalogInfo["orderInCatalog"],
			"showKey" => 1,
		];

		if (false === ($res = $objMArticleCatalog->getList($parameterArray)))
		{
			return "";
		}

		$counter = 0;

		foreach($res AS $row)
		{
			$counter++;

			$subArticleCatalogInfo = $objMArticleCatalog->getInfo($row["articleCatalog_id"]);

			$donatedWidth = 0;

			if ((float)$row["addField_1"] > 0 AND (float)$row["addField_2"])
			{
				$donatedWidth = (float)$row["addField_2"] * 100 / (float)$row["addField_1"];
			}

			$donatedBlock = "";
			$donateBtn = "";

			if (1 === (int)$row["addField_lang_4"])
			{
				$data =
				[
					"cost" => number_format((float)$row["addField_1"], 0, ".", "."),
					"donated" => number_format((float)$row["addField_2"], 0, ".", "."),
					"donatedWidth" => number_format($donatedWidth, 2, ".", ""),
				];
				$donatedBlock = $this->objSTemplate->getHtml("project", "donatedBlock", $data);

				if (Func::isEmpty($row["addField_lang_5"]))
				{
					if (!Func::isEmpty($row["addField_3"]) AND $objMArticle->isExist($row["addField_3"]))
					{
						$articleInfo = $objMArticle->getInfo($row["addField_3"]);

						$donateBtn = $this->objSTemplate->getHtml("project", "donateBtn_2", ["href" => Convert::textUnescape($articleInfo["addField_lang_1"])]);
					}
					else
					{
						//$donateBtn = $this->objSTemplate->getHtml("project", "donateBtn_1", ["projectCatalogId" => $row["id"], "projectId" => null]);
					}
				}
				else
				{
					$donateBtn = $this->objSTemplate->getHtml("project", "donateBtn_2", ["href" => Convert::textUnescape($row["addField_lang_5"])]);
				}
			}

			$data =
			[
				"addClass" => (Func::isOne($onIndexKey)) ? "nbd" : "",
				"id" => $row["id"],
				"articleCatalogImg" => Convert::textUnescape($subArticleCatalogInfo["addField_2"]),
				"articleCatalogTitle" => Convert::textUnescape($subArticleCatalogInfo["title"]),
				"imgSrc1" => GLOB::$SETTINGS["articleCatalogImgDir"]."/".$row["fileName1"],
				"href" => "/project/".$row["urlName"]."/",
				"altTitle" => Convert::textUnescape($row["title"], true),
				"title" => Convert::textUnescape($row["title"]),
				"description" => Convert::textUnescape($row["description"]),

				"donatedBlock" => $donatedBlock,
				"donateBtn" => $donateBtn,
			];

			if (!is_null($onIndexKey) AND Func::isOne($onIndexKey))
			{
				if (Func::isOne($row["addField_4"]))
				{
					$html .= $this->objSTemplate->getHtml("project", "projectListItem".$projectListItemTemplateType, $data);
				}
			}
			else
			{
				$html .= $this->objSTemplate->getHtml("project", "projectListItem".$projectListItemTemplateType, $data);
			}

			if ($showChildList)
			{
				if ($objMArticleCatalog->hasChild($row["id"]))
				{
					$html .= $this->getHtml_projectList_catalog($row["id"], $projectListItemTemplateType, $onIndexKey);
				}
				else
				{
					$html .= $this->getHtml_projectList_article($row["id"], $projectListItemTemplateType, $onIndexKey);
				}
			}
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_projectList_article($articleCatalogId, $projectListItemTemplateType = 1, $onIndexKey = null)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

		$parameterArray =
		[
			"articleCatalogIdArray" => [$articleCatalogInfo["id"]],
			"orderType" => $articleCatalogInfo["orderInCatalog"],
			"showKey" => 1,
			"addField" => ["addField_4" => $onIndexKey],
		];

		if (false === ($res = $objMArticle->getList($parameterArray)))
		{
			return "";
		}

		$counter = 0;

		foreach($res AS $row)
		{
			$counter++;

			$subArticleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getParentId($row["articleCatalogId"]));

			$donatedWidth = 0;

			if ((float)$row["addField_1"] > 0 AND (float)$row["addField_2"])
			{
				$donatedWidth = (float)$row["addField_2"] * 100 / (float)$row["addField_1"];
			}

			$donatedBlock = "";
			$donateBtn = "";

			if (1 === (int)$row["addField_lang_4"])
			{
				$data =
				[
					"cost" => number_format((float)$row["addField_1"], 0, ".", "."),
					"donated" => number_format((float)$row["addField_2"], 0, ".", "."),
					"donatedWidth" => number_format($donatedWidth, 2, ".", ""),
				];
				$donatedBlock = $this->objSTemplate->getHtml("project", "donatedBlock", $data);

				if (Func::isEmpty($row["addField_lang_5"]))
				{
					if (!Func::isEmpty($row["addField_3"]) AND $objMArticle->isExist($row["addField_3"]))
					{
						$articleInfo = $objMArticle->getInfo($row["addField_3"]);

						$donateBtn = $this->objSTemplate->getHtml("project", "donateBtn_2", ["href" => Convert::textUnescape($articleInfo["addField_lang_1"])]);
					}
					else
					{
						//$donateBtn = $this->objSTemplate->getHtml("project", "donateBtn_1", ["projectCatalogId" => $row["id"], "projectId" => null]);
					}
				}
				else
				{
					$donateBtn = $this->objSTemplate->getHtml("project", "donateBtn_2", ["href" => Convert::textUnescape($row["addField_lang_5"])]);
				}
			}

			$data =
			[
				"addClass" => (Func::isOne($onIndexKey)) ? "nbd" : "",
				"id" => $row["id"],
				"articleCatalogImg" => Convert::textUnescape($subArticleCatalogInfo["addField_2"]),
				"articleCatalogTitle" => Convert::textUnescape($subArticleCatalogInfo["title"]),
				"imgSrc1" => GLOB::$SETTINGS["articleImgDir"]."/".$row["fileName1"],
				"href" => "/project/".$row["urlName"]."/",
				"altTitle" => Convert::textUnescape($row["title"], true),
				"title" => Convert::textUnescape($row["title"]),
				"description" => Convert::textUnescape($row["description"]),

				"donatedBlock" => $donatedBlock,
				"donateBtn" => $donateBtn,
			];

			if (!is_null($onIndexKey) AND Func::isOne($onIndexKey))
			{
				if (Func::isOne($row["addField_4"]))
				{
					$html .= $this->objSTemplate->getHtml("project", "projectListItem".$projectListItemTemplateType, $data);
				}
			}
			else
			{
				$html .= $this->objSTemplate->getHtml("project", "projectListItem".$projectListItemTemplateType, $data);
			}
		}

		return $html;
	}

	/*********************************************************************************/
}

?>