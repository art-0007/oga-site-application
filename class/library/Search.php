<?php

class Search extends Base
{
	/*********************************************************************************/

	private static $obj = null;

	/*********************************************************************************/

	protected function __construct()
	{
		parent::__construct();
		$this->init();
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
			self::$obj = new Search();
		}

		return self::$obj;
	}

	/*********************************************************************************/

	private function init()
	{
	}

	/*********************************************************************************/

	//Вовзаращет список товаров
	public function getDataList($searchString, $start = null, $amount = null)
	{
		$objMSearch = MSearch::getInstance();
		$res = null;

		//Получаем массив слов для поиска
		if(false === ($searchWordArray = $this->getSearchWordArray($searchString)))
		{
			return false;
		}

		//Достаем кол-во товаров по И
		$dataAmount = $objMSearch->getDataAmount($searchWordArray, 1);

		//Если товаров по методу И не нашло, то ищем товары по методу ИЛИ
		if($dataAmount > 0)
		{
			$res = $objMSearch->getDataList($searchWordArray, 1, $start, $amount);
		}
		else
		{
			$res = $objMSearch->getDataList($searchWordArray, 2, $start, $amount);
		}

		return $res;
	}

	/*********************************************************************************/

	//Вовзаращет список товаров
	public function getDataAmount($searchString)
	{
		$objMSearch = MSearch::getInstance();
		//Предварительная обработка фразы + добавление всех словоформ в поиск
		$searchWordArray = $this->getSearchWordArray($searchString);

		//Достаем кол-во товаров по И
		$dataAmount = $objMSearch->getDataAmount($searchWordArray, 1);

		//Если товаров по методу И не нашло, то ищем товары по методу ИЛИ
		if(0 === $dataAmount)
		{
			$dataAmount = $objMSearch->getDataAmount($searchWordArray, 2);
		}

		return (int)$dataAmount;
	}

	/*********************************************************************************/

	//Обрабатывает поисковую фразу перед поиском
	private function getSearchWordArray($searchString)
	{
		//Код библиотеки
		require_once(PATH.Config::$thirdPartyLibraryPath."/phpMorphy/src/common.php");

		$phpMorphyDictDir = PATH.Config::$thirdPartyLibraryPath."/phpMorphy/dicts/utf-8";

		$phpMorphyOptions = array
		(
			"storage" => PHPMORPHY_STORAGE_FILE,
			"predict_by_suffix" => true,
			"predict_by_db" => true
		);

		$objPhpMorphy = new phpMorphy($phpMorphyDictDir, "ru_RU", $phpMorphyOptions);
		//Массив слов, по которым будет вестись поиск
		$wordArray = array();
		//Массив СТОП слов
		$stopWordArray = array("для", "c");

		//Разбиваем фразу на слова по пробелу
		$searchStringWordArray = preg_split("#[ ]#i", $searchString, -1, PREG_SPLIT_NO_EMPTY);

		//Обходим массив слов
		foreach($searchStringWordArray as $word)
		{
			//Если текущее слово является стоп словом, то пропускаем его
			if(in_array($word, $stopWordArray))
			{
				continue;
			}

			//Пытаемся получаем все словоформы слова. Если таковых нет, то просто добавляем фразу
			if(false === ($wordAllFormsArray = $objPhpMorphy->getAllForms(mb_strtoupper($word, "utf-8"))))
			{
				//Добавляем слово в массив
				$wordArray[] = array(mb_strtoupper($word, "utf-8"));
			}
			else
			{
				//Добавялем список словоформ в массив
				$wordArray[] = $wordAllFormsArray;
			}
		}

		//Если нет слов для поиска, то возвращаем false
		if(count($wordArray) === 0)
		{
			return false;
		}

		return $wordArray;
	}

	/*********************************************************************************/
}

?>