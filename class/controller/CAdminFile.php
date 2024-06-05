<?php

class CAdminFile extends CMainAdminFancyBoxInit
{
	//*********************************************************************************

	private $fileCatalogList_emptyKey = false;

	//*********************************************************************************

	public function __construct()
	{
		parent::__construct();

		$this->setInputVars();
		//$this->setCSS();
		$this->setJavaScript();
		$this->init();
	}

	//*********************************************************************************

	private function init()
	{
		$objMFileCatalog = MFileCatalog::getInstance();
		$pageTitleH1 = "Хранилище файлов";
		$toolbarButton = "";
		$fileCatalogList_emptyKey = false;

		if ((int)$this->vars["fileCatalogId"] !== 1)
		{
			$fileCatalogInfo = 	$objMFileCatalog->getInfo($this->vars["fileCatalogId"]);

			$pageTitleH1 = "Хранилище файлов. Каталог: \"".$fileCatalogInfo["title"]."\"";

			$data = array
	  		(
	  			"fileCatalogId" => $fileCatalogInfo["fileCatalog_id"],
	  		);
			$toolbarButton = $this->objSTemplate->getHtml("adminFile", "toolbarButton", $data);
		}

		$data = array
		(
  			"pageTitleH1" => $pageTitleH1,
  			"fileCatalogId" => $this->vars["fileCatalogId"],
			"toolbarButton" => $toolbarButton,
  			"fileCatalogList" => $this->getFileCatalogListHtml(),
  			"fileList" => $this->getFileListHtml(),
		);

		//Контент страницы
		$this->html["content"] = $this->objSTemplate->getHtml("adminFile", "content", $data);
 	}

	//*********************************************************************************

	private function getFileCatalogListHtml()
	{
		$objMFileCatalog = MFileCatalog::getInstance();
		$html = "";

		if (false === ($res = $objMFileCatalog->getList($this->vars["fileCatalogId"])))
		{
			$this->fileCatalogList_emptyKey = true;
			return "";
		}

		$count = 0;
		foreach ($res AS $row)
		{
			$count++;
			if (0 === ($count % 2))
			{
				$zebra = "zebra";
			}
			else
			{
				$zebra = "";
			}

			$data = array
	   		(
	   			"id" => $row["id"],
	   			"imgSrcType" => GLOB::$SETTINGS["adminFileDir"]."/catalog/folder.png",
	   			"title" => $row["title"],
	   			"href" => "/admin/file/".$row["id"]."/",
	   			"zebra" => $zebra,
	   		);

			$html .= $this->objSTemplate->getHtml("adminFile", "fileCatalogListIteam", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function getFileListHtml()
	{
		$objMFile = MFile::getInstance();
		$html = "";

		if (false === ($res = $objMFile->getList($this->vars["fileCatalogId"])))
		{
			if ($this->fileCatalogList_emptyKey)
			{
				return $this->objSTemplate->getHtml("adminFile", "fileList_empty");
			}
			else
			{
				return "";
			}
		}

		$count = 0;
		foreach ($res AS $row)
		{
			$count++;
			if (0 === ($count % 2))
			{
				$zebra = "zebra";
			}
			else
			{
				$zebra = "";
			}

			$data = array
	   		(
	   			"id" => $row["fileId"],
				"filePath" => GLOB::$SETTINGS["adminFileDir"]."/".$row["name"],
	   			"imgSrcType" => (1 === (int)$row["fileTypeId"] OR 2 === (int)$row["fileTypeId"] OR 3 === (int)$row["fileTypeId"]) ? GLOB::$SETTINGS["adminFileDir"]."/".$row["name"] : GLOB::$SETTINGS["adminFileDir"]."/file/".$row["cssClass"].".png",
	   			"name" => $row["name"],
	   			"nameOriginal" => $row["nameOriginal"],
	   			"href" => "/download/?fileName=".$row["name"],
	   			"zebra" => $zebra,
	   		);

			$html .= $this->objSTemplate->getHtml("adminFile", "fileListIteam", $data);
		}

		return $html;
	}

	//*********************************************************************************

	private function setCSS()
	{
	}

	//*********************************************************************************

	private function setJavaScript()
	{
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-file-catalog.js");
		$this->objJavaScript->addJavaScriptFile("/js/admin/admin-file.js");
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
		$this->objValidation->checkVars("fileCatalogId", $rules, $_GET);

		if (!$objMFileCatalog->isExist($this->objValidation->vars["fileCatalogId"]))
		{
			$this->objSOutput->critical("Каталог файлов не найдено в базе данных");
		}

		//-----------------------------------------------------------------------------------

		//Принимаем данные
		$this->vars = $this->objValidation->vars;
	}

	//*********************************************************************************
}

?>