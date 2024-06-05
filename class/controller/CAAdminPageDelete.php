<?php

class CAAdminPageDelete extends CAjaxInit
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
		if (!is_array($this->vars["pageId"]))
 		{
			$this->vars["pageId"] = array($this->vars["pageId"]);
 		}

		$this->objMySQL->startTransaction();

		$this->delete();

		$this->objMySQL->commit();

		$this->objSOutput->ok("Статические страницы удалены", array("pageId" => $this->vars["pageId"]));
	}

	//*********************************************************************************

	private function delete()
	{
		$objMPage = MPage::getInstance();

		foreach ($this->vars["pageId"] AS $pageId)
		{
	  		if (false === $objMPage->isExist($pageId))
	  		{
	  			$this->objSOutput->critical("Статической страницы с таким id не существует [".$pageId."]");
	  		}

	  		if (true === $objMPage->isBase($pageId))
	  		{
	  			$this->objSOutput->error("Удаление, одной из выбранных, статических страниц заблокировано, так как она является базовой");
	  		}
		}

		foreach ($this->vars["pageId"] AS $pageId)
		{
	 		$pageInfo = $objMPage->getInfo($pageId);

			@unlink(PATH.GLOB::$SETTINGS["pageImgDir"]."/".$pageInfo["fileName1"]);
			//Удаляем
			$objMPage->delete($pageId);
		}
	}

	//*********************************************************************************

	private function setInputVars()
	{
		$this->objValidation->newCheck();

		$rules = array
		(
			Validation::exist => "Недостаточно данных [pageId]",
		);

		$this->objValidation->checkVars("pageId", $rules, $_POST);

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>