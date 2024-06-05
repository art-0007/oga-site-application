<?php

/**
 * Содержит набор переменных конфигурации проекта
 * @package AstridCore
 * @author Игорь Михальчук
 * @author Александр Шевяков
 * @version 1.1 2011.12.14 21:30:07
 * @link http://www.it-island.com/astrid/ IT-Island:Astrid
 * */

class Config extends SConfig
{
	//*********************************************************************************

	public static $db = array();
	public static $debugJavaScript = false;

	//*********************************************************************************

 	public static function loadConfig()
 	{
		self::$db = self::$config["db"];
 	}

	//*********************************************************************************
}

?>