<?php

class CAAdminArticleEdit extends CAdminAjaxInit
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
		$objMArticle = MArticle::getInstance();

		if (isset($_POST["id"]) AND Reg::isNum($_POST["id"]))
		{
			if (!$objMArticle->isExist($_POST["id"]))
			{
				$this->objSOutput->error("Ошибка: такой статьи не существует в БД");
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
			if (0 === Func::mb_strcasecmp($_POST["hotEditName"], "fileName3"))
			{
				$_FILES["fileName3"] = $_FILES["hotEditValue"];
			}
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
		//Связь статьи со значением параметра статьи
		if (isset($_POST["articleParameterValue"]))
		{
			$this->edit_articleParameterValue($_POST["articleParameterValue"]);
		}

		//Наименование
		if (isset($_POST["title"]))
		{
			$this->editTitle($_POST["title"]);
		}
		//Часть ЧПУ адреса товара ****** ВАЖНО. Должен идти после editTitle
		if (isset($_POST["urlName"]))
		{
			$this->editUrlName($_POST["urlName"]);
		}

		//Текст заголовка страницы
		if (isset($_POST["pageTitle"]))
		{
			$this->editPageTitle($_POST["pageTitle"]);
		}

		//linkToCompany
		if (isset($_POST["linkToCompany"]))
		{
			$this->editLinkToCompany($_POST["linkToCompany"]);
		}

		//addField_1
		if (isset($_POST["addField_1"]))
		{
			$this->edit_addField(1, $_POST["addField_1"]);
		}
		//addField_2
		if (isset($_POST["addField_2"]))
		{
			$this->edit_addField(2, $_POST["addField_2"]);
		}
		//addField_3
		if (isset($_POST["addField_3"]))
		{
			$this->edit_addField(3, $_POST["addField_3"]);
		}
		//addField_4
		if (isset($_POST["addField_4"]))
		{
			$this->edit_addField(4, $_POST["addField_4"]);
		}
		//addField_5
		if (isset($_POST["addField_5"]))
		{
			$this->edit_addField(5, $_POST["addField_5"]);
		}
		//addField_6
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

		//Теги статьи
		if (isset($_POST["tag"]))
		{
			$this->editTag($_POST["tag"]);
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
		//Изображение 2
		if (isset($_FILES["fileName2"]) AND is_uploaded_file($_FILES["fileName2"]["tmp_name"]))
		{
			$this->editImage(2);
		}
		/*
		//Изображение 3
		if (isset($_FILES["fileName3"]) AND is_uploaded_file($_FILES["fileName3"]["tmp_name"]))
		{
			$this->editImage(3);
		}
		*/

		if (isset($_FILES["fileName3"]) AND is_uploaded_file($_FILES["fileName3"]["tmp_name"]))
		{
			$this->editFileName3();
		}

		//Редактируем только в том случае если это не горячее редактирование
		if(!isset($_POST["hotEdit"]))
		{
			//Дата / Время
			if (isset($_POST["date"]) AND isset($_POST["time"]))
			{
				$this->editDate($_POST["date"], $_POST["time"]);
			}

			// Ключ отображения
			if (isset($_POST["showKey"]))
			{
				$this->editShowKey(1);
			}
			else
			{
				$this->editShowKey(0);
			}

			$this->editArticleCatalogArticle();
		}

		$data = array
		(
			"html" => $this->html,
		);

		$this->objSOutput->ok("Статья отредактирована", $data);
	}

	//*********************************************************************************

	private function editDevName($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		//Проверяем существование с таким devName
		if ((mb_strlen($value) !== 0) AND (true === $objMArticle->isExistByDevName($value, $_POST["id"])))
		{
			$this->objSOutput->error("Статья с таким именем для разработчика уже существует");
		}

		$data = array
		(
			"devName" => $value,
		);

		$objMArticle->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editUrlName($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		//Проверяем существование с таким urlName
		if ((mb_strlen($value) !== 0))
		{
			$value = Func::translitForUrlName($value)."-a".$_POST["id"];
			//$value = Func::translitForUrlName($value);

			if (true === $objMArticle->isExistByUrlName($value, $_POST["id"]))
			{
				$this->objSOutput->error("Статья с таким URL-лом уже существует");
			}
		}
		else
		{
			$value = Func::translitForUrlName($objMArticle->getTitle($_POST["id"]))."-a".$_POST["id"];
			//$value = Func::translitForUrlName($objMArticle->getTitle($_POST["id"]));
		}

		$data = array
		(
			"urlName" => $value,
		);

		$objMArticle->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editPosition($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$value = $objMArticle->getMaxPosition($objMArticle->getArticleCatalogId($_POST["id"])) + 1;
		}

		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: позиция имеет неверный формат");
		}

		$data = array
		(
			"position" => $value,
		);

		$objMArticle->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	/**
	 * Связь статьи со значением параметра статьи
	 * @param $value
	 */
	private function edit_articleParameterValue($articleParameterValueArray)
	{
		$objMArticleParameterValueArticle = MArticleParameterValueArticle::getInstance();

		//Удаляем все
		$objMArticleParameterValueArticle->deleteByArticleId($_POST["id"]);

		if (!is_array($articleParameterValueArray))
		{
			$articleParameterValueArray[] = $articleParameterValueArray;
		}

		foreach ($articleParameterValueArray AS $key => $articleParameterValueId)
		{
			$data = array
			(
				"articleParameterValue_id" => $articleParameterValueId,
				"article_id" => $_POST["id"],
			);
			$objMArticleParameterValueArticle->add($data);
		}
	}

	//*********************************************************************************

	private function editDate($date, $time)
	{
		$objMArticle = MArticle::getInstance();
		$articleInfo = $objMArticle->getInfo($_POST["id"]);
		$date = trim($date);

		$data = array
		(
			"date" => $date,
			"time" => mktime(substr($time, 0, 2), substr($time, 3, 2), 0, substr($date, 5, 2), substr($date, 8, 2), substr($date, 0, 4)),
		);

		$objMArticle->edit($_POST["id"], $data);

		$this->html = $date;
	}

	//*********************************************************************************

	private function editShowKey($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		$data = array
		(
			"showKey" => $value,
		);

		$objMArticle->edit($_POST["id"], $data);
	}

	//*********************************************************************************

	private function editTitle($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Ошибка: наименование не может быть пустым");
		}

		//Проверяем существование с таким title
		if (true === $objMArticle->isExistByTitle($value, $_POST["id"], $objMArticle->getArticleCatalogId($_POST["id"])))
		{
			$this->objSOutput->error("Статья с таким наименованием уже существует");
		}

		$data = array
		(
			"title" => $value,
		);

		$objMArticle->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editPageTitle($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		$data = array
		(
			"pageTitle" => $value,
		);

		$objMArticle->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editLinkToCompany($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		$data = array
		(
			"linkToCompany" => $value,
		);

		$objMArticle->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function edit_addField($number, $value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		$data = array
		(
			"addField_".$number => $value,
		);

		$objMArticle->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function edit_addField_lang($number, $value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		$data = array
		(
			"addField_lang_".$number => $value,
		);

		$objMArticle->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editDescription($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		$data = array
		(
			"description" => $value,
		);

		$objMArticle->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editText($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		$data = array
		(
			"text" => $value,
		);

		$objMArticle->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editTag($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		$data = array
		(
			"tag" => $value,
		);

		$objMArticle->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editMetaTitle($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		$data = array
		(
			"metaTitle" => $value,
		);

		$objMArticle->editLang($_POST["id"], $data);
	}

	//*********************************************************************************

	private function editMetaKeywords($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		$data = array
		(
			"metaKeywords" => $value,
		);

		$objMArticle->editLang($_POST["id"], $data);
	}

	//*********************************************************************************

	private function editMetaDescription($value)
	{
		$objMArticle = MArticle::getInstance();
		$value = trim($value);

		$data = array
		(
			"metaDescription" => $value,
		);

		$objMArticle->editLang($_POST["id"], $data);
	}

	//*********************************************************************************

	private function editImage($imgId)
	{
		$objMArticle = MArticle::getInstance();
		$objMArticleCatalog = MArticleCatalog::getInstance();

		$articleInfo = $objMArticle->getInfo($_POST["id"]);
		$articleCatalogInfo = $objMArticleCatalog->getInfo($articleInfo["articleCatalogId"]);

		$partDirectory = PATH.GLOB::$SETTINGS["articleImgDir"];
		$file = "fileName".$imgId;
		//Генерируем имя файла
		$fileName = Func::uniqueIdForDB(DB_articleLang, $file, 10, "mixed", "", "", "");
		$articleImgWidth = 0;
		$articleImgHeight = 0;

		//Костыль чтобы не добавлять поля в БД
		if (3 !== (int)$imgId)
		{
			$articleImgWidth = $articleCatalogInfo["articleImgInCatalogWidth_".$imgId];
			$articleImgHeight = $articleCatalogInfo["articleImgInCatalogHeight_".$imgId];
		}

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
			if (0 === (int)$articleImgWidth OR 0 === (int)$articleImgHeight)
			{
				if (false === @copy($_FILES[$file]["tmp_name"], $partDirectory."/".$fileName.".".$ext))
				{
					@unlink($partDirectory."/".$fileName.".".$ext);

					$this->objSOutput->error("Ошибка передачи файла на сервер 1");
				}
			}
			else
			{
				if (false === Func::resizeImage($_FILES[$file]["tmp_name"], $partDirectory."/".$fileName, $articleImgWidth, $articleImgHeight))
				{
					$this->objSOutput->error("Ошибка передачи файла на сервер 1 1");
				}
			}
		}

		@unlink($partDirectory."/".$articleInfo[$file]);

		//Получаем имя файла из пути
		//$fileName = basename($fileName);

		$data = array
		(
			$file => $fileName.".".$ext,
		);

		$objMArticle->editLang($_POST["id"], $data);

		$this->html = GLOB::$SETTINGS["articleImgDir"]."/".$fileName.".".$ext;
	}

	//*********************************************************************************

	private function editFileName3()
	{
		$objMArticle = MArticle::getInstance();

		$partDirectory = PATH.GLOB::$SETTINGS["articleImgDir"];
		$file = "fileName3";

		$ext = Func::getFileExtension($_FILES[$file]["name"]);

		if (Func::mb_strcmp("pdf", $ext) !== 0)
		{
			$this->objSOutput->error("Неверный формат Файла");
		}

		$fileName = mb_substr($_FILES[$file]["name"], 0, mb_strlen($_FILES[$file]["name"]) - 4);
		$fileName = Func::translitForUrlName($fileName).".".$ext;

		if ($objMArticle->isExistByFileName3($fileName, $_POST["id"]))
		{
			$this->objSOutput->error("Файл с таким наименованием уже существует");
		}

		//Дополнительная проверка данных Filedata
		if (false === is_uploaded_file($_FILES[$file]["tmp_name"]))
		{
			$this->objSOutput->error("hacket attamp");
		}

		if (false === @copy($_FILES[$file]["tmp_name"], $partDirectory."/".$fileName))
		{
			@unlink($partDirectory."/".$fileName);

			$this->objSOutput->error("Ошибка передачи файла на сервер 1");
		}

		$data = array
		(
			$file => $fileName,
		);

		$objMArticle->editLang($_POST["id"], $data);

		$this->html = GLOB::$SETTINGS["articleImgDir"]."/".$fileName;
	}

	//*********************************************************************************

	private function editArticleCatalogArticle()
	{
		$objMArticleCatalogArticle = MArticleCatalogArticle::getInstance();

		if (isset($_POST["articleCatalogArticle"]))
		{
			$articleCatalogArticleArray = $_POST["articleCatalogArticle"];

			if (!is_array($articleCatalogArticleArray))
			{
				$articleCatalogArticleArray = [$articleCatalogArticleArray];
			}
		}
		else
		{
			return;
		}

		if (0 === count($articleCatalogArticleArray))
		{
			return;
		}

		//Удаляем все связи
		$objMArticleCatalogArticle->deleteByArticle($_POST["id"]);

		$data = [];

		foreach ($articleCatalogArticleArray AS $articleCatalogId)
		{
			$data[] =
			[
				"articleCatalog_id" => $articleCatalogId,
				"article_id" => $_POST["id"],
			];
		}

		//Добавляем все связи
		$objMArticleCatalogArticle->addGroup($data);
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>
