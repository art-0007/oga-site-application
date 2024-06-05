<?php

if (!isset($config["dbPrefix"])) $config["dbPrefix"] = "";

//Таблица настроек
define("DB_settings", $config["dbPrefix"]."settings");
define("DB_new_settings", $config["dbPrefix"]."new_settings");
//Таблица общих данных
define("DB_global", $config["dbPrefix"]."global");
//Языки
define("DB_lang", $config["dbPrefix"]."lang");

//Пользователи админ панели
define("DB_adminUser", $config["dbPrefix"]."adminUser");
define("DB_adminUserSession", $config["dbPrefix"]."adminUserSession");

//Статический html
define("DB_staticHtml", $config["dbPrefix"]."staticHtml");
define("DB_staticHtmlLang", $config["dbPrefix"]."staticHtmlLang");

//Статические страницы
define("DB_page", $config["dbPrefix"]."page");
define("DB_pageLang", $config["dbPrefix"]."pageLang");

//Файлы хранилища
define("DB_file", $config["dbPrefix"]."file");
define("DB_fileCatalog", $config["dbPrefix"]."fileCatalog");
define("DB_fileType", $config["dbPrefix"]."fileType");

//Статьи
define("DB_article", $config["dbPrefix"]."article");
define("DB_articleLang", $config["dbPrefix"]."articleLang");
define("DB_articleCatalog", $config["dbPrefix"]."articleCatalog");
define("DB_articleCatalogLang", $config["dbPrefix"]."articleCatalogLang");
define("DB_articleImage", $config["dbPrefix"]."articleImage");

//Каталог
define("DB_catalog", $config["dbPrefix"]."catalog");
define("DB_catalogLang", $config["dbPrefix"]."catalogLang");

//Товар
define("DB_data", $config["dbPrefix"]."data");
define("DB_dataLang", $config["dbPrefix"]."dataLang");

/*
//Размер товара
define("DB_dataSize", $config["dbPrefix"]."dataSize");
define("DB_dataSizeLang", $config["dbPrefix"]."dataSizeLang");

//Цвет товара
define("DB_dataColor", $config["dbPrefix"]."dataColor");
define("DB_dataColorLang", $config["dbPrefix"]."dataColorLang");
*/

//изображения товара
define("DB_dataImage", $config["dbPrefix"]."dataImage");
define("DB_dataImageType", $config["dbPrefix"]."dataImageType");

//Метки товара
define("DB_dataMark", $config["dbPrefix"]."dataMark");
define("DB_dataMarkData", $config["dbPrefix"]."dataMarkData");
define("DB_dataMarkLang", $config["dbPrefix"]."dataMarkLang");

//Слайдер
define("DB_sliderImageCatalog", $config["dbPrefix"]."sliderImageCatalog");
define("DB_sliderImageCatalogLang", $config["dbPrefix"]."sliderImageCatalogLang");
define("DB_sliderImage", $config["dbPrefix"]."sliderImage");
define("DB_sliderImageLang", $config["dbPrefix"]."sliderImageLang");

//Заказ
define("DB_order", $config["dbPrefix"]."order");
define("DB_orderOffer", $config["dbPrefix"]."orderOffer");
//Статусы заказа
define("DB_orderStatus", $config["dbPrefix"]."orderStatus");
define("DB_orderStatusLang", $config["dbPrefix"]."orderStatusLang");
//Тип доставки заказа
define("DB_orderDeliveryType", $config["dbPrefix"]."orderDeliveryType");
define("DB_orderDeliveryTypeLang", $config["dbPrefix"]."orderDeliveryTypeLang");
//Тип оплаты заказа
define("DB_orderPayType", $config["dbPrefix"]."orderPayType");
define("DB_orderPayTypeLang", $config["dbPrefix"]."orderPayTypeLang");

//E-mail
define("DB_email", $config["dbPrefix"]."email");

//E-mail подписчиков
define("DB_subscribe", $config["dbPrefix"]."subscribe");

//Поиск
define("DB_search", $config["dbPrefix"]."search");

//Пользователи
define("DB_user", $config["dbPrefix"]."user");
define("DB_userSession", $config["dbPrefix"]."userSession");

//Донаты
define("DB_donate", $config["dbPrefix"]."donate");
//Online Pay
define("DB_onlinePaySystem", $config["dbPrefix"]."onlinePaySystem");
define("DB_onlinePayTransaction", $config["dbPrefix"]."onlinePayTransaction");
define("DB_onlinePayTransactionRequest", $config["dbPrefix"]."onlinePayTransactionRequest");

?>