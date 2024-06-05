<?php

/**
 * Содержит функционал работы с определенными ситуациами ответов сервера. Обеспечивает отправку некоторых http заголовков
 *
 * @package System
 * */
class SResponse
{
	/**
	 * @var object Ссылка на объект данного класса, использующаяся в механизме "Класс - одиночка"
	 * */
	private static $obj = null;

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new SResponse();
		}

		return self::$obj;
	}

	//*********************************************************************************

	private function __construct()
	{
	}

	//*********************************************************************************

	private function __clone()
	{
	}

	//*********************************************************************************

	/**
	 * Отсылает http заголовок $header. Если http заголовки уже отправлены генерирует страницу ошибки
	 *
	 * @param string $header Http заголовок
	 * */
	public function sendHeader($header)
	{
		if(!headers_sent())
		{
			header($header);
		}
		else
		{
			if (true === SConfig::$debug)
			{
				$this->showPageError503("Ошибка отправки http заголовка \"".$header."\", заголовки уже отправлены");
			}
		}
	}

	//*********************************************************************************

	/**
	 * Отображает страницу ошибки с кодом 403
	 *
	 * @param string $text Текст который выводится на данной странице
	 * */
	public function showPageError403($text = "")
	{
		$this->sendStatus403(false);

		$this->showPageError($text, SEResponseStatus::Status403);
		exit();
	}

	//*********************************************************************************

	/**
	 * Отображает страницу ошибки с кодом 404
	 *
	 * @param string $text Текст который выводится на данной странице
	 * */
	public function showPageError404($text = "")
	{
		$this->sendStatus404(false);

		$this->showPageError($text, SEResponseStatus::Status404);
		exit();
	}

	//*********************************************************************************

	/**
	 * Отображает страницу ошибки с кодом 500
	 *
	 * @param string $text Текст который выводится на данной странице
	 * */
	public function showPageError500($text = "")
	{
		$this->sendStatus500(false);

		$this->showPageError($text, SEResponseStatus::Status500);
		exit();
	}

	//*********************************************************************************

	/**
	 * Отображает страницу ошибки с кодом 503
	 *
	 * @param string $text Текст который выводится на данной странице
	 * */
	public function showPageError503($text = "")
	{
		$this->sendStatus503(false);

		$this->showPageError($text, SEResponseStatus::Status503);
		exit();
	}

	//*********************************************************************************

	/**
	 * Отсылает соответствующие http заголовки для произведения перенаправления на страницу с адресом $address
	 *
	 * @param string $address Адрес страницы, на которую производится перенаправление
	 * @param string $type Тип перенаправления
	 * */
	public function redirect($address, $type = SERedirect::found)
	{
		SGLOB::$stdOutProcessed = true;
		switch($type)
		{
			//Отправляет заголовок 302 - страница найденна по другому адресу
			case SERedirect::found:
			{
				$this->sendHeader(SHTTP::getProtocolName()." 302 Found");
				$this->sendHeader("Location: ".$address);
				exit();

				break;
			}

			//Отправляет заголовок 301 - страница окончательно перемещенна
			case SERedirect::movedPermanently:
			{
				$this->sendHeader(SHTTP::getProtocolName()." 301 Moved Permanently");
				$this->sendHeader("Location: ".$address);
				exit();

				break;
			}
		}
	}

	//*********************************************************************************

	/**
	 * Отсылает http заголовок статуса с кодом 403
	 *
	 * @param bool $exit Ключ, указывающий производить ли завершение работы скрипта
	 * */
	public function sendStatus403($exit = true)
	{
		$this->sendHeader(SHTTP::getProtocolName()." 403 Forbidden");

		if (true === $exit) exit();
	}

	//*********************************************************************************

	/**
	 * Отсылает http заголовок статуса с кодом 404
	 *
	 * @param bool $exit Ключ, указывающий производить ли завершение работы скрипта
	 * */
	public function sendStatus404($exit = true)
	{
		$this->sendHeader(SHTTP::getProtocolName()." 404 Not Found");

		if (true === $exit) exit();
	}

	//*********************************************************************************

	/**
	 * Отсылает http заголовок статуса с кодом 500
	 *
	 * @param bool $exit Ключ, указывающий производить ли завершение работы скрипта
	 * */
	public function sendStatus500($exit = true)
	{
		$this->sendHeader(SHTTP::getProtocolName()." 500 Internal Server Error");

		if (true === $exit) exit();
	}

	//*********************************************************************************

	/**
	 * Отсылает http заголовок статуса с кодом 503
	 *
	 * @param bool $exit Ключ, указывающий производить ли завершение работы скрипта
	 * */
	public function sendStatus503($exit = true)
	{
		$this->sendHeader(SHTTP::getProtocolName()." 503 Service Unavailable");

		if (true === $exit) exit();
	}

	//*********************************************************************************

	/**
	 * Отображает страницу ошибки, используя метод пользовательского класса GLOB::showPageError(), который должен быть обязательно объявлен
	 *
	 * @param string $text Текст который выводится на данной странице
	 * @param string $responseStatus Код http статуса ответа сервера
	 * */
	private function showPageError($text, $responseStatus)
	{
		GLOB::showPageError($text, $responseStatus);
	}

	//*********************************************************************************
}

?>