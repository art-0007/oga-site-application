<?php

/**
 * Осуществляет создание объекта контроллера. Является первичным классом в основной рабочей ветке
 *
 * @package System
 * */
class SCore
{
	//*********************************************************************************

	private $objSRouter = null;
	private $objSOutput = null;

	//*********************************************************************************

	public function __construct()
	{
		//Вспомогательные классы
		$this->objSRouter = SRouter::getInstance();
		$this->objSOutput = SOutput::getInstance();
	}

	//*********************************************************************************

	public function init()
	{
		$this->setController();
	}

	//*********************************************************************************

	/**
	 * Проверяет существование файла класса контроллера и создает его объект. Выполняет специфический код, характерный для каждого типа обработчика
	 * */
	private function setController()
	{
		//Для каждого из типов обработчиков выполняем разный код запуска контроллера
		switch($this->objSRouter->processorType)
  		{
  			case SEProcessorType::usual:
  			{
				//Проверяем существет ли контроллер
				if($this->isControllerExist())
				{
					//Создаем обьект класса контроллера
					$objClass = new $this->objSRouter->className;

					//Отображаем страницу
					$objClass->showHtml();
				}
				else
				{
					exit("Контроллер ".$this->objSRouter->className.".php не найден.");
				}

  				break;
  			}
  			case SEProcessorType::ajax:
  			{
				//Запрещаем обрыв выполнения скрипта, в случе обрыва соединения
				ignore_user_abort(true);

				//Подключаем файл инициализации серверной части библиотеки "JsHttpRequest"
				require_once(PATH."/include/JsHttpRequest_loader.php");

				//Проверяем существет ли контроллер
				if($this->isControllerExist())
				{
					//Создаем обьект класса контроллера
					$objClass = new $this->objSRouter->className;
				}
				else
				{
					exit("Контроллер ".$this->objSRouter->className.".php не найден.");
				}

  				break;
  			}
  			case SEProcessorType::base:
  			{
				//Запрещаем обрыв выполнения скрипта, в случе обрыва соединения
				ignore_user_abort(true);

				//Проверяем существет ли контроллер
				if($this->isControllerExist())
				{
					//Создаем обьект класса контроллера
					$objClass = new $this->objSRouter->className;
				}
				else
				{
					exit("Контроллер ".$this->objSRouter->className.".php не найден.");
				}

				break;
  			}
  			default:
  			{
  				exit("Некорректный тип обработчика");
  			}
  		}
	}

	//*********************************************************************************

	/**
	 * Проверяет существет ли файл класса контроллера. При этом учитываются файлы как типичных контроллеров, так и не типичных, т.е. размещенных в папке библиотек
	 * */
	private function isControllerExist()
	{
		if
		(
			file_exists(PATH."/class/controller/".$this->objSRouter->className.".php")
			||
			file_exists(PATH."/class/library/".$this->objSRouter->className.".php")
		)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************
}

?>