<?php

class CAdminOnlinePaySystemEdit extends CMainAdminFancyBoxInit
{
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		//$this->setCSS();
		$this->setJavaScript();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();

		if (false === $onlinePaySystemInfo = $objMOnlinePaySystem->getInfo($this->vars["onlinePaySystemId"]))
		{
			$this->objSOutput->critical("Ошибка выборки информации о системе онлайн оплаты из БД [".$this->vars["onlinePaySystemId"]."]");
		}

		$data =
		[
			"pageTitleH1" => "Редактирование системы онлайн оплаты \"".$onlinePaySystemInfo["title"]."\"",
			"inputTitleName" => "Наименование",
			"id" => $onlinePaySystemInfo["id"],
			"title" => $onlinePaySystemInfo["title"],
			"devName" => $onlinePaySystemInfo["devName"],
			"onlinePaySystemSettings" => $this->getHtml_onlinePaySystemSettings($onlinePaySystemInfo),
			"position" => $onlinePaySystemInfo["position"],

			"submitButtonTitle" => "Редактировать",
		];

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminOnlinePaySystem", "adminOnlinePaySystemEdit", $data);
	}

	//*********************************************************************************
	
	private function getHtml_onlinePaySystemSettings(&$onlinePaySystemInfo)
	{
		$data = [];
		$settingsArray = $this->getSettings($onlinePaySystemInfo["settings"]);

		switch ($onlinePaySystemInfo["id"])
		{
			case EOnlinePaySystem::stripe:
			{
				$public_key = "";
				$secret_key = "";

				if (isset($settingsArray["public_key"]))
				{
					$public_key = $settingsArray["public_key"];
				}

				if (isset($settingsArray["secret_key"]))
				{
					$secret_key = $settingsArray["secret_key"];
				}

				$data =
				[
					"frontUrl" => $this->getFrontFullUrl(),
					"public_key" => $public_key,
					"secret_key" => $secret_key,
				];

				break;
			}
			case EOnlinePaySystem::payPal:
			{
				$sandboxKey = 0;
				$sandboxKey_checked = "";
				$client_id = "";
				$secret_key = "";

				if (isset($settingsArray["sandboxKey"]))
				{
					$sandboxKey = $settingsArray["sandboxKey"];
					$sandboxKey_checked = ((bool)$settingsArray["sandboxKey"]) ? "checked='checked'" : "";
				}

				if (isset($settingsArray["client_id"]))
				{
					$client_id = $settingsArray["client_id"];
				}

				if (isset($settingsArray["secret_key"]))
				{
					$secret_key = $settingsArray["secret_key"];
				}

				$data =
				[
					"frontUrl" => $this->getFrontFullUrl(),
					"sandboxKey" => $sandboxKey,
					"sandboxKey_checked" => $sandboxKey_checked,
					"client_id" => $client_id,
					"secret_key" => $secret_key,
				];
				break;
			}
			default:
			{
				$this->objSOutput->critical("Unregistered onlinePaySystem [".$onlinePaySystemInfo["id"]."]");
			}
		}

		return $this->objSTemplate->getHtml("adminOnlinePaySystem", "onlinePaySystemSettings_".$onlinePaySystemInfo["id"], $data);
	}

	//*********************************************************************************

	private function getFrontFullUrl()
	{
		return "http://".GLOB::$SETTINGS["front_domain"]."/";
	}

	//*********************************************************************************

	/**
	 * Достает массив информации настроек для способа онлайн оплаты
	 *
	 * @param string $settings настройки системы онлайн оплаты
	 *
	 * @return array Массив информации настроек для системы онлайн оплаты
	 */
	public function getSettings($settings)
	{
		$settingsArray = [];

		if (!Func::isEmpty($settings))
		{
			if (null === ($settingsArray = @json_decode(Convert::textUnescape($settings), true)))
			{
				$this->objSOutput->critical("Failed to json_decode settings");
			}
		}

		return $settingsArray;
	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptCode("var _onlinePaySystemId = \"".$this->vars["onlinePaySystemId"]."\";");
		//$this->objJavaScript->addJavaScriptFile("/js/admin/admin-fancybox-tinymce.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-online-pay-system-list.js");
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();
		$this->objValidation->newCheck();

		//-------------------------------------------------------------

		$rules =
		[
			Validation::exist => "Недостаточно данных [onlinePaySystemId]",
			Validation::isNum => "Некоректные данные [onlinePaySystemId]",
		];
		$this->objValidation->checkVars("onlinePaySystemId", $rules, $_GET);

		//Проверяем существование с таким id
		if (false === $objMOnlinePaySystem->isExist($this->objValidation->vars["onlinePaySystemId"]))
		{
			$this->objSOutput->critical("Системы онлайн оплаты с таким id не существует [".$this->objValidation->vars["onlinePaySystemId"]."]");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>