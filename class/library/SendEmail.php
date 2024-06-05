<?php

/**
 * ВНИМАНИЕ!
 * Эти строки подключения библиотеки PHPMailer необходимо делать за пределами кода метода или функции, так как оператор use там не работает
 * */

require_once(PATH.Config::$thirdPartyLibraryPath."/phpMailer/PHPMailer.php");
require_once(PATH.Config::$thirdPartyLibraryPath."/phpMailer/SMTP.php");
require_once(PATH.Config::$thirdPartyLibraryPath."/phpMailer/Exception.php");

class SendEmail extends Base
{
	//*********************************************************************************

	private static $obj = null;

	//*********************************************************************************

	protected function __construct()
	{
		parent::__construct();
	}

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new SendEmail();
		}

		return self::$obj;
	}

	//*********************************************************************************

	/**
	 * Отправляет email
	 *
	 * @param string $subject Тема письма
	 * @param string $content Текст письма
	 * @param mixed $emailTo Может быть как массивом почтовых ящиков так и одной строкой, которая содержит почтовый яащик, куда отправлять письмо
	 * @param string $emailFrom Почтовый яащик, от имени которого отправлять письмо. Если не указано, то используется из настроек
	 *
	 * @return true или описание ошибки
	 * */
	public static function send($subject, $content, $emailTo, $emailFrom = null, $addAttachmentArray = array())
	{
		$emailTo = preg_split("#,#", $emailTo, null, PREG_SPLIT_NO_EMPTY);

		if (!is_array($emailTo))
		{
			$emailTo = [$emailTo];
		}

		//$objPHPMailer = new PHPMailer;
		$objPHPMailer = new PHPMailer\PHPMailer\PHPMailer();

		switch((int)GLOB::$SETTINGS["emailGateway"])
		{
			case 1:
			{
				$objPHPMailer->isSMTP();
				break;
			}
			case 2:
			{
				$objPHPMailer->isMail();
				break;
			}
			case 3:
			{
				$objPHPMailer->isSendmail();
				break;
			}
			default:
			{
				$objPHPMailer->isSMTP();
			}
		}

		//Кодировка письма
		$objPHPMailer->CharSet = "UTF-8";
		//Адрес отправителя
		$objPHPMailer->SetFrom((is_null($emailFrom)) ? GLOB::$SETTINGS["noreplyEmail"] : $emailFrom);

		//Отправялем email-ы
		foreach($emailTo AS $email)
		{
			//Адрес получателя
			$objPHPMailer->AddAddress($email);

			//Тема письма
			$objPHPMailer->Subject = $subject;
			//Текст письма
			$objPHPMailer->MsgHTML($content);

			if (count($addAttachmentArray) > 0)
			{
				$objPHPMailer->addAttachment($addAttachmentArray["path"], $addAttachmentArray["name"]);
			}

			//Если произошла ошибка в процессе отправки письма, то возвращаем ошибку
			if(!$objPHPMailer->Send())
			{
				return false;
			}

			//Очищаем значения получателя и прикрепленных файлов
			$objPHPMailer->ClearAddresses();
			$objPHPMailer->ClearAttachments();
		}

		//Добавляем отправляемое письмо в БД
		//self::addEmailToBD($subject, $content, $addAttachmentArray);

		unset($objPHPMailer);

		return true;
	}

	//*********************************************************************************

	public static function addEmailToBD($subject, $content, $addAttachmentArray = array())
	{
		$objMEmail = MEmail::getInstance();

		$time = time();

		$data = array
		(
			"subject" => $subject,
			"content" => $content,
			"time" => $time,
			"fileName" => (isset($addAttachmentArray["name"])) ? $addAttachmentArray["name"] : "",
		);

		$emailId = $objMEmail->addAndReturnId($data);

		if (false === $emailId)
		{
			return false;
		}

		return $emailId;
	}

	//*********************************************************************************

}

?>