<?php

/**
 * Осуществляет вывод сообщений отладки
 *
 * @package System
 * */

/**
 * ВНИМАНИЕ!
 * Эти строки подключения библиотеки PHPMailer необходимо делать за пределами кода метода или функции, так как оператор use там не работает
 * */

require_once(PATH.Config::$thirdPartyLibraryPath."/phpMailer/PHPMailer.php");
require_once(PATH.Config::$thirdPartyLibraryPath."/phpMailer/SMTP.php");
require_once(PATH.Config::$thirdPartyLibraryPath."/phpMailer/Exception.php");

class SDebug
{
	private static $debugBuffer = "";

	//*************************************************************************************************

	private static $usualMsgStringBefore = "<pre><p style=\"color: #00B000;\">";
	private static $usualMsgStringAfter = "</p></pre>";

	private static $ajaxMsgStringBefore = "<br><pre>";
	private static $ajaxMsgStringAfter = "<br></pre>";

	private static $baseMsgStringBefore = "\n";
	private static $baseMsgStringAfter = "\n";

	//*************************************************************************************************

	private static $usualBufferStringBefore = "";
	private static $usualBufferStringAfter = "";

	private static $ajaxBufferStringBefore = "";
	private static $ajaxBufferStringAfter = "";

	private static $baseBufferStringBefore = "";
	private static $baseBufferStringAfter = "";

	//*************************************************************************************************

	/**
	 * Помещает в буфер отладки структурированную информацию о данных $data. (определяет тип; для строк - длинну; для массивов - количество элементов)
	 *
	 * @param mixed $data Данные, структура которых помещаются в отладочный вывод с отображением их структуры. В случае, если $prepareDataKey = false, в буфер отладки помещается лиш преобразованные в строку эти данные
	 * @param string $prepareDataKey Ключ указывающий производить ли отображение структуры данных или выводить как есть
	 *
	 * @return string HTML со структурой данных или просто строка, если $prepareDataKey = false
	 * */
	public static function message($data, $prepareDataKey = true)
	{
		//Ничего не делаем, если отладка отключена
		if (false === SConfig::$debug)
		{
			return;
		}

		if (true === $prepareDataKey)
		{
			$data = self::prepareData($data);
		}

		self::$debugBuffer .= $data;

		return $data;
	}

	//*************************************************************************************************

	/**
	 * Возвращает строку, которая на данный момент находится в буфере отладки
	 *
	 * @return string Строка, которую содержит буфер отладки
	 * */
	public static function getDebugBuffer()
	{
		$result = "";
		$objSRouter = SRouter::getInstance();

		switch($objSRouter->processorType)
		{
			case SEProcessorType::usual:
			{
				$result = self::$usualBufferStringBefore.self::$debugBuffer.self::$usualBufferStringAfter;
				break;
			}
			case SEProcessorType::ajax:
			{
				$result = self::$ajaxBufferStringBefore.self::$debugBuffer.self::$ajaxBufferStringAfter;
				break;
			}
			case SEProcessorType::base:
			{
				$result = self::$baseBufferStringBefore.self::$debugBuffer.self::$baseBufferStringAfter;
				break;
			}

			default:
			{
				exit("Неверный тип обработчика");
			}
		}

		return $result;
	}

	//*********************************************************************************

	/**
	 * Отправляет email разработчикам, сообщая отладочную информацию
	 *
	 * @param string $message Текст сообщения, которое отправляется на почту
	 * */
	public static function sendEmail($message)
	{
		/**
		 * ВНИМАНИЕ! Существует ситуация, в которой данный код отрабатывает до заполнения массива настроек.
		 * Такое возможно, например, при ошибке соединения с базой данных.
		 * Потому нужно проверить существование данного массива, до его использования.
		 * Отправлять сообщения на почту в таком случае мы не сможем, так как не знаем на какой ящик отправлять.
		 * */
		if (!isset(GLOB::$SETTINGS) || 0 === count(GLOB::$SETTINGS)) return;

		//Конвертируем перемедаваемые данные в строку
		$message = self::convertDataToString($message);

		//require_once(SConfig::$thirdPartyLibraryPath."/phpMailer/class.phpmailer.php");

		$objSTemplate = STemplate::getInstance();
		$objSRouter = SRouter::getInstance();

		//Формируем массив мыл
		$debugEmailArray = explode(";", GLOB::$SETTINGS["debugEmail"]);

		foreach($debugEmailArray AS $emailToItem)
  		{
  			//Отрабаытваем ситуацию введеных пробелов и некорректного формата email
  			$emailToItem = trim($emailToItem);
  			if (0 === mb_strlen($emailToItem)) continue;
  			if (false === Reg::isEmail($emailToItem)) continue;

		    //$objPHPMailer = new PHPMailer;
		    $objPHPMailer = new PHPMailer\PHPMailer\PHPMailer();
			$objPHPMailer->IsSMTP();

			$objPHPMailer->CharSet = "utf-8";

			/** Почтовый ящик отправителя */
			$objPHPMailer->SetFrom(GLOB::$SETTINGS["noreplyEmail"]);

			/** Добавляем адресата */
			$objPHPMailer->AddAddress($emailToItem);

			/** Тема письма */
			$objPHPMailer->Subject = "Отладочная информация на платформе Astrid";

			/** Содержимое письма */
			//Также здесь вставляются общие переменные

			$data = array
	  		(
	  			"message" => $message,
	  			"domain" => $_SERVER["HTTP_HOST"],
	  			"className" => $objSRouter->className,
	  			"SERVER" => SDebug::convertDataToString($_SERVER),
	  			"COOKIE" => SDebug::convertDataToString($_COOKIE),
	  			"GET" => SDebug::convertDataToString($_GET),
	  			"POST" => SDebug::convertDataToString($_POST),
			    "backtrace" => SDebug::convertDataToString(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)),
	  		);
			$objPHPMailer->MsgHTML($objSTemplate->getHtml("engine/debug", "content", $data));

			//Отсылаем письмо
			$objPHPMailer->Send();

			unset($objPHPMailer);
		}
	}

	//*************************************************************************************************

	/**
	 * Формирует строку, которая отображает структуру данных, которые передаются в $data, обрамляя ее префиксами и постфиксами характерными для определенного типа обработчика
	 *
	 * @param mixed $data Данные, структура которых будет возвращена в строке
	 *
	 * @return string Строка отображающая структуру данных, которые передаются в $data
	 * */
	private static function prepareData($data)
	{
		$result = "";
		$objSRouter = SRouter::getInstance();

		switch($objSRouter->processorType)
		{
			case SEProcessorType::usual:
			{
				$result = self::$usualMsgStringBefore.self::convertDataToString($data).self::$usualMsgStringAfter;
				break;
			}
			case SEProcessorType::ajax:
			{
				$result = self::$ajaxMsgStringBefore.self::convertDataToString($data).self::$ajaxMsgStringAfter;
				break;
			}
			case SEProcessorType::base:
			{
				$result = self::$baseMsgStringBefore.self::convertDataToString($data).self::$baseMsgStringAfter;
				break;
			}

			default:
			{
				exit("Неверный тип обработчика");
			}
		}

		return $result;
	}

	//*************************************************************************************************

	/**
	 * Формирует строку, которая отображает структуру данных, которые передаются в $data
	 *
	 * @param mixed $data Данные, структура которых будет возвращена в строке
	 * @param int $tabCount Количество отступов (используется в процессе рекурсивного вызова для формирования визуального отступа посредством табуляций)
	 *
	 * @return string Строка отображающая структуру данных, которые передаются в $data
	 * */
	public static function convertDataToString($data, $tabCount = 0)
	{
		$objSRouter = SRouter::getInstance();

		if (is_array($data))
		{
			$tabs = "";
			for($i = 0; $i < $tabCount; $i++)
			{
				$tabs .= "\t";
			}
			$result = "\n".$tabs."<strong>array{".count($data)."}</strong> \n".$tabs."(";

			foreach ($data AS $key => $value)
			{
				$result .= "\n".$tabs."\t".self::convertDataToString($key)." => ".self::convertDataToString($value, $tabCount + 1);
			}

			$result .= "\n".$tabs.")";
			return $result;
		}
		else
		{
			if (is_bool($data))
			{
				if
				(
					(SEProcessorType::usual === $objSRouter->processorType)
					||
					(SEProcessorType::ajax === $objSRouter->processorType)
				)
				{
					if (true === $data)
						return "<strong>(bool)</strong> true";
					else
						return "<strong>(bool)</strong> false";
				}
				else
				{
					if (true === $data)
						return "(bool) true";
					else
						return "(bool) false";
				}
			}
			else
			{
				if (is_null($data))
				{
					if
					(
						(SEProcessorType::usual === $objSRouter->processorType)
						||
						(SEProcessorType::ajax === $objSRouter->processorType)
					)
					{
						return "<strong>NULL</strong>";
					}
					else
					{
						return "NULL";
					}
				}
				else
				{
					if (is_object($data))
					{
						return "<pre>".print_r($data, true)."</pre>";
					}
					else
					{
						if (is_integer($data))
						{
							if
							(
								(SEProcessorType::usual === $objSRouter->processorType)
								||
								(SEProcessorType::ajax === $objSRouter->processorType)
							)
							{
								return "<strong>(int)</strong> ".(string)$data;
							}
							else
							{
								return "(int) ".(string)$data;
							}
						}
						else
						{
							if (is_string($data))
							{
								if (0 === mb_strlen($data))
								{
									$data = "EMPTY_STRING";
								}

								if
								(
									(SEProcessorType::usual === $objSRouter->processorType)
									||
									(SEProcessorType::ajax === $objSRouter->processorType)
								)
								{
									return "<strong>(string:".mb_strlen($data).")</strong> ".htmlspecialchars($data, ENT_QUOTES);
								}
								else
								{
									return "(string:".mb_strlen($data).") ".$data;
								}
							}
							else
							{
								return "(".gettype($data).") ".(string)$data;
							}
						}
					}
				}
			}
		}
	}

	//*************************************************************************************************

}
?>