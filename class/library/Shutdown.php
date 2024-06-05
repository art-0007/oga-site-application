<?php

/**
 * Обеспечивает механизм непредвиденного завершения работы
 * */
class Shutdown
{
	/************************************************************************************************************/

	private static $befofeShutdownFunction = null;
	private static $befofeShutdownFunctionParameter = null;

	private static $obj = null;

	//*********************************************************************************

	protected function __construct()
	{
	}

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new Shutdown();
		}

		return self::$obj;
	}

	//*********************************************************************************

	/**
	 * Задает функцию, которая будет запущена в случае, если произойдет запуск метода shutdown()
	 *
	 * @param mixed $mixedFunction Первый аргумент функции call_user_func(). Может быть как массиваом так и строкой (см. документацию)
	 * @param mixed $parameter Второй аргумент функции call_user_func() (см. документацию). Не обязателен
	 * */
	public static function setBeforeShutdownFunction($mixedFunction, $mixedFunctionParameter = null)
	{
		self::$befofeShutdownFunction = $mixedFunction;
		self::$befofeShutdownFunctionParameter = $mixedFunctionParameter;
	}

	//*********************************************************************************

	/**
	 * Запускает функцию, которая указана в self::$befofeShutdownFunction с аргументами self::$befofeShutdownFunctionParameter
	 * */
	public static function callBeforeShutdownFunction()
	{
		//Если установлена функция, которую нужно вызвать перед завершением работы, тоо вызываем ее
		if (!is_null(self::$befofeShutdownFunction))
		{
			//Если указаны параметры данной функции, то вызываем ее с параметрами
			if (!is_null(self::$befofeShutdownFunctionParameter))
			{
				call_user_func(self::$befofeShutdownFunction, self::$befofeShutdownFunctionParameter);
			}
			else
			{
				call_user_func(self::$befofeShutdownFunction);
			}
		}
	}

	//*********************************************************************************

	/**
	 * Данный метод отрабатывает при завершении работы скрипта ПОСЛЕ всего остального кода.
	 * В случае аварийного завершения работы скрипта, запускает функцию self::$befofeShutdownFunction, а затем выдает ошибку в соответствии с типом обработчика
	 * */
	public function shutdown()
	{
		//Проверяем обработан ли корректно поток вывода
		if (true === GLOB::$stdOutProcessed)
		{
			//Поток вывода обработан корректно, значит просто выводим его
			ob_end_flush();
			return;
		}

	 	$objSOutput = SOutput::getInstance();
	 	$objSOutput->sendEmail("Буфер вывода не обработан");

		$objSRouter = SRouter::getInstance();

		//ВНИМАНИЕ! Проверяем на критичесую ситуацию, когда не заполнена переменная правил, что означает, что произошло завершение работы до того как отработал код инициализации контроллера
	 	if (is_null(SRoutes::$rules))
	 	{
	 		//Выбрасываем поток вывода, чтобы увидеть причину ошибки
	 		ob_end_flush();
			exit("Core error 1");
	 	}

		//ВНИМАНИЕ! Проверяем на критичесую ситуацию, когда не заполнена переменная типа обработчика, что означает, что произошло завершение работы до того как отработал код инициализации контроллера
	 	if (is_null($objSRouter->processorType))
	 	{
	 		//Выбрасыем поток вывода, чтобы увидеть причину ошибки
	 		ob_end_flush();
			exit("Core error 2");
	 	}

		$objSResponse = SResponse::getInstance();

		switch($objSRouter->processorType)
		{
			case SEProcessorType::usual:
			{
				$objSResponse->sendStatus503(false);

				$debug = "";
				if (true === Config::$debug)
				{
					if (0 !== mb_strlen(SDebug::getDebugBuffer()))
					{
						$debug = "<br><br><strong>Содержимое буфера отладки: </strong><br>".SDebug::getDebugBuffer();
					}
				}

				$stdOut = "";
				if (true === Config::$showStdOut)
				{
					if (0 !== ob_get_length())
					{
						$stdOut = "<br><br><strong>Содержимое буфера вывода: </strong><br>".ob_get_contents();
					}
				}

				//Очищаем буфер вывода
				ob_clean();

				$tplData["content"] = "Произошла ошибка! Возможно у Вас открыта устаревшая версия страницы.<br>Обновите страницу воспользовавшись комбинацией клавиш 'Ctrl+R'.<br>Если ошибка не устраниться, свяжитесь с системным администратором сайта.<br><br><strong>Текст ошибки: </strong><em>Буфер вывода не обработан [".md5(ob_get_contents())."]</em>".$debug.$stdOut;
				$objSTemplate = STemplate::getInstance();
				echo $objSTemplate->getHtml("engine/mainError503", "content", $tplData);

				ob_end_flush();
				return;

				break;
			}

			case SEProcessorType::ajax:
			{
				//Тут вообще не нужно ничего делать, так как все сделала библиотека JsHttpRequest. Она перехватила буфер вывода и возвратит ошибку в корректном виде браузеру

				//Нужно просто выбросить буфер вывода
				ob_end_flush();

				break;
			}

			case SEProcessorType::base:
			{
				$objSResponse->sendStatus503(false);

				$debug = "";
				if (true === Config::$debug)
				{
					if (0 !== mb_strlen(SDebug::getDebugBuffer()))
					{
						$debug = "\n\nСодержимое буфера отладки: \n".SDebug::getDebugBuffer();
					}
				}

				$stdOut = "";
				if (true === Config::$showStdOut)
				{
					$stdOut = "\n\nСодержимое буфера вывода: \n".ob_get_contents();
				}

				//Очищаем буфер вывода
				ob_clean();

				echo "Произошла ошибка! Возможно у Вас открыта устаревшая версия страницы.\nОбновите страницу воспользовавшись комбинацией клавиш 'Ctrl+R'.\nЕсли ошибка не устраниться, свяжитесь с системным администратором сайта.\n\nТекст ошибки: Буфер вывода не обработан [".md5(ob_get_contents())."]".$debug.$stdOut;

				ob_end_flush();

				break;
			}

			default:
			{
				//Очищаем буфер вывода
				ob_clean();

				$objSResponse->sendStatus503(false);

				exit("Critical error. Call to system administrator");

				//Эти команды не имеют смысла, и написаны только для маловероятной ситуации ошибки
				ob_end_flush();
			}
		}

		self::callBeforeShutdownFunction();
	}

	//*********************************************************************************

}

?>