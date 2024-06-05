<?php

/**
 * Осуществляет работу с URI адресами
 *
 * @package System
 * */
class SURI
{
	//*********************************************************************************

	/**
	 * @var string Обработанный URI запроса
	 * */
	public $requestURI = "";

	/**
	 * @var string Имя скрипта
	 * */
	public $scriptName = "";

	/**
	 * @var string Если строка не пуста, то используется для проверки в классе SRouter присутствует ли в конце слеш
	 * */
	public $requestURIForCheckSlech = "";

	/**
	 * @var object Ссылка на объект данного класса, использующаяся в механизме "Класс - одиночка"
	 * */
	private static $obj = null;

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new SURI();
		}

		return self::$obj;
	}

	//*********************************************************************************

	private function __construct()
	{
		$this->scriptName = basename($_SERVER["SCRIPT_NAME"]);

		//В случае, если $_SERVER["REQUEST_URI"] не существует, то устанавливаем соответствующую переменную класса в "пустую строку".
		//Такая ситуация возможна, например, при запуске скрипта из консоли.
		if (!isset($_SERVER["REQUEST_URI"]))
		{
			$this->requestURI = "";
			return;
		}

		if(SConfig::$classicUrl)
		{
			$this->requestURI = $_SERVER["REQUEST_URI"];
		}
		else
		{
			$this->requestURI = $this->getHSURequestUri();
		}
	}

	//*********************************************************************************

	private function __clone()
	{
	}

	//*********************************************************************************

	/**
	 * Определяет значение URI используемого в классе SRouter для проверки присутствия последенго слеша (нужно для ЧПУ)
	 *
	 * @return string Строка URI используемого в классе SRouter для проверки присутствия последенго слеша
	 * */
 	private function getHSURequestUri()
 	{
		//Убираем часть в которой содержится путь к файлу
  		$requestURI = strtr($_SERVER["REQUEST_URI"], array($_SERVER["SCRIPT_NAME"] => ""));

		if($requestURI === "/" OR empty($requestURI))
  		{
  			return "";
  		}
  		else
  		{
			//Разбиваем строку запроса по "/" для дальнейшей проверки
			$uriArray = preg_split("#\/#iu", $requestURI, -1, PREG_SPLIT_NO_EMPTY);
			//Достаем кол-во секций в URI
			$uriAmount = count($uriArray);

			if($uriAmount > 0)
			{
				//Если сегмент 1-н, то провреяем, является ли он роутером или набором параметров
				if($uriAmount === 1)
				{
					if(mb_strpos($uriArray[$uriAmount - 1], "?") === 0 OR mb_strpos($uriArray[$uriAmount - 1], "&") === 0 OR mb_strpos($uriArray[$uriAmount - 1], "#") === 0)
					{
						return "";
					}
					else
					{
						/* Проверяется только в случае если сегмент не набор параметров, иначе сам фреймворк выкинет ошибку 404 */

						//Так как сегмент 1-н и не является строкой параметров, то заносим requestURI для проверки "/" в конце
						$this->requestURIForCheckSlech = $requestURI;
					}
				}
				else
				{
					//Проверяем начало последнего сегмента, если в начале сегмента присутсвует ? или # или &, то удаляем сегмент
					if(mb_strpos($uriArray[$uriAmount - 1], "?") === 0 OR mb_strpos($uriArray[$uriAmount - 1], "&") === 0 OR mb_strpos($uriArray[$uriAmount - 1], "#") === 0)
					{
						unset($uriArray[$uriAmount - 1]);
					}
					else
					{
						/* Проверяется только в случае если полседний сегмент не набор параметров, иначе сам фреймворк выкинет ошибку 404 */

						//В requestURI нет параметров, по этому заносим requestURI для проверки "/" в конце
						$this->requestURIForCheckSlech = $requestURI;
					}
				}

				//Собираем строку запроса, без учета недопустимых частей URI в правильном формате, т.е. с слешем в конце
				$requestURI = "/".implode("/", $uriArray)."/";

				return $requestURI;
			}
			else
			{
				return "";
			}
		}
 	}

	//*********************************************************************************
}

?>