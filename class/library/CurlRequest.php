<?php

class CurlRequest
{
	public $error = "";

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
			self::$obj = new CurlRequest();
		}

		return self::$obj;
	}

	//*********************************************************************************

	public function send($url, $postArray = array())
	{
		//Обязательно сбрасываем переменню содержащую текст последней ошибки
		$this->error = "";

		//Формируем канал
		$channel = curl_init();

		//Формируем массив опций
		$options = array
		(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_SSL_VERIFYPEER => false,
		);

		//Если массив POST параметров не пустой, то добавляем специальные опции для их передачи
		if (is_array($postArray) && 0 !== count($postArray))
		{
			$options[CURLOPT_POST] = 1;
			$options[CURLOPT_POSTFIELDS] = $postArray;
		}

		//Устанавливаем сформированне опции
		curl_setopt_array($channel, $options);

		//Выполняем запрос
		if (false === ($response = curl_exec($channel)))
		{
			//Произошла ошибка запроса

			$error = curl_error($channel);

			//Закрываем канал
			curl_close($channel);

			//Записываем текст ошибки в переменную класса и возвращаем FALSE
			$this->error = "Ошибка отправки запроса (".$error.")";
			return false;
		}
		else
		{
			//Закрываем канал
			curl_close($channel);

			//Возвращаем ответ
			return $response;
		}
	}

	//*********************************************************************************

}

?>