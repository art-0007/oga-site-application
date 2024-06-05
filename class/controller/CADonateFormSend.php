<?php

class CADonateFormSend extends CAjaxInit
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
 		//Добаввляем запись в БД donate
	    $donateCode = $this->addDonate();

	    $data =
	    [
		    "donateCode" => $donateCode,
	    ];

	    $this->objSOutput->ok("Ок", $data);
 	}

	//*********************************************************************************

	private function addDonate()
	{
		$objMDonat = MDonate::getInstance();

		$onlinePaySystemId = $this->getOnlinePaySystemId();

		$code = Func::uniqueIdForDB(DB_donate, "code", 10, "num");

		$data =
		[
			"article_id" => $this->vars["projectId"],
			"onlinePaySystem_id" => $onlinePaySystemId,
			"code" => $code,
			"sum" => Func::moneyToPrintable($this->vars["donationAmount"]),
		];

		$donateId = $objMDonat->addAndReturnId($data);

		return $code;
	}

	//*********************************************************************************

	/**
	 * Достаем ИД системы онлайн оплаты из типа доната
	 *
	 * @return int
	 */
	private function getOnlinePaySystemId()
	{
		$objMArticle = MArticle::getInstance();
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();

		//Достаем информацию о способе доната
		$articleInfo = $objMArticle->getInfo($this->vars["articleDonateId"]);

		if (false === $articleInfo OR !$objMOnlinePaySystem->isExist($articleInfo["addField_3"]))
		{
			$errorArray["error"][] =
			[
				"errorText" => "Error: The online payment system is not defined",
				"inputName" => "articleDonateId"
			];

			$this->objSOutput->error("Message sending error", $errorArray);
		}

		return (int)$articleInfo["addField_3"];
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();
		$objStaticHtml = StaticHtml::getInstance();
		$objArticleCatalog = ArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		//Массив с ошибками, для ответа JS
		$errorArray = [];

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [projectId]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("projectId", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [articleDonateId]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("articleDonateId", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [donationAmount]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("donationAmount", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;

		//----------------------------------------------------------------------------

		if(isset($this->vars["projectId"]))
		{
			//Дополнительная проверка данных
			if(empty($this->vars["projectId"]))
			{
				$errorArray["error"][] =
				[
					"errorText" => $objStaticHtml->getHtml("e11"),
					"inputName" => "projectId"
				];
			}
			else
			{
				//Достаем информацию о статье
				$articleCatalogId = $objMArticle->getArticleCatalogId($this->vars["projectId"]);

				//Проверяем существование статьи и пренадлежит ли статья к данному каталогу
				if (false === $articleCatalogId OR !$objArticleCatalog->isSuitableCatalog($articleCatalogId, "project"))
				{
					$errorArray["error"][] =
					[
						"errorText" => "Project does not exist",
						"inputName" => "projectId"
					];
				}
			}
		}

		//----------------------------------------------------------------------------

		if(isset($this->vars["articleDonateId"]))
		{
			//Дополнительная проверка данных
			if(empty($this->vars["articleDonateId"]))
			{
				$errorArray["error"][] =
				[
					"errorText" => $objStaticHtml->getHtml("e12"),
					"inputName" => "articleDonateId"
				];
			}
			else
			{
				//Достаем информацию о статье
				$articleCatalogId = $objMArticle->getArticleCatalogId($this->vars["articleDonateId"]);

				//Проверяем существование статьи и пренадлежит ли статья к данному каталогу
				if (false === $articleCatalogId OR !$objArticleCatalog->isSuitableCatalog($articleCatalogId, "donate"))
				{
					$errorArray["error"][] =
					[
						"errorText" => "Donate does not exist",
						"inputName" => "Message sending error"
					];
				}
			}
		}

		//----------------------------------------------------------------------------

		if(isset($this->vars["donationAmount"]))
		{
			//Дополнительная проверка данных
			if(empty($this->vars["donationAmount"]))
			{
				$errorArray["error"][] =
				[
					"errorText" => $objStaticHtml->getHtml("e9"),
					"inputName" => "donationAmount"
				];
			}
			else
			{
				if ((int)$this->vars["donationAmount"] < 0)
				{
					$errorArray["error"][] =
					[
						"errorText" => $objStaticHtml->getHtml("e10"),
						"inputName" => "donationAmount"
					];
				}
			}
		}

		//----------------------------------------------------------------------------

		if(count($errorArray) > 0)
		{
			$this->objSOutput->error("Message sending error", $errorArray);
		}
	}

	//*********************************************************************************
}

?>