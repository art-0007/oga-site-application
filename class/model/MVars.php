<?php

class MVars extends Model
{
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
			self::$obj = new MVars();
		}

		return self::$obj;
	}

	/*********************************************************************************/

	//Возвращает числовой массив, с строки формата 1.2.3 и т.д.
	//Если строка пустая, возвращает пустой массив
	public function getNumArray($string, $delimiter = ".")
	{
		if(strpos($string, $delimiter) !== false)
		{
			$tempArray = explode($delimiter, $string);

			for($i = 0; $i < count($tempArray); $i++)
			{
				$tempArray[$i] = (int)$tempArray[$i];
			}

			return $tempArray;
		}
		else
		{
			if(!empty($string))
			{
				return array((int)$string);
			}
			else
			{
				return array();
			}
		}
	}

	/*********************************************************************************/

	//Возвращает id из urlName
	public function getCatalogIdFromUrlName(&$urlName)
	{
		if(preg_match("#^[a-z0-9\-]+\-c([0-9]+)$#is", $urlName, $matches))
		{
			return (int)$matches[1];
		}

		return false;
	}

	/*********************************************************************************/

	//Возвращает id из urlName
	public function getOfferIdFromUrlName(&$urlName)
	{
		if(preg_match("#^[a-z0-9\-]+\-o([0-9]+)$#is", $urlName, $matches))
		{
			return (int)$matches[1];
		}

		return false;
	}

	/*********************************************************************************/

	//Возвращает id из urlName
	public function getArticleCatalogIdFromUrlName(&$urlName)
	{
		if(preg_match("#^[a-z0-9\-]+\-ac([0-9]+)$#is", $urlName, $matches))
		{
			return (int)$matches[1];
		}

		return false;
	}

	/*********************************************************************************/

	//Возвращает id из urlName
	public function getArticleIdFromUrlName(&$urlName)
	{
		if(preg_match("#^[a-z0-9\-]+\-a([0-9]+)$#is", $urlName, $matches))
		{
			return (int)$matches[1];
		}

		return false;
	}

	/*********************************************************************************/
}

?>