<?php

class CADonateFormShow extends CAjaxInit
{
	//*********************************************************************************
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$objStaticHtml = StaticHtml::getInstance();

		$donationAmountArray = $this->getHtml_donationAmountList();

		$data =
		[
			"projectOptionSelect" => $this->getHtml_projectOptionSelect(),
			"donateOptionSelect" => $this->getHtml_donateOptionSelect(),
			"donationAmountList" => $donationAmountArray["list"],
			"donationAmountValue" => $donationAmountArray["value"],
		];

		$data =
		[
			"modalHtml" => $objStaticHtml->replaceInString($this->objSTemplate->getHtml("form", "donateForm", $data)),
		];

		$this->objSOutput->ok("Ок", $data);
	}

	//*********************************************************************************

	private function getHtml_projectOptionSelect()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();

		//Достаем Информацию о проекте-компании
		if (false === ($projectCompanyInfo = $objMArticle->getInfo($objMArticle->getIdByDevName("projectCompany"))))
		{
			$this->objSOutput->error("ProjectCompany does not exist");
		}

		$html = "<option value='".$projectCompanyInfo["id"]."'>".Convert::textUnescape($projectCompanyInfo["title"])."</option>";


		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("project"));

		if ($articleCatalogInfo !== false AND (int)$articleCatalogInfo["showKey"] !== 0)
		{
			if (false === ($articleCatalogIdArray = $objMArticleCatalog->getList_id($articleCatalogInfo["id"])))
			{
				$articleCatalogIdArray = [$articleCatalogInfo["id"]];
			}

			$parameterArray =
			[
				"articleCatalogIdArray" => $articleCatalogIdArray,
				"orderType" => $articleCatalogInfo["orderInCatalog"],
				"start" => 0,
				"amount" => GLOB::$SETTINGS["projectAmountOnIndex"],
				"showKey" => 1,
			];

			if (($res = $objMArticle->getList($parameterArray)) !== false)
			{
				foreach($res AS $row)
				{
					$selected = "";

					if ((int)$row["id"] === (int)$this->vars["projectId"])
					{
						$selected = "selected='selected'";
					}

					$html .= "<option value='".$row["id"]."' ".$selected.">".Convert::textUnescape($row["title"])."</option>";
				}
			}
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_donateOptionSelect()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();

		$html = "";

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("donate"));

		if (false !== $articleCatalogInfo)
		{
			$parameterArray =
				[
					"articleCatalogIdArray" => $articleCatalogInfo["id"],
					"orderType" => $articleCatalogInfo["orderInCatalog"],
					"showKey" => 1,
				];

			if
			(
				false !== $articleCatalogInfo
				AND
				false !== ($res = $objMArticle->getList($parameterArray))
			)
			{
				foreach($res AS $row)
				{
					$selected = "";
					$disabled = "";

					if ((int)$row["id"] === (int)$this->vars["donateId"])
					{
						$selected = "selected='selected'";
					}

					if (Func::isEmpty($row["addField_3"]))
					{
						continue;
						//$disabled = "disabled='disabled'";
					}

					$html .= "<option value='".$row["id"]."' ".$selected." ".$disabled.">".Convert::textUnescape($row["title"])."</option>";
				}
			}
		}

		return $html;
	}

	//*********************************************************************************

	private function getHtml_donationAmountList()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();

		$donationAmountArray =
			[
				"list" => "",
				"value" => ""
			];

		$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("donationAmount"));

		if (false !== $articleCatalogInfo)
		{
			$parameterArray =
				[
					"articleCatalogIdArray" => $articleCatalogInfo["id"],
					"orderType" => $articleCatalogInfo["orderInCatalog"],
					"showKey" => 1,
				];

			if
			(
				false !== $articleCatalogInfo
				AND
				false !== ($res = $objMArticle->getList($parameterArray))
			)
			{
				foreach($res AS $row)
				{
					if ((int)1 === (int)$row["addField_2"])
					{
						$donationAmountArray["value"] = $row["addField_1"];
					}

					$data =
						[
							"title" => Convert::textUnescape($row["title"]),
							"sum" => Convert::textUnescape($row["addField_1"]),
						];
					$donationAmountArray["list"] .= $this->objSTemplate->getHtml("form", "donationAmountListItem", $data);
				}
			}
		}

		return $donationAmountArray;
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();
		$objArticleCatalog = ArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();

		$this->objValidation->vars["projectId"] = 0;
		$this->objValidation->vars["donateId"] = 0;

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [projectId]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("projectId", $rules, $_POST);

		if (0 !== (int)$this->objValidation->vars["projectId"])
		{
			if (!$objMArticle->isExist($this->objValidation->vars["projectId"]))
			{
				$this->objSOutput->critical("Donate does not exist [".$this->objValidation->vars["projectId"]."]");
			}

			//Достаем информацию о статье
			$articleCatalogId = $objMArticle->getArticleCatalogId($this->objValidation->vars["projectId"]);

			//Проверяем существование статьи и пренадлежит ли статья к данному каталогу
			if (false === $articleCatalogId OR !$objArticleCatalog->isSuitableCatalog($articleCatalogId, "project"))
			{
				$this->objSOutput->critical("Project does not exist");
			}
		}

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [donateId]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("donateId", $rules, $_POST);

		if (0 !== (int)$this->objValidation->vars["donateId"])
		{
			if (!$objMArticle->isExist($this->objValidation->vars["donateId"]))
			{
				$this->objSOutput->critical("Donate does not exist [".$this->objValidation->vars["donateId"]."]");
			}

			//Достаем информацию о статье
			$articleCatalogId = $objMArticle->getArticleCatalogId($this->objValidation->vars["donateId"]);

			//Проверяем существование статьи и пренадлежит ли статья к данному каталогу
			if (false === $articleCatalogId OR !$objArticleCatalog->isSuitableCatalog($articleCatalogId, "donate"))
			{
				$this->objSOutput->critical("Donate does not exist");
			}
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>