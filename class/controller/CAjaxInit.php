<?php

class CAjaxInit extends Controller
{
	protected $html = array(); //Содержит все части HTML страницы
	protected $vars = array(); //Массив входящих данных

	//*********************************************************************************

	protected function __construct()
	{
		parent::__construct();
	}

	//*********************************************************************************

	//В ajax не нужен [Определяется только потому, что у родителя он абстрактный и его нужно определить]
 	protected function templateInit()
 	{
 	}

	//*********************************************************************************

}

?>