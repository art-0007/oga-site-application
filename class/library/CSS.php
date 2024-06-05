<?php

/**
 * Осуществляет работу с подключением CSS файлов и CSS кодов в html
 * */
class CSS
{
	//*********************************************************************************

	private $fileArray = array();
	private $html = "";

	private static $obj = null;

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new CSS();
		}

		return self::$obj;
	}

	//*********************************************************************************

	protected function __construct()
	{
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
	}

	//*********************************************************************************

	public function getHtml()
	{
		return $this->html;
	}

	//*********************************************************************************

	public function addCSSFile($file)
	{
		//Если файл уже подключался, то ничего не подключаем
		if (in_array($file, $this->fileArray))
		{
			return;
		}
		$this->fileArray[] = $file;

		if (0 !== preg_match("#^http(s)?\:\/\/#iu", $file))
		{
			$this->html .= "\t<link href=\"".$file."\" type=\"text/css\">\r\n";
		}
		else
		{
			if (0 === mb_strpos($file, "/"))
			{
				$filePath = PATH.$file;
			}
			else
			{
				$filePath = PATH."/".$file;
			}

			if (0)
			{
				if (file_exists($filePath))
				{
					$file .= "?".filemtime($filePath);
					$this->html .= "\t<link href=\"".$file."\" rel=\"stylesheet\" type=\"text/css\">\r\n";
				}
				else
				{
					$this->html .= "\t<link href=\"".$file."?FILE_NOT_EXIST\" rel=\"stylesheet\" type=\"text/css\">\r\n";
				}
			}
			else
			{
				if (file_exists($filePath))
				{
					$code = file_get_contents($filePath);
					$this->html .= "<style type=\"text/css\">".$code."</style>\r\n";
				}
				else
				{
					$this->html .= "\t<link href=\"".$file."?FILE_NOT_EXIST\" rel=\"stylesheet\" type=\"text/css\">\r\n";
				}
			}
		}
	}

	//*********************************************************************************

 	public function addCSSCode($code)
 	{
 		$this->html .= "<style type=\"text/css\">".$code."</style>\r\n";
 	}

	//*********************************************************************************
}

?>