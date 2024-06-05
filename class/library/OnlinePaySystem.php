<?php

class OnlinePaySystem extends Library
{
	//*********************************************************************************

	/** @var OnlinePaySystem */
	private static $obj = null;

	//*********************************************************************************

	protected function __construct()
	{
		parent::__construct();
	}

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new OnlinePaySystem();
		}

		return self::$obj;
	}

	//*********************************************************************************

	/**
	 * Достает массив информации настроек для системы онлайн оплаты
	 *
	 * @param int $onlinePaySystemId ИД системы онлайн оплаты
	 *
	 * @return array Массив информации настроек для системы онлайн оплаты
	 */
	public function getSettings($onlinePaySystemId)
	{
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();
		$settingsArray = [];

		if (false === ($settings = $objMOnlinePaySystem->getSettings($onlinePaySystemId)))
		{
			$this->objSOutput->critical("Failed to load onlinePaySystem settings [".$onlinePaySystemId."]");
		}

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

	/**
	 * Редактирует значение поля settings
	 *
	 * @param array $settingsArray Массив настроек
	 * @param int $onlinePaySystemId ИД системы онлайн оплаты
	 */
	public function edit_settings($settingsArray, $onlinePaySystemId)
	{
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();

		$data = array
		(
			"settings" => json_encode($settingsArray),
		);
		$objMOnlinePaySystem->edit($onlinePaySystemId, $data);
	}

	//*********************************************************************************

	/**
	 * Редактирует значение поля position
	 *
	 * @param int $position Позиция
	 * @param int $id ИД системы онлайн оплаты
	 */
	public function edit_position($position, $id)
	{
		$objMOnlinePaySystem = MOnlinePaySystem::getInstance();

		if (0 === mb_strlen($position))
		{
			$position = $objMOnlinePaySystem->getMaxPosition();
		}

		$data =
		[
			"position" => $position,
		];
		$objMOnlinePaySystem->edit($id, $data);
	}

	//*********************************************************************************

}

?>