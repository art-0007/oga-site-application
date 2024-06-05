<?php

/**
 * Содержит методы осуществляющие вывод результирующих сообщений выполнения скрипта
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

class SOutput
{
	/**
	 * @var object Ссылка на объект данного класса, использующаяся в механизме "Класс - одиночка"
	 * */
	private static $obj = null;

	/**********************************************************************/

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new SOutput();
		}

		return self::$obj;
	}

	/************************************************************************************************************/

	/**
	 * Выводит сообщение (для различного типа контроллера вывод производится различно) об успешном завершении работы, а также завершает работу скрипта
	 *
	 * @param string $text Текст сообщения
	 * @param mixed $data Содержит, либо ассоциативный массив, либо одно данное, либо не передается и тогда неучитываеться
	 * 1) В ajax обработчике:
	 * добавляется как переменная "data",
	 * которая преобразуется библиотекой аякса
	 * в объект со свойствами соответсвующими элементам массива (если $data это массив),
	 * либо преобразуется в объект имеющий только одно значение (если $data это просто переменная)
	 * 2) В usual и base обработчиках:
	 * данная переменная не учитывается
	 * */
	public function ok($text, $data = null)
	{
		//Проверяем пустой ли буфер вывода
		if (false === SGLOB::$stdOutProcessed AND ob_get_length() > 0)
		{
			//Буфер вывода не пуст, значит возможно произошла какая-то ошибка
			$this->critical("Буфер вывода не обработан [".md5(ob_get_contents())."]");
		}

		$objSRouter = SRouter::getInstance();

		switch($objSRouter->processorType)
		{
			case SEProcessorType::usual:
			{
				$statistic = "";
				if (true === SConfig::$showStatistic)
				{
					$statistic = $this->getStatisticString(mb_strlen($text));
				}

				$debug = "";
				if (true === SConfig::$debug)
				{
					if (0 !== mb_strlen(SDebug::getDebugBuffer()))
					{
						$debug = "<br><br><strong>Содержимое буфера отладки: </strong><br>".SDebug::getDebugBuffer();
					}
				}

				echo $text.$statistic.$debug;

				SGLOB::$stdOutProcessed = true;
				exit();

				break;
			}

			case SEProcessorType::ajax:
			{
				$statistic = "";
				if (true === SConfig::$showStatistic)
				{
					$statistic = $this->getStatisticString(mb_strlen($text));
				}

				$debug = "";
				if (true === SConfig::$debug)
				{
					if (0 !== mb_strlen(SDebug::getDebugBuffer()))
					{
						$debug = "<br><br><strong>Содержимое буфера отладки: </strong><br>".SDebug::getDebugBuffer();
					}
				}

				$GLOBALS["_RESULT"] = array("status" => "ok", "message" => $text.$statistic.$debug);
				if (!is_null($data))
				{
					$GLOBALS["_RESULT"]["data"] = $data;
				}

				SGLOB::$stdOutProcessed = true;
				exit();

				break;
			}

			case SEProcessorType::base:
			{
				$statistic = "";
				if (true === SConfig::$showStatistic)
				{
					$statistic = $this->getStatisticString(mb_strlen($text));
				}

				$debug = "";
				if (true === SConfig::$debug)
				{
					if (0 !== mb_strlen(SDebug::getDebugBuffer()))
					{
						$debug = "\n\nСодержимое буфера отладки: \n".SDebug::getDebugBuffer();
					}
				}

				echo $text.$statistic.$debug;

				SGLOB::$stdOutProcessed = true;
				exit();

				break;
			}

			default: {exit("Fatal error processorType is not a valid in SOutput::ok [".$objSRouter->processorType."]");}
		}
	}

	/************************************************************************************************************/

	/**
	 * Выводит сообщение (для различного типа контроллера вывод производится различно) о возникновении ошибки (но не критической) в процессе работы, а также завершает работу скрипта
	 *
	 * @param string $text Текст сообщения
	 * @param mixed $data Содержит, либо ассоциативный массив, либо одно данное, либо не передается и тогда неучитываеться
	 * @param mixed $data Содержит, либо ассоциативный массив, либо одно данное, либо не передается и тогда неучитываеться
	 * 1) В ajax обработчике:
	 * добавляется как переменная "data",
	 * которая преобразуется библиотекой аякса
	 * в объект со свойствами соответсвующими элементам массива (если $data это массив),
	 * либо преобразуется в объект имеющий только одно значение (если $data это просто переменная)
	 * 2) В usual и base обработчиках:
	 * данная переменная не учитывается
	 * @param string $templateFileName Имя файла шаблона использующегося для вывода ошибок
	 * @param string $templateName Имя шаблона использующегося для вывода ошибок
	 * */
	public function error($text, $data = null, $templateFileName = "", $templateName = "")
	{
		//Проверяем пустой ли буфер вывода
		if (false === SGLOB::$stdOutProcessed AND ob_get_length() > 0)
		{
			//Буфер вывода не пуст, значит возможно произошла какая-то ошибка
			$this->critical("Буфер вывода не обработан [".md5(ob_get_contents())."]");
		}

		$objSRouter = SRouter::getInstance();
		$objSResponse = SResponse::getInstance();

		switch($objSRouter->processorType)
		{
			case SEProcessorType::usual:
			{
				$statistic = "";
				if (true === SConfig::$showStatistic)
				{
					$statistic = $this->getStatisticString(mb_strlen($text));
				}

				$debug = "";
				if (true === SConfig::$debug)
				{
					if (0 !== mb_strlen(SDebug::getDebugBuffer()))
					{
						$debug = "<br><br><strong>Содержимое буфера отладки: </strong><br>".SDebug::getDebugBuffer();
					}
				}

				SGLOB::$stdOutProcessed = true;
				$objSResponse->showPageError503($text.$statistic.$debug, $templateFileName, $templateName);

				break;
			}

			case SEProcessorType::ajax:
			{
				$statistic = "";
				if (true === SConfig::$showStatistic)
				{
					$statistic = $this->getStatisticString(mb_strlen($text));
				}

				$debug = "";
				if (true === SConfig::$debug)
				{
					if (0 !== mb_strlen(SDebug::getDebugBuffer()))
					{
						$debug = "<br><br><strong>Содержимое буфера отладки: </strong><br>".SDebug::getDebugBuffer();
					}
				}

				$GLOBALS["_RESULT"] = array("status" => "error", "message" => $text.$statistic.$debug);
				if (!is_null($data))
				{
					$GLOBALS["_RESULT"]["data"] = $data;
				}

				SGLOB::$stdOutProcessed = true;
				exit();

				break;
			}

			case SEProcessorType::base:
			{
				$statistic = "";
				if (true === SConfig::$showStatistic)
				{
					$statistic = $this->getStatisticString(mb_strlen($text));
				}

				$debug = "";
				if (true === SConfig::$debug)
				{
					if (0 !== mb_strlen(SDebug::getDebugBuffer()))
					{
						$debug = "\n\nСодержимое буфера отладки: \n".SDebug::getDebugBuffer();
					}
				}

				$objSResponse->sendStatus503(false);/** ВНИМАНИЕ! Необходимо отсылать статус 503 */

				echo $text.$statistic.$debug;

				SGLOB::$stdOutProcessed = true;
				exit();

				break;
			}

			default: {exit("Fatal error processorType is not a valid in SOutput::error [".$objSRouter->processorType."]");}
		}
	}

	/************************************************************************************************************/

	/**
	 * Выводит сообщение (для различного типа контроллера вывод производится различно) о возникновении критической ошибки в процессе работы, а также завершает работу скрипта
	 *
	 * @param string $text Текст сообщения
	 * @param string $templateFileName Имя файла шаблона использующегося для вывода ошибок
	 * @param string $templateName Имя шаблона использующегося для вывода ошибок
	 * */
	public function critical($text, $sendEmailKey = true, $templateFileName = "", $templateName = "")
	{
	 	if (true === $sendEmailKey)
	 	{
	 		$this->sendEmail($text);
	 	}

		$objSRouter = SRouter::getInstance();
		$objSResponse = SResponse::getInstance();

		switch($objSRouter->processorType)
		{
			case SEProcessorType::usual:
			{
				$debug = "";
				if (true === SConfig::$debug)
				{
					if (0 !== mb_strlen(SDebug::getDebugBuffer()))
					{
						$debug = "<br><br><strong>Содержимое буфера отладки: </strong><br>".SDebug::getDebugBuffer();
					}
				}

				//Проверяем нужно ли показывать стандартный вывод
				$stdOutMessage = "";
				if (true === SConfig::$showStdOut)
				{
					if (0 !== ob_get_length())
					{
						$stdOutMessage = "<br><br><strong>Содержимое буфера вывода:</strong><br>".ob_get_contents();
					}
				}

				/** Очищаем буфер вывода */
				ob_clean();

				//SGLOB::$stdOutProcessed = true;//Данный параметр устанавливается теперь внутри метода SResponse::showPageError503(), потому мы его тут не устанавливаем
				$objSResponse->showPageError503("Произошла ошибка! Возможно у Вас открыта устаревшая версия страницы.<br>Обновите страницу воспользовавшись комбинацией клавиш 'Ctrl+R'.<br>Если ошибка не устраниться, свяжитесь с системным администратором сайта.<br><br><strong>Текст ошибки: </strong><em>".$text."</em>".$debug.$stdOutMessage, $templateFileName, $templateName);

				break;
			}

			case SEProcessorType::ajax:
			{
				$debug = "";
				if (true === SConfig::$debug)
				{
					if (0 !== mb_strlen(SDebug::getDebugBuffer()))
					{
						$debug = "<br><br><strong>Содержимое буфера отладки: </strong><br>".SDebug::getDebugBuffer();
					}
				}

				//Проверяем нужно ли показывать стандартный вывод
				$stdOutMessage = "";
				if (true === SConfig::$showStdOut)
				{
					if (0 !== ob_get_length())
					{
						$stdOutMessage = "<br><br><strong>Содержимое буфера вывода:</strong><br>".ob_get_contents();
					}
				}

				/** Очищаем буфер вывода */
				ob_clean();

				$GLOBALS["_RESULT"] = array("status" => "error", "message" => "Произошла ошибка! Возможно у Вас открыта устаревшая версия страницы.<br>Обновите страницу воспользовавшись комбинацией клавиш 'Ctrl+R'.<br>Если ошибка не устраниться, свяжитесь с системным администратором сайта.<br><br><strong>Текст ошибки: </strong>".$text."".$debug.$stdOutMessage);

				SGLOB::$stdOutProcessed = true;
				exit();

				break;
			}

			case SEProcessorType::base:
			{
				$debug = "";
				if (true === SConfig::$debug)
				{
					if (0 !== mb_strlen(SDebug::getDebugBuffer()))
					{
						$debug = "\n\nСодержимое буфера отладки: \n".SDebug::getDebugBuffer();
					}
				}

				//Проверяем нужно ли показывать стандартный вывод
				$stdOutMessage = "";
				if (true === SConfig::$showStdOut)
				{
					if (0 !== ob_get_length())
					{
						$stdOutMessage = "\n\nСодержимое буфера вывода: \n".ob_get_contents();
					}
				}

				/** Очищаем буфер вывода */
				ob_clean();

				$objSResponse->sendStatus503(false);
				SGLOB::$stdOutProcessed = true;
				exit("Произошла ошибка! Возможно у Вас открыта устаревшая версия страницы.\nОбновите страницу воспользовавшись комбинацией клавиш 'Ctrl+R'.\nЕсли ошибка не устраниться, свяжитесь с системным администратором сайта.\n\nТекст ошибки: ".$text."".$debug.$stdOutMessage);

				break;
			}
			default:
			{
				exit("Неверный тип обработчика");
			}
		}

		exit("Пасхальное_яйцо_1");//На всякий случай, так как должно отработать в коде выше. Отрабатывает, если код выше отработает с ошибкой.
	}

	//*********************************************************************************

	/**
	 * Отправляет email разработчикам, оповещая о критической ишибке произошедшей в системе
	 *
	 * @param string $message Текст письма
	 * @param string $templateFileName Имя файла шаблона письма
	 * @param string $templateName Имя шаблона письма
	 * */
	public function sendEmail($message = "[не указано]", $templateFileName = "engine/fatalError", $templateName = "content")
	{
		/**
		 * ВНИМАНИЕ! Существует ситуация, в которой данный код отрабатывает до заполнения массива настроек.
		 * Такое возможно, например, при ошибке соединения с базой данных.
		 * Потому нужно проверить существование данного массива, до его использования.
		 * Отправлять сообщения на почту в таком случае мы не сможем, так как не знаем на какой ящик отправлять.
		 * */
		if (!isset(GLOB::$SETTINGS) || 0 === count(GLOB::$SETTINGS)) return;

		//require_once(PATH.Config::$thirdPartyLibraryPath."/phpMailer/PHPMailerAutoload.php");

		$objSTemplate = STemplate::getInstance();
		$objSRouter = SRouter::getInstance();

		//Формируем массив мыл
		$fatalErrorEmailArray = explode(";", GLOB::$SETTINGS["fatalErrorEmail"]);

		foreach($fatalErrorEmailArray AS $emailToItem)
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
			$objPHPMailer->Subject = "Критическая ошибка на платформе Astrid";

			/** Содержимое письма */
			//Также здесь вставляются общие переменные

			$data = array
	  		(
	  			"errorText" => $message,
	  			"domain" => $_SERVER["HTTP_HOST"],
	  			"className" => $objSRouter->className,
	  			"SERVER" => SDebug::convertDataToString($_SERVER),
	  			"COOKIE" => SDebug::convertDataToString($_COOKIE),
	  			"GET" => SDebug::convertDataToString($_GET),
	  			"POST" => SDebug::convertDataToString($_POST),
	  			"obContent" => (0 === ob_get_length()) ? "[буфер пуст]" : ob_get_contents(),
	  			"obContentBase64" => (0 === ob_get_length()) ? "[буфер пуст]" : base64_encode(ob_get_contents()),
	  		);
			$objPHPMailer->MsgHTML($objSTemplate->getHtml($templateFileName, $templateName, $data));

			//Отсылаем письмо
			$objPHPMailer->Send();

			unset($objPHPMailer);
		}
	}

	//*********************************************************************************

	/**
	 * Возвращает строку, в которой выведены статичстические данные работы скрипта
	 *
	 * @return string Строка со статистическими данными
	 * */
	private function getStatisticString($contentLength)
	{
		global $startTime;

		$objSRouter = SRouter::getInstance();

		switch($objSRouter->processorType)
		{
			case SEProcessorType::usual:
			{
				$statistic = "<br><br><strong>Статистическая информация: </strong><br>Страница сгенерирована за: ".round(microtime(true) - $startTime, 6)." с. <br>Длина строки вывода: ".$contentLength;
				return $statistic;

				break;
			}

			case SEProcessorType::ajax:
			{
				$statistic = "<br><br><strong>Статистическая информация: </strong><br>Страница сгенерирована за: ".round(microtime(true) - $startTime, 6)." с. <br>Длина строки вывода: ".$contentLength;
				return $statistic;

				break;
			}

			case SEProcessorType::base:
			{
				$statistic = "\n\nСтатистическая информация:\nСтраница сгенерирована за: ".round(microtime(true) - $startTime, 6)."с. \r\nДлина строки вывода: ".$contentLength;
				return $statistic;

				break;
			}

			default: {exit("Fatal error processorType is not a valid in SOutput::getStatisticString [".$objSRouter->processorType."]");}
		}
	}

	/************************************************************************************************************/

}

?>