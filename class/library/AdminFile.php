<?php

class AdminFile extends Base
{
	/** @var AdminFile */
	private static $obj = null;

	/*********************************************************************************/

	protected function __construct()
	{
		parent::__construct();
	}

	/*********************************************************************************/

	private function __clone()
	{
	}

	/*********************************************************************************/

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new AdminFile();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function getHtml_fileBlock($id)
	{
		$objMFileCatalog = MFileCatalog::getInstance();
		$html = "";

		$fileCatalogIdArray = preg_split("#,#", $id, null, PREG_SPLIT_NO_EMPTY);

		if (0 === count($fileCatalogIdArray))
		{
			return "";
		}

		foreach ($fileCatalogIdArray AS $fileCatalogId)
		{
			if (!$objMFileCatalog->isExist($fileCatalogId))
			{
				continue;
			}

			$fileCatalogInfo = $objMFileCatalog->getInfo($fileCatalogId);

			$data =
			[
				"fileCatalogTitle" => Convert::textUnescape($fileCatalogInfo["title"]),
				"fileList" => $this->getHtml_fileList($fileCatalogId),
			];

			$html .= $this->objSTemplate->getHtml("file", "fileBlock", $data);
		}

		return $html;
	}

	//*********************************************************************************

	public function getHtml_fileList($fileCatalogId)
	{
		$objMFile = MFile::getInstance();
		$html = "";

		if (false === ($res = $objMFile->getList($fileCatalogId)))
		{
			return "";
		}

		foreach($res AS $row)
		{
			$data =
			[
				"id" => $row["fileId"],
				"href" => GLOB::$SETTINGS["adminFileDir"]."/".$row["name"],
				"name" => Convert::textUnescape($row["name"]),
				"nameOriginal" => Convert::textUnescape($row["nameOriginal"]),
			];

			$html .= $this->objSTemplate->getHtml("file", "fileListItem", $data);
		}

		return $html;
	}

	/*********************************************************************************/
}

?>