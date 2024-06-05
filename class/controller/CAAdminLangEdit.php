<?php

class CAAdminLangEdit extends CAdminAjaxInit
{
	//*********************************************************************************
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		//$this->setInputVars();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$objMLang = MLang::getInstance();

		if (isset($_POST["id"]) AND Reg::isNum($_POST["id"]))
		{
			if (!$objMLang->isExist($_POST["id"]))
			{
				$this->objSOutput->error("Ошибка: такого языка не существует в БД");
			}
		}
		else
		{
			$this->objSOutput->error("Ошибка: ИД имеет неверный формат");
		}

		if(isset($_POST["hotEditName"]) AND !isset($_FILES["hotEditValue"]))
		{
			$_POST[$_POST["hotEditName"]] = $_POST["hotEditValue"];
		}

		if(isset($_FILES["hotEditValue"]))
		{
			if (0 === Func::mb_strcasecmp($_POST["hotEditName"], "fileName1"))
			{
				$_FILES["fileName1"] = $_FILES["hotEditValue"];
			}
			if (0 === Func::mb_strcasecmp($_POST["hotEditName"], "fileName2"))
			{
				$_FILES["fileName2"] = $_FILES["hotEditValue"];
			}
		}

		//Имя
		if (isset($_POST["name"]))
		{
			$this->edit_name($_POST["name"]);
		}
		//Код
		if (isset($_POST["code"]))
		{
			$this->edit_code($_POST["code"]);
		}

		//Изображение 1
		if (isset($_FILES["fileName1"]) AND is_uploaded_file($_FILES["fileName1"]["tmp_name"]))
		{
			$this->edit_img();
		}
		//Изображение 2
		if (isset($_FILES["fileName2"]) AND is_uploaded_file($_FILES["fileName2"]["tmp_name"]))
		{
			$this->edit_imgBig();
		}

		//Позиция
		if (isset($_POST["position"]))
		{
			$this->edit_position($_POST["position"]);
		}

		//Редактируем только в том случае если это не горячее редактирование
		if(!isset($_POST["hotEdit"]))
		{
			// Ключ по умолчанию
			if (isset($_POST["defaultKey"]))
			{
				$this->edit_defaultKey(1);
			}
			else
			{
				$this->edit_defaultKey(0);
			}
		}

		$data = array
		(
			"html" => $this->html,
		);

		$this->objSOutput->ok("Язык отредактирован", $data);
	}

	//*********************************************************************************

	private function edit_name($value)
	{
		$objMLang = MLang::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Ошибка: имя не может быть пустым");
		}

		//Проверяем существование с таким name
		if (true === $objMLang->isExistByName($value, $_POST["id"]))
		{
			$this->objSOutput->error("Язык с таким именем уже существует");
		}

		$data = array
		(
			"name" => $value,
		);
		$objMLang->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function edit_code($value)
	{
		$objMLang = MLang::getInstance();
		$value = trim($value);

		//Проверяем существование с таким devName
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Укажите код языка");
		}

		//Проверяем существование с таким devName
		if (true === $objMLang->isExistByCode($value, $_POST["id"]))
		{
			$this->objSOutput->error("Язык с таким кодом уже существует");
		}

		$data = array
		(
			"code" => $value,
		);
		$objMLang->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function edit_position($value)
	{
		$objMLang = MLang::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$value = $objMLang->getMaxPosition() + 1;
		}

		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: позиция имеет неверный формат");
		}

		$data =
		[
			"position" => $value,
		];

		$objMLang->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function edit_defaultKey($value)
	{
		$objMLang = MLang::getInstance();
		$value = trim($value);

		//Если язык дефолтный то не даем убрать галочку
		if (0 === (int)$value AND $objMLang->isDefault($_POST["id"]))
		{
			$this->objSOutput->error("В системе не может не быть языка по умолчанию");
		}

		//Если проставляют язык дефолтным, то все остальные делаем не дефолнтыми
		if (1 === (int)$value)
		{
			$objMLang->setAllDefaultKeyInZero(0);
		}

		$data = array
		(
			"defaultKey" => $value,
		);
		$objMLang->edit($_POST["id"], $data);
	}

	//*********************************************************************************

	private function edit_img()
	{
		$objMLang = MLang::getInstance();

		$langInfo = $objMLang->getInfo($_POST["id"]);

		$directory = "/template/img/lang/";
		$partDirectory = PATH.$directory;
		$file = "fileName1";
		//Генерируем имя файла
		//$fileName = Func::uniqueIdForDB(DB_langLang, $file, 10, "mixed", "", "", "");
		$fileName = $langInfo["code"]."_flag";

		//Дополнительная проверка данных Filedata
		if (false === is_uploaded_file($_FILES[$file]["tmp_name"]))
		{
			$this->objSOutput->error("hacket attamp");
		}

		//Достаем разширение файла. Это нужно для проверки на svg
		$extension = pathinfo($_FILES[$file]["name"], PATHINFO_EXTENSION);

		if ("svg" === $extension)
		{
			$ext = $extension;

			if (false === @copy($_FILES[$file]["tmp_name"], $partDirectory."/".$fileName.".".$extension))
			{
				@unlink($partDirectory."/".$fileName.".".$extension);

				$this->objSOutput->error("Ошибка передачи файла на сервер 1 img-svg");
			}
		}
		else
		{
			if (false === ($ext = Func::getImageType($_FILES[$file]["tmp_name"])))
			{
				$this->objSOutput->error("Файл изображения имеет недопустимый тип");
			}

			if (false === @copy($_FILES[$file]["tmp_name"], $partDirectory."/".$fileName.".".$ext))
			{
				@unlink($partDirectory."/".$fileName.".".$ext);

				$this->objSOutput->error("Ошибка передачи файла на сервер 1 img");
			}
		}

		@unlink($partDirectory."/".$langInfo["img"]);

		//Получаем имя файла из пути
		//$fileName = basename($fileName);

		$data = array
		(
			"img" => $directory.$fileName.".".$ext,
		);
		$objMLang->edit($_POST["id"], $data);

		$this->html = $directory.$fileName.".".$ext;
	}

	//*********************************************************************************

	private function edit_imgBig()
	{
		$objMLang = MLang::getInstance();

		$langInfo = $objMLang->getInfo($_POST["id"]);

		$directory = "/template/img/lang/";
		$partDirectory = PATH.$directory;
		$file = "fileName2";
		//Генерируем имя файла
		//$fileName = Func::uniqueIdForDB(DB_langLang, $file, 10, "mixed", "", "", "");
		$fileName = $langInfo["code"]."_flag_big";

		//Дополнительная проверка данных Filedata
		if (false === is_uploaded_file($_FILES[$file]["tmp_name"]))
		{
			$this->objSOutput->error("hacket attamp");
		}

		//Достаем разширение файла. Это нужно для проверки на svg
		$extension = pathinfo($_FILES[$file]["name"], PATHINFO_EXTENSION);

		if ("svg" === $extension)
		{
			$ext = $extension;

			if (false === @copy($_FILES[$file]["tmp_name"], $partDirectory."/".$fileName.".".$extension))
			{
				@unlink($partDirectory."/".$fileName.".".$extension);

				$this->objSOutput->error("Ошибка передачи файла на сервер 2 imgBig-svg");
			}
		}
		else
		{
			if (false === ($ext = Func::getImageType($_FILES[$file]["tmp_name"])))
			{
				$this->objSOutput->error("Файл изображения имеет недопустимый тип");
			}

			if (false === @copy($_FILES[$file]["tmp_name"], $partDirectory."/".$fileName.".".$ext))
			{
				@unlink($partDirectory."/".$fileName.".".$ext);

				$this->objSOutput->error("Ошибка передачи файла на сервер 2 imgBig");
			}
		}

		@unlink($partDirectory."/".$langInfo["imgBig"]);

		//Получаем имя файла из пути
		//$fileName = basename($fileName);

		$data = array
		(
			"imgBig" => $directory.$fileName.".".$ext,
		);
		$objMLang->edit($_POST["id"], $data);

		$this->html = $directory.$fileName.".".$ext;
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>