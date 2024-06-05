<?php

class CASubscribeFormSend extends CAjaxInit
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

		$this->add();

	    $data =
	    [
		    "modalTitle" => "{sh_message}",
		    "modalBody" => "{sh_subscribeFormMessageOk}",
	    ];

	    $data =
	    [
		    "modalHtml" => $objStaticHtml->replaceInString($this->objSTemplate->getHtml("modal", "modalMessageOk", $data)),
	    ];

  		$this->objSOutput->ok("Ок", $data);
 	}

	//*********************************************************************************

	private function add()
	{
		$objStaticHtml = StaticHtml::getInstance();
		$objMSubscribe = MSubscribe::getInstance();

		if ($objMSubscribe->isExist($objMSubscribe->getIdByEmail($this->vars["email"])))
		{
			return true;
		}

		$data =
		[
			"name" => $this->vars["name"],
			"email" => $this->vars["email"],
		];

		if (false === $objMSubscribe->add($data))
		{
			$data =
			[
				"errorText" => $objStaticHtml->replaceInString("{sh_subscribeErorText}"),
			];

			$this->objSOutput->error("error", $data);
		}

		return true;
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();
		$objStaticHtml = StaticHtml::getInstance();
		//Массив с ошибками, для ответа JS
		$errorArray = [];

		$this->objValidation->vars["name"] = "";

		//-----------------------------------------------------------------------------------

		//$rules =
		//[
		//	Validation::exist => "Недостаточно данных [name]",
		//	Validation::trim => "",
		//];
		//$this->objValidation->checkVars("name", $rules, $_POST);

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

		//if(isset($this->vars["name"]))
		//{
		//	//Дополнительная проверка данных E-mail
		//	if(empty($this->vars["name"]))
		//	{
		//		$errorArray["error"][] =
		//		[
		//			"errorText" => $objStaticHtml->replaceInString("{sh_e3}"),
		//			"inputName" => "name"
		//		];
		//	}
		//}

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
			$this->objSOutput->error("Ошибка подписки", $errorArray);
		}
	}

	//*********************************************************************************
}

?>