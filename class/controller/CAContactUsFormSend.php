<?php

class CAContactUsFormSend extends CAjaxInit
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
		$objMArticle = MArticle::getInstance();

		$articleTitle = "";

		if ((int)$this->vars["requestId"] > 0)
		{
			$articleTitle = $objMArticle->getTitle($this->vars["requestId"]);
		}

	    $this->addEmailToBD($articleTitle);
	    $this->sendEmail($articleTitle);

	    $data =
	    [
	    	"modalTitle" => "{sh_message}",
	    	"modalBody" => "{sh_contactUsFormMessageOk}",
	    ];

	    $data =
	    [
		    "modalHtml" => $objStaticHtml->replaceInString($this->objSTemplate->getHtml("modal", "modalMessageOk", $data)),
	    ];

	    $this->objSOutput->ok("Ок", $data);
 	}

	//*********************************************************************************

	private function addEmailToBD($articleTitle)
	{
		$objSendEmail = SendEmail::getInstance();

		$data =
		[
			"domain" => $_SERVER["SERVER_NAME"],
			"articleTitle" => $articleTitle,
			"email" => $this->vars["email"],
			"ip" => $_SERVER["REMOTE_ADDR"],
		];

		$subject = $this->objSTemplate->getHtml("email", "subject_contactUsForm", $data);
		$contentText = $this->objSTemplate->getHtml("email", "content_contactUsForm", $data);

		$data = array
		(
			"content" => $contentText,
		);

		$content = $this->objSTemplate->getHtml("email", "content", $data);

		$this->lastEmailId = $objSendEmail->addEmailToBD($subject, $content);

		return array
		(
			"subject" => $subject,
			"content" => $content,
		);
	}

	//*********************************************************************************

	private function sendEmail($articleTitle)
	{
		$objSendEmail = SendEmail::getInstance();

		$data =
		[
			"domain" => $_SERVER["SERVER_NAME"],
			"articleTitle" => $articleTitle,
			"email" => $this->vars["email"],
			"ip" => $_SERVER["REMOTE_ADDR"],
		];

		$subject = $this->objSTemplate->getHtml("email", "subject_contactUsForm", $data);
		$contentText = $this->objSTemplate->getHtml("email", "content_contactUsForm", $data);

		$data = array
		(
			"content" => $contentText,
		);

		$content = $this->objSTemplate->getHtml("email", "content", $data);

		$objSendEmail->send($subject, $content, GLOB::$SETTINGS["emailTo"], GLOB::$SETTINGS["emailFrom"]);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();
		$objStaticHtml = StaticHtml::getInstance();
		//Массив с ошибками, для ответа JS
		$errorArray = [];

		$this->vars["requestId"] = 0;

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [requestId]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("requestId", $rules, $_POST);

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

		if(isset($this->vars["requestId"]))
		{
			//Дополнительная проверка данных E-mail
			if(empty($this->vars["requestId"]))
			{
				$errorArray["error"][] =
				[
					"errorText" => $objStaticHtml->replaceInString("{sh_e8}"),
					"inputName" => "requestId"
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