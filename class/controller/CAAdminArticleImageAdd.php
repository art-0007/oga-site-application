<?php

class CAAdminArticleImageAdd extends CAjaxInit
{
	//*********************************************************************************
	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

 		$this->setInputVars();
		$this->init();
	}

	//*********************************************************************************

 	private function init()
 	{
		$this->objMySQL->startTransaction();

		$this->add();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Изображение статьи создано", array("articleId" => $this->vars["articleId"]));

	}

	//*********************************************************************************

	private function add()
	{
		$objMArticleImage = MArticleImage::getInstance();

		//Проверяем существование с таким title
/*
		if (mb_strlen($this->vars["title"]) > 0)
		{
			if (true === $objMArticleImage->isExistByTitle($this->vars["title"]))
			{
				$this->objSOutput->error("Изображение статьи с таким наименованием уже существует");
			}
		}
*/
		$fileName = $this->uploadFile();

  		$data = array
		(
			"article_id" => $this->vars["articleId"],
			//"title" => $this->vars["title"],
			"position" => $objMArticleImage->getMaxPosition($this->vars["articleId"]) + 1,
			"fileName" => $fileName,
		);

  		$objMArticleImage->add($data);
	}

	//*********************************************************************************

	private function uploadFile()
	{
		$objMArticleImage = MArticleImage::getInstance();

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

		//Получаем имя файла из пути
		$fileName = basename($fileName);

		return $fileName;
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$objMArticle = MArticle::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [articleId]",
			Validation::isNum => "Некоректные данные [articleId]",
		);
		$this->objValidation->checkVars("articleId", $rules, $_POST);

 		//Проверяем существование с таким id
		if (!$objMArticle->isExist($this->objValidation->vars["articleId"]))
		{
			$this->objSOutput->critical("Статьи с таким id не существует [".$this->objValidation->vars["articleId"]."]");
		}

		//-----------------------------------------------------------------------------------

		//Дополнительная проверка данных fileName
		if (false === is_uploaded_file($_FILES["fileName"]["tmp_name"]))
		{
			$this->objSOutput->error("Выберите файл изображения статьи");
		}

		//-----------------------------------------------------------------------------------
/*
		$rules = array
		(
			Validation::exist => "Недостаточно данных [href]",
			Validation::trim => "",
		);

		$this->objValidation->checkVars("href", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [title]",
			Validation::trim => "",
		);

		$this->objValidation->checkVars("title", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [position]",
		);

		$this->objValidation->checkVars("position", $rules, $_POST);

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [text]",
		);

		$this->objValidation->checkVars("text", $rules, $_POST);
*/
		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>