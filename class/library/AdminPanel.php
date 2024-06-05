<?php

class AdminPanel extends Base
{
	private static $obj = null;

	private $html = "";

	//*********************************************************************************

	protected function __construct()
	{
		parent::__construct();
		$this->init();
	}

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new AdminPanel();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function getHtml()
	{
		return $this->html;
	}

	//*********************************************************************************

	private function init()
	{
		$objMFileCatalog = MFileCatalog::getInstance();

        $catalogId = 0;
		$dataId = 0;

        if (0 === Func::mb_strcmp("CCatalog", $this->objSRouter->className))
        {
            $objMCatalog = MCatalog::getInstance();

	  		if (isset($_GET["catalogId"]))
	  		{
	  			$catalogId = $_GET["catalogId"];
	  		}

	  		if (isset($_GET["catalogUrlName"]))
	  		{
	  			$catalogId = $objMCatalog->getIdByUrlName($_GET["catalogUrlName"]);
	  		}
        }
        elseif (0 === Func::mb_strcmp("CData", $this->objSRouter->className))
        {
			$objMData = MData::getInstance();

	  		if (isset($_GET["dataId"]))
	  		{
	  			$dataId = $_GET["dataId"];
	  		}

	  		if (isset($_GET["dataUrlName"]))
	  		{
	  			$dataId = $objMData->getIdByUrlName($_GET["dataUrlName"]);
	  		}

			$catalogId = $objMData->getCatalogId($dataId);
        }

		$data = array
		(
			"catalogId" => $catalogId,
			"dataId" => $dataId,
			"fileCatalogId" => $objMFileCatalog->getId_base(),
			"additionalButtons" => $this->getAdditionalButtonsHtml(),
		);

		$this->html = $this->objSTemplate->getHtml("adminPanel", "content", $data);
	}

	//*********************************************************************************

	private function getAdditionalButtonsHtml()
	{
		$content = "";

		switch($this->objSRouter->className)
		{
			//Главная
			case "CIndex":
			{
				$objMPage = MPage::getInstance();
				$pageInfo = $objMPage->getInfo(1);

				$data = array
				(
					"id" => $pageInfo["id"],
					"title" => $pageInfo["title"],
				);

				$content = "adminPanel_index";
				break;
			}

			//Статические страницы
			case "CPage":
			{
				$objMPage = MPage::getInstance();
				$pageInfo = $objMPage->getInfo($objMPage->getIdByUrlName($_GET["pageUrlName"]));

				$data = array
				(
					"id" => $pageInfo["id"],
					"title" => $pageInfo["title"],
				);

				$content = "adminPanel_page";
				break;
			}

			//Новости
			case "CNews":
			{
				$objMArticle = MArticle::getInstance();
				$objMArticleCatalog = MArticleCatalog::getInstance();
				$articleCatalogId = $objMArticleCatalog->getIdByDevName("news");
				$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

				$data = array
				(
					"catalogId" => $articleCatalogId,
					"catalogTitle" => $articleCatalogInfo["title"],
					"catalogAddOnclick" => ($objMArticle->isExistByArticleCatalogId($articleCatalogId)) ? "alert('Создание каталога заблокированно. Каталог содержит статьи');" : "AdminFancyboxPage.show('/admin/article-catalog/add/".$articleCatalogId."/');",
					"articleAddOnclick" => ($objMArticleCatalog->hasChild($articleCatalogId)) ? "alert('Создание статьи заблокированно. Каталог содержит каталоги');" : "AdminFancyboxPage.show('/admin/article/add/".$articleCatalogId."/');",
				);

				$content = "adminPanel_articleCatalog";
				break;
			}

			//Страница просмотра новости
			case "CNewsView":
			{
				$objMArticle = MArticle::getInstance();

				$newsId = 0;

				if (isset($_GET["newsId"]))
				{
					$newsId = $_GET["newsId"];
				}
				else
				{
					if (isset($_GET["articleUrlName"]))
					{
						$newsId = $objMArticle->getIdByUrlName($_GET["articleUrlName"]);
					}
				}

				$articleInfo = $objMArticle->getInfo($newsId);

				$data = array
				(
					"id" => $articleInfo["id"],
					"title" => $articleInfo["title"],
				);

				$content = "adminPanel_article";
				break;
			}

			//Статьи
			case "CArticle":
			{
				$objMArticle = MArticle::getInstance();
				$objMArticleCatalog = MArticleCatalog::getInstance();
				$articleCatalogId = $objMArticleCatalog->getIdByDevName("article");
				$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

				$data = array
				(
					"catalogId" => $articleCatalogId,
					"catalogTitle" => $articleCatalogInfo["title"],
					"catalogAddOnclick" => ($objMArticle->isExistByArticleCatalogId($articleCatalogId)) ? "alert('Создание каталога заблокированно. Каталог содержит статьи');" : "AdminFancyboxPage.show('/admin/article-catalog/add/".$articleCatalogId."/');",
					"articleAddOnclick" => ($objMArticleCatalog->hasChild($articleCatalogId)) ? "alert('Создание статьи заблокированно. Каталог содержит каталоги');" : "AdminFancyboxPage.show('/admin/article/add/".$articleCatalogId."/');",
				);

				$content = "adminPanel_articleCatalog";
				break;
			}

			//Страница просмотра статьи
			case "CArticleView":
			{
				$objMArticle = MArticle::getInstance();

				$articleId = 0;

				if (isset($_GET["articleId"]))
				{
					$articleId = $_GET["articleId"];
				}
				else
				{
					if (isset($_GET["articleUrlName"]))
					{
						$articleId = $objMArticle->getIdByUrlName($_GET["articleUrlName"]);
					}
				}

				$articleInfo = $objMArticle->getInfo($articleId);

				$data = array
				(
					"id" => $articleInfo["id"],
					"title" => $articleInfo["title"],
				);

				$content = "adminPanel_article";
				break;
			}

			//Акции
			case "CAction":
			{
				$objMArticle = MArticle::getInstance();
				$objMArticleCatalog = MArticleCatalog::getInstance();
				$articleCatalogId = $objMArticleCatalog->getIdByDevName("action");
				$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

				$data = array
				(
					"catalogId" => $articleCatalogId,
					"catalogTitle" => $articleCatalogInfo["title"],
					"catalogAddOnclick" => ($objMArticle->isExistByArticleCatalogId($articleCatalogId)) ? "alert('Создание каталога заблокированно. Каталог содержит статьи');" : "AdminFancyboxPage.show('/admin/article-catalog/add/".$articleCatalogId."/');",
					"articleAddOnclick" => ($objMArticleCatalog->hasChild($articleCatalogId)) ? "alert('Создание статьи заблокированно. Каталог содержит каталоги');" : "AdminFancyboxPage.show('/admin/article/add/".$articleCatalogId."/');",
				);

				$content = "adminPanel_articleCatalog";
				break;
			}

			//Страница просмотра акции
			case "CActionView":
			{
				$objMArticle = MArticle::getInstance();

				$actionId = 0;

				if (isset($_GET["actionId"]))
				{
					$actionId = $_GET["actionId"];
				}
				else
				{
					if (isset($_GET["actionUrlName"]))
					{
						$actionId = $objMArticle->getIdByUrlName($_GET["actionUrlName"]);
					}
				}

				$articleInfo = $objMArticle->getInfo($actionId);

				$data = array
				(
					"id" => $articleInfo["id"],
					"title" => $articleInfo["title"],
				);

				$content = "adminPanel_article";
				break;
			}

   			//Каталог
			case "CCatalog":
			{
				$objMCatalog = MCatalog::getInstance();

				$catalogId = 0;

		  		if (isset($_GET["catalogId"]))
		  		{
		  			$catalogId = $_GET["catalogId"];
		  		}

		  		if (isset($_GET["catalogUrlName"]))
		  		{
		  			$catalogId = $objMCatalog->getIdByUrlName($_GET["catalogUrlName"]);
		  		}

				if (0 === (int)$catalogId)
				{
					$data = array
					(
						"catalogId" => $catalogId,
						"catalogTitle" => "",
						"catalogAddOnclick" => "AdminFancyboxPage.show('/admin/catalog/add/".$catalogId."/');",
						"catalogAddTitle" => "Добавить новый каталог как главный",
						"catalogEditOnclick" => "alert('Выберите каталог');",
						"catalogDeleteOnclick" => "alert('Выберите каталог');",

						"dataAddOnclick" => "alert('Добавление товара заблокировано. Каталог содержит подкаталоги');",
					);
				}
				else
				{
					$catalogInfo = $objMCatalog->getInfo($catalogId);

					if ($objMCatalog->hasChild($catalogId))
					{
						$data = array
						(
							"catalogId" => $catalogId,
							"catalogTitle" => $catalogInfo["title"],
							"catalogAddOnclick" => "AdminFancyboxPage.show('/admin/catalog/add/".$catalogId."/');",
							"catalogAddTitle" => "Добавить новый каталог в каталог \"".$catalogInfo["title"]."\"",
							"catalogEditOnclick" => "AdminFancyboxPage.show('/admin/catalog/edit/".$catalogId."/');",
							"catalogDeleteOnclick" => "AdminCatalog.deleteConfirm(".$catalogId.");",

							"dataAddOnclick" => "alert('Добавление товара заблокировано. Каталог содержит подкаталоги');",
						);
					}
					else
					{
						if ($objMCatalog->hasData($catalogId))
						{
							$data = array
							(
								"catalogId" => $catalogId,
								"catalogTitle" => $catalogInfo["title"],
								"catalogAddOnclick" => "alert('Добавление каталога заблокировано. Каталог содержит товары');",
								"catalogAddTitle" => "Добавить новый каталог в каталог \"".$catalogInfo["title"]."\"",
								"catalogEditOnclick" => "AdminFancyboxPage.show('/admin/catalog/edit/".$catalogId."/');",
								"catalogDeleteOnclick" => "AdminCatalog.deleteConfirm(".$catalogId.");",

								"dataAddOnclick" => "AdminFancyboxPage.show('/admin/data/add/".$catalogId."/');",
							);
						}
						else
						{
							$data = array
							(
								"catalogId" => $catalogId,
								"catalogTitle" => $catalogInfo["title"],
								"catalogAddOnclick" => "AdminFancyboxPage.show('/admin/catalog/add/".$catalogId."/');",
								"catalogAddTitle" => "Добавить новый каталог в каталог \"".$catalogInfo["title"]."\"",
								"catalogEditOnclick" => "AdminFancyboxPage.show('/admin/catalog/edit/".$catalogId."/');",
								"catalogDeleteOnclick" => "AdminCatalog.deleteConfirm(".$catalogId.");",

								"dataAddOnclick" => "AdminFancyboxPage.show('/admin/data/add/".$catalogId."/');",
							);
						}

					}
				}

				$content = "adminPanel_catalog";
				break;
			}

			//Страница товара
			case "CData":
			{
				$objMData = MData::getInstance();

				$dataId = 0;

		  		if (isset($_GET["dataId"]))
		  		{
		  			$dataId = $_GET["dataId"];
		  		}

		  		if (isset($_GET["dataUrlName"]))
		  		{
		  			$dataId = $objMData->getIdByUrlName($_GET["dataUrlName"]);
		  		}

				$dataInfo = $objMData->getInfo($dataId);

				$data = array
				(
					"dataId" => $dataInfo["id"],
					"dataTitle" => $dataInfo["title"],
				);

				$content = "adminPanel_data";
				break;
			}

			default:
			{
				break;
			}
		}

		if (0 === mb_strlen($content))
		{
			return "";
		}

		return $this->objSTemplate->getHtml("adminPanel", $content, $data);
	}

	//*********************************************************************************

}


?>