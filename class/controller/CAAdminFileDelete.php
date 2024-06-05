<?php

class CAAdminFileDelete extends CAjaxInit
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
		if (!is_array($this->vars["fileId"]))
 		{
			$this->vars["fileId"] = array($this->vars["fileId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->delete();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Файлы удалены", array("fileId" => $this->vars["fileId"]));
	}

	//*********************************************************************************

	private function delete()
	{
		$objMFile = MFile::getInstance();

		foreach ($this->vars["fileId"] AS $fileId)
		{
	  		if (false === $objMFile->isExist($fileId))
	  		{
	  			$this->objSOutput->critical("Файла с таким id не существует [".$fileId."]");
	  		}
		}

		foreach ($this->vars["fileId"] AS $fileId)
		{
	 		$fileInfo = $objMFile->getInfo($fileId);

			@unlink(PATH.GLOB::$SETTINGS["adminFileDir"]."/".$fileInfo["name"]);

			//Удаляем
			$objMFile->delete($fileId);
		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [fileId]",
		);

		$this->objValidation->checkVars("fileId", $rules, $_POST);

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>