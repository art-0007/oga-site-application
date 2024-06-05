<?php

class Lang extends Base
{
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
			self::$obj = new Lang();
		}

		return self::$obj;
	}

	//*********************************************************************************

	/**
	 * Переберает весь массив языков в базе данных
	 * и для каждого языка создает строку в таблице $table,
	 * в которую заносит данные из массива $data, а также устанвливает значение поля `lang_id` в соответствующее значение
	 * ВНИМАНИЕ! Если в массиве $data будет элемент с ключем lang_id, то он будет переписан.
	 *
	 * @param $table string Имя таблицы
	 * @param $data array Массив полей и их значений в таблице (Ключ это имя поля, а значение это значение поля)
	 *
	 * @return bool TRUE - успех, FALSE - ошибка
	 * */
	public function insertLangDataInDB($table, $data = array(), $processDataKey = true)
	{
		$objMLang = MLang::getInstance();

		//Достаем список языков
		if (false === ($res = $objMLang->getList()))
		{
			//Нет ниодного языка
			$this->objSOutput->critical("Не определено ниодного языка в системе");
		}
		else
		{
			//Перебираем все языки и заносим в базу данных соответствующую строку
			foreach ($res AS $row)
			{
				$data["lang_id"] = $row["id"];

				if (false === $this->objMySQL->insert($table, $data, $processDataKey))
				{
					return false;
				}
			}
		}

		return true;
	}

	//*********************************************************************************

}
?>