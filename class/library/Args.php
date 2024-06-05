<?php

class Args
{
	//*********************************************************************************

	public static $name = "name";
	public static $required = "required";
	public static $defaultValue = "defaultValue";
	public static $type = "type";
	public static $setType = "setType";

	public static $isNum = "isNum";
	public static $isString = "isString";

	private $vars = array();

	//*********************************************************************************

	protected function __construct()
	{
		parent::__construct();
	}

	//*********************************************************************************

	public function __get($name)
	{

	}

	//*********************************************************************************

	public function check($paramsArray, $argsArray)
	{

		if(0 === count($argsArray) OR !isset($argsArray[0]))
		{
			return;
		}

		//Обходим массив параметров
		foreach($paramsArray AS $varName => $varParams)
		{
			$argsArray = $varParams[self::][0];

			if(true === $varParams[self::$required])
			{

			}
		}
	}

	//*********************************************************************************
}

?>