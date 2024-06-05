<?php

class Convert
{
	//*********************************************************************************

	public static function textUnescape($text, $stripTags = false, $length = 0)
	{
		$text = htmlspecialchars_decode($text, ENT_QUOTES);

		if($stripTags)
		{
			$text = strip_tags($text);
		}

		if($length > 0)
		{
			if(strlen($text) > $length)
			{
				$text = mb_substr($text, 0, $length);
			}
		}

		return $text;
	}

	//*********************************************************************************

	public static function dateFromISOToGOST($date, $delimierISO = "-", $delimiterGOST = ".")
	{
		$dateArray = array();

		if(preg_match("|^([0-9]{4})".$delimierISO."([0-9]{2})".$delimierISO."([0-9]{2})$|i", $date, $dateArray))
		{
			$date = $dateArray[3].$delimiterGOST.$dateArray[2].$delimiterGOST.$dateArray[1];
			return $date;
		}

		return false;
	}

	//*********************************************************************************

	public static function dateFromGOSTToISO($date, $delimierGOST = ".", $delimiterISO = "-")
	{
		$dateArray = array();

		if(preg_match("|^([0-9]{2})".$delimierGOST."([0-9]{2})".$delimierGOST."([0-9]{4})$|i", $date, $dateArray))
		{
			$date = $dateArray[3].$delimiterISO.$dateArray[2].$delimiterISO.$dateArray[1];
			return $date;
		}

		return false;
	}

	//*********************************************************************************

}

?>