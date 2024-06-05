<?php

class CAAdminArticleDelete extends CAjaxInit
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
		if (!is_array($this->vars["articleId"]))
 		{
			$this->vars["articleId"] = array($this->vars["articleId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->delete();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Статьи удалены", array("articleId" => $this->vars["articleId"]));
	}

	//*********************************************************************************

	private function delete()
	{
		$objMArticle = MArticle::getInstance();

 		foreach($this->vars["articleId"] AS $articleId)
  		{
	  		//Проверяем существование с таким id
	  		if (false === $objMArticle->isExist($articleId))
	  		{
	  			$this->objSOutput->critical("Статьи с таким id не существует");
	  		}

	  		if (0 === Func::mb_strcmp("projectCompany", $objMArticle->getDevName($articleId)))
		    {
			    $this->objSOutput->error("Удаление этой статьи заблокировано");
		    }
		}

 		foreach($this->vars["articleId"] AS $articleId)
  		{
	 		$articleInfo = $objMArticle->getInfo($articleId);

			@unlink(PATH.GLOB::$SETTINGS["articleImgDir"]."/".$articleInfo["fileName1"]);
			@unlink(PATH.GLOB::$SETTINGS["articleImgDir"]."/".$articleInfo["fileName2"]);

			//Удаляем указанный каталог
	  		$objMArticle->delete($articleId);
  		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [articleId]",
		);

		$this->objValidation->checkVars("articleId", $rules, $_POST);

 		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>