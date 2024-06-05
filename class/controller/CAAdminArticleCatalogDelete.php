<?php

class CAAdminArticleCatalogDelete extends CAjaxInit
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
		if (!is_array($this->vars["articleCatalogId"]))
 		{
			$this->vars["articleCatalogId"] = array($this->vars["articleCatalogId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->delete();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Каталоги статей удалены", array("articleCatalogId" => $this->vars["articleCatalogId"]));
	}

	//*********************************************************************************

	private function delete()
	{
		$objMArticleCatalog = MArticleCatalog::getInstance();
		$objMArticle = MArticle::getInstance();

 		foreach($this->vars["articleCatalogId"] AS $articleCatalogId)
  		{
	  		//Проверяем существование с таким id
	  		if (false === $objMArticleCatalog->isExist($articleCatalogId))
	  		{
	  			$this->objSOutput->critical("Каталога с таким id не существует");
	  		}

	  		//Проверяем базовый ли каталог
	  		if (true === $objMArticleCatalog->isBase($articleCatalogId))
	  		{
	  			$this->objSOutput->error("Удаление невозможно! Каталог является базовым");
	  		}

	  		//Проверяем существование дочерних каталогов
	  		if (true === $objMArticleCatalog->hasChild($articleCatalogId))
	  		{
	  			$this->objSOutput->error("Удаление невозможно! Каталог содержит дочерние каталоги");
	  		}

	  		//Проверяем существование файлов в каталоге
	  		if (true === $objMArticle->isExistByArticleCatalogId($articleCatalogId))
	  		{
				$this->objSOutput->error("Удаление невозможно! Каталог содержит сатьи");
	  		}
		}

 		foreach($this->vars["articleCatalogId"] AS $articleCatalogId)
  		{
	 		$articleCatalogInfo = $objMArticleCatalog->getInfo($articleCatalogId);

			@unlink(PATH.GLOB::$SETTINGS["articleCatalogImgDir"]."/".$articleCatalogInfo["fileName1"]);
			@unlink(PATH.GLOB::$SETTINGS["articleCatalogImgDir"]."/".$articleCatalogInfo["fileName2"]);
			@unlink(PATH.GLOB::$SETTINGS["articleCatalogImgDir"]."/".$articleCatalogInfo["fileName3"]);

			//Удаляем указанный каталог
	  		$objMArticleCatalog->delete($articleCatalogId);
 		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [articleCatalogId]",
		);

		$this->objValidation->checkVars("articleCatalogId", $rules, $_POST);

 		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>