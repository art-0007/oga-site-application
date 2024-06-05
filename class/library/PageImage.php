<?php

class PageImage extends Base
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
			self::$obj = new PageImage();
		}

		return self::$obj;
	}

	/*********************************************************************************/

 	//Дополняем массив переменными для заменны на разных языках
	public function extendArray(&$arrayHtml)
 	{
		$objMFileCatalog = MFileCatalog::getInstance();
		$objMFile = MFile::getInstance();

		//Достаем языково зависимые переменные
		if (false === ($res = $objMFile->getList($objMFileCatalog->getIdByDevName("pageImage"))))
		{
			return;
		}

		//Дополняем
		foreach ($res AS $row)
		{
			$arrayHtml[$row["nameOriginal"]] = GLOB::$SETTINGS["adminFileDir"]."/".$row["name"];
		}
 	}

	/*********************************************************************************/
}

?>