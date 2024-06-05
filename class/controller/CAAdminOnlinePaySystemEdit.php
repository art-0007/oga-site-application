<?php

class CAAdminOnlinePaySystemEdit extends CAjaxInit
{
	//*********************************************************************************
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$objOnlinePaySystem = OnlinePaySystem::getInstance();

		$this->objMySQL->startTransaction();

		$objOnlinePaySystem->edit_position($this->vars["position"], $this->vars["id"]);

		$this->editSettings();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Система онлайн оплаты отредактирована");
	}

	//*********************************************************************************

	private function editSettings()
	{
		$objOnlinePaySystem = OnlinePaySystem::getInstance();
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();

		if (false === ($onlinePaySystemInfo = $objMOnlinePaySystem->getInfo($this->vars["id"])))
		{
			$this->objSOutput->critical("Failed to load onlinePaySystem info");
		}

		$settingsArray = $objOnlinePaySystem->getSettings($this->vars["id"]);

		switch ($onlinePaySystemInfo["id"])
		{
			case EOnlinePaySystem::stripe:
			{
				$public_key = "";
				$secret_key = "";

				if (isset($_POST["public_key"]) )
				{
					$public_key = $_POST["public_key"];
				}

				if (isset($_POST["secret_key"]) )
				{
					$secret_key = $_POST["secret_key"];
				}

				$settingsArray["public_key"] = $public_key;
				$settingsArray["secret_key"] = $secret_key;

				break;
			}
			case EOnlinePaySystem::payPal:
			{
				$sandboxKey = 0;
				$client_id = "";
				$secret_key = "";

				if (isset($_POST["sandboxKey"]) )
				{
					$sandboxKey = 1;
				}

				if (isset($_POST["client_id"]) )
				{
					$client_id = $_POST["client_id"];
				}

				if (isset($_POST["secret_key"]) )
				{
					$secret_key = $_POST["secret_key"];
				}

				$settingsArray["sandboxKey"] = $sandboxKey;
				$settingsArray["client_id"] = $client_id;
				$settingsArray["secret_key"] = $secret_key;

				break;
			}
			default:
			{
				$this->objSOutput->critical("OnlinePaySystemId not registered [".$onlinePaySystemInfo["id"]."]");
			}
		}

		$objOnlinePaySystem->edit_settings($settingsArray, $this->vars["id"]);
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "ID [id]",
			Validation::isNum => "I [id]"
		];
		$this->objValidation->checkVars("id", $rules, $_POST);

		//Проверяем существование с таким id
		if (false === $objMOnlinePaySystem->isExist($this->objValidation->vars["id"]))
		{
			$this->objSOutput->critical("OnlinePaySystem not found [".$this->objValidation->vars["id"]."]");
		}

		//-----------------------------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [position]",
			Validation::trim => "",
		];
		$this->objValidation->checkVars("position", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>