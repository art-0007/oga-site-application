<?php

class CAAdminSliderImageEdit extends CAdminAjaxInit
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
		$objMSliderImage = MSliderImage::getInstance();

		if (isset($_POST["id"]) AND Reg::isNum($_POST["id"]))
		{
			if (!$objMSliderImage->isExist($_POST["id"]))
			{
				$this->objSOutput->error("Ошибка: такого изображения слайдера не существует в БД");
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

	    //
	    if (isset($_POST["href"]))
	    {
		    $this->editHref($_POST["href"]);
	    }
	    //onclick
	    if (isset($_POST["onclick"]))
	    {
		    $this->edit_onclick($_POST["onclick"]);
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

	    //btnText
	    if (isset($_POST["btnText"]))
	    {
		    $this->edit_btnText($_POST["btnText"]);
	    }
	    //Описание
	    if (isset($_POST["description"]))
	    {
		    $this->edit_description($_POST["description"]);
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

		//Редактируем только в том случае если это не горячее редактирование
		if(!isset($_POST["hotEdit"]))
		{
			// Ключ отображения
			if (isset($_POST["showKey"]))
			{
				$this->editShowKey(1);
			}
			else
			{
				$this->editShowKey(0);
			}
		}

		$objMSliderImage = MSliderImage::getInstance();

		$data =
   		[
   			"sliderImageCatalogId" => $objMSliderImage->getSliderImageCatalogId($_POST["id"]),
   			"html" => $this->html,
   		];

  		$this->objSOutput->ok("Cлайдер отредактирован", $data);
 	}

	//*********************************************************************************

	private function editHref($value)
	{
		$objMSliderImage = MSliderImage::getInstance();
		$value = trim($value);
/*
		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Ошибка: ссылка не может быть пустой");
		}
*/
		$data = array
		(
			"href" => $value,
		);

		$objMSliderImage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function edit_onclick($value)
	{
		$objMSliderImage = MSliderImage::getInstance();
		$value = trim($value);

		$data =
		[
			"onclick" => $value,
		];

		$objMSliderImage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editTitle($value)
	{
		$objMSliderImage = MSliderImage::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Ошибка: наименование не может быть пустым");
		}

		//Проверяем существование с таким title
		if (true === $objMSliderImage->isExistByTitle($value, $_POST["id"], $objMSliderImage->getSliderImageCatalogId($_POST["id"])))
		{
			$this->objSOutput->error("Cлайдер с таким наименованием уже существует в текущем каталоге");
		}

		$data = array
		(
			"title" => $value,
		);

		$objMSliderImage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editPosition($value)
	{
		$objMSliderImage = MSliderImage::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$value = $objMSliderImage->getMaxPosition($objMSliderImage->getSliderImageCatalogId($_POST["id"])) + 1;
		}

		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: позиция имеет неверный формат");
		}

		$data = array
		(
			"position" => $value,
		);

		$objMSliderImage->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editShowKey($value)
	{
		$objMSliderImage = MSliderImage::getInstance();
		$value = trim($value);

		$data = array
		(
			"showKey" => $value,
		);

		$objMSliderImage->edit($_POST["id"], $data);
	}

	//*********************************************************************************

	private function edit_btnText($value)
	{
		$objMSliderImage = MSliderImage::getInstance();
		$value = trim($value);

		$data =
		[
			"btnText" => $value,
		];

		$objMSliderImage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function edit_description($value)
	{
		$objMSliderImage = MSliderImage::getInstance();
		$value = trim($value);

		$data =
		[
			"description" => $value,
		];

		$objMSliderImage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editText($value)
	{
		$objMSliderImage = MSliderImage::getInstance();
		$value = trim($value);

		$data = array
		(
			"text" => $value,
		);

		$objMSliderImage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editImage($imgId = "")
	{
		$objMSliderImage = MSliderImage::getInstance();
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();

		$partDirectory = PATH.GLOB::$SETTINGS["sliderImgDir"];
		$file = "fileName".$imgId;
		//Генерируем имя файла
		$fileName = Func::uniqueIdForDB(DB_sliderImageLang, $file, 10, "mixed", "", "", "");
		$sliderImageInfo = $objMSliderImage->getInfo($_POST["id"]);
		$sliderImageCatalogInfo = $objMSliderImageCatalog->getInfo($sliderImageInfo["sliderImageCatalogId"]);

		$imgWidth = $sliderImageCatalogInfo["imgWidth_1"];
		$imgHeight = $sliderImageCatalogInfo["imgHeight_1"];

		//Дополнительная проверка данных fileName
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

				$this->objSOutput->error("Ошибка передачи файла на сервер 1-svg");
			}
		}
		else
		{
			if (false === ($ext = Func::getImageType($_FILES[$file]["tmp_name"])))
			{
				$this->objSOutput->error("Файл изображения имеет недопустимый тип");
			}

			//Если в размер изображений равен 0, то просто загружаем файл
			if (0 === (int)$imgWidth OR 0 === (int)$imgHeight)
			{
				if (false === @copy($_FILES[$file]["tmp_name"], $partDirectory."/".$fileName.".".$ext))
				{
					@unlink($fileName);

					$this->objSOutput->error("Ошибка передачи файла на сервер 1");
				}
			}
			else
			{
				if (false === Func::resizeImage($_FILES[$file]["tmp_name"], $partDirectory."/".$fileName, $imgWidth, $imgHeight))
				{
					$this->objSOutput->error("Ошибка передачи файла на сервер 1 1");
				}
			}
		}

		@unlink($partDirectory."/".$sliderImageInfo[$file]);

		//Получаем имя файла из пути
		//$fileName = basename($fileName);
		$fileName = $fileName.".".$ext;

		$data = array
		(
			$file => $fileName,
		);

		$objMSliderImage->editLang($_POST["id"], $data);

		$this->html = GLOB::$SETTINGS["sliderImgDir"]."/".$fileName;
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>