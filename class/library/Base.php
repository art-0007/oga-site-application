<?php

/**
 * Абстрактный класс предоставляющий набор объектов всех базовых классов ядра.
 * При запуске конструктора данного класса производится инициализация всех вышеуказаных объектов.
 * */

abstract class Base
{
  	protected $objSURI = null;
  	protected $objSRouter = null;
  	protected $objSResponse = null;
  	protected $objSOutput = null;
  	protected $objMySQL = null;
  	protected $objValidation = null;
  	protected $objSTemplate = null;
  	protected $objJavaScript = null;
  	protected $objCSS = null;

	//*********************************************************************************

	/**
	 * Запускает инициализацию всех переменных класса (объектов всех базовых классов AstridCore)
	 * */
	protected function __construct()
	{
		$this->loadClass();
	}

	//*********************************************************************************

	private function loadClass()
	{
		$this->objSURI = SURI::getInstance();
		$this->objSRouter = SRouter::getInstance();
		$this->objSResponse = SResponse::getInstance();
		$this->objSOutput = SOutput::getInstance();
		$this->objMySQL = MySQL::getInstance();
		$this->objValidation = Validation::getInstance();
		$this->objSTemplate = STemplate::getInstance();
		$this->objJavaScript = JavaScript::getInstance();
		$this->objCSS = CSS::getInstance();
	}

	//*********************************************************************************
}
?>