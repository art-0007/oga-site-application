<?php

//Нельзя наследовать от BASE, т.к. класс создает экземпляр SRouter еще до сбора роутов и запуска Core
class MSettings
{
	//*********************************************************************************

	private $objMySQL = null;
	private static $obj = null;

	//*********************************************************************************

	protected function __construct()
	{
		$this->init();
	}

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new MSettings();
		}

		return self::$obj;
	}

	//*********************************************************************************

	private function init()
	{
		$this->objMySQL = MySQL::getInstance();
	}

	//*********************************************************************************

	//Достаем настройки
	public function getList()
	{
		$query =
		"
			SELECT
				`".DB_settings."`.*
			FROM
				`".DB_settings."`
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		return $res;
	}

	//*********************************************************************************

	//Достаем настройки
	public function getInfo()
	{
		$query =
			"
			SELECT
				`".DB_settings."`.*
			FROM
				`".DB_settings."`
			WHERE
				`".DB_settings."`.`id`='1'
		";

		$res = $this->objMySQL->query($query);

		if (0 === count($res))
		{
			return false;
		}

		$this->settings = $res[0];

		return $res[0];
	}

	//*********************************************************************************

	public function add($data)
	{
		return $this->objMySQL->insert(DB_new_settings, $data);
	}

	//*********************************************************************************

	public function edit($data)
	{
		return $this->objMySQL->update(DB_settings, $data);
	}

	//*********************************************************************************

	/**
	 * Редактирует значение поля value у строки с указанным значением поля name
	 *
	 * @param string $name Значение поля name
	 * @param string $value Значение поля value
	 */
	public function editValueByName($name, $value)
	{
		$this->objMySQL->update(DB_settings, ["value" => $value], "`name` = '".Func::bb($name)."'", true, false);
	}

	//*********************************************************************************
}

?>