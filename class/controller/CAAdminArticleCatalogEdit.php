<?php

class CAAdminArticleCatalogEdit extends CAdminAjaxInit
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
		$objMArticleCatalog = MArticleCatalog::getInstance();

		if (isset($_POST["id"]) AND Reg::isNum($_POST["id"]))
		{
			if (!$objMArticleCatalog->isExist($_POST["id"]))
			{
				$this->objSOutput->error("Ошибка: такого каталога статей не существует в БД");
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
		}

		//каталогом параметров статей
		if (isset($_POST["articleParameterId"]))
		{
			$this->editArticleParameterId($_POST["articleParameterId"]);
		}
		//Имя для разработчика
		if (isset($_POST["devName"]))
		{
			$this->editDevName($_POST["devName"]);
		}
		//Позиция каталога
		if (isset($_POST["position"]))
		{
			$this->editPosition($_POST["position"]);
		}

	    //Позиция данных в нутри каталога
	    if (isset($_POST["orderInCatalog"]))
	    {
		    $this->editOrderInCatalog($_POST["orderInCatalog"]);
	    }

	    //Тип оформления
	    if (isset($_POST["designType"]))
	    {
		    $this->editDesignType($_POST["designType"]);
	    }

	    //Ширина изображения каталога
		//Высота изображения каталога
		if (isset($_POST["catalogImgWidth_1"])) { $this->editCatalogImgWidth(1, $_POST["catalogImgWidth_1"]); }
		if (isset($_POST["catalogImgHeight_1"])) { $this->editCatalogImgHeight(1, $_POST["catalogImgHeight_1"]); }
		if (isset($_POST["catalogImgWidth_2"])) { $this->editCatalogImgWidth(2, $_POST["catalogImgWidth_2"]); }
		if (isset($_POST["catalogImgHeight_2"])) { $this->editCatalogImgHeight(2, $_POST["catalogImgHeight_2"]); }

		//Ширина изображения в нутри каталога
		//Высота изображения в нутри каталога
		if (isset($_POST["articleImgInCatalogWidth_1"])) { $this->editArticleImgInCatalogWidth(1, $_POST["articleImgInCatalogWidth_1"]); }
		if (isset($_POST["articleImgInCatalogHeight_1"])) { $this->editArticleImgInCatalogHeight(1, $_POST["articleImgInCatalogHeight_1"]); }
		if (isset($_POST["articleImgInCatalogWidth_2"])) { $this->editArticleImgInCatalogWidth(2, $_POST["articleImgInCatalogWidth_2"]); }
		if (isset($_POST["articleImgInCatalogHeight_2"])) { $this->editArticleImgInCatalogHeight(2, $_POST["articleImgInCatalogHeight_2"]); }

		//Название каталога
		if (isset($_POST["title"]))
		{
			$this->editTitle($_POST["title"]);
		}
		//Часть ЧПУ адреса каталога ****** ВАЖНО. Должен идти после editTitle
		if (isset($_POST["urlName"]))
		{
			$this->editUrlName($_POST["urlName"]);
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

	    //Доп поле
	    if (isset($_POST["addField_1"]))
	    {
		    $this->edit_addField(1, $_POST["addField_1"]);
	    }
	    if (isset($_POST["addField_2"]))
	    {
		    $this->edit_addField(2, $_POST["addField_2"]);
	    }
	    if (isset($_POST["addField_3"]))
	    {
		    $this->edit_addField(3, $_POST["addField_3"]);
	    }
	    if (isset($_POST["addField_4"]))
	    {
		    $this->edit_addField(4, $_POST["addField_4"]);
	    }
	    if (isset($_POST["addField_5"]))
	    {
		    $this->edit_addField(5, $_POST["addField_5"]);
	    }
	    if (isset($_POST["addField_6"]))
	    {
		    $this->edit_addField(6, $_POST["addField_6"]);
	    }

	    //Доп поле (Языки)
	    if (isset($_POST["addField_lang_1"]))
	    {
		    $this->edit_addField_lang(1, $_POST["addField_lang_1"]);
	    }
	    if (isset($_POST["addField_lang_2"]))
	    {
		    $this->edit_addField_lang(2, $_POST["addField_lang_2"]);
	    }
	    if (isset($_POST["addField_lang_3"]))
	    {
		    $this->edit_addField_lang(3, $_POST["addField_lang_3"]);
	    }
	    if (isset($_POST["addField_lang_4"]))
	    {
		    $this->edit_addField_lang(4, $_POST["addField_lang_4"]);
	    }
	    if (isset($_POST["addField_lang_5"]))
	    {
		    $this->edit_addField_lang(5, $_POST["addField_lang_5"]);
	    }
	    if (isset($_POST["addField_lang_6"]))
	    {
		    $this->edit_addField_lang(6, $_POST["addField_lang_6"]);
	    }

		//Изображение 1
		if (isset($_FILES["fileName1"]) AND is_uploaded_file($_FILES["fileName1"]["tmp_name"]))
		{
			$this->editImage(1);
		}
		//Изображение 2
		if (isset($_FILES["fileName2"]) AND is_uploaded_file($_FILES["fileName2"]["tmp_name"]))
		{
			$this->editImage(2);
		}
		//Изображение 3
		if (isset($_FILES["fileName3"]) AND is_uploaded_file($_FILES["fileName3"]["tmp_name"]))
		{
			$this->editImage(3);
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

		$data = array
   		(
   			"html" => $this->html,
   		);

  		$this->objSOutput->ok("Каталог отредактирован", $data);
 	}

	//*********************************************************************************

	private function editProjectTypeId($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		$data = array
		(
			"projectType_id" => $value,
		);

		$objMArticleCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editUrlName($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		//Проверяем существование с таким urlName
		if ((mb_strlen($value) !== 0))
		{
			$value = Func::translitForUrlName($value)."-ac".$_POST["id"];
			//$value = Func::translitForUrlName($value);

			if (true === $objMArticleCatalog->isExistByUrlName($value, $_POST["id"]))
			{
				$this->objSOutput->error("Каталог статей с таким URL-лом уже существует");
			}
		}
		else
		{
			$value = Func::translitForUrlName($objMArticleCatalog->getTitle($_POST["id"]))."-ac".$_POST["id"];
			//$value = Func::translitForUrlName($objMArticleCatalog->getTitle($_POST["id"]));
		}

		$data = array
		(
			"urlName" => $value,
		);

		$objMArticleCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editDevName($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		//Проверяем существование с таким urlName
		if ((mb_strlen($value) !== 0) AND (true === $objMArticleCatalog->isExistByDevName($value, $_POST["id"])))
		{
			$this->objSOutput->error("Каталог с таким именем для разработчика уже существует");
		}

		$data = array
		(
			"devName" => $value,
		);

		$objMArticleCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editArticleParameterId($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticleParameter = MArticleParameter::getInstance();
		$value = trim($value);

		//Проверяем существование с таким urlName
		if ((int)$value !== 0 AND !$objMArticleParameter->isExist($value))
		{
			$this->objSOutput->error("Ошибка: Такого каталога параметров статей не существует [".$value."]");
		}

		$data = array
		(
			"articleParameter_id" => $value,
		);

		$objMArticleCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editPosition($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$value = $objMArticleCatalog->getMaxPosition($objMArticleCatalog->getParentId($_POST["id"])) + 1;
		}

		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: позиция имеет неверный формат");
		}

		$data = array
		(
			"position" => $value,
		);

		$objMArticleCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editOrderInCatalog($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Выберите сортировку в нутри каталога статей");
		}

		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: позиция в нутри каталога статей имеет неверный формат");
		}

		if (!isset(EOrderInArticleCatalogType::$orderInArticleCatalogTypeTitleArray[$value]))
		{
			$this->objSOutput->error("Ошибка: позиция в нутри каталога статей имеет неверный формат 2");
		}

		$data = array
		(
			"orderInCatalog" => $value,
		);

		$objMArticleCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editDesignType($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Выберите тип оформленя каталога статей");
		}

		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: тип оформленя каталога статей имеет неверный формат");
		}

		if (!isset(EArticleCatalogDesignType::$typeTitleArray[$value]))
		{
			$this->objSOutput->error("Ошибка: тип оформленя каталога статей имеет неверный формат 2");
		}

		$data = array
		(
			"designType" => $value,
		);

		$objMArticleCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editShowKey($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		$data = array
		(
			"showKey" => $value,
		);

		$objMArticleCatalog->edit($_POST["id"], $data);
	}

	//*********************************************************************************

	private function edit_addField($number, $value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		$data =
		[
			"addField_".$number => $value,
		];

		$objMArticleCatalog->edit($_POST["id"], $data);
	}

	//*********************************************************************************

	private function edit_addField_lang($number, $value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		$data =
		[
			"addField_lang_".$number => $value,
		];

		$objMArticleCatalog->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editTitle($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Ошибка: название не может быть пустым");
		}

		//Проверяем существование с таким title
		if (true === $objMArticleCatalog->isExistByTitle($value, $_POST["id"], $objMArticleCatalog->getParentId($_POST["id"])))
		{
			$this->objSOutput->error("Каталог с таким названием уже существует");
		}

		$data = array
		(
			"title" => $value,
		);

		$objMArticleCatalog->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editPageTitle($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		$data = array
		(
			"pageTitle" => $value,
		);

		$objMArticleCatalog->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editDescription($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		$data = array
		(
			"description" => $value,
		);

		$objMArticleCatalog->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editText($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		$data = array
		(
			"text" => $value,
		);

		$objMArticleCatalog->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editProjectType()
	{
		$objMProjectType = MProjectType::getInstance();
		$objMProjectTypeArticleCatalog = MProjectTypeArticleCatalog::getInstance();
		$html = "";

		if (false === ($res = $objMProjectType->getList()))
		{
			return;
		}

		foreach ($res AS $row)
		{
			$objMProjectTypeArticleCatalog->delete($_POST["id"], $row["id"]);

			if (isset($_POST["projectType".$row["id"]]))
			{
				$data = array
	    		(
	    			"articleCatalog_id" => $_POST["id"],
	    			"projectType_id" => $row["id"],
	    		);

				$objMProjectTypeArticleCatalog->add($data);
			}
		}
	}

	//*********************************************************************************

	private function editMetaTitle($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		$data = array
		(
			"metaTitle" => $value,
		);

		$objMArticleCatalog->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editMetaKeywords($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		$data = array
		(
			"metaKeywords" => $value,
		);

		$objMArticleCatalog->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editMetaDescription($value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		$data = array
		(
			"metaDescription" => $value,
		);

		$objMArticleCatalog->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editCatalogImgWidth($imgId, $value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: ширина изображения каталога статей №".$imgId." (маленькое) должна быть целым положительным числом, или ноль");
		}

		$data = array
		(
			"catalogImgWidth_".$imgId => $value,
		);

		$objMArticleCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editCatalogImgHeight($imgId, $value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: высота изображения каталога статей №".$imgId." (маленькое) должна быть целым положительным числом, или ноль");
		}

		$data = array
		(
			"catalogImgHeight_".$imgId => $value,
		);

		$objMArticleCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editArticleImgInCatalogWidth($imgId, $value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: ширина изображения статей в нутри каталога №".$imgId." (маленькое) должна быть целым положительным числом, или ноль");
		}

		$data = array
		(
			"articleImgInCatalogWidth_".$imgId => $value,
		);

		$objMArticleCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editArticleImgInCatalogHeight($imgId, $value)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: высота изображения статей в нутри каталога №".$imgId." (маленькое) должна быть целым положительным числом, или ноль");
		}

		$data = array
		(
			"articleImgInCatalogHeight_".$imgId => $value,
		);

		$objMArticleCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editImage($imgId)
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();

		$articleCatalogInfo = $objMArticleCatalog->getInfo($_POST["id"]);

		$partDirectory = PATH.GLOB::$SETTINGS["articleCatalogImgDir"];
		$file = "fileName".$imgId;
		//Генерируем имя файла
		$fileName = Func::uniqueIdForDB(DB_articleCatalogLang, $file, 10, "mixed", "", "", "");
		$catalogImgWidth = $articleCatalogInfo["catalogImgWidth_".$imgId];
		$catalogImgHeight = $articleCatalogInfo["catalogImgHeight_".$imgId];

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
			if (0 === (int)$catalogImgWidth OR 0 === (int)$catalogImgHeight)
			{
				if (false === @copy($_FILES[$file]["tmp_name"], $partDirectory."/".$fileName.".".$ext))
				{
					@unlink($partDirectory."/".$fileName.".".$ext);

					$this->objSOutput->error("Ошибка передачи файла на сервер 1");
				}
			}
			else
			{
				if (false === Func::resizeImage($_FILES[$file]["tmp_name"], $partDirectory."/".$fileName, $catalogImgWidth, $catalogImgHeight))
				{
					$this->objSOutput->error("Ошибка передачи файла на сервер 1 1");
				}
			}
		}

		@unlink($partDirectory."/".$articleCatalogInfo[$file]);

		//Получаем имя файла из пути
		//$fileName = basename($fileName);

		$data = array
		(
			$file => $fileName.".".$ext,
		);

		$objMArticleCatalog->editLang($_POST["id"], $data);

		$this->html = GLOB::$SETTINGS["articleCatalogImgDir"]."/".$fileName;
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>
