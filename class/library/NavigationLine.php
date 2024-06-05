<?php

class NavigationLine extends Base
{
	private $html = "";
	private static $obj = null;

	/*********************************************************************************/

	protected function __construct()
	{
		parent::__construct();
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
			self::$obj = new NavigationLine();
		}

		return self::$obj;
	}

	/*********************************************************************************/

	public function getHtml()
	{
		return $this->html;
	}

	/*********************************************************************************/

 	public function initNavLine($ajaxKey = false)
 	{
 		$html = "";

 		switch($this->objSRouter->className)
 		{
		    //Статические страницы
		    case "CIndex":
		    {
			    break;
		    }

		    //Статические страницы
		    case "CPage":
		    {
			    $objMPage = MPage::getInstance();

			    if (false !== $pageInfo = $objMPage->getInfo($objMPage->getIdByUrlName($_GET["pageUrlName"])))
			    {
				    $data =
				    [
					    "title" => (!empty($pageInfo["pageTitle"]) ? Convert::textUnescape($pageInfo["pageTitle"], false) : Convert::textUnescape($pageInfo["title"], false)),
				    ];
				    //Формируем содержимое навигационной строки
				    $html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);
			    }

			    break;
		    }

		    //
		    case "COnlinePaySccess":
		    {
			    $objMPage = MPage::getInstance();
			    $pageInfo = $objMPage->getInfo($objMPage->getIdByDevName(EPageDevName::onlinePaySuccess));

			    $data =
			    [
				    "title" => (!empty($pageInfo["pageTitle"]) ? Convert::textUnescape($pageInfo["pageTitle"], false) : Convert::textUnescape($pageInfo["title"], false)),
			    ];
			    //Формируем содержимое навигационной строки
			    $html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);

			    break;
		    }

		    //
		    case "COnlinePayError":
		    {
			    $objMPage = MPage::getInstance();
			    $pageInfo = $objMPage->getInfo($objMPage->getIdByDevName(EPageDevName::onlinePayError));

			    $data =
			    [
				    "title" => (!empty($pageInfo["pageTitle"]) ? Convert::textUnescape($pageInfo["pageTitle"], false) : Convert::textUnescape($pageInfo["title"], false)),
			    ];
			    //Формируем содержимое навигационной строки
			    $html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);

			    break;
		    }

  			//Страница списка новостей
 			case "CNews":
 			{
		 		$objMArticleCatalog = MArticleCatalog::getInstance();
				$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("news"));

				$data = array
	      		(
	      			"title" => (!empty($articleCatalogInfo["pageTitle"]) ? Convert::textUnescape($articleCatalogInfo["pageTitle"], false) : Convert::textUnescape($articleCatalogInfo["title"], false)),
	      		);
				//Формируем содержимое навигационной строки
				$html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);

 				break;
 			}

 			//Страница просмотра новости
 			case "CNewsView":
 			{
			    $objMArticleCatalog = MArticleCatalog::getInstance();
			    $objMArticle = MArticle::getInstance();
			    $articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("news"));
			    $newsId = 0;

			    if (isset($_GET["articleUrlName"]))
			    {
				    $newsId = $objMArticle->getIdByUrlName($_GET["articleUrlName"]);
			    }

			    $articleInfo = $objMArticle->getInfo($newsId);

			    $data1 =
			    [
				    "href" => "/news/",
				    "title" => (!empty($articleCatalogInfo["pageTitle"]) ? Convert::textUnescape($articleCatalogInfo["pageTitle"], false) : Convert::textUnescape($articleCatalogInfo["title"], false)),
			    ];
			    $data2 =
			    [
				    "title" => (!empty($articleInfo["pageTitle"]) ? Convert::textUnescape($articleInfo["pageTitle"], false) : Convert::textUnescape($articleInfo["title"], false)),
			    ];
			    //Формируем содержимое навигационной строки
			    $html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_active", $data1).$this->objSTemplate->getHtml("navigationLine", "navigationLineItem_separator").$this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data2);

			    break;
 			}

  			//Страница списка
 			case "CProject":
 			{
		 		$objMArticleCatalog = MArticleCatalog::getInstance();

			    if (isset($_GET["articleCatalogUrlName"]))
			    {
				    $articleCatalogId = $objMArticleCatalog->getIdByUrlName($_GET["articleCatalogUrlName"]);
			    }
			    else
			    {
				    $articleCatalogId = $objMArticleCatalog->getIdByDevName("project");
			    }

			    //$data =
	      		//[
	      		//	"title" => (!empty($articleCatalogInfo["pageTitle"]) ? Convert::textUnescape($articleCatalogInfo["pageTitle"]) : Convert::textUnescape($articleCatalogInfo["title"])),
	      		//];
				////Формируем содержимое навигационной строки
				//$html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);


			    $html = $this->getArticleCatalogListHtmlForArticleCatalog($articleCatalogId, "/project/", false);

 				break;
 			}

 			//Страница просмотра
 			case "CProjectView":
 			{
		 		$objMArticle = MArticle::getInstance();

				$articleId = 0;

				if (isset($_GET["articleUrlName"]))
				{
					$articleId = $objMArticle->getIdByUrlName($_GET["articleUrlName"]);
				}

				$articleInfo = $objMArticle->getInfo($articleId);

				$data1 =
	      		[
	      			"title" => (!empty($articleInfo["pageTitle"]) ? Convert::textUnescape($articleInfo["pageTitle"], false) : Convert::textUnescape($articleInfo["title"], false)),
	      		];
				//Формируем содержимое навигационной строки
				$html = $this->getArticleCatalogListHtmlForArticleCatalog($articleInfo["articleCatalogId"], "/project/", true).$this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data1);

 				break;
 			}

  			//Страница списка
 			case "CEvent":
 			{
		 		$objMArticleCatalog = MArticleCatalog::getInstance();
				$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("event"));

				$data =
	      		[
	      			"title" => (!empty($articleCatalogInfo["pageTitle"]) ? Convert::textUnescape($articleCatalogInfo["pageTitle"]) : Convert::textUnescape($articleCatalogInfo["title"])),
	      		];
				//Формируем содержимое навигационной строки
				$html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);

 				break;
 			}

 			//Страница просмотра
 			case "CEventView":
 			{
		 		$objMArticleCatalog = MArticleCatalog::getInstance();
		 		$objMArticle = MArticle::getInstance();
				$articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("event"));
				$eventId = 0;

				if (isset($_GET["articleUrlName"]))
				{
					$eventId = $objMArticle->getIdByUrlName($_GET["articleUrlName"]);
				}

				$articleInfo = $objMArticle->getInfo($eventId);

				$data1 =
	      		[
	      			"href" => "/event/",
	      			"title" => (!empty($articleCatalogInfo["pageTitle"]) ? Convert::textUnescape($articleCatalogInfo["pageTitle"], false) : Convert::textUnescape($articleCatalogInfo["title"], false)),
	      		];
				$data2 =
	      		[
	      			"title" => (!empty($articleInfo["pageTitle"]) ? Convert::textUnescape($articleInfo["pageTitle"], false) : Convert::textUnescape($articleInfo["title"], false)),
	      		];
				//Формируем содержимое навигационной строки
				$html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_active", $data1).$this->objSTemplate->getHtml("navigationLine", "navigationLineItem_separator").$this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data2);

 				break;
 			}

		    //Страница списка
		    case "CTeam":
		    {
			    $objMArticleCatalog = MArticleCatalog::getInstance();
			    $articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("team"));

			    $data =
			    [
				    "title" => (!empty($articleCatalogInfo["pageTitle"]) ? Convert::textUnescape($articleCatalogInfo["pageTitle"]) : Convert::textUnescape($articleCatalogInfo["title"])),
			    ];
			    //Формируем содержимое навигационной строки
			    $html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);

			    break;
		    }

		    //Страница просмотра
		    case "CTeamView":
		    {
			    $objMArticleCatalog = MArticleCatalog::getInstance();
			    $objMArticle = MArticle::getInstance();
			    $articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("team"));
			    $teamId = 0;

			    if (isset($_GET["articleUrlName"]))
			    {
				    $teamId = $objMArticle->getIdByUrlName($_GET["articleUrlName"]);
			    }

			    $articleInfo = $objMArticle->getInfo($teamId);

			    $data1 =
			    [
				    "href" => "/team/",
				    "title" => (!empty($articleCatalogInfo["pageTitle"]) ? Convert::textUnescape($articleCatalogInfo["pageTitle"], false) : Convert::textUnescape($articleCatalogInfo["title"], false)),
			    ];
			    $data2 =
			    [
				    "title" => (!empty($articleInfo["pageTitle"]) ? Convert::textUnescape($articleInfo["pageTitle"], false) : Convert::textUnescape($articleInfo["title"], false)),
			    ];
			    //Формируем содержимое навигационной строки
			    $html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_active", $data1).$this->objSTemplate->getHtml("navigationLine", "navigationLineItem_separator").$this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data2);

			    break;
		    }

		    //Страница списка
		    case "CDonate":
		    {
			    $objMArticleCatalog = MArticleCatalog::getInstance();
			    $articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("donate"));

			    $data =
			    [
				    "title" => (!empty($articleCatalogInfo["pageTitle"]) ? Convert::textUnescape($articleCatalogInfo["pageTitle"]) : Convert::textUnescape($articleCatalogInfo["title"])),
			    ];
			    //Формируем содержимое навигационной строки
			    $html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);

			    break;
		    }

		    //Страница списка
		    case "CPartner":
		    {
			    $objMArticleCatalog = MArticleCatalog::getInstance();
			    $articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("partner"));

			    $data =
			    [
				    "title" => (!empty($articleCatalogInfo["pageTitle"]) ? Convert::textUnescape($articleCatalogInfo["pageTitle"]) : Convert::textUnescape($articleCatalogInfo["title"])),
			    ];
			    //Формируем содержимое навигационной строки
			    $html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);

			    break;
		    }

		    //Страница списка
		    case "CGetInvolved":
		    {
			    $objMArticleCatalog = MArticleCatalog::getInstance();
			    $articleCatalogInfo = $objMArticleCatalog->getInfo($objMArticleCatalog->getIdByDevName("getInvolved"));

			    $data =
			    [
				    "title" => (!empty($articleCatalogInfo["pageTitle"]) ? Convert::textUnescape($articleCatalogInfo["pageTitle"]) : Convert::textUnescape($articleCatalogInfo["title"])),
			    ];
			    //Формируем содержимое навигационной строки
			    $html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);

			    break;
		    }


		    //Страница списка
		    case "CSomeElementView":
		    {
			    $objMArticle = MArticle::getInstance();
			    $articleId = 0;

			    if (isset($_GET["articleUrlName"]))
			    {
				    $articleId = $objMArticle->getIdByUrlName($_GET["articleUrlName"]);
			    }

			    $articleInfo = $objMArticle->getInfo($articleId);

			    $data1 =
			    [
				    "title" => (!empty($articleInfo["pageTitle"]) ? Convert::textUnescape($articleInfo["pageTitle"], false) : Convert::textUnescape($articleInfo["title"], false)),
			    ];
			    //Формируем содержимое навигационной строки
			    $html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data1);

			    break;
		    }

		    default:
			{
				$data =
				[
					"title" => $this->getDefaultPageTitle(),
				];

				$html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);

				break;
			}
 		}

		if (0 === mb_strlen($html))
		{
			return "";
		}

		$html = $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_first_active").$this->objSTemplate->getHtml("navigationLine", "navigationLineItem_separator").$html;

		//Заворачиваем строку навигации
		$data  =
		[
			"content" => $html,
		];

		$this->html = $this->objSTemplate->getHtml("navigationLine", "content", $data);
 	}

	/*********************************************************************************/

	//HTML список каталогов
	private function getCatalogListHtmlForCatalog($catalogId, $currentCatalogAsLinkKey = false)
	{
		$objMCatalog = MCatalog::getInstance();
		$html = "";
		$catalogArray = $objMCatalog->getListForNavigationLine($catalogId);

		//Формируем содержимое навигационной строки

		$count = count($catalogArray);
		$counter = 0;

		for($i = 0; $i < $count; $i++)
		{
			$counter++;
			$data = array
			(
				"href" => "/".$catalogArray[$i]["urlName"]."/",
				"title" => Convert::textUnescape($catalogArray[$i]["title"], false),
			);

			if($counter === $count)
			{
				if(true === $currentCatalogAsLinkKey)
				{
					$html .= $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_active", $data).$this->objSTemplate->getHtml("navigationLine", "navigationLineItem_separator");
				}
				else
				{
					$html .= $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);
				}
			}
			else
			{
				$html .= $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_active", $data).$this->objSTemplate->getHtml("navigationLine", "navigationLineItem_separator");
			}
		}

		return $html;
	}

	/*********************************************************************************/

	//HTML список каталогов
	private function getArticleCatalogListHtmlForArticleCatalog($articleCatalogId, $firstHref, $currentArticleCatalogAsLinkKey = false)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$html = "";
		$articleCatalogArray = $objMArticleCatalog->getListForNavigationLine($articleCatalogId);

		//Формируем содержимое навигационной строки

		$count = count($articleCatalogArray);
		$counter = 0;

		for($i = 0; $i < $count; $i++)
		{
			$counter++;

			if (1 === $counter)
			{
				$data =
				[
					"href" => $firstHref,
					"title" => Convert::textUnescape($articleCatalogArray[$i]["title"], false),
				];
			}
			else
			{
				$data =
				[
					"href" => $firstHref.$articleCatalogArray[$i]["urlName"]."/",
					"title" => Convert::textUnescape($articleCatalogArray[$i]["title"], false),
				];
			}

			if($counter === $count)
			{
				if(true === $currentArticleCatalogAsLinkKey)
				{
					$html .= $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_active", $data).$this->objSTemplate->getHtml("navigationLine", "navigationLineItem_separator");
				}
				else
				{
					$html .= $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_passive", $data);
				}
			}
			else
			{
				$html .= $this->objSTemplate->getHtml("navigationLine", "navigationLineItem_active", $data).$this->objSTemplate->getHtml("navigationLine", "navigationLineItem_separator");
			}
		}

		return $html;
	}

	/*********************************************************************************/

	private function getDefaultPageTitle()
	{
		$pageTitleArray =
		[
			"CCart" => [1 => "Корзина", 2 => "Кошик", 3 => "Cart"],
			"CCartEmpty" => [1 => "Корзина", 2 => "Кошик", 3 => "Cart"],
			"CCartComplete" => [1 => "Корзина", 2 => "Кошик", 3 => "Cart"],
			"CUserPasswordRecovery" => array(1 => "Восстановление пароля", 2 => "Відновлення паролю", 3 => "Password recovery"),
			"CSearch" => array(1 => "Поиск", 2 => "Пошук", 3 => "Search"),
		];

		if(isset($pageTitleArray[$this->objSRouter->className]))
		{
			return $pageTitleArray[$this->objSRouter->className][GLOB::$langId];
		}

		return "";
	}

	/*********************************************************************************/
}

?>