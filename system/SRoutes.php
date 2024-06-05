<?php

/**
 * Содержит переменные правил (роуты)
 * */
class SRoutes
{
	//*********************************************************************************

	/**
	 * @var string Имя контроллера по умолчанию
	 * */
	public static $defaultController = "";

	/**
	 * @var string Массив правил
	 * */
	public static $rules = "";

	//*********************************************************************************

	public static function loadRules()
	{
		global $routes;

		self::$defaultController = $routes["defaultController"];
		self::$rules = $routes["rules"];
	}

	//*********************************************************************************
}

?>