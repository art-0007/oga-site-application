<?php

class CAGetInvolvedFormSend extends CAjaxInit
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
	    $objMArticle = MArticle::getInstance();
	    $objStaticHtml = StaticHtml::getInstance();

	    $getInvolvedTitle = Convert::textUnescape($objMArticle->getTitle($this->vars["articleId"]));

	    $this->addEmailToBD($getInvolvedTitle);
	    $this->sendEmail($getInvolvedTitle);

	    $data =
	    [
	    	"modalTitle" => "{sh_message}",
	    	"modalBody" => "{sh_getInvolvedForm_messageOk}",
	    ];

	    $data =
	    [
		    "modalHtml" => $objStaticHtml->replaceInString($this->objSTemplate->getHtml("modal", "modalMessageOk", $data)),
	    ];

	    $this->objSOutput->ok("Ок", $data);
 	}

	//*********************************************************************************

	private function addEmailToBD($getInvolvedTitle)
	{
		$objSendEmail = SendEmail::getInstance();

		$data =
		[
			"domain" => $_SERVER["SERVER_NAME"],
			"getInvolvedTitle" => $getInvolvedTitle,
			"name" => $this->vars["name"],
			"phone" => $this->vars["phone"],
			"email" => $this->vars["email"],
			"ip" => $_SERVER["REMOTE_ADDR"],
		];

		$subject = $this->objSTemplate->getHtml("email", "subject_getInvolvedForm", $data);
		$contentText = $this->objSTemplate->getHtml("email", "content_getInvolvedForm", $data);

		$data =
		[
			"content" => $contentText,
		];

		$content = $this->objSTemplate->getHtml("email", "content", $data);

		$this->lastEmailId = $objSendEmail->addEmailToBD($subject, $content);

		return [
			"subject" => $subject,
			"content" => $content,
		];
	}

	//*********************************************************************************

	private function sendEmail($getInvolvedTitle)
	{
		$objSendEmail = SendEmail::getInstance();

		$data =
		[
			"domain" => $_SERVER["SERVER_NAME"],
			"getInvolvedTitle" => $getInvolvedTitle,
			"name" => $this->vars["name"],
			"phone" => $this->vars["phone"],
			"email" => $this->vars["email"],
			"ip" => $_SERVER["REMOTE_ADDR"],
		];

		$subject = $this->objSTemplate->getHtml("email", "subject_getInvolvedForm", $data);
		$contentText = $this->objSTemplate->getHtml("email", "content_getInvolvedForm", $data);

		$data =
		[
			"content" => $contentText,
		];

		$content = $this->objSTemplate->getHtml("email", "content", $data);

		$objSendEmail->send($subject, $content, GLOB::$SETTINGS["emailTo"], GLOB::$SETTINGS["emailFrom"]);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();
		$objStaticHtml = StaticHtml::getInstance();
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();
		//Массив с ошибками, для ответа JS
		$errorArray = [];

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [articleId]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("articleId", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [name]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("name", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [phone]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("phone", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [email]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("email", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;

		//----------------------------------------------------------------------------

		if(isset($this->vars["articleId"]))
		{
			if (!$objMArticle->isExist($this->vars["articleId"]))
			{
				$errorArray["errorText"] = "GetInvolved does not exist [".$this->vars["articleId"]."]";
			}

			//Достаем информацию о каталоге услуги и проверяем на его существование
			if (false === ($articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("getInvolved"))))
			{
				$errorArray["errorText"] = "Error";
			}

			//Достаем информацию о статье
			$articleInfo = $objMArticle->getInfo($this->vars["articleId"]);

			//Проверяем существование статьи и пренадлежит ли статья к данному каталогу
			if (false === $articleInfo OR (int)$articleInfo["articleCatalogId"] !== (int)$articleCatalogInfo["id"])
			{
				$errorArray["errorText"] = "GetInvolved does not exist";
			}
		}

		//----------------------------------------------------------------------------

		if(isset($this->vars["name"]))
		{
			//Дополнительная проверка данных
			if(empty($this->vars["name"]))
			{
				$errorArray["error"][] =
				[
					"errorText" => $objStaticHtml->getHtml("e3"),
					"inputName" => "name"
				];
			}
		}

		//----------------------------------------------------------------------------


		if(isset($this->vars["phone"]))
		{
			//Дополнительная проверка данных E-mail
			if(empty($this->vars["phone"]))
			{
				$errorArray["error"][] =
				[
					"errorText" => $objStaticHtml->replaceInString("{sh_e4}"),
					"inputName" => "phone"
				];
			}
		}

		//----------------------------------------------------------------------------

		if(isset($this->vars["email"]))
		{
			//Дополнительная проверка данных E-mail
			if(empty($this->vars["email"]))
			{
				$errorArray["error"][] =
					[
						"errorText" => $objStaticHtml->replaceInString("{sh_e1}"),
						"inputName" => "email"
					];
			}
			else
			{
				if(!Reg::isEmail($this->vars["email"]))
				{
					$errorArray["error"][] =
						[
							"errorText" => $objStaticHtml->replaceInString("{sh_e2}"),
							"inputName" => "email"
						];
				}
			}
		}

		//----------------------------------------------------------------------------

		if(count($errorArray) > 0)
		{
			$this->objSOutput->error("Ошибка отправки сообщения", $errorArray);
		}
	}

	//*********************************************************************************
}

?>