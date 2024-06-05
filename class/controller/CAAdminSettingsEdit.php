<?php

class CAAdminSettingsEdit extends CAjaxInit
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
		$objMSettings = MSettings::getInstance();

		$data =
  		[
  			"emailFrom" => $this->vars["emailFrom"],
  			"emailTo" => $this->vars["emailTo"],
  			"emailGateway" => $this->vars["emailGateway"],
  			//"catalogImgWidth_1" => $this->vars["catalogImgWidth_1"],
  			//"catalogImgHeight_1" => $this->vars["catalogImgHeight_1"],
  			//"newsAmountInNewsList" => $this->vars["newsAmountInNewsList"],
  			//"newsAmountInLeftMenu" => $this->vars["newsAmountInLeftMenu"],
  			//"dataAmountInBlock" => $this->vars["dataAmountInBlock"],
  			"projectAmountOnIndex" => $this->vars["projectAmountOnIndex"],
  			"newsAmountOnIndex" => $this->vars["newsAmountOnIndex"],
  			"partnerAmountOnIndex" => $this->vars["partnerAmountOnIndex"],
  			"eventAmountOnIndex" => $this->vars["eventAmountOnIndex"],
  			"teamAmountOnIndex" => $this->vars["teamAmountOnIndex"],

		    //"minOrderSum" => $this->vars["minOrderSum"],

  			//"numAmountAfterPoint" => $this->vars["numAmountAfterPoint"],
  			//"cutLastNumberIfZeros" => $this->vars["cutLastNumberIfZeros"],

		    "phone1" => $this->vars["phone1"],
		    "phone2" => $this->vars["phone2"],
		    "email1" => $this->vars["email1"],
		    "email2" => $this->vars["email2"],

		    //"currencyRate" => $this->vars["currencyRate"],
  			"front_domain" => $this->vars["front_domain"],
  			"front_companyName" => $this->vars["front_companyName"],
  		];

	    foreach ($data AS $name => $value)
	    {
		    if (false === $objMSettings->editValueByName($name, $value))
		    {
			    $this->objSOutput->error("Ошибка сохранения настроек");
		    }
		}

		$this->objSOutput->ok("Настройки сохранены");
 	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [emailFrom]",
			Validation::trim => "",
			Validation::isNoEmpty => "Поле \"emailFrom\" не должно быть пустым",
			Validation::isEmail => "Поле \"emailFrom\" имеет не верный формат",
		);
		$this->objValidation->checkVars("emailFrom", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [emailTo]",
			Validation::trim => "",
			Validation::isNoEmpty => "Поле \"Email для писем\" не должно быть пустым",
			//Validation::isEmail => "Поле \"Email для писем\" имеет не верный формат",
		);
		$this->objValidation->checkVars("emailTo", $rules, $_POST);

		$emailToArray = preg_split("#,#", $this->objValidation->vars["emailTo"], null, PREG_SPLIT_NO_EMPTY);

		foreach ($emailToArray as $key => $value)
		{
			if (!Reg::isEmail(trim($value)))
			{
				$this->objSOutput->error("Один из Email [".$value."] в поле \"Email для писем\" имеет не верный формат");
			}
		}

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [emailGateway]",
			Validation::trim => "",
			Validation::isNoEmpty => "Выберите Email шлюз",
		);
		$this->objValidation->checkVars("emailGateway", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//$rules = array
		//(
		//	Validation::exist => "Недостаточно данных [catalogImgWidth_1]",
		//	Validation::trim => "",
		//	Validation::isNoEmpty => "Поле \"Размеры изображения каталога (Ширина)\" не должно быть пустым",
		//	Validation::isNum => "Значение поля \"Размеры изображения каталога (Ширина)\" должно быть целым числом больше ноля",
		//);
		//$this->objValidation->checkVars("catalogImgWidth_1", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//$rules = array
		//(
		//	Validation::exist => "Недостаточно данных [catalogImgHeight_1]",
		//	Validation::trim => "",
		//	Validation::isNoEmpty => "Поле \"Размеры изображения каталога (Высота)\" не должно быть пустым",
		//	Validation::isNum => "Значение поля \"Размеры изображения каталога (Высота)\" должно быть целым числом больше ноля",
		//);
		//$this->objValidation->checkVars("catalogImgHeight_1", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//$rules = array
		//(
		//	Validation::exist => "Недостаточно данных [newsAmountInNewsList]",
		//	Validation::trim => "",
		//	Validation::isNoEmpty => "Введите значение количества выводимых новостей",
		//);
		//
		//$this->objValidation->checkVars("newsAmountInNewsList", $rules, $_POST);
		//
		//if (!Reg::isNum($this->objValidation->vars["newsAmountInNewsList"]))
		//{
		//	$this->objSOutput->error("Значение количества выводимых новостей должно быть целым числом!");
		//}
		//if(0 > (int)$this->objValidation->vars["newsAmountInNewsList"] OR 0 === (int)$this->objValidation->vars["newsAmountInNewsList"])
		//{
		//	$this->objSOutput->error("Значение количества выводимых новостей не может быть отрицательным или нулем!");
		//}

		//-----------------------------------------------------------------------------------

		//$rules = array
		//(
		//	Validation::exist => "Недостаточно данных [newsAmountInLeftMenu]",
		//	Validation::trim => "",
		//	Validation::isNoEmpty => "Введите значение количества выводимых новостей в левом меню",
		//);
		//
		//$this->objValidation->checkVars("newsAmountInLeftMenu", $rules, $_POST);
		//
		//if (!Reg::isNum($this->objValidation->vars["newsAmountInLeftMenu"]))
		//{
		//	$this->objSOutput->error("Значение количества выводимых новостей в левом меню должно быть целым числом!");
		//}
		//if(0 > (int)$this->objValidation->vars["newsAmountInLeftMenu"] OR 0 === (int)$this->objValidation->vars["newsAmountInLeftMenu"])
		//{
		//	$this->objSOutput->error("Значение количества выводимых новостей в левом меню не может быть отрицательным или нулем!");
		//}

		//-----------------------------------------------------------------------------------

		//$rules = array
		//(
		//	Validation::exist => "Недостаточно данных [dataAmountInBlock]",
		//	Validation::trim => "",
		//	Validation::isNoEmpty => "Введите значение количества выводимых новостей в левом меню",
		//);
		//
		//$this->objValidation->checkVars("dataAmountInBlock", $rules, $_POST);
		//
		//if (!Reg::isNum($this->objValidation->vars["dataAmountInBlock"]))
		//{
		//	$this->objSOutput->error("Значение количества выводимых товаров в блоке должно быть целым числом!");
		//}
		//if(0 > (int)$this->objValidation->vars["dataAmountInBlock"] OR 0 === (int)$this->objValidation->vars["dataAmountInBlock"])
		//{
		//	$this->objSOutput->error("Значение количества выводимых товаров в блоке не может быть отрицательным или нулем!");
		//}

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [projectAmountOnIndex]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите значение количества выводимых проэктов на главной",
		];

		$this->objValidation->checkVars("projectAmountOnIndex", $rules, $_POST);

		if (!Reg::isNum($this->objValidation->vars["projectAmountOnIndex"]))
		{
			$this->objSOutput->error("Значение количества выводимых проэктов на главной должно быть целым числом!");
		}
		if(0 > (int)$this->objValidation->vars["projectAmountOnIndex"] OR 0 === (int)$this->objValidation->vars["projectAmountOnIndex"])
		{
			$this->objSOutput->error("Значение количества выводимых проэктов на главной не может быть отрицательным или нулем!");
		}

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [newsAmountOnIndex]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите значение количества выводимых новостей на главной",
		];

		$this->objValidation->checkVars("newsAmountOnIndex", $rules, $_POST);

		if (!Reg::isNum($this->objValidation->vars["newsAmountOnIndex"]))
		{
			$this->objSOutput->error("Значение количества выводимых новостей на главной должно быть целым числом!");
		}
		if(0 > (int)$this->objValidation->vars["newsAmountOnIndex"] OR 0 === (int)$this->objValidation->vars["newsAmountOnIndex"])
		{
			$this->objSOutput->error("Значение количества выводимых новостей на главной не может быть отрицательным или нулем!");
		}

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [partnerAmountOnIndex]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите значение количества выводимых партнеров на главной",
		];

		$this->objValidation->checkVars("partnerAmountOnIndex", $rules, $_POST);

		if (!Reg::isNum($this->objValidation->vars["partnerAmountOnIndex"]))
		{
			$this->objSOutput->error("Значение количества выводимых партнеров на главной должно быть целым числом!");
		}
		if(0 > (int)$this->objValidation->vars["partnerAmountOnIndex"] OR 0 === (int)$this->objValidation->vars["partnerAmountOnIndex"])
		{
			$this->objSOutput->error("Значение количества выводимых партнеров на главной не может быть отрицательным или нулем!");
		}

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [eventAmountOnIndex]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите значение количества выводимых событий на главной",
		];

		$this->objValidation->checkVars("eventAmountOnIndex", $rules, $_POST);

		if (!Reg::isNum($this->objValidation->vars["eventAmountOnIndex"]))
		{
			$this->objSOutput->error("Значение количества выводимых событий на главной должно быть целым числом!");
		}
		if(0 > (int)$this->objValidation->vars["eventAmountOnIndex"] OR 0 === (int)$this->objValidation->vars["eventAmountOnIndex"])
		{
			$this->objSOutput->error("Значение количества выводимых событий на главной не может быть отрицательным или нулем!");
		}

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [teamAmountOnIndex]",
			Validation::trim => "",
			Validation::isNoEmpty => "Введите значение количества выводимых команды на главной",
		];

		$this->objValidation->checkVars("teamAmountOnIndex", $rules, $_POST);

		if (!Reg::isNum($this->objValidation->vars["teamAmountOnIndex"]))
		{
			$this->objSOutput->error("Значение количества выводимых команды на главной должно быть целым числом!");
		}
		if(0 > (int)$this->objValidation->vars["teamAmountOnIndex"] OR 0 === (int)$this->objValidation->vars["teamAmountOnIndex"])
		{
			$this->objSOutput->error("Значение количества выводимых команды на главной не может быть отрицательным или нулем!");
		}

		//-----------------------------------------------------------------------------------

		//$rules = array
		//(
		//	Validation::exist => "Недостаточно данных [numAmountAfterPoint]",
		//	Validation::trim => "",
		//	Validation::isNoEmpty => "Введите значение количества знаков после точки в ценах",
		//);
		//
		//$this->objValidation->checkVars("numAmountAfterPoint", $rules, $_POST);
		//
		//if (!Reg::isNum($this->objValidation->vars["numAmountAfterPoint"]))
		//{
		//	$this->objSOutput->error("Значение количества знаков после точки в ценах должно быть целым числом!");
		//}
		//if(0 > (int)$this->objValidation->vars["numAmountAfterPoint"] OR 0 === (int)$this->objValidation->vars["numAmountAfterPoint"])
		//{
		//	$this->objSOutput->error("Значение количества знаков после точки в ценах не может быть отрицательным или нулем!");
		//}

		//-----------------------------------------------------------------------------------

		//$rules = array
		//(
		//	Validation::exist => "Недостаточно данных [cutLastNumberIfZeros]",
		//	Validation::trim => "",
		//	Validation::isNoEmpty => "Укажите, удалять последние цифры если это нули?",
		//);
		//$this->objValidation->checkVars("cutLastNumberIfZeros", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//$rules = array
		//(
		//	Validation::exist => "Недостаточно данных [currencyRate]",
		//	Validation::trim => "",
		//	Validation::isNoEmpty => "Введите коэфициент конвертации",
		//);
		//
		//$this->objValidation->checkVars("currencyRate", $rules, $_POST);
		//
		//if (!Reg::isFloat($this->objValidation->vars["currencyRate"]))
		//{
		//	$this->objSOutput->error("Коэфициент конвертации должен быть десятичной дробью (разделитель - точка). Пример: 1.3, 5, 12.03");
		//}
		//
		//if ((float)0 === (float)($this->objValidation->vars["currencyRate"]))
		//{
		//	$this->objSOutput->error("Коэфициент конвертации не должен быть равным нулю");
		//}

		//-----------------------------------------------------------------------------------

		//$rules = array
		//(
		//	Validation::exist => "Недостаточно данных [minOrderSum]",
		//	Validation::trim => "",
		//	Validation::isNoEmpty => "Введите значение минимальной суммы заказа",
		//);
		//
		//$this->objValidation->checkVars("minOrderSum", $rules, $_POST);
		//
		//if (!Reg::isNum($this->objValidation->vars["minOrderSum"]))
		//{
		//	$this->objSOutput->error("Значение минимальной суммы заказа должно быть целым числом!");
		//}
		//if (0 > (int)$this->objValidation->vars["minOrderSum"])
		//{
		//	$this->objSOutput->error("Значение минимальной суммы заказа не может быть отрицательным или нулем!");
		//}

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [front_domain]",
			Validation::trim => "",
			Validation::isNoEmpty => "Поле \"Домен\" не должно быть пустым",
		);
		$this->objValidation->checkVars("front_domain", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [front_companyName]",
			Validation::trim => "",
			Validation::isNoEmpty => "Поле \"Название компании\" не должно быть пустым",
		);
		$this->objValidation->checkVars("front_companyName", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [phone1]",
			Validation::trim => "",
			Validation::isNoEmpty => "Поле \"Телефон компании №1\" не должно быть пустым",
		);
		$this->objValidation->checkVars("phone1", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [phone2]",
			Validation::trim => "",
			//Validation::isNoEmpty => "Поле \"Телефон компании №2\" не должно быть пустым",
		);
		$this->objValidation->checkVars("phone2", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [email1]",
			Validation::trim => "",
			//Validation::isNoEmpty => "Поле \"Email компании\" не должно быть пустым",
			//Validation::isEmail => "Поле \"Email компании\" имеет не верный формат",
		);
		$this->objValidation->checkVars("email1", $rules, $_POST);

		if (mb_strlen($this->objValidation->vars["email1"]) > 0 AND !Reg::isEmail($this->objValidation->vars["email1"]))
		{
			$this->objSOutput->error("Поле \"Email компании №1\" имеет не верный формат");
		}

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [email2]",
			Validation::trim => "",
			//Validation::isNoEmpty => "Поле \"Email компании\" не должно быть пустым",
			//Validation::isEmail => "Поле \"Email компании\" имеет не верный формат",
		);
		$this->objValidation->checkVars("email2", $rules, $_POST);

		if (mb_strlen($this->objValidation->vars["email2"]) > 0 AND !Reg::isEmail($this->objValidation->vars["email2"]))
		{
			$this->objSOutput->error("Поле \"Email компании №2\" имеет не верный формат");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>