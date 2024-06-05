<?php

/**
 * Обеспечивает функции работы с некоторыми алгоритмами http протокола
 *
 * @package System
 * */
class SHTTP
{
	//*********************************************************************************

	/**
	 * Возвращает версию информационного протокола, который был использован для запроса.
	 *
	 * @return string Версия информационного протокола
	 * */
	public static function getProtocolVersion()
	{
		if(isset($_SERVER["SERVER_PROTOCOL"]))
		{
			if(mb_strpos($_SERVER["SERVER_PROTOCOL"], "1.1") === false)
			{
				return SEProtocol::HTTP1_0;
			}
			else
			{
				return SEProtocol::HTTP1_1;
			}
		}
		else
		{
			return SEProtocol::HTTP1_0;
		}
	}

	//*********************************************************************************

	/**
	 * Возвращает имя информационного протокола
	 *
	 * @return string Имя информационного протокола
	 * */
	public static function getProtocolName($protocol = "")
	{
		if(!empty($protocol))
		{
			switch($protocol)
			{
				case SEProtocol::HTTP1_0:
				{
					return "HTTP/1.0";
				}

				case SEProtocol::HTTP1_1:
				{
					return "HTTP/1.1";
				}

				default:
				{
					return "HTTP/1.1";
				}
			}
		}
		else
		{
			if(isset($_SERVER["SERVER_PROTOCOL"]))
			{
				if(mb_strpos($_SERVER["SERVER_PROTOCOL"], "1.1") === false)
				{
					return "HTTP/1.0";
				}
				else
				{
					return "HTTP/1.1";
				}
			}
			else
			{
				return "HTTP/1.1";
			}
		}
	}

	//*********************************************************************************
}

?>