<?php

class Modal extends Base
{
	private static $obj = null;

	private $pageClass = "";

	//*********************************************************************************

	protected function __construct()
	{
		parent::__construct();
		$this->init();
	}

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new Modal();
		}

		return self::$obj;
	}

	//*********************************************************************************

	private function init()
	{
		$this->pageClass = strtolower(mb_substr($this->objSRouter->className, 1));
	}

	//*********************************************************************************

	public function get_modalHtml($modalTitle = null, $modalBody = null)
	{
		$objStaticHtml = StaticHtml::getInstance();

		if (is_null($modalTitle))
		{
			$modalTitle = "{sh_message}";
		}

		if (is_null($modalBody))
		{
			$modalBody = "";
		}

		$data =
		[
			"modalTitle" => $modalTitle,
			"modalBody" => $modalBody,
		];

		return $objStaticHtml->replaceInString($this->objSTemplate->getHtml("modal", "modal", $data));
	}

	//*********************************************************************************
}
?>