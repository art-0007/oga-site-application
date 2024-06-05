<?php

class CDownload extends Base
{
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
		$objMFile = MFile::getInstance();

		if (false === ($fileId = $objMFile->getIdByName($_GET["fileName"])))
		{
			$this->objSOutput->error("Файла с таким наименованием не существует");
		}

		if (false === ($fileInfo = $objMFile->getInfo($fileId)))
		{
			$this->objSOutput->error("Ошибка выборки информации о файле из БД");
		}

		$filePath = PATH.GLOB::$SETTINGS["adminFileDir"]."/".$fileInfo["name"];

		//Отправляем заголовки для скачивания
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"".$fileInfo["nameOriginal"]."\"");
		header("Content-Length: ".$fileInfo["size"]);

		$file = fopen($filePath, "r+b");
		$this->objSOutput->ok(fread($file, $fileInfo["size"]));
		fclose($file);
 	}

	//*********************************************************************************

	private function setInputVars()
	{
		if (!isset($_GET["fileName"]))
		{
			$this->objSOutput->error("Недостаточно данных [fileName]");
		}
	}

	//*********************************************************************************
}

?>