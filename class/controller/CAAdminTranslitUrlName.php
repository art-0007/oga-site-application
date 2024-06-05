<?php

class CAAdminTranslitUrlName extends CAjaxInit
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
		//Преобразовываем название каталога в URL

		$data = array
   		(
   			"urlName" => Func::translitForUrlName($this->vars["title"]),
   		);

  		$this->objSOutput->ok("Название преобразовано", $data);
 	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [title]",
			Validation::isNoEmpty => "Поле наименование пустое",
		);
		$this->objValidation->checkVars("title", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>