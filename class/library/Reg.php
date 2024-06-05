<?php

/**
 * Предоставляет набор методов обеспечивающих атомарную обработку данных посредством регулярных выражений
 * @package AstridCore
 * @author Игорь Михальчук
 * @author Александр Шевяков
 * @version 1.1 2011.12.14 21:30:07
 * @link http://www.it-island.com/astrid/ IT-Island:Astrid
 * */

class Reg
{
	public static function isNum($value)
	{
		if(preg_match("|^[0-9]+$|iu", $value))
		{
			return(true);
		}

		return(false);
	}

	//Проверяет на целое число, которое может быть со знаком "минус"
	public static function isNumSigned($value)
	{
		if(preg_match("|^(\-)?[0-9]+$|iu", $value))
		{
			return(true);
		}

		return(false);
	}

	public static function isFloat($value, $numAmountAfterPoint = null)
	{
		if (is_null($numAmountAfterPoint))
		{
			$pattern = "|^[0-9]+(\.[0-9]+)?$|iu";
		}
		else
		{
			$numAmountAfterPoint = (int)$numAmountAfterPoint;
			$pattern = "|^[0-9]+(\.[0-9]{".$numAmountAfterPoint."})?$|iu";
		}

		if(preg_match($pattern, $value))
		{
			return(true);
		}

		return(false);
	}

	public static function isString($value)
	{
		if(preg_match("|^[a-z]*$|iu", $value))
		{
			return(true);
		}

		return(false);
	}

	public static function isURL($value)
	{
		if(preg_match("|^[a-z0-9\-\.]*$|iu", $value))
		{
			return(true);
		}

		return(false);
	}

	public static function isCode($value)
	{
		if(preg_match("|^[a-z0-9]+$|iu", $value))
		{
			return(true);
		}

		return(false);
	}

	/**
	 * Проверяет соответствие даты стандарту "ISO 8601"
	 * Пример "2001-12-31"
	 *
	 * @param string $date Дата
	 * @param string $delimiter Разделитель между частями даты
	 * */
	public static function isDateISO($date, $delimiter = "-")
	{
		//Необходимо прослешить каждый символ, так как этот текст будет использоватся в регулярном выражении
		$delimiterResult = "";
		for($i = 0; $i < mb_strlen($delimiter); $i++)
		{
			$delimiterResult .= "\\".$delimiter[$i];
		}

		$matches = array();

		if (
			preg_match("|^([0-9]{4})".$delimiterResult."([0-9]{2})".$delimiterResult."([0-9]{2})$|iu", $date, $matches)
			&&
			((int)$matches[2] <= 12)
			&&
			((int)$matches[3] <= 31)
		)
		{
			return true;
		}

		return false;
	}

	/**
	 * Проверяет соответствие даты стандарту "ГОСТ Р 6.30-2003 (п. 3.11)"
	 * Пример "31.12.2001"
	 *
	 * @param string $date Дата
	 * @param string $delimiter Разделитель между частями даты
	 * */
	public static function isDateGOST($date, $delimiter = ".")
	{
		//Необходимо прослешить каждый символ, так как этот текст будет использоватся в регулярном выражении
		$delimiterResult = "";
		for($i = 0; $i < mb_strlen($delimiter); $i++)
		{
			$delimiterResult .= "\\".$delimiter[$i];
		}

		$matches = array();

		if(
			preg_match("|^([0-9]{2})".$delimiterResult."([0-9]{2})".$delimiterResult."([0-9]{4})$|iu", $date, $matches)
			&&
			((int)$matches[1] <= 31)
			&&
			((int)$matches[2] <= 12)
		)
		{
			return true;
		}

		return false;
	}

	public static function isEmail($value)
	{
		if(preg_match("|^[0-9a-z_\-\.]+@[0-9a-z_\-^\.]+\.[a-z]{2,8}$|iu", $value))
		{
			return true;
		}

		return false;
	}

	public static function isPrice($value)
	{
		if(preg_match("|^[0-9]+(\.[0-9]{1,2})?$|iu", $value))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public static function isShortUrl($value)
	{
		if(preg_match("|^[a-z0-9\-\/]+$|u", $value))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public static function isShortUrlSection($value)
	{
		if(preg_match("|^[a-z0-9\-]+$|u", $value))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public static function isIp($value)
	{
		if(preg_match("|^[1-9][0-9]{0,2}\.[0-9]{1,3}\.[0-9]{1,3}\.[1-9][0-9]{0,2}+$|u", $value))
		{
			//Вторая часть проверки на корректность IPv4
			if (false === ip2long($value))
			{
				return false;
			}

			return true;
		}
		else
		{
			return false;
		}
	}
}

?>