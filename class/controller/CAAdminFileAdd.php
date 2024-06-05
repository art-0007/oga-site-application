<?php

class CAAdminFileAdd extends CAjaxInit
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

		$this->objSOutput->ok("Файл загружен", array("fileCatalogId" => $this->vars["fileCatalogId"]));

	}

	//*********************************************************************************

	private function add()
	{
		$objMFile = MFile::getInstance();
		$objMFileType = MFileType::getInstance();
		$nameOriginal = $_FILES["fileName"]["name"];

		//Проверяем существование с таким nameOriginal
		if (true === $objMFile->isExistByNameOriginal($nameOriginal))
		{
			$this->objSOutput->error("Файл с таким наименованием уже существует");
		}

		$time = time();
		$fileName = $this->uploadFile();

  		$data = array
		(
			"fileCatalog_id" => $this->vars["fileCatalogId"],
			"fileType_id" => $objMFileType->getIdByExtension(Func::getFileExtension($nameOriginal)),
			"name" => $fileName,
			"nameOriginal" => $nameOriginal,
			"size" => $_FILES["fileName"]["size"],
			"time" => $time,
		);

  		$objMFile->add($data);
	}

	//*********************************************************************************

	private function uploadFile()
	{
		$ext = Func::getFileExtension($_FILES["fileName"]["name"], true);

		//Генерируем полный путь к файлу
		$fileName = PATH.GLOB::$SETTINGS["adminFileDir"]."/".Func::uniqueIdForDB(DB_file, "name", 10, "mixed", "", "", "").$ext;

		if (false === Func::moveUploadedFile("fileName", $fileName))
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
		$objMFileCatalog = MFileCatalog::getInstance();
		$this->objValidation->newCheck();

		//-----------------------------------------------------------------------------------

		$rules = array
		(
			Validation::exist => "Недостаточно данных [fileCatalogId]",
			Validation::isNum => "Некоректные данные [fileCatalogId]",
		);

		$this->objValidation->checkVars("fileCatalogId", $rules, $_POST);

 		//Проверяем существование с таким id
		if (!$objMFileCatalog->isExist($this->objValidation->vars["fileCatalogId"]))
		{
			$this->objSOutput->critical("Каталога файлов с таким id не существует [".$this->objValidation->vars["fileCatalogId"]."]");
		}

		//-----------------------------------------------------------------------------------

		//Дополнительная проверка данных fileName
		if (false === is_uploaded_file($_FILES["fileName"]["tmp_name"]))
		{
			$this->objSOutput->error("Выберите файл изображения товара");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>