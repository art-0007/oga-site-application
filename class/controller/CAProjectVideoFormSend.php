<?php

class CAProjectVideoFormSend extends CAjaxInit
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

		$formTitle = $objStaticHtml->getHtml("projectVideoForm_title");
        $projectVideoTitle = Convert::textUnescape($objMArticle->getTitle($this->vars["projectVideoId"]));

        $this->addEmailToBD($formTitle, $projectVideoTitle);
        $this->sendEmail($formTitle, $projectVideoTitle);

		if (true === $this->vars["recordVideoResponseKey"])
		{
			$this->sendEmail_user($projectVideoTitle);
		}

        $data =
        [
            "modalTitle" => "{sh_message}",
            "modalBody" => "{sh_projectVideoForm_messageOk}",
        ];

        $data =
        [
            "href" => $this->getHref(),
            "modalHtml" => $objStaticHtml->replaceInString($this->objSTemplate->getHtml("modal", "modalMessageOk", $data)),
        ];

        $this->objSOutput->ok("Ок", $data);
    }

    //*********************************************************************************

    private function addEmailToBD($formTitle, $projectVideoTitle)
    {
        $objSendEmail = SendEmail::getInstance();

        $data =
        [
            "domain" => $_SERVER["SERVER_NAME"],
            "formTitle" => $formTitle,
            "projectVideoTitle" => $projectVideoTitle,
            "email" => $this->vars["email"],
			"response" => (true === $this->vars["recordVideoResponseKey"]) ? "Wants to record a video response" : "",
            "ip" => $_SERVER["REMOTE_ADDR"],
        ];

        $subject = $this->objSTemplate->getHtml("email", "subject_projectVideoForm", $data);
        $contentText = $this->objSTemplate->getHtml("email", "content_projectVideoForm", $data);

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

    private function sendEmail($formTitle, $projectVideoTitle)
    {
        $objSendEmail = SendEmail::getInstance();

        $data =
        [
            "domain" => $_SERVER["SERVER_NAME"],
            "formTitle" => $formTitle,
            "projectVideoTitle" => $projectVideoTitle,
            "email" => $this->vars["email"],
            "response" => (true === $this->vars["recordVideoResponseKey"]) ? "Wants to record a video response" : "",
            "ip" => $_SERVER["REMOTE_ADDR"],
        ];

        $subject = $this->objSTemplate->getHtml("email", "subject_projectVideoForm", $data);
        $contentText = $this->objSTemplate->getHtml("email", "content_projectVideoForm", $data);

        $data =
        [
            "content" => $contentText,
        ];

        $content = $this->objSTemplate->getHtml("email", "content", $data);

        $objSendEmail->send($subject, $content, GLOB::$SETTINGS["emailTo"], GLOB::$SETTINGS["emailFrom"]);
    }

    //*********************************************************************************

    private function sendEmail_user($projectVideoTitle)
    {
        $objSendEmail = SendEmail::getInstance();
		$objStaticHtml = StaticHtml::getInstance();

        $data =
        [
            "subject_projectVideoForm_user" => $objStaticHtml->getHtml("projectVideoForm_user_subject"),
            "content_projectVideoForm_user" => $objStaticHtml->getHtml("projectVideoForm_user_content"),
        ];

        $subject = $this->objSTemplate->getHtml("email", "subject_projectVideoForm_user", $data);
        $contentText = $this->objSTemplate->getHtml("email", "content_projectVideoForm_user", $data);

		$data =
		[
			"domain" => $_SERVER["SERVER_NAME"],
			"projectVideoTitle" => $projectVideoTitle,
			"email" => $this->vars["email"],
		];

		//Производим замену переменных шаблона на их значения
		foreach($data as $name => $value)
		{
			$subject = strtr($subject, array("{".$name."}" => $value));
			$contentText = strtr($contentText, array("{".$name."}" => $value));
		}

		$data =
        [
            "content" => $contentText,
        ];

        $content = $this->objSTemplate->getHtml("email", "content", $data);

        $objSendEmail->send($subject, $content, $this->vars["email"], GLOB::$SETTINGS["emailFrom"]);
    }

     //*********************************************************************************

    private function getHref()
    {
         $objMArticle = MArticle::getInstance();

		 $href = "";

		 if (($articleInfo = $objMArticle->getInfo($this->vars["projectVideoId"])) !== false)
		 {
			if (1 === (int)$articleInfo["addField_lang_4"])
			{
				if (Func::isEmpty($articleInfo["addField_lang_5"]))
				{
					if (!Func::isEmpty($articleInfo["addField_3"]) AND $objMArticle->isExist($articleInfo["addField_3"]))
					{
						$articleInfo = $objMArticle->getInfo($articleInfo["addField_3"]);

						$href = Convert::textUnescape($articleInfo["addField_lang_1"]);
					}
					else
					{
						//$donateBtn = $this->objSTemplate->getHtml("project", "donateBtn_1", ["projectCatalogId" => $articleInfo["id"], "projectId" => null]);
					}
				}
				else
				{
					$href = Convert::textUnescape($articleInfo["addField_lang_5"]);
				}
		 	}
		 }

		return $href;
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
			Validation::exist => "Недостаточно данных [projectVideoId]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("projectVideoId", $rules, $_POST);

        //-----------------------------------------------------------------------------------

        $rules =
		[
			Validation::exist => "Недостаточно данных [email]",
			Validation::trim => "",
		];
        $this->objValidation->checkVars("email", $rules, $_POST);

        //-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::checkbox => "",
		];
		$this->objValidation->checkVars("recordVideoResponseKey", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;

		//----------------------------------------------------------------------------

		if(isset($this->vars["projectVideoId"]))
		{
			//Дополнительная проверка данных
			if(empty($this->vars["projectVideoId"]))
			{
				$errorArray["error"][] =
				[
					"errorText" => $objStaticHtml->getHtml("e11"),
					"inputName" => "projectVideoId"
				];
			}
			else
			{
				//Достаем информацию о статье
				$articleCatalogId = $objMArticle->getArticleCatalogId($this->vars["projectVideoId"]);

				//Проверяем существование статьи и пренадлежит ли статья к данному каталогу
				if (false === $articleCatalogId OR !$objArticleCatalog->isSuitableCatalog($articleCatalogId, "projectVideo"))
				{
					$errorArray["error"][] =
					[
						"errorText" => "ProjectVideo does not exist",
						"inputName" => "projectVideoId"
					];
				}
			}
		}

        //----------------------------------------------------------------------------

        if(isset($this->vars["email"]))
        {
            //Дополнительная проверка данных E-mail
            if(empty($this->vars["email"]))
            {
//                $errorArray["error"][] =
//                [
//                    "errorText" => $objStaticHtml->replaceInString("{sh_e1}"),
//                    "inputName" => "email"
//                ];
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
			$this->objSOutput->error("Message sending error", $errorArray);
		}
	}

	//*********************************************************************************
}

?>
