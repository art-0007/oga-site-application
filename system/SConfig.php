<?php

/**
 * Содержит набор переменных конфигурации проекта. А также производит их инициализацию
 *
 * @package System
 * */
class SConfig
{
	//*********************************************************************************

	/**
	 * @var array Массив конфигурационных опций
	 * */
	public static $config = array();

	/**
	 * @var bool Ключ указывающий помещать ли в лог запросы в базу данных
	 * */
	public static $logDBQueries = false;

	/**
	 * @var bool Ключ указывающий использовать ли классические URL или ЧПУ
	 * */
	public static $classicUrl = false;

	/**
	 * @var string Содержит относительный пут к директории с шаблонами
	 * */
	public static $templateDir = "/template";

	/**
	 * @var string Содержит абсолютный путь к директории с библиотеками сторонних разработчиков
	 * */
	public static $thirdPartyLibraryPath = "/usr/www_php_third_party_library";

	/**
	 * @var bool Ключ указывающий производить ли отладку работы (эта переменая влияет как на вывод содержимого отладочного буфера, так и на вывод отладочной информации в JavaScript - этот флаг обычно учитывается таким образом в пользовательском коде)
	 * */
	public static $debug = true;

	/**
	 * @var bool Ключ указывающий отображать ли строку со статистическими данными
	 * */
	public static $showStatistic = false;

	/**
	 * @var bool Ключ указывающий отображать ли строку с данными стандартного буфера вывода, в случае возникновения ошибки
	 * */
	public static $showStdOut = true;

	//*********************************************************************************

	/**
	 * Производит инициализацию переменных конфигурации
	 * */
 	public static function loadConfig()
 	{
		self::loadConfigFromFile();

		if(isset(self::$config["logDBQueries"]))
		{
			self::$logDBQueries = self::$config["logDBQueries"];
		}

		if(isset(self::$config["classicUrl"]))
		{
			self::$classicUrl = self::$config["classicUrl"];
		}

		if(isset(self::$config["templateDir"]))
		{
			self::$templateDir = self::$config["templateDir"];
		}

		if(isset(self::$config["thirdPartyLibraryPath"]))
		{
			self::$thirdPartyLibraryPath = self::$config["thirdPartyLibraryPath"];
		}

		if(isset(self::$config["debug"]))
		{
			self::$debug = self::$config["debug"];
		}

		if(isset(self::$config["showStatistic"]))
		{
			self::$showStatistic = self::$config["showStatistic"];
		}

		if(isset(self::$config["showStdOut"]))
		{
			self::$showStdOut = self::$config["showStdOut"];
		}
 	}

	//*********************************************************************************

	/**
	 * Загружает содержимое файла конфигурации и преобразует его в массив, который присваивает переменной self::$config
	 * */
	private static function loadConfigFromFile()
	{
		if (false === ($content = @file_get_contents(PATH."/config/config.json")))
		{
			exit("Ошибка загрузки конфигурационного файла");
		}

		if (null === (self::$config = @json_decode($content, true)))
		{
			exit("Ошибка формата конфигурационного файла");
		}
	}

	//*********************************************************************************
}

?>