<?php

/**
 * Производит автоматическое подключение файлов классов, при первом обращении классу
 *
 * @package System
 * */
class SAutoloader
{
	/**
	 * @var object Ссылка на объект данного класса, использующаяся в механизме "Класс - одиночка"
	 * */
	private static $obj = null;

	/**********************************************************************/

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new SAutoloader();
		}

		return self::$obj;
	}

	/**********************************************************************/

	private function __construct()
	{
	}

	//*********************************************************************************

	/**
	 * Производит автоподключение файлов классов. Вызывается автоматически
	 *
	 * @param sting $className Имя класса
	 * */
	public function autoload($className)
	{
		if(file_exists(SYSTEM_PATH."/".$className.".php"))
		{
			require_once(SYSTEM_PATH."/".$className.".php");
		}
		else
		{
			if(file_exists(PATH."/class/library/".$className.".php"))
			{
				require_once(PATH."/class/library/".$className.".php");
			}
			else
			{
				$firstChar = mb_substr($className, 0, 1);

				switch($firstChar)
				{
					case "C":
					{
						require_once(PATH."/class/controller/".$className.".php");
						break;
					}

					case "M":
					{
						require_once(PATH."/class/model/".$className.".php");
						break;
					}

					case "E":
					{
						require_once(PATH."/class/enum/".$className.".php");
						break;
					}
				}
			}
		}
	}

	//*********************************************************************************

}

?>