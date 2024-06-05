<?php

class CAAdminPageEdit extends CAdminAjaxInit
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
		$objMPage = MPage::getInstance();

		if (isset($_POST["id"]) AND Reg::isNum($_POST["id"]))
		{
			if (!$objMPage->isExist($_POST["id"]))
			{
				$this->objSOutput->error("Ошибка: такой страницы не существует в БД");
			}
		}
		else
		{
			$this->objSOutput->error("Ошибка: ИД имеет неверный формат");
		}

		if(isset($_POST["hotEditName"]) AND Func::mb_strcasecmp($_POST["hotEditName"], "fileName") !== 0)
		{
			$_POST[$_POST["hotEditName"]] = $_POST["hotEditValue"];
		}

		if(isset($_FILES["hotEditValue"]))
		{
			if (0 === Func::mb_strcasecmp($_POST["hotEditName"], "fileName1"))
			{
				$_FILES["fileName1"] = $_FILES["hotEditValue"];
			}
		}

		//Имя для разработчика
		if (isset($_POST["devName"]))
		{
			$this->editDevName($_POST["devName"]);
		}

		//URL страницы сайта
		if (isset($_POST["urlName"]))
		{
			$this->editUrlName($_POST["urlName"]);
		}

		//Позиция страницы сайта
		if (isset($_POST["position"]))
		{
			$this->editPosition($_POST["position"]);
		}

		//Ширина изображения страницы
		//Высота изображения страницы
		if (isset($_POST["imgWidth_1"])) { $this->editImgWidth(1, $_POST["imgWidth_1"]); }
		if (isset($_POST["imgHeight_1"])) { $this->editImgHeight(1, $_POST["imgHeight_1"]); }

		//Наименование
		if (isset($_POST["title"]))
		{
			$this->editTitle($_POST["title"]);
		}

		//Текст заголовка страницы
		if (isset($_POST["pageTitle"]))
		{
			$this->editPageTitle($_POST["pageTitle"]);
		}

		//Описание
		if (isset($_POST["description"]))
		{
			$this->editDescription($_POST["description"]);
		}

		//Текст
		if (isset($_POST["text"]))
		{
			$this->editText($_POST["text"]);
		}

		//Map
		if (isset($_POST["map"]))
		{
			$this->edit_map($_POST["map"]);
		}

	    //Доп поле (Языки)
	    if (isset($_POST["addField_lang_1"]))
	    {
		    $this->edit_addField_lang(1, $_POST["addField_lang_1"]);
	    }

	    //metaTitle
		if (isset($_POST["metaTitle"]))
		{
			$this->editMetaTitle($_POST["metaTitle"]);
		}

		//metaKeywords
		if (isset($_POST["metaKeywords"]))
		{
			$this->editMetaKeywords($_POST["metaKeywords"]);
		}

		//metaDescription
		if (isset($_POST["metaDescription"]))
		{
			$this->editMetaDescription($_POST["metaDescription"]);
		}

		//Изображение 1
		if (isset($_FILES["fileName1"]) AND is_uploaded_file($_FILES["fileName1"]["tmp_name"]))
		{
			$this->editImage(1);
		}

 		$data = array
   		(
   			"html" => $this->html,
   		);

  		$this->objSOutput->ok("Страница отредактирована", $data);
 	}

	//*********************************************************************************

	private function editDevName($value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Ошибка: Имя для разработчиков не может быть пустым");
		}

  		//Проверяем существование с таким devName
  		if (true === $objMPage->isExistByDevName($value, $_POST["id"]))
  		{
  			$this->objSOutput->error("Страница с таким именем для разработчиков уже существует");
  		}

		$data = array
		(
			"devName" => $value,
		);

		$objMPage->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editUrlName($value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Ошибка: URL страницы сайта не может быть пустым");
		}

  		//Проверяем существование с таким urlName
  		if (true === $objMPage->isExistByUrlName($value, $_POST["id"]))
  		{
  			$this->objSOutput->error("Страница с таким URL-лом страницы уже существует");
  		}

		$data = array
		(
			"urlName" => $value,
		);

		$objMPage->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editPosition($value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$value = $objMPage->getMaxPosition() + 1;
		}

		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: позиция имеет неверный формат");
		}

		$data = array
		(
			"position" => $value,
		);

		$objMPage->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editImgWidth($imgId, $value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: ширина изображения страницы №".$imgId." должна быть целым положительным числом, или ноль");
		}

		$data = array
		(
			"imgWidth_".$imgId => $value,
		);

		$objMPage->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editImgHeight($imgId, $value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: высота изображения страницы №".$imgId." должна быть целым положительным числом, или ноль");
		}

		$data = array
		(
			"imgHeight_".$imgId => $value,
		);

		$objMPage->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editTitle($value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Ошибка: название не может быть пустым");
		}

  		//Проверяем существование с таким наименованием
  		if (true === $objMPage->isExistByTitle($value, $_POST["id"]))
  		{
  			$this->objSOutput->error("Страница с таким наименованием уже существует");
  		}

		$data = array
		(
			"title" => $value,
		);

		$objMPage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editPageTitle($value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		$data = array
		(
			"pageTitle" => $value,
		);

		$objMPage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editDescription($value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		$data = array
		(
			"description" => $value,
		);

		$objMPage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editText($value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		$data = array
		(
			"text" => $value,
		);

		$objMPage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function edit_map($value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		$data =
		[
			"map" => $value,
		];

		$objMPage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function edit_addField_lang($number, $value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		$data =
		[
			"addField_lang_".$number => $value,
		];

		$objMPage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editMetaTitle($value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		$data = array
		(
			"metaTitle" => $value,
		);

		$objMPage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editMetaKeywords($value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		$data = array
		(
			"metaKeywords" => $value,
		);

		$objMPage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editMetaDescription($value)
	{
		$objMPage = MPage::getInstance();
		$value = trim($value);

		$data = array
		(
			"metaDescription" => $value,
		);

		$objMPage->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editImage($imgId)
	{
		$objMPage = MPage::getInstance();
  		$pageInfo = $objMPage->getInfo($_POST["id"]);

		$partDirectory = PATH.GLOB::$SETTINGS["pageImgDir"];
		$file = "fileName".$imgId;
		//Генерируем имя файла
		$fileName = Func::uniqueId(10, "mixed");

		$imgWidth = $pageInfo["imgWidth_".$imgId];
		$imgHeight = $pageInfo["imgHeight_".$imgId];

		if (isset($_POST["imgWidth_".$imgId])) { $imgWidth = $_POST["imgWidth_".$imgId]; }
		if (isset($_POST["imgHeight_".$imgId])) { $imgHeight = $_POST["imgHeight_".$imgId]; }


		//Дополнительная проверка данных Filedata
		if (false === is_uploaded_file($_FILES[$file]["tmp_name"]))
		{
			$this->objSOutput->error("hacket attamp");
		}

		if (false === ($ext = Func::getImageType($_FILES[$file]["tmp_name"])))
		{
			$this->objSOutput->error("Файл изображения имеет недопустимый тип");
		}


		//Если в размер изображений равен 0, то просто загружаем файл
		if (0 === (int)$imgWidth OR 0 === (int)$imgHeight)
		{
			if (false === @copy($_FILES[$file]["tmp_name"], $partDirectory."/".$fileName.".".$ext))
			{
				@unlink($partDirectory."/".$fileName.".".$ext);

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

		@unlink($partDirectory."/".$pageInfo[$file]);

		//Получаем имя файла из пути
		//$fileName = basename($fileName);

		$data = array
		(
			$file => $fileName.".".$ext,
		);

		$objMPage->edit($_POST["id"], $data);

		$this->html = GLOB::$SETTINGS["pageImgDir"]."/".$fileName.".".$ext;
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>