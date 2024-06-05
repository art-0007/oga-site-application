<?php

/**
 * Осуществляет работу с подключением JavaScript файлов и JavaScript кодов в html
 * */
class JavaScript
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
			self::$obj = new JavaScript();
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

	public function addJavaScriptFile($file, $charset = "UTF-8")
	{
		//Если файл уже подключался, то ничего не подключаем
		if (in_array($file, $this->fileArray))
		{
			return;
		}
		$this->fileArray[] = $file;

		if(!empty($charset))
		{
			$charset = "charset=\"".$charset."\"";
		}

		if (0 !== preg_match("#^http(s)?\:\/\/#iu", $file))
		{
			$this->html .= "\t<script src=\"".$file."\" type=\"text/javascript\" ".$charset."></script>\r\n";
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

			if (1)
			{
				if (file_exists($filePath))
				{
					$file .= "?mt=".filemtime($filePath);
					$this->html .= "\t<script src=\"".$file."\" type=\"text/javascript\" ".$charset."></script>\r\n";
				}
				else
				{
					$this->html .= "\t<script src=\"".$file."?FILE_NOT_EXIST\" type=\"text/javascript\" ".$charset."></script>\r\n";
				}
			}
			else
			{
				if (file_exists($filePath))
				{
					$code = file_get_contents($filePath);
					$this->html .= "<script type=\"text/javascript\">".$code."</script>\r\n";
				}
				else
				{
					$this->html .= "\t<script src=\"".$file."?FILE_NOT_EXIST\" type=\"text/javascript\" ".$charset."></script>\r\n";
				}
			}
		}
	}

	//*********************************************************************************

 	public function addJavaScriptCode($code)
 	{
 		$this->html .= "<script type=\"text/javascript\">".$code."</script>\r\n";
 	}

	//*********************************************************************************
}

?>