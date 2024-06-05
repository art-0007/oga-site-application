<?php

//Контроллер по умолчанию (используется только для ЧПУ)
$routes["defaultController"] = array("controller" => "CIndex", "type" => SEProcessorType::usual, "args" => array("template" => "index.html"));

//Правила перенаправлений
$routes["rules"] = array
(
	//Админка
	"/admin/" => array("controller" => "CAdminLogin", "type" => SEProcessorType::usual),
	//Авторизация админ пользователя
	"/ajax/CAAdminLogin/" => array("controller" => "CAAdminLogin", "type" => SEProcessorType::ajax),
	//Розвторизация админ пользователя
	"/ajax/CAAdminLogout/" => array("controller" => "CAAdminLogout", "type" => SEProcessorType::ajax),
	//*************************************************************************************************************************************************

	//Страница списка E-mail
	"/admin/email/" => array("controller" => "CAdminEmail", "type" => SEProcessorType::usual),
	//Страница просмотра E-mail
	"/admin/email/view/{emailId:~[0-9]+}/" => array("controller" => "CAdminEmailView", "type" => SEProcessorType::usual),
	//Удаление E-mail
	"/ajax/CAAdminEmailDelete/" => array("controller" => "CAAdminEmailDelete", "type" => SEProcessorType::ajax),

	//*************************************************************************************************************************************************

	//Страница  списка E-mail подписчиков на рассылку
	"/admin/subscribe/" => array("controller" => "CAdminSubscribe", "type" => SEProcessorType::usual),

	//*************************************************************************************************************************************************

	//Скачивание файла
	"/download/" => array("controller" => "CDownload", "type" => SEProcessorType::base),

	//*************************************************************************************************************************************************

	//Общие настройки
	"/admin/settings-edit/" => array("controller" => "CAdminSettingsEdit", "type" => SEProcessorType::usual),
	//Редактирование обшие настройки
	"/ajax/CAAdminSettingsEdit/" => array("controller" => "CAAdminSettingsEdit", "type" => SEProcessorType::ajax),

	//*************************************************************************************************************************************************

	//Страница списка языков
	"/admin/lang/list/" => array("controller" => "CAdminLangList", "type" => SEProcessorType::usual),
	//Страница добавление статьи
	"/admin/lang/add/" => array("controller" => "CAdminLangAdd", "type" => SEProcessorType::usual),
	//Добавление аякс
	"/ajax/CAAdminLangAdd/" => array("controller" => "CAAdminLangAdd", "type" => SEProcessorType::ajax),
	//Страница редактирования статьи
	"/admin/lang/edit/{langId:~[0-9]+}/" => array("controller" => "CAdminLangEdit", "type" => SEProcessorType::usual),
	//Редактирование аякс
	"/ajax/CAAdminLangEdit/" => array("controller" => "CAAdminLangEdit", "type" => SEProcessorType::ajax),
	//Удаление аякс
	"/ajax/CAAdminLangDelete/" => array("controller" => "CAAdminLangDelete", "type" => SEProcessorType::ajax),

	//*************************************************************************************************************************************************

	//Страница выбора языка
	"/admin/language-selection-page/" => array("controller" => "CAdminLanguageSelectionPage", "type" => SEProcessorType::usual),

	//*************************************************************************************************************************************************

	// Преобразования названия каталога в URL
	"/ajax/CAAdminTranslitUrlName/" => array("controller" => "CAAdminTranslitUrlName", "type" => SEProcessorType::ajax),

	//*************************************************************************************************************************************************

	//Статьи
	"/admin/article/{articleCatalogId:~[0-9]+}/" => array("controller" => "CAdminArticle", "type" => SEProcessorType::usual),

	//Страница добавление статьи
	"/admin/article/add/{articleCatalogId:~[0-9]+}/" => array("controller" => "CAdminArticleAdd", "type" => SEProcessorType::usual),
	//Добавление аякс
	"/ajax/CAAdminArticleAdd/" => array("controller" => "CAAdminArticleAdd", "type" => SEProcessorType::ajax),
	//Страница редактирования статьи
	"/admin/article/edit/{articleId:~[0-9]+}/" => array("controller" => "CAdminArticleEdit", "type" => SEProcessorType::usual),
	//Редактирование аякс
	"/ajax/CAAdminArticleEdit/" => array("controller" => "CAAdminArticleEdit", "type" => SEProcessorType::ajax),
	//Удаление аякс
	"/ajax/CAAdminArticleDelete/" => array("controller" => "CAAdminArticleDelete", "type" => SEProcessorType::ajax),

	//Страница списка статьи
	"/admin/article-image/{articleId:~[0-9]+}/" => array("controller" => "CAdminArticleImage", "type" => SEProcessorType::usual),

	//Страница добавление изображения статьи
	"/admin/article-image/add/{articleId:~[0-9]+}/" => array("controller" => "CAdminArticleImageAdd", "type" => SEProcessorType::usual),
	//Добавление аякс
	"/ajax/CAAdminArticleImageAdd/" => array("controller" => "CAAdminArticleImageAdd", "type" => SEProcessorType::ajax),
	//Страница редактирования изображения статьи
	"/admin/article-image/edit/{articleImageId:~[0-9]+}/" => array("controller" => "CAdminArticleImageEdit", "type" => SEProcessorType::usual),
	//Редактирование аякс
	"/ajax/CAAdminArticleImageEdit/" => array("controller" => "CAAdminArticleImageEdit", "type" => SEProcessorType::ajax),
	//Удаление аякс
	"/ajax/CAAdminArticleImageDelete/" => array("controller" => "CAAdminArticleImageDelete", "type" => SEProcessorType::ajax),

	//Удаление аякс изображения статьи в редактировании статьи
	"/ajax/CAAdminArticleOneImageDelete/" => array("controller" => "CAAdminArticleOneImageDelete", "type" => SEProcessorType::ajax),

	//Страница добавление каталога статьи
	"/admin/article-catalog/add/{articleCatalogId:~[0-9]+}/" => array("controller" => "CAdminArticleCatalogAdd", "type" => SEProcessorType::usual),
	//Добавление аякс
	"/ajax/CAAdminArticleCatalogAdd/" => array("controller" => "CAAdminArticleCatalogAdd", "type" => SEProcessorType::ajax),
	//Страница редактирования каталога статьи
	"/admin/article-catalog/edit/{articleCatalogId:~[0-9]+}/" => array("controller" => "CAdminArticleCatalogEdit", "type" => SEProcessorType::usual),
	//Редактирование аякс
	"/ajax/CAAdminArticleCatalogEdit/" => array("controller" => "CAAdminArticleCatalogEdit", "type" => SEProcessorType::ajax),
	//Удаление аякс
	"/ajax/CAAdminArticleCatalogDelete/" => array("controller" => "CAAdminArticleCatalogDelete", "type" => SEProcessorType::ajax),

	//*************************************************************************************************************************************************

	//Статический HTML
	"/admin/static-html/" => array("controller" => "CAdminStaticHtml", "type" => SEProcessorType::usual),
	//Страница добавление
	"/admin/static-html/add/" => array("controller" => "CAdminStaticHtmlAdd", "type" => SEProcessorType::usual),
	//Добавление аякс
	"/ajax/CAAdminStaticHtmlAdd/" => array("controller" => "CAAdminStaticHtmlAdd", "type" => SEProcessorType::ajax),
	//Страница редактирования
	"/admin/static-html/edit/{staticHtmlId:~[0-9]+}/" => array("controller" => "CAdminStaticHtmlEdit", "type" => SEProcessorType::usual),
	//Редактирование аякс
	"/ajax/CAAdminStaticHtmlEdit/" => array("controller" => "CAAdminStaticHtmlEdit", "type" => SEProcessorType::ajax),
	//Удаление аякс
	"/ajax/CAAdminStaticHtmlDelete/" => array("controller" => "CAAdminStaticHtmlDelete", "type" => SEProcessorType::ajax),

	//*************************************************************************************************************************************************

	//Список админпользователей
	"/admin/admin-user/" => array("controller" => "CAdminAdminUser", "type" => SEProcessorType::usual),

	//Страница добавление
	"/admin/admin-user/add/" => array("controller" => "CAdminAdminUserAdd", "type" => SEProcessorType::usual),
	//Добавление аякс
	"/ajax/CAAdminAdminUserAdd/" => array("controller" => "CAAdminAdminUserAdd", "type" => SEProcessorType::ajax),
	//Страница редактирования
	"/admin/admin-user/edit/{adminUserId:~[0-9]+}/" => array("controller" => "CAdminAdminUserEdit", "type" => SEProcessorType::usual),
	//Редактирование аякс
	"/ajax/CAAdminAdminUserEdit/" => array("controller" => "CAAdminAdminUserEdit", "type" => SEProcessorType::ajax),
	//Удаление аякс
	"/ajax/CAAdminAdminUserDelete/" => array("controller" => "CAAdminAdminUserDelete", "type" => SEProcessorType::ajax),

	//*************************************************************************************************************************************************

	//Список статических страниц
	"/admin/page/" => array("controller" => "CAdminPage", "type" => SEProcessorType::usual),

	//Страница добавление статической страницы
	"/admin/page/add/" => array("controller" => "CAdminPageAdd", "type" => SEProcessorType::usual),
	//Добавление аякс
	"/ajax/CAAdminPageAdd/" => array("controller" => "CAAdminPageAdd", "type" => SEProcessorType::ajax),
	//Страница редактирования статической страницы
	"/admin/page/edit/{pageId:~[0-9]+}/" => array("controller" => "CAdminPageEdit", "type" => SEProcessorType::usual),
	//Редактирование аякс
	"/ajax/CAAdminPageEdit/" => array("controller" => "CAAdminPageEdit", "type" => SEProcessorType::ajax),
	//Удаление аякс
	"/ajax/CAAdminPageDelete/" => array("controller" => "CAAdminPageDelete", "type" => SEProcessorType::ajax),

	//*************************************************************************************************************************************************

	//Список файлов хранилища
	"/admin/file/{fileCatalogId:~[0-9]+}/" => array("controller" => "CAdminFile", "type" => SEProcessorType::usual),

	//Страница добавление файлов хранилища
	"/admin/file/add/{fileCatalogId:~[0-9]+}/" => array("controller" => "CAdminFileAdd", "type" => SEProcessorType::usual),
	//Добавление аякс
	"/ajax/CAAdminFileAdd/" => array("controller" => "CAAdminFileAdd", "type" => SEProcessorType::ajax),
	//Удаление аякс
	"/ajax/CAAdminFileDelete/" => array("controller" => "CAAdminFileDelete", "type" => SEProcessorType::ajax),

	//Страница добавление каталога файлов хранилища
	"/admin/file-catalog/add/{fileCatalogId:~[0-9]+}/" => array("controller" => "CAdminFileCatalogAdd", "type" => SEProcessorType::usual),
	//Добавление аякс
	"/ajax/CAAdminFileCatalogAdd/" => array("controller" => "CAAdminFileCatalogAdd", "type" => SEProcessorType::ajax),
	//Страница редактирования каталога хранилища
	"/admin/file-catalog/edit/{fileCatalogId:~[0-9]+}/" => array("controller" => "CAdminFileCatalogEdit", "type" => SEProcessorType::usual),
	//Редактирование аякс
	"/ajax/CAAdminFileCatalogEdit/" => array("controller" => "CAAdminFileCatalogEdit", "type" => SEProcessorType::ajax),
	//Удаление аякс
	"/ajax/CAAdminFileCatalogDelete/" => array("controller" => "CAAdminFileCatalogDelete", "type" => SEProcessorType::ajax),

	//*************************************************************************************************************************************************

	//Список изображения слайдера
	"/admin/slider-image/{sliderImageCatalogId:~[0-9]+}/" => array("controller" => "CAdminSliderImage", "type" => SEProcessorType::usual),

	//Страница добавление изображения слайдера
	"/admin/slider-image/add/{sliderImageCatalogId:~[0-9]+}/" => array("controller" => "CAdminSliderImageAdd", "type" => SEProcessorType::usual),
	//Добавление аякс
	"/ajax/CAAdminSliderImageAdd/" => array("controller" => "CAAdminSliderImageAdd", "type" => SEProcessorType::ajax),
	//Страница редактирования изображения слайдера
	"/admin/slider-image/edit/{sliderImageId:~[0-9]+}/" => array("controller" => "CAdminSliderImageEdit", "type" => SEProcessorType::usual),
	//Редактирование аякс
	"/ajax/CAAdminSliderImageEdit/" => array("controller" => "CAAdminSliderImageEdit", "type" => SEProcessorType::ajax),
	//Удаление аякс
	"/ajax/CAAdminSliderImageDelete/" => array("controller" => "CAAdminSliderImageDelete", "type" => SEProcessorType::ajax),

	//Страница добавление каталога слайдера
	"/admin/slider-image-catalog/add/{sliderImageCatalogId:~[0-9]+}/" => array("controller" => "CAdminSliderImageCatalogAdd", "type" => SEProcessorType::usual),
	//Добавление аякс
	"/ajax/CAAdminSliderImageCatalogAdd/" => array("controller" => "CAAdminSliderImageCatalogAdd", "type" => SEProcessorType::ajax),
	//Страница редактирования каталога слайдера
	"/admin/slider-image-catalog/edit/{sliderImageCatalogId:~[0-9]+}/" => array("controller" => "CAdminSliderImageCatalogEdit", "type" => SEProcessorType::usual),
	//Редактирование аякс
	"/ajax/CAAdminSliderImageCatalogEdit/" => array("controller" => "CAAdminSliderImageCatalogEdit", "type" => SEProcessorType::ajax),
	//Удаление аякс
	"/ajax/CAAdminSliderImageCatalogDelete/" => array("controller" => "CAAdminSliderImageCatalogDelete", "type" => SEProcessorType::ajax),

	//*************************************************************************************************************************************************

	//Системы опнлайн оплаты
	"/admin/online-pay-system/list/" => array("controller" => "CAdminOnlinePaySystemList", "type" => SEProcessorType::usual),
	//Страница редактирования
	"/admin/online-pay-system/{onlinePaySystemId:~[0-9]+}/" => array("controller" => "CAdminOnlinePaySystemEdit", "type" => SEProcessorType::usual),
	//Редактирование аякс
	"/ajax/CAAdminOnlinePaySystemEdit/" => array("controller" => "CAAdminOnlinePaySystemEdit", "type" => SEProcessorType::ajax),

	//*************************************************************************************************************************************************

	//Транзакции онлайн оплаты
	"/admin/donate/list/" => array("controller" => "CAdminDonateList", "type" => SEProcessorType::usual),

	//*************************************************************************************************************************************************

	//Транзакции онлайн оплаты
	"/admin/online-pay-transaction/list/{donateId:~[0-9]+}/" => array("controller" => "CAdminOnlinePayTransactionList", "type" => SEProcessorType::usual),

	//Запросы транзакции онлайн оплаты
	"/admin/online-pay-transaction-request/list/{onlinePayTransactionId:~[0-9]+}/" => array("controller" => "CAdminOnlinePayTransactionRequestList", "type" => SEProcessorType::usual),
	//Просмотр запроса транзакции онлайн оплаты
	"/admin/online-pay-transaction-request/{onlinePayTransactionRequestId:~[0-9]+}/" => array("controller" => "CAdminOnlinePayTransactionRequestView", "type" => SEProcessorType::usual),

	//*************************************************************************************************************************************************
	//*************************************************************************************************************************************************
	//*************************************************************************************************************************************************

	//Мобильное меню
	"/ajax/CAGetMobileMenu/" => array("controller" => "CAGetMobileMenu", "type" => SEProcessorType::ajax),

	//Страница поиска
	"/search/" => array("controller" => "CSearch", "type" => SEProcessorType::usual),
	"/ajax/CASearch/" => array("controller" => "CASearch", "type" => SEProcessorType::ajax),

	//Статические страницы
	"/page/{pageUrlName:~[a-z0-9\-]+}/" => array("controller" => "CPage", "type" => SEProcessorType::usual),

	//Успешная оплата
	"/online-pay-uccess/" => array("controller" => "COnlinePaySccess", "type" => SEProcessorType::usual),
	//Статические страницы
	"/online-pay-error/" => array("controller" => "COnlinePayError", "type" => SEProcessorType::usual),

	//Просмотр
	"/{articleUrlName:~[a-z0-9\-]+\-a[0-9]+}/" => array("controller" => "CSomeElementView", "type" => SEProcessorType::usual),

	//Страница списка project
	"/project/" => array("controller" => "CProject", "type" => SEProcessorType::usual),
	//Просмотр каталога project
	"/project/{articleCatalogUrlName:~[a-z0-9\-]+\-ac[0-9]+}/" => array("controller" => "CProject", "type" => SEProcessorType::usual),
	//Просмотр project
	"/project/{articleUrlName:~[a-z0-9\-]+\-a[0-9]+}/" => array("controller" => "CProjectView", "type" => SEProcessorType::usual),

	//Страница списка partner
	"/partner/" => array("controller" => "CPartner", "type" => SEProcessorType::usual),

	//Страница списка
	"/donate/" => array("controller" => "CDonate", "type" => SEProcessorType::usual),

	//Страница
	"/get-involved/" => array("controller" => "CGetInvolved", "type" => SEProcessorType::usual),

	//Страница списка project
	"/team/" => array("controller" => "CTeam", "type" => SEProcessorType::usual),
	"/team/{articleCatalogUrlName:~[a-z0-9\-]+\-ac[0-9]+}/" => array("controller" => "CTeam", "type" => SEProcessorType::usual),
	//Просмотр услуг
	"/team/{articleUrlName:~[a-z0-9\-]+\-a[0-9]+}/" => array("controller" => "CTeamView", "type" => SEProcessorType::usual),

	//Страница списка project
	"/event/" => array("controller" => "CEvent", "type" => SEProcessorType::usual),
	//Просмотр услуг
	"/event/{articleUrlName:~[a-z0-9\-]+\-a[0-9]+}/" => array("controller" => "CEventView", "type" => SEProcessorType::usual),

	//Страница списка новостей
	"/news/" => array("controller" => "CNews", "type" => SEProcessorType::usual),
	//Просмотр новости
	"/news/{articleUrlName:~[a-z0-9\-]+\-a[0-9]+}/" => array("controller" => "CNewsView", "type" => SEProcessorType::usual),

	//Модельное окно
	"/ajax/CAGetModal/" => array("controller" => "CAGetModal", "type" => SEProcessorType::ajax),

	//Форма доната
	"/ajax/CAProjectDonateFormShow/" => array("controller" => "CAProjectDonateFormShow", "type" => SEProcessorType::ajax),
	//Форма доната
	"/ajax/CADonateFormShow/" => array("controller" => "CADonateFormShow", "type" => SEProcessorType::ajax),
	"/ajax/CADonateFormSend/" => array("controller" => "CADonateFormSend", "type" => SEProcessorType::ajax),
	//Форма события
	"/ajax/CARegisterForEventFormShow/" => array("controller" => "CARegisterForEventFormShow", "type" => SEProcessorType::ajax),
	"/ajax/CARegisterForEventFormSend/" => array("controller" => "CARegisterForEventFormSend", "type" => SEProcessorType::ajax),
	//Форма getInvolved
	"/ajax/CAGetInvolvedFormShow/" => array("controller" => "CAGetInvolvedFormShow", "type" => SEProcessorType::ajax),
	"/ajax/CAGetInvolvedFormSend/" => array("controller" => "CAGetInvolvedFormSend", "type" => SEProcessorType::ajax),
	//Форма контакты
	"/ajax/CAContactUsFormSend/" => array("controller" => "CAContactUsFormSend", "type" => SEProcessorType::ajax),
	//Форма подписки
	"/ajax/CASubscribeFormShow/" => array("controller" => "CASubscribeFormShow", "type" => SEProcessorType::ajax),
	"/ajax/CASubscribeFormSend/" => array("controller" => "CASubscribeFormSend", "type" => SEProcessorType::ajax),
	//Форма доната на видео
	"/ajax/CAProjectVideoFormShow/" => array("controller" => "CAProjectVideoFormShow", "type" => SEProcessorType::ajax),
	"/ajax/CAProjectVideoFormSend/" => array("controller" => "CAProjectVideoFormSend", "type" => SEProcessorType::ajax),

	"/online-pay/start/" => ["controller" => "COnlinePayStart", "type" => SEProcessorType::base],
	"/online-pay/process/" => ["controller" => "COnlinePayProcess", "type" => SEProcessorType::base],
	"/online-pay/result/" => ["controller" => "COnlinePayResult", "type" => SEProcessorType::base],

	"/online-pay/check-complete-status/" => ["controller" => "COnlinePayCheckCompleteStatus", "type" => SEProcessorType::base],

);

?>
