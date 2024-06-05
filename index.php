<?php

if(!headers_sent())
{
	header("X-Powered-By: Astrid");
}

$startTime = microtime(true);

//Включаем вывод всех ошибок
error_reporting(E_ALL);
//Установка русской локали
$localeArray = array
(
	"UTF8",
	"UTF-8",
	"ru.UTF8",
	"ru.UTF-8",
	"ru.65001",
	"ru_RU.UTF8",
	"ru_RU.UTF-8",
	"ru_RU.65001",
	"ru_RUS.UTF8",
	"ru_RUS.UTF-8",
	"ru_RUS.65001",
	"rus_RUS.UTF8",
	"rus_RUS.UTF-8",
	"rus_RUS.65001",
	"Russian_Russia.UTF8",
	"Russian_Russia.UTF-8",
	"Russian_Russia.65001",
);

setlocale(LC_ALL, $localeArray);

//Абсолютный путь к директории с проектом
define("PATH", strtr(pathinfo(__FILE__,  PATHINFO_DIRNAME), array("\\" => "/")));

//Подключение файла с списком таблиц БД
require_once(PATH."/config/db_tables.php");

//Директория с файлами system
define("SYSTEM_PATH", PATH."/system");
//Имя share директории
define("SHARE_DIR_NAME", "share");
//Имя tmp директории
define("TMP_DIR_NAME", "tmp");

//Регистрируем функцию автоподключения посредством функции, которая позволяет ставить в стек несколько функций автоподключения
require_once(SYSTEM_PATH."/SAutoloader.php");
$objSAutoloader = SAutoloader::getInstance();
spl_autoload_register(array($objSAutoloader, "autoload"));

//Подключение файла роутеров
require_once(PATH."/config/routes.php");

//Загружаем роуты
SRoutes::loadRules();

//Запуск буферизации вывода. Весь пользовательский код должен размещатся далее
ob_start();

//Создаем глобальный массив настроек
SConfig::loadConfig();

//Регистрируем shutdown функцию, которая будет вызыватся после завершения скрипта
$objShutdown = Shutdown::getInstance();
register_shutdown_function(array($objShutdown, "shutdown"));

//Загружаем настройки системы
GLOB::init();

$objSCore = new SCore();
$objSCore->init();

?>