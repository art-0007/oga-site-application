<?php

/**
 * Интерфейс для всех контроллеров. Реализует фунционал вывода html-я
 * */
abstract class Controller extends Base
{
	//*********************************************************************************

	protected function __construct()
	{
		parent::__construct();
	}

	//*********************************************************************************

	//Отображает HTML страницу
 	public function showHtml()
 	{
 		global $startTime;

 		$this->templateInit(); //Инициализация всех частей шаблона
 		$this->objSOutput->ok($this->objSTemplate->getHtml($this->templateFileName, $this->templateName, $this->html));
 	}

	//*********************************************************************************

	//Возвращает HTML страницы
 	public function getHtml()
 	{
 		$this->templateInit(); //Инициализация всех частей шаблона
 		return $this->objSTemplate->getHtml($this->templateFileName, $this->templateName, $this->html);
 	}

	//*********************************************************************************

	abstract protected function templateInit();

	//*********************************************************************************
}

?>