<?php

class CAAdminArticleImageEdit extends CAdminAjaxInit
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
		$objMArticleImage = MArticleImage::getInstance();

		if (isset($_POST["id"]) AND Reg::isNum($_POST["id"]))
		{
			if (!$objMArticleImage->isExist($_POST["id"]))
			{
				$this->objSOutput->error("Ошибка: такого изображения статьи не существует в БД");
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
			if (0 === Func::mb_strcasecmp($_POST["hotEditName"], "fileName"))
			{
				$_FILES["fileName"] = $_FILES["hotEditValue"];
			}
		}

		//Часть ЧПУ адреса товара
		if (isset($_POST["href"]))
		{
			$this->editHref($_POST["href"]);
		}

		//Наименование
		if (isset($_POST["title"]))
		{
			$this->editTitle($_POST["title"]);
		}

		//Позиция
		if (isset($_POST["position"]))
		{
			$this->editPosition($_POST["position"]);
		}

		//Текст
		if (isset($_POST["text"]))
		{
			$this->editText($_POST["text"]);
		}

 		//Изображение
		if (isset($_FILES["fileName"]) AND is_uploaded_file($_FILES["fileName"]["tmp_name"]))
		{
			$this->editImage();
		}

		$objMArticleImage = MArticleImage::getInstance();

		$data = array
   		(
   			"articleId" => $objMArticleImage->getArticleId($_POST["id"]),
   			"html" => $this->html,
   		);

  		$this->objSOutput->ok("Изображения статьи отредактировано", $data);
 	}

	//*********************************************************************************

	private function editHref($value)
	{
		$objMArticleImage = MArticleImage::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
/*
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Ошибка: ссылка не может быть пустой");
		}
*/
		$data = array
		(
			"href" => $value,
		);

		$objMArticleImage->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editTitle($value)
	{
		$objMArticleImage = MArticleImage::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
/*
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Ошибка: наименование не может быть пустым");
		}
*/
		//Проверяем существование с таким title
		if (mb_strlen($value) > 0)
		{
			if (true === $objMArticleImage->isExistByTitle($value, $_POST["id"]))
			{
				$this->objSOutput->error("Изображения статьи с таким наименованием уже существует");
			}
		}

		$data = array
		(
			"title" => $value,
		);

		$objMArticleImage->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editPosition($value)
	{
		$objMArticleImage = MArticleImage::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
/*
		if (0 === mb_strlen($value))
		{
			$value = $objMArticleImage->getMaxPosition($objMArticleImage->getArticleImageCatalogId($_POST["id"])) + 1;
		}
*/
		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: позиция имеет неверный формат");
		}

		$data = array
		(
			"position" => $value,
		);

		$objMArticleImage->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editText($value)
	{
		$objMArticleImage = MArticleImage::getInstance();
		$value = trim($value);

		$data = array
		(
			"text" => $value,
		);

		$objMArticleImage->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editImage()
	{
		$objMArticleImage = MArticleImage::getInstance();

		//Дополнительная проверка данных fileName
		if (false === is_uploaded_file($_FILES["fileName"]["tmp_name"]))
		{
			$this->objSOutput->error("hacket attamp");
		}

		if (false === ($ext = Func::getImageType($_FILES["fileName"]["tmp_name"])))
		{
			$this->objSOutput->error("Файл изображения имеет недопустимый тип");
		}

		//Генерируем полный путь к файлу
		$fileName = PATH.GLOB::$SETTINGS["articleImgDir"]."/".Func::uniqueIdForDB(DB_articleImage, "fileName", 10, "mixed", "", "", "").".".$ext;

		if (false === (move_uploaded_file($_FILES["fileName"]["tmp_name"], $fileName)))
		{
			@unlink($fileName);

			$this->objSOutput->error("Ошибка передачи файла на сервер");
		}

		$articleImageInfo = $objMArticleImage->getInfo($_POST["id"]);

		@unlink(PATH.GLOB::$SETTINGS["articleImgDir"]."/".$articleImageInfo["fileName"]);

		//Получаем имя файла из пути
		$fileName = basename($fileName);

		$data = array
		(
			"fileName" => $fileName,
		);

		$objMArticleImage->edit($_POST["id"], $data);

		$this->html = GLOB::$SETTINGS["articleImgDir"]."/".$fileName;
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>