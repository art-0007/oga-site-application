<?php

class StaticHtml extends Base
{
	/*********************************************************************************/

	private static $obj = null;

	/*********************************************************************************/

	protected function __construct()
	{
		parent::__construct();
	}

	/*********************************************************************************/

	protected function __clone()
	{
	}

	/*********************************************************************************/

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new StaticHtml();
		}

		return self::$obj;
	}

	/*********************************************************************************/

 	//Дополняем массив переменными для заменны на разных языках
	public function extendArray(&$arrayHtml)
 	{
		$objMStaticHtml = MStaticHtml::getInstance();

		//Достаем языково зависимые переменные
		if (false === ($res = $objMStaticHtml->getList(true)))
		{
			return;
		}

		//Дополняем
		foreach ($res AS $row)
		{
			$arrayHtml["sh_".$row["name"]] = Convert::textUnescape($row["html"], false);
		}
 	}

	//*********************************************************************************

	//Заменяем в стоке языково зависимые переменные
	public function replaceInString($string)
	{
		$objMStaticHtml = MStaticHtml::getInstance();

		//Достаем языково зависимые переменные
		if (false === ($res = $objMStaticHtml->getList()))
		{
			return;
		}

		//Находим и заменяем
		foreach ($res AS $row)
		{
			$string = str_replace("{sh_".$row["name"]."}", Convert::textUnescape($row["html"], false), $string);
		}

		return $string;
	}

	//*********************************************************************************

	//Заменяем в стоке языково зависимые переменные
	public function getHtml($name)
	{
		$objMStaticHtml = MStaticHtml::getInstance();

		//Достаем языково зависимые переменные
		if (false === ($html = $objMStaticHtml->getHtmlByName($name)))
		{
			return "[No-translate]";
		}

		return Convert::textUnescape($html, false);
	}

	//*********************************************************************************

	//Заменяем в массиве языково зависимые переменные
	public function replaceInArray(&$array)
	{
		$objMStaticHtml = MStaticHtml::getInstance();

		//Достаем языково зависимые переменные
		if (false === ($res = $objMStaticHtml->getList()))
		{
			return;
		}

		//Перебираем массив
		foreach ($array AS $key => $value)
		{
			//Находим и заменяем
			foreach ($res AS $row)
			{
				$value = str_replace("{sh_".$row["name"]."}", Convert::textUnescape($row["html"], false), $value);
			}

			$array[$key] = $value;
		}

		return $array;
	}

	/*********************************************************************************/
}

?>