<?php

class MSearch extends Model
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
			self::$obj = new MSearch();
		}

		return self::$obj;
	}

	/*********************************************************************************/

	//Вовзаращет список товаров соответсвующих словам
	public function getDataList($searchWordArray, $likeType = 1, $start = null, $amount = null, $orderType = EDataOrderType::title)
	{
		$query =
		"
			SELECT
    			`".DB_data."`.`id` AS `id`,
    			`".DB_data."`.`catalog_id` AS `catalogId`,
    			`".DB_data."`.`article` AS `article`,
				`".DB_data."`.`urlName` AS `urlName`,
      			`".DB_data."`.`price` AS `price`,
    			`".DB_data."`.`priceOld` AS `priceOld`,
				`".DB_data."`.`showKey` AS `showKey`,
				`".DB_data."`.`notAvailableKey` AS `notAvailableKey`,
				`".DB_data."`.`newOffersKey` AS `newOffersKey`,
				`".DB_data."`.`promotionalOffersKey` AS `promotionalOffersKey`,
				`".DB_data."`.`salesLeadersKey` AS `salesLeadersKey`,
    			`".DB_dataLang."`.`title` AS `title`,
    			`".DB_dataLang."`.`description` AS `description`,
    			`".DB_dataLang."`.`options` AS `options`,
    			`".DB_dataImage."`.`fileName` AS `fileName`
			FROM
				`".DB_data."`,
				`".DB_dataLang."`,
				`".DB_dataImage."`
			WHERE
			(
				`".DB_dataLang."`.`data_id` = `".DB_data."`.`id`
				AND
				`".DB_dataImage."`.`data_id` = `".DB_data."`.`id`
			)
				AND
			(
				`".DB_dataLang."`.`lang_id` = '".GLOB::$langId."'
				AND
				`".DB_dataImage."`.`defaultKey` = '1'
			)
			".$this->getWordArrayAsMysqlLike($searchWordArray, $likeType)."
			".$this->getMySQLOrderBy($orderType)."
			".$this->getMySQLLimit($start, $amount)."
		";

		$res = $this->objMySQL->query($query);

		if(0 === count($res))
		{
			return false;
		}

		return $res;
	}

	/*********************************************************************************/

	//Вовзаращет кол-во товаров соответсвующих запросу
	public function getDataAmount($searchWordArray, $likeType = 1)
	{
		$query =
		"
			SELECT
    			COUNT(`".DB_data."`.`id`) AS `count`
			FROM
				`".DB_data."`,
				`".DB_dataLang."`
			WHERE
			(
				`".DB_dataLang."`.`data_id` = `".DB_data."`.`id`
			)
				AND
			(
				`".DB_dataLang."`.`lang_id` = '".GLOB::$langId."'
					AND
				`".DB_data."`.`showKey` = '1'
			)
			".$this->getWordArrayAsMysqlLike($searchWordArray, $likeType)."
		";

		$res = $this->objMySQL->query($query);

		return (int)$res[0]["count"];
	}

	/*********************************************************************************/

	//Вовзращает LIKE часть запроса
	private function getWordArrayAsMysqlLike($searchWordArray, $likeType = 1)
	{
		$mysqlLike = "";

		switch($likeType)
		{
			//Поиск OR между словоформами и AND между словами
			case 1:
			{
				foreach($searchWordArray as $wordGroupArray)
				{
					$tempSQL = "";

					//Обходим слова внутри группы
					foreach($wordGroupArray AS $word)
					{
						if(empty($tempSQL))
						{
							//Формируем группу слов через OR между LIKE-ами
							$tempSQL .= "`".DB_dataLang."`.`title` LIKE '%".Func::res($word)."%'";
						}
						else
						{
							//Формируем группу слов через OR между LIKE-ами
							$tempSQL .= " OR `".DB_dataLang."`.`title` LIKE '%".Func::res($word)."%'";
						}
					}

					$mysqlLike .= " AND (".$tempSQL.")";
				}

				break;
			}

			//Поиск OR
			case 2:
			{
				foreach($searchWordArray as $wordGroupArray)
				{
					//Обходим слова внутри группы
					foreach($wordGroupArray AS $word)
					{
						if(empty($mysqlLike))
						{
							//Формируем группу слов через OR между LIKE-ами
							$mysqlLike .= "`".DB_dataLang."`.`title` LIKE '%".Func::res($word)."%'";
						}
						else
						{
							//Формируем группу слов через OR между LIKE-ами
							$mysqlLike .= " OR `".DB_dataLang."`.`title` LIKE '%".Func::res($word)."%'";
						}
					}
				}

				$mysqlLike = " AND (".$mysqlLike.")";
				break;
			}

			default:
			{
				Error::message("Ошибка: недопустимый тип [likeType]");
			}
		}

		return $mysqlLike;
	}

	//*********************************************************************************

	//Вовзражает MySQL ORDER BY часть запроса
	private function getMySQLOrderBy($orderType)
	{
		$mysqlOrderBy = "";

		//Вовзращает часть запроса с сортировкой
		switch($orderType)
		{
			//Сортировка по имени
			case EDataOrderType::title:
			{
				$mysqlOrderBy = " ORDER BY `".DB_dataLang."`.`title`";

				break;
			}

			//Сортировка по позиции
			case EDataOrderType::popular:
			{
				$mysqlOrderBy = " ORDER BY `".DB_data."`.`view`";

				break;
			}

			//Сортировка по имени
			case EDataOrderType::price:
			{
				$mysqlOrderBy = " ORDER BY `".DB_data."`.`price`";

				break;
			}

			//Сортировка по имени
			case EDataOrderType::priceDESC:
			{
				$mysqlOrderBy = " ORDER BY `".DB_data."`.`price` DESC";

				break;
			}

			default:
			{
				$mysqlOrderBy = " ORDER BY `".DB_dataLang."`.`title`";
				break;
			}
		}

		return $mysqlOrderBy;
	}

	//*********************************************************************************

	//Вовзражает MySQL ORDER BY часть запроса
	private function getMySQLLimit($start, $amount)
	{
		$mysqlLimit = "";

		if (!is_null($start) AND (int)$start >= 0)
		{
			$mysqlLimit = " LIMIT ".$start.", ".$amount;
		}

		return $mysqlLimit;
	}

	/*********************************************************************************/
}

?>