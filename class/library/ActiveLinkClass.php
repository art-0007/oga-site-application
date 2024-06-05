<?php

class ActiveLinkClass extends Base
{
	private static $obj = null;

	private $activeLinkClassArray = "";

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
			self::$obj = new ActiveLinkClass();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function getActiveLinkClass()
	{
		return $this->activeLinkClassArray;
	}

	//*********************************************************************************

	private function init()
	{
		$indexActive = "";
		$aboutActive = "";
		$contactsActive = "";
		$newsActive = "";
		$projectActive = "";
		$eventActive = "";
		$donateActive = "";
		$partnerActive = "";
		$teamActive = "";

		switch($this->objSRouter->className)
		{
			//Акции
			case "CIndex":
			{
				$indexActive = "active";
				break;
			}

			case "CNews":
			case "CNewsView":
			{
				$newsActive = "active";
				break;
			}

			case "CProject":
			CASE "CProjectView":
			{
				$projectActive = "active";
				break;
			}

			case "CEvent":
			CASE "CEventView":
			{
				$eventActive = "active";
				break;
			}

			case "CDonate":
			CASE "CDonateView":
			{
				$donateActive = "active";
				break;
			}

			case "CPartner":
			CASE "CPartnerView":
			{
				$partnerActive = "active";
				break;
			}

			case "CTeame":
			CASE "CTeamView":
			{
				$donateActive = "active";
				break;
			}

			//Статические страницы
			case "CPage":
			{
				$objMPage = MPage::getInstance();

				//Достаем ид страницы по pageUrlName
    			$devName = $objMPage->getDevName($objMPage->getIdByUrlName($_GET["pageUrlName"]));

				switch($devName)
				{
					//Статические страницы
					case "about":
					{
						$aboutActive = "active";
						break;
					}
					//Статические страницы
					case "contacts":
					{
						$contactsActive = "active";
						break;
					}
					default:
					{
						break;
					}
				}

				break;
			}

			default:
			{
				break;
			}
		}

		$this->activeLinkClassArray =
		[
			"indexActive" => $indexActive,
			"aboutActive" => $aboutActive,
			"contactsActive" => $contactsActive,
			"newsActive" => $newsActive,
			"projectActive" => $projectActive,
			"eventActive" => $eventActive,
			"donateActive" => $donateActive,
			"partnerActive" => $partnerActive,
			"teamActive" => $teamActive,
		];
	}

	//*********************************************************************************

}


?>