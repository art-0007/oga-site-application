<?php

/**
 * Абстрактный класс. Обеспечивает интерфейс для всех классов-моделей
 * @package AstridCore
 * @author Игорь Михальчук
 * @author Александр Шевяков
 * @version 1.1 2011.12.14 21:30:07
 * @link http://www.it-island.com/astrid/ IT-Island:Astrid
 * */

abstract class Model extends Base
{
	//*********************************************************************************

	protected function __construct()
	{
		parent::__construct();
	}

	//*********************************************************************************
}

?>