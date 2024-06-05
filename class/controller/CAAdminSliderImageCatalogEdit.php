<?php

class CAAdminSliderImageCatalogEdit extends CAdminAjaxInit
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
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();

		if (isset($_POST["id"]) AND Reg::isNum($_POST["id"]))
		{
			if (!$objMSliderImageCatalog->isExist($_POST["id"]))
			{
				$this->objSOutput->error("Ошибка: такого каталога не существует в БД");
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

		//Ширина изображения
		//Высота изображения
		if (isset($_POST["imgWidth_1"])) { $this->editImgWidth(1, $_POST["imgWidth_1"]); }
		if (isset($_POST["imgHeight_1"])) { $this->editImgHeight(1, $_POST["imgHeight_1"]); }

		//Название каталога
		if (isset($_POST["title"]))
		{
			$this->editTitle($_POST["title"]);
		}

		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();

		$data = array
   		(
   			"sliderImageCatalogId" => $objMSliderImageCatalog->getParentId($_POST["id"]),
   			"html" => $this->html,
   		);

  		$this->objSOutput->ok("Каталог отредактирован", $data);
 	}

	//*********************************************************************************

	private function editDevName($value)
	{
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();
		$value = trim($value);

		//Проверяем существование с таким urlName
		if ((mb_strlen($value) !== 0) AND (true === $objMSliderImageCatalog->isExistByDevName($value, $_POST["id"])))
		{
			$this->objSOutput->error("Каталог с таким именем для разработчика уже существует");
		}

		$data = array
		(
			"devName" => $value,
		);

		$objMSliderImageCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editPosition($value)
	{
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$value = $objMSliderImageCatalog->getMaxPosition($objMSliderImageCatalog->getParentId($_POST["id"])) + 1;
		}

		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: позиция имеет неверный формат");
		}

		$data = array
		(
			"position" => $value,
		);

		$objMSliderImageCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editImgWidth($imgId, $value)
	{
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: ширина изображения №".$imgId." должна быть целым положительным числом, или ноль");
		}

		$data = array
		(
			"imgWidth_".$imgId => $value,
		);

		$objMSliderImageCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editImgHeight($imgId, $value)
	{
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (!Reg::isNum($value))
		{
			$this->objSOutput->error("Ошибка: высота изображения №".$imgId." должна быть целым положительным числом, или ноль");
		}

		$data = array
		(
			"imgHeight_".$imgId => $value,
		);

		$objMSliderImageCatalog->edit($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editTitle($value)
	{
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();
		$value = trim($value);

		//Проверяем что бы значение небыло пустым
		if (0 === mb_strlen($value))
		{
			$this->objSOutput->error("Ошибка: название не может быть пустым");
		}

		//Проверяем существование с таким title
		if (true === $objMSliderImageCatalog->isExistByTitle($value, $_POST["id"]))
		{
			$this->objSOutput->error("Каталог с таким названием уже существует");
		}

		$data = array
		(
			"title" => $value,
		);

		$objMSliderImageCatalog->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function editPageTitle($value)
	{
		$objMSliderImageCatalog = MSliderImageCatalog::getInstance();
		$value = trim($value);

		$data = array
		(
			"pageTitle" => $value,
		);

		$objMSliderImageCatalog->editLang($_POST["id"], $data);

		$this->html = $value;
	}

	//*********************************************************************************

	private function setInputVars()
	{
	}

	//*********************************************************************************
}

?>