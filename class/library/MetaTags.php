<?php

class MetaTags extends Base
{
	/*********************************************************************************/

	public $metaTitle = "";
	public $metaKeywords = "";
	public $metaDescription = "";

	private static $obj = null;

	/*********************************************************************************/

	protected function __construct()
	{
		parent::__construct();
		$this->init();
	}

	/*********************************************************************************/

	protected function __clone()
	{
	}

	/*********************************************************************************/

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new MetaTags();
		}

		return self::$obj;
	}

	/*********************************************************************************/

 	private function init()
 	{
		switch($this->objSRouter->className)
		{
			//Главная страница
			case "CIndex":
			{
				$objMPage = MPage::getInstance();

				//Достаем информацию о странице отзывов к сайту
    			$pageInfo = $objMPage->getInfo(1);

				//Заполняем metaTitle
				$this->metaTitle = (!empty($pageInfo["metaTitle"])) ? $pageInfo["metaTitle"] : $pageInfo["title"];
				//Заполняем metaKeywords
				$this->metaKeywords = (!empty($pageInfo["metaKeywords"])) ? $pageInfo["metaKeywords"] : "";
				//Заполняем metaDescription
				$this->metaDescription = (!empty($pageInfo["metaDescription"])) ? $pageInfo["metaDescription"] : "";

				break;
			}

			//Статические страницы
			case "CPage":
			{
				$objMPage = MPage::getInstance();

				//Достаем ид страницы по pageUrlName
				$pageId = $objMPage->getIdByUrlName($_GET["pageUrlName"]);

				//Достаем информацию о статической странице
				if(false === ($pageInfo = $objMPage->getInfo($pageId)))
				{
					return;
				}

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($pageInfo["metaTitle"])) ? $pageInfo["metaTitle"] : $pageInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($pageInfo["metaKeywords"])) ? $pageInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($pageInfo["metaDescription"])) ? $pageInfo["metaDescription"] : "";

				break;
			}


			//Статические страницы
			case "COnlinePaySccess":
			{
				$objMPage = MPage::getInstance();

				//Достаем ид страницы по pageUrlName
				$pageId = $objMPage->getIdByDevName("onlinePaySuccess");

				//Достаем информацию о статической странице
				if(false === ($pageInfo = $objMPage->getInfo($pageId)))
				{
					return;
				}

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($pageInfo["metaTitle"])) ? $pageInfo["metaTitle"] : $pageInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($pageInfo["metaKeywords"])) ? $pageInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($pageInfo["metaDescription"])) ? $pageInfo["metaDescription"] : "";

				break;
			}

			//Статические страницы
			case "COnlinePayError":
			{
				$objMPage = MPage::getInstance();

				//Достаем ид страницы по pageUrlName
				$pageId = $objMPage->getIdByDevName("onlinePayError");

				//Достаем информацию о статической странице
				if(false === ($pageInfo = $objMPage->getInfo($pageId)))
				{
					return;
				}

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($pageInfo["metaTitle"])) ? $pageInfo["metaTitle"] : $pageInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($pageInfo["metaKeywords"])) ? $pageInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($pageInfo["metaDescription"])) ? $pageInfo["metaDescription"] : "";

				break;
			}

			//
			case "CRegistrationComplete":
			{
				$objMPage = MPage::getInstance();

				//Достаем ид страницы по pageUrlName
				$pageId = $objMPage->getIdByDevName("registrationComplete");

				//Достаем информацию о статической странице
				if(false === ($pageInfo = $objMPage->getInfo($pageId)))
				{
					return;
				}

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($pageInfo["metaTitle"])) ? $pageInfo["metaTitle"] : $pageInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($pageInfo["metaKeywords"])) ? $pageInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($pageInfo["metaDescription"])) ? $pageInfo["metaDescription"] : "";

				break;
			}

			//
			case "CUserProfile":
			{
				$objMPage = MPage::getInstance();

				//Достаем ид страницы по pageUrlName
				$pageId = $objMPage->getIdByDevName("userProfile");

				//Достаем информацию о статической странице
				if(false === ($pageInfo = $objMPage->getInfo($pageId)))
				{
					return;
				}

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($pageInfo["metaTitle"])) ? $pageInfo["metaTitle"] : $pageInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($pageInfo["metaKeywords"])) ? $pageInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($pageInfo["metaDescription"])) ? $pageInfo["metaDescription"] : "";

				break;
			}

			//
			case "CUserOrderList":
			{
				$objMPage = MPage::getInstance();

				//Достаем ид страницы по pageUrlName
				$pageId = $objMPage->getIdByDevName("userOrderList");

				//Достаем информацию о статической странице
				if(false === ($pageInfo = $objMPage->getInfo($pageId)))
				{
					return;
				}

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($pageInfo["metaTitle"])) ? $pageInfo["metaTitle"] : $pageInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($pageInfo["metaKeywords"])) ? $pageInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($pageInfo["metaDescription"])) ? $pageInfo["metaDescription"] : "";

				break;
			}

			//
			case "CUserOrderView":
			{
				$objMPage = MPage::getInstance();

				//Достаем ид страницы по pageUrlName
				$pageId = $objMPage->getIdByDevName("userOrderView");

				//Достаем информацию о статической странице
				if(false === ($pageInfo = $objMPage->getInfo($pageId)))
				{
					return;
				}

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($pageInfo["metaTitle"])) ? $pageInfo["metaTitle"] : $pageInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($pageInfo["metaKeywords"])) ? $pageInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($pageInfo["metaDescription"])) ? $pageInfo["metaDescription"] : "";

				break;
			}

			//
			case "CUserChangePassword":
			{
				$objMPage = MPage::getInstance();

				//Достаем ид страницы по pageUrlName
				$pageId = $objMPage->getIdByDevName("userChangePassword");

				//Достаем информацию о статической странице
				if(false === ($pageInfo = $objMPage->getInfo($pageId)))
				{
					return;
				}

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($pageInfo["metaTitle"])) ? $pageInfo["metaTitle"] : $pageInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($pageInfo["metaKeywords"])) ? $pageInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($pageInfo["metaDescription"])) ? $pageInfo["metaDescription"] : "";

				break;
			}

			//Каталог
			case "CCatalog":
			{
				$objMCatalog = MCatalog::getInstance();

				$catalogId = $objMCatalog->getIdByUrlName($_GET["catalogUrlName"]);

				$catalogInfo = $objMCatalog->getInfo($catalogId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($catalogInfo["metaTitle"])) ? $catalogInfo["metaTitle"] : $catalogInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($catalogInfo["metaKeywords"])) ? $catalogInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($catalogInfo["metaDescription"])) ? $catalogInfo["metaDescription"] : "";

				break;
			}

			//товар
			case "COffer":
			{
				$objMData = MData::getInstance();

				$offerId = $objMData->getIdByUrlName($_GET["offerUrlName"]);

				$offerInfo = $objMData->getInfo($offerId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($offerInfo["metaTitle"])) ? $offerInfo["metaTitle"] : $offerInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($offerInfo["metaKeywords"])) ? $offerInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($offerInfo["metaDescription"])) ? $offerInfo["metaDescription"] : "";

				break;
			}

			//Страница списка новостей
			case "CNews":
			{
				$objMArticleCatalog = MArticleCatalog::getInstance();
				//Достаем ИД каталога новостей
				$articleCatalogId = $objMArticleCatalog->getIdByDevName("news");
				//Достаем информацию о каталоге
				$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($articleCatalogInfo["metaTitle"])) ? $articleCatalogInfo["metaTitle"] : $articleCatalogInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($articleCatalogInfo["metaKeywords"])) ? $articleCatalogInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($articleCatalogInfo["metaDescription"])) ? $articleCatalogInfo["metaDescription"] : "";

				break;
			}

			//Страница просмотра
			case "CNewsView":
			{
				$objMArticle = MArticle::getInstance();

				$newsId = 0;

				if (isset($_GET["articleUrlName"]))
				{
					$newsId = $objMArticle->getIdByUrlName($_GET["articleUrlName"]);
				}

				//Достаем информацию о статье
				$articleInfo = $objMArticle->getInfo($newsId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($articleInfo["metaTitle"])) ? $articleInfo["metaTitle"] : $articleInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($articleInfo["metaKeywords"])) ? $articleInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($articleInfo["metaDescription"])) ? $articleInfo["metaDescription"] : "";

				break;
			}

			//Страница списка
			case "CProject":
			{
				$objMArticleCatalog = MArticleCatalog::getInstance();
				//Достаем ИД каталога
				$articleCatalogId = $objMArticleCatalog->getIdByDevName("project");
				//Достаем информацию о каталоге
				$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($articleCatalogInfo["metaTitle"])) ? $articleCatalogInfo["metaTitle"] : $articleCatalogInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($articleCatalogInfo["metaKeywords"])) ? $articleCatalogInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($articleCatalogInfo["metaDescription"])) ? $articleCatalogInfo["metaDescription"] : "";

				break;
			}

			//Страница просмотра
			case "CProjectView":
			{
				$objMArticle = MArticle::getInstance();

				$projectId = 0;

				if (isset($_GET["articleUrlName"]))
				{
					$projectId = $objMArticle->getIdByUrlName($_GET["articleUrlName"]);
				}

				//Достаем информацию о статье
				$articleInfo = $objMArticle->getInfo($projectId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($articleInfo["metaTitle"])) ? $articleInfo["metaTitle"] : $articleInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($articleInfo["metaKeywords"])) ? $articleInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($articleInfo["metaDescription"])) ? $articleInfo["metaDescription"] : "";

				break;
			}

			//Страница списка
			case "CEvent":
			{
				$objMArticleCatalog = MArticleCatalog::getInstance();
				//Достаем ИД каталога
				$articleCatalogId = $objMArticleCatalog->getIdByDevName("event");
				//Достаем информацию о каталоге
				$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($articleCatalogInfo["metaTitle"])) ? $articleCatalogInfo["metaTitle"] : $articleCatalogInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($articleCatalogInfo["metaKeywords"])) ? $articleCatalogInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($articleCatalogInfo["metaDescription"])) ? $articleCatalogInfo["metaDescription"] : "";

				break;
			}

			//Страница просмотра
			case "CEventView":
			{
				$objMArticle = MArticle::getInstance();

				$eventId = 0;

				if (isset($_GET["articleUrlName"]))
				{
					$eventId = $objMArticle->getIdByUrlName($_GET["articleUrlName"]);
				}

				//Достаем информацию о статье
				$articleInfo = $objMArticle->getInfo($eventId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($articleInfo["metaTitle"])) ? $articleInfo["metaTitle"] : $articleInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($articleInfo["metaKeywords"])) ? $articleInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($articleInfo["metaDescription"])) ? $articleInfo["metaDescription"] : "";

				break;
			}

			//Страница списка
			case "CTeam":
			{
				$objMArticleCatalog = MArticleCatalog::getInstance();
				//Достаем ИД каталога
				$articleCatalogId = $objMArticleCatalog->getIdByDevName("team");
				//Достаем информацию о каталоге
				$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($articleCatalogInfo["metaTitle"])) ? $articleCatalogInfo["metaTitle"] : $articleCatalogInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($articleCatalogInfo["metaKeywords"])) ? $articleCatalogInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($articleCatalogInfo["metaDescription"])) ? $articleCatalogInfo["metaDescription"] : "";

				break;
			}

			//Страница просмотра
			case "CTeamView":
			{
				$objMArticle = MArticle::getInstance();

				$teamId = 0;

				if (isset($_GET["articleUrlName"]))
				{
					$teamId = $objMArticle->getIdByUrlName($_GET["articleUrlName"]);
				}

				//Достаем информацию о статье
				$articleInfo = $objMArticle->getInfo($teamId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($articleInfo["metaTitle"])) ? $articleInfo["metaTitle"] : $articleInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($articleInfo["metaKeywords"])) ? $articleInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($articleInfo["metaDescription"])) ? $articleInfo["metaDescription"] : "";

				break;
			}

			//Страница списка
			case "CDonate":
			{
				$objMArticleCatalog = MArticleCatalog::getInstance();
				//Достаем ИД каталога
				$articleCatalogId = $objMArticleCatalog->getIdByDevName("donate");
				//Достаем информацию о каталоге
				$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($articleCatalogInfo["metaTitle"])) ? $articleCatalogInfo["metaTitle"] : $articleCatalogInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($articleCatalogInfo["metaKeywords"])) ? $articleCatalogInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($articleCatalogInfo["metaDescription"])) ? $articleCatalogInfo["metaDescription"] : "";

				break;
			}

			//Страница списка
			case "CPartner":
			{
				$objMArticleCatalog = MArticleCatalog::getInstance();
				//Достаем ИД каталога
				$articleCatalogId = $objMArticleCatalog->getIdByDevName("partner");
				//Достаем информацию о каталоге
				$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($articleCatalogInfo["metaTitle"])) ? $articleCatalogInfo["metaTitle"] : $articleCatalogInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($articleCatalogInfo["metaKeywords"])) ? $articleCatalogInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($articleCatalogInfo["metaDescription"])) ? $articleCatalogInfo["metaDescription"] : "";

				break;
			}

			//Страница списка
			case "CGetInvolved":
			{
				$objMArticleCatalog = MArticleCatalog::getInstance();
				//Достаем ИД каталога
				$articleCatalogId = $objMArticleCatalog->getIdByDevName("getInvolved");
				//Достаем информацию о каталоге
				$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($articleCatalogInfo["metaTitle"])) ? $articleCatalogInfo["metaTitle"] : $articleCatalogInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($articleCatalogInfo["metaKeywords"])) ? $articleCatalogInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($articleCatalogInfo["metaDescription"])) ? $articleCatalogInfo["metaDescription"] : "";

				break;
			}

			//Страница просмотра
			case "CSomeElementView":
			{
				$objMArticle = MArticle::getInstance();

				$articleId = 0;

				if (isset($_GET["articleUrlName"]))
				{
					$articleId = $objMArticle->getIdByUrlName($_GET["articleUrlName"]);
				}

				//Достаем информацию о статье
				$articleInfo = $objMArticle->getInfo($articleId);

				//Заполняем и обрабатываем metaTitle
				$this->metaTitle = (!empty($articleInfo["metaTitle"])) ? $articleInfo["metaTitle"] : $articleInfo["title"];
				//Заполняем и обрабатываем metaKeywords
				$this->metaKeywords = (!empty($articleInfo["metaKeywords"])) ? $articleInfo["metaKeywords"] : "";
				//Заполняем и обрабатываем metaDescription
				$this->metaDescription = (!empty($articleInfo["metaDescription"])) ? $articleInfo["metaDescription"] : "";

				break;
			}

			default:
			{
				//Таги для страниц, которые не конфигурируются
				$this->setDefaultPageMetaTags();
				break;
			}
		}
 	}

	/*********************************************************************************/

	private function setDefaultPageMetaTags()
	{
		$pageTitleArray =
		[
			"CAdminLogin" => [1 => "Авторизация", 2 => "Авторизація", 3 => "Authorization"],
			"CCart" => [1 => "Корзина", 2 => "Кошик", 3 => "Cart"],
			"CCartEmpty" => [1 => "Корзина", 2 => "Кошик", 3 => "Cart"],
			"CCartComplete" => [1 => "Корзина", 2 => "Кошик", 3 => "Cart"],
			"CUserPasswordRecovery" => array(1 => "Восстановление пароля", 2 => "Відновлення паролю", 3 => "Password recovery"),
			"CSearch" => array(1 => "Поиск", 2 => "Пошук", 3 => "Search"),
		];

		if(isset($pageTitleArray[$this->objSRouter->className]))
		{
			$title = $pageTitleArray[$this->objSRouter->className][GLOB::$langId];

			$this->metaTitle = $title;
			$this->metaKeywords = "";
			$this->metaDescription = "";
		}
		else
		{
			$this->metaTitle = "";
			$this->metaKeywords = "";
			$this->metaDescription = "";
		}
	}

	/*********************************************************************************/
}

?>