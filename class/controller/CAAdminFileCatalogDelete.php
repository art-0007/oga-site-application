<?php

class CAAdminFileCatalogDelete extends CAjaxInit
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
		if (!is_array($this->vars["fileCatalogId"]))
 		{
			$this->vars["fileCatalogId"] = array($this->vars["fileCatalogId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->delete();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Каталоги удалены", array("fileCatalogId" => $this->vars["fileCatalogId"]));
	}

	//*********************************************************************************

	private function delete()
	{
		$objMFileCatalog = MFileCatalog::getInstance();
		$objMFile = MFile::getInstance();

 		foreach($this->vars["fileCatalogId"] AS $fileCatalogId)
  		{
	  		//Проверяем существование с таким id
	  		if (false === $objMFileCatalog->isExist($fileCatalogId))
	  		{
	  			$this->objSOutput->critical("Каталога с таким id не существует");
	  		}

	  		//Проверяем базовый ли каталог
	  		if (true === $objMFileCatalog->isBase($fileCatalogId))
	  		{
	  			$this->objSOutput->error("Удаление невозможно! Каталог является базовым");
	  		}

	  		//Проверяем существование дочерних каталогов
	  		if (true === $objMFileCatalog->hasChild($fileCatalogId))
	  		{
	  			$this->objSOutput->error("Удаление невозможно! Каталог содержит дочерние каталоги");
	  		}

	  		//Проверяем существование файлов в каталоге
	  		if (true === $objMFile->isExistByFileCatalogId($fileCatalogId))
	  		{
				$this->objSOutput->error("Удаление невозможно! Каталог содержит файлы");
	  		}
		}

 		foreach($this->vars["fileCatalogId"] AS $fileCatalogId)
  		{
			//Удаляем указанный каталог
	  		$objMFileCatalog->delete($fileCatalogId);
 		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [fileCatalogId]",
		);

		$this->objValidation->checkVars("fileCatalogId", $rules, $_POST);

 		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>