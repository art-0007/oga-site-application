<?php

class Func
{
	//*********************************************************************************

	/**
	 * Обработка данных при вставке в базу
	 * */
	public static function res($value)
	{
		return(mysqli_real_escape_string(MySQL::$db, htmlspecialchars(trim($value), ENT_QUOTES, "UTF-8")));
	}

	//*********************************************************************************

	/**
	 * Обработка данных при вставке в базу
	 * */
	public static function bb($value)
	{
		return self::res($value);
	}

	//*********************************************************************************

	public static function floatToPrintable($value, $numAmountAfterPoint = null)
	{
		if (is_null($numAmountAfterPoint))
		{
			$numAmountAfterPoint = (int)GLOB::$SETTINGS["numAmountAfterPoint"];
		}

		return number_format((float)$value, $numAmountAfterPoint, ".", "");
	}

	//*********************************************************************************
	/**
	 * Преобразует сумму денег из строки в формат для вывода (целая_часть.дробная_часть_2_знака_с_округлением)/
	 * ВНИМАНИЕ! Результат округляется, если знаков после запятой больше чем два.
	 * Передаваемое данное может быть типа string, но иметь вид десятичной дроби или целого числа (123.456, 123.0000, 123)
	 *
	 * @param float $money Может иметь тип как string так и float и int. Сумма денег
	 * @param int $numAmountAfterPoint Количество символов после точки
	 *
	 * @return string Строка с суммой денег приведеной к формату для вывода
	 * */
	public static function moneyToPrintable($money, $numAmountAfterPoint = null)
	{
		if (is_null($numAmountAfterPoint))
		{
			$numAmountAfterPoint = GLOB::$SETTINGS["numAmountAfterPoint"];
		}
		return number_format($money, $numAmountAfterPoint, '.', '');
	}

	//*********************************************************************************

	//Возвращает front домен для куков
	public static function getFrontDomainForCookies()
	{
		if(!empty(GLOB::$SETTINGS["front_domain"]))
		{
			return GLOB::$SETTINGS["front_domain"];
		}

		return $_SERVER["SERVER_NAME"];
	}

	//*********************************************************************************

	/**
	 * Удаляет из строки $tel все символы кроме цифр
	 *
	 * @param string $tel Номер телефона в любом формате
	 *
	 * @return string Строка содержащая только цифры
	 * */
	public static function toTelephoneSearch($tel)
	{
		return preg_replace("|[^0-9]|iu", "", $tel);
	}

	//*********************************************************************************

	/**
	 * Генерирует уникальный ключ
	 *
	 * @param int $length Количество символов длины генерируемого значения
	 * @param string $type Тип данных генерируемого ключа. "mixed" - числа и буквы английского алфавита; "num" - числа
	 *
	 * @return string Сгенерированый ключ
	 * */
	public static function uniqueId($length = 45, $type = "mixed")
	{
		$uniqueId = "";

		switch($type)
		{
			case "mixed":
			{
				$alfavitArray = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");

				for($i = 0; $i < $length; $i++)
				{
					if(mt_rand(0, 1) === 1)
					{
						$uniqueId .= mt_rand(0, 9);
					}
					else
					{
						$uniqueId .= $alfavitArray[mt_rand(0, count($alfavitArray)-1)];
					}
				}

				break;
			}

			case "mixedCaseInsensitive":
			{
				$alfavitArray = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

				for($i = 0; $i < $length; $i++)
				{
					if(mt_rand(0, 1) === 1)
					{
						$uniqueId .= mt_rand(0, 9);
					}
					else
					{
						$uniqueId .= $alfavitArray[mt_rand(0, count($alfavitArray)-1)];
					}
				}

				break;
			}

			case "num":
			{
				for($i = 0; $i < $length; $i++)
				{
					if($i === 0)
					{
						$uniqueId .= mt_rand(1, 9);
					}
					else
					{
						$uniqueId .= mt_rand(0, 9);
					}
				}

				break;
			}
		}

		//Возвращаем uniqueId
		return $uniqueId;
	}

	//*********************************************************************************

	/**
	 * Генерирует уникальный ключ, проверяея его уникальность среди значений полей $fieldName в таблице $tableName
	 *
	 * @param string $tableName Имя таблицы базы данных
	 * @param string $fieldName Имя поля в таблице базы данных
	 * @param int $length Количество символов длины генерируемого значения
	 * @param string $type Тип данных генерируемого ключа. "mixed" - числа и буквы английского алфавита; "num" - числа
	 * @param string $where Дополнительное условие для выборки строк из таблицы в базе данных (в обычном sql формате и без ключевого слова WHERE)
	 * @param string $prefixString Строка, которая вставляется ДО генерируемого ключа, перед проверкой уникальности в базе данных
	 * @param string $postfixString Строка, которая вставляется ПОСЛЕ генерируемого ключа, перед проверкой уникальности в базе данных
	 *
	 * @return string Сгенерированый ключ
	 * */
	public static function uniqueIdForDB($tableName, $fieldName, $length, $type = "mixed", $where = "", $prefixString = "", $postfixString = "")
	{
		$alfavitArray = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
		$mysqlWhere = "";

		while(1)
		{
			//Генерируем рандомный уникальный ID фришного файла
			$uniqueId = self::uniqueId($length, $type);

			/** Добавляем справа и слева префикс и постфикс, если они не пусты */
			$uniqueId = $prefixString.$uniqueId.$postfixString;

			if(!empty($where) AND empty($mysqlWhere))
			{
				$mysqlWhere = " AND (".$where.")";
			}

			$query =
				"
				SELECT
					COUNT(*) AS `count`
				FROM
					`".$tableName."`
				WHERE
				(
					`".$fieldName."` = '".self::bb($uniqueId)."'
				)
				".$mysqlWhere."
			";

			$objMySQL = MySQL::getInstance();

			$res = $objMySQL->query($query);

			if((int)$res[0]["count"] === 0)
			{
				break;
			}
		}

		//Возвращаем uniqueId
		return $uniqueId;
	}

	/************************************************************************************************************/

	/**
	 * Возвращает расширение файла, имя которого (или путь размещения) передается в переменной $fileName
	 *
	 * @param string $fileName Имя файла (или путь размещения)
	 * @param bool $getWithDot Ключ указывающий возвращать ли строку с опережающим символом "точка"
	 *
	 * @return string Расширение файла. Если расширения нет, то возвращает пустую строку
	 * */
	public static function getFileExtension($fileName, $getWithDot = false)
	{
		$array = explode(".", $fileName);
		if (count($array) > 1)
		{
			return ($getWithDot === true) ? ".".$array[count($array) -1] : $array[count($array) -1];
		}
		else
		{
			return "";
		}
	}

	//*********************************************************************************

	/**
	 * Производит транслитерацию строки $text из кирилицы в латиницу. Преобразует в соответствии с требованиями формирования ЧПУ URL
	 *
	 * @param string $text Исходная строка
	 *
	 * @return string Выхоная строка
	 * */
	public static function translitForUrlName($text)
	{
		$rusAlfabet = array
		(
			"а" => "a",
			"б" => "b",
			"в" => "v",
			"г" => "g",
			"д" => "d",
			"е" => "e",
			"ё" => "e",
			"ж" => "j",
			"з" => "z",
			"и" => "i",
			"й" => "yi",
			"к" => "k",
			"л" => "l",
			"м" => "m",
			"н" => "n",
			"о" => "o",
			"п" => "p",
			"р" => "r",
			"с" => "s",
			"т" => "t",
			"у" => "u",
			"ф" => "f",
			"х" => "h",
			"ц" => "c",
			"ч" => "ch",
			"ш" => "sh",
			"щ" => "sch",
			"ь" => "",
			"ы" => "y",
			"ъ" => "",
			"э" => "e",
			"ю" => "yu",
			"я" => "ya",

			"і" => "i",
			"ї" => "yi",
			"є" => "e",
			"ґ" => "g",

			" " => "-"
		);

		$text = strip_tags($text);

		//Вырезаем запрещенные символы
		$text = trim(preg_replace("#[^a-zа-яіїєґ0-9 \-]+#iu", " ", $text));

		//Заменяем множественные пробелы на один
		$text = preg_replace("#[ ]{2,}#iu", " ", $text);

		//Заменяем соответсующие символы в строке
		$text = strtr(mb_strtolower($text), $rusAlfabet);

		return $text;
	}

	//*********************************************************************************

	/**
	 * Производит перемещение загруженого файла $fileName по адресу $dstFileName используя стандартную функцию "move_uploaded_file"
	 *
	 * @param string $fileName Путь к файлу загруженном как временный файл php во временную папку
	 * @param string $dstFileName Адрес (включая имя) файла назначения
	 *
	 * @return bool TURE - в случае успеха; FALSE - в случае ошибки
	 * */
	public static function moveUploadedFile($fileName, $dstFileName)
	{
		if (true === @move_uploaded_file($_FILES[$fileName]["tmp_name"], $dstFileName))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************

	//Вовзращает кол-во товаров в массиве, который имеет формат массива корзины
	public static function getOfferAmountByCartOfferArray($offerArray)
	{
		//Кол-во товаров
		$offerAmount = 0;

		//Обходим массив и считем кол-во товаров
		foreach($offerArray as $offerId => $amount)
		{
			$offerAmount = $offerAmount + $amount;
		}

		return $offerAmount;
	}

	//*********************************************************************************

	//Текст ошибки, что переменная не определенна
	public static function error_text($text, $methodName = "")
	{
		return $methodName." ".$text;
	}

	//*********************************************************************************

	//Текст ошибки, что переменная не определенна
	public static function error_varNotExist($varName, $methodName = "")
	{
		return "Ошибка: переменная [".$methodName." ".$varName."] не определенна.";
	}

	//*********************************************************************************

	//Текст ошибки, что элемента не сущности не существует
	public static function error_elementNotExist($elementName, $methodName = "")
	{
		return "Ошибка: [".$methodName." ".$elementName."] не существует.";
	}

	//*********************************************************************************

	/**
	 * Производит рекурсивное копирование директории $srcPath в $dstPath, включая все ее содержимое
	 * ВНИМАНИЕ! Прекращает процесс и возвращает FALSE, если $dstPath существует
	 * ВНИМАНИЕ! $srcPath не должен заканчиватся на разделительные слеши
	 *
	 * @param string $srcPath Путь к копируемой директории
	 * @param string $dstPath Путь к директории назначения
	 *
	 * @return bool TRUE - успех; FALSE - ошибка
	 * */
	public static function copyDir($srcPath, $dstPath)
	{
		//Источник должен существовать
		if (!file_exists($srcPath)) return false;
		//Назначение НЕ должно существовать
		if (file_exists($dstPath)) return false;
		//Источник должен быть директорией
		if (!is_dir($srcPath)) return false;

		//Создаем директорию по адресу назначения
		if (false === @mkdir($dstPath)) return false;

		//Производим перебор и копирование содержимого

		$fileArray = @scandir($srcPath);

		if (false === $fileArray || 0 === count($fileArray))
		{
			//Папка пуста
			return true;
		}

		//В папке есть содержимое

		//Перебираем содержимое папки и копируем рекурсивно вложенные папки, а а также копируем файлы
		foreach($fileArray AS $file)
		{
			//Исключаем спецдиректории
			if (0 === Func::mb_strcmp($file, ".") || 0 === Func::mb_strcmp($file, "..") ) continue;

			//Устаналиваем полный путь к текущему источнику
			$srcFilePath = $srcPath."/".$file;

			//Устаналиваем полный путь к текущему назначению
			$dstFilePath = $dstPath."/".$file;

			if (is_dir($srcFilePath))
			{
				//Копируем директорию
				if (false === self::copyDir($srcFilePath, $dstFilePath))
				{
					//Удаляем созданную выше директорию
					self::removeDir($dstPath);
					return false;
				}
			}
			else
			{
				//Копируем файл
				if (false === @copy($srcFilePath, $dstFilePath))
				{
					//Удаляем созданную выше директорию
					self::removeDir($dstPath);
					return false;
				}
			}
		}

		return true;
	}

	//*********************************************************************************

	/**
	 * Преобразует дату в формате "ISO 8601" в дату в формате "ГОСТ Р 6.30-2003"
	 *
	 * @param string $date Дата в формате "ISO 8601"
	 * @param string $delimiterISO Разделитель внутри даты между годом, месяцем и днем (для "ISO 8601")
	 * @param string $delimiterGOST Разделитель внутри даты между годом, месяцем и днем (для "ГОСТ Р 6.30-2003")
	 *
	 * @return string Строка с датой в формате "ISO 8601"
	 * */
	public static function dateFromISOToGOST($date, $delimiterISO = "-", $delimiterGOST = ".")
	{
		$dateArray = array();

		if(preg_match("|^([0-9]{4})".$delimiterISO."([0-9]{2})".$delimiterISO."([0-9]{2})$|iu", $date, $dateArray))
		{
			$date = $dateArray[3].$delimiterGOST.$dateArray[2].$delimiterGOST.$dateArray[1];
			return $date;
		}

		return false;
	}

	//*********************************************************************************

	/**
	 * Преобразует дату в формате "ГОСТ Р 6.30-2003" в дату в формате "ISO 8601"
	 *
	 * @param string $date Дата в формате "ГОСТ Р 6.30-2003"
	 * @param string $delimiterGOST Разделитель внутри даты между годом, месяцем и днем (для "ГОСТ Р 6.30-2003")
	 * @param string $delimiterISO Разделитель внутри даты между годом, месяцем и днем (для "ISO 8601")
	 *
	 * @return string Строка с датой в формате "ISO 8601"
	 * */
	public static function dateFromGOSTToISO($date, $delimiterGOST = ".", $delimiterISO = "-")
	{
		$dateArray = array();

		if(preg_match("|^([0-9]{2})".$delimiterGOST."([0-9]{2})".$delimiterGOST."([0-9]{4})$|iu", $date, $dateArray))
		{
			$date = $dateArray[3].$delimiterISO.$dateArray[2].$delimiterISO.$dateArray[1];
			return $date;
		}

		return false;
	}

	//*********************************************************************************

	/**
	 * Преобразовывает дату в формате ISO $date в временную метку UNIX, устанавливая начальную сукунду этих суток
	 *
	 * @param string $date дата в формате ISO 8601
	 *
	 * @return int
	 * */
	public static function mktimeFrom($date)
	{
		return mktime(0, 0, 0, mb_substr($date, 5, 2), mb_substr($date, 8, 2), mb_substr($date, 0, 4));
	}

	//*********************************************************************************

	/**
	 * Преобразовывает дату в формате ISO $date в временную метку UNIX, устанавливая последнюю сукунду этих суток
	 *
	 * @param string $date дата в формате ISO 8601
	 *
	 * @return int
	 * */
	public static function mktimeTo($date)
	{
		return mktime(23, 59, 59, mb_substr($date, 5, 2), mb_substr($date, 8, 2), mb_substr($date, 0, 4));
	}

	//*********************************************************************************

	/**
	 * Преобразовывает дату в формате ISO $date в временную метку UNIX, также учитывается время передающееся $timeStr. Если $timeStrContainSecondsKey = true, то $timeStr содержит секунды
	 *
	 * @param string $date Дата в формате "ISO 8601"
	 * @param string|null [$timeStr = null] Время в виде "чч:мм:сс" (например, 23:59:59)
	 * @param bool [$timeStrContainSecondsKey = false] Ключ указывающий содержит ли $timeStr секунды
	 * @param string|null [$timeZone = null] Временная зона, которая будет использована для преобразования. Если не передается, то будет использована текущая временная зона
	 *
	 * @return int Временная метка UNIX
	 * */
	public static function mktime($date, $timeStr = null, $timeStrContainSecondsKey = false, $timeZone = null)
	{
		if (!Reg::isDateISO($date))
		{
			$objSOutput = SOutput::getInstance();
			$objSOutput->critical("Func::mktime: Parameter date has wrong format [".$date."]");
		}

		if (true === $timeStrContainSecondsKey)
		{
			if (is_null($timeStr))
			{
				$timeStr = "12:00:00";
			}

			$seconds = mb_substr($timeStr, 6, 2);
		}
		else
		{
			if (is_null($timeStr))
			{
				$timeStr = "12:00";
			}

			$seconds = 0;
		}

		/**
		 * Для конвертации в метку времени UNIXTIME из даты необходимо изменить часовой пояс на, часовой пояс $timeZone
		 * */

		if (!is_null($timeZone))
		{
			//[1] Буферизируем текущую временную зону
			$currentTimeZone = date_default_timezone_get();

			//[2] Устанавливаем временную зону источника
			date_default_timezone_set($timeZone);

			//Конвертируем дату во время
			$time = mktime(mb_substr($timeStr, 0, 2), mb_substr($timeStr, 3, 2), $seconds, mb_substr($date, 5, 2), mb_substr($date, 8, 2), mb_substr($date, 0, 4));

			//[3] Восстанавливаем текущую временную зону
			date_default_timezone_set($currentTimeZone);

			return $time;
		}
		else
		{
			return mktime(mb_substr($timeStr, 0, 2), mb_substr($timeStr, 3, 2), $seconds, mb_substr($date, 5, 2), mb_substr($date, 8, 2), mb_substr($date, 0, 4));
		}
	}

	//*********************************************************************************

	/**
	 * Создан лишь для удобства. Пребразует UNIXTIME время в дату (или время) в формате $datetimeFormat
	 *
	 * @param int $time Временная метка UNIXTIME
	 * @param string $datetimeFormat Формат строки выходной даты
	 * @param string $timeZone Временная зона, которая будет использована для преобразования. Если не передается, то будет использована текущая временная зона
	 *
	 * @return string Дата в формате $datetimeFormat
	 * */
	public static function mkdatetime($time, $datetimeFormat = "Y-m-d", $timeZone = null)
	{
		/**
		 * Для конвертации метки времени UNIXTIME в дату необходимо изменить часовой пояс на, часовой пояс $timeZone
		 * */

		if (!is_null($timeZone))
		{
			//[1] Буферизируем текущую временную зону
			$currentTimeZone = date_default_timezone_get();

			//[2] Устанавливаем временную зону источника
			date_default_timezone_set($timeZone);

			//Конвертируем время в дату
			$date = date($datetimeFormat, $time);

			//[3] Восстанавливаем текущую временную зону
			date_default_timezone_set($currentTimeZone);

			return $date;
		}
		else
		{
			return date($datetimeFormat, $time);
		}
	}

	//*********************************************************************************

	/**
	 * Проверяет пустая ли строка в многобайтовых кодировках.
	 *
	 * @param string $str Строка для сравнения
	 *
	 * @return bool TRUE - строка пуста; FALSE - строка не пуста
	 * */
	public static function isEmpty($str)
	{
		//ВНИМАНИЕ! Если передаваемое значение ни строка, ни число, то проверять не нужно, так как будут некорректные результаты при приведении типов.
		//Например, если передать булево FALSE, то оно преобразуется в пустую строку
		if (!is_numeric($str) AND !is_string($str)) return false;

		return (0 === mb_strlen($str));
	}

	//*********************************************************************************

	/**
	 * Сравнение строк в многобайтовых кодировках с учетом регистра
	 *
	 * @param string $str1 Первая строка для сравнения
	 * @param string $str2 Вторая строка для сравнения
	 *
	 * @return bool TRUE - строки равны с учетом регистра; FALSE - строки не равны с учетом регистра
	 * */
	public static function isCmp($str1, $str2)
	{
		//ВНИМАНИЕ! Если передаваемое значение ни строка, ни число, то проверять не нужно, так как будут некорректные результаты при приведении типов.
		//Например, если передать булево FALSE, то оно преобразуется в пустую строку
		if ((!is_numeric($str1) AND !is_string($str1)) OR (!is_numeric($str2) AND !is_string($str2))) return false;

		return (0 === self::mb_strcmp($str1, $str2));
	}

	//*********************************************************************************

	/**
	 * Сравнение чисел с приведением к int
	 *
	 * @param mixed $num1 Первое число
	 * @param mixed $num2 Второе число
	 *
	 * @return bool TRUE - числа равный; FALSE - числа не равный
	 * */
	public static function isCmpInt($num1, $num2)
	{
		//ВНИМАНИЕ! Если передаваемое значение ни строка, ни число, то проверять не нужно, так как будут некорректные результаты при приведении типов.
		if ((!is_numeric($num1) AND !is_string($num1)) OR (!is_numeric($num2) AND !is_string($num2))) return false;

		return ((int)$num1 === (int)$num2);
	}

	//*********************************************************************************

	/**
	 * Сравнение чисел с приведением к float
	 *
	 * @param mixed $num1 Первое число
	 * @param mixed $num2 Второе число
	 *
	 * @return bool TRUE - числа равный; FALSE - числа не равный
	 * */
	public static function isCmpFloat($num1, $num2)
	{
		//ВНИМАНИЕ! Если передаваемое значение ни строка, ни число, то проверять не нужно, так как будут некорректные результаты при приведении типов.
		if ((!is_numeric($num1) AND !is_string($num1)) OR (!is_numeric($num2) AND !is_string($num2))) return false;

		return ((float)$num1 === (float)$num2);
	}

	//*********************************************************************************

	/**
	 * Сравнение числа с единицей и приведением к int
	 *
	 * @param mixed $num Число
	 *
	 * @return bool TRUE - равно единице; FALSE - не равно единице
	 * */
	public static function isOne($num)
	{
		//ВНИМАНИЕ! Если передаваемое значение ни строка, ни число, то проверять не нужно, так как будут некорректные результаты при приведении типов.
		if (!is_numeric($num) AND !is_string($num)) return false;

		return (1 === (int)$num);
	}

	//*********************************************************************************

	/**
	 * Сравнение числа с нулем и приведением к int
	 *
	 * @param mixed $num Число
	 *
	 * @return bool TRUE - равно нулю; FALSE - не равно нулю
	 * */
	public static function isZero($num)
	{
		//ВНИМАНИЕ! Если передаваемое значение ни строка, ни число, то проверять не нужно, так как будут некорректные результаты при приведении типов.
		if (!is_numeric($num) AND !is_string($num)) return false;

		return (0 === (int)$num);
	}

	//*********************************************************************************

	/**
	 * Сравнение числа с нулем и приведением к float
	 *
	 * @param mixed $num Число
	 *
	 * @return bool TRUE - равно нулю; FALSE - не равно нулю
	 * */
	public static function isZeroFloat($num)
	{
		//ВНИМАНИЕ! Если передаваемое значение ни строка, ни число, то проверять не нужно, так как будут некорректные результаты при приведении типов.
		if (!is_numeric($num) AND !is_string($num)) return false;

		return ((float)0 === (float)$num);
	}

	//*********************************************************************************

	/**
	 * Сравнение строк в многобайтовых кодировках без учета регистра
	 *
	 * @param string $str1 Первая строка для сравнения
	 * @param string $str2 Вторая строка для сравнения
	 *
	 * @return bool TRUE - строки равны без учета регистра; FALSE - строки не равны без учета регистра
	 * */
	public static function isCaseCmp($str1, $str2)
	{
		//ВНИМАНИЕ! Если передаваемое значение ни строка, ни число, то проверять не нужно, так как будут некорректные результаты при приведении типов.
		if ((!is_numeric($str1) AND !is_string($str1)) OR (!is_numeric($str2) AND !is_string($str2))) return false;

		return (0 === self::mb_strcasecmp($str1, $str2));
	}

	//*********************************************************************************

	/**
	 * Реализация функции для сравнения строк в многобайтных кодировках и с учетом регистра
	 * ВНИМАНИЕ! Стандартная функция strcmp() выдает неверный результат в определенных ситуациях (по результатам тестирования, например при строках: "Я"(в верхнем регистре) и "я"(в нижнем регистре) выдавала результат -1 вместо 0)
	 *
	 * @param string $str1 Первая строка для сравнения
	 * @param string $str2 Вторая строка для сравнения
	 *
	 * @return int 0 - строки равны с учетом регистра; -1 - строки не равны с учетом регистра
	 * */
	public static function mb_strcmp($str1, $str2)
	{
		//ВНИМАНИЕ! Если передаваемое значение ни строка, ни число, то проверять не нужно, так как будут некорректные результаты при приведении типов.
		if ((!is_numeric($str1) AND !is_string($str1)) OR (!is_numeric($str2) AND !is_string($str2))) return false;

		if (0 === mb_strlen($str1) && 0 === mb_strlen($str2))
		{
			return 0;
		}

		//Если длины строк равны и одна из строк является подстрокой второй и при этом входит с нолевого символа (с учетом регистра), то значит эти строки равны
		if
		(
			(mb_strlen($str1) === mb_strlen($str2))
			&&
			(0 === mb_strpos($str1, $str2))
		)
		{
			return 0;
		}
		else
		{
			return -1;
		}
	}

	//*********************************************************************************

	/**
	 * Реализация функции для сравнения строк в многобайтных кодировках и без учета регистра.
	 * ВНИМАНИЕ! Стандартная функция strcasecmp() выдает неверный результат в определенных ситуациях (по результатам тестирования, например при строках: "V"(в верхнем регистре) и "v"(в нижнем регистре) выдавала результат 0, а должна была число отличное от ноля)
	 *
	 * @param string $str1 Первая строка для сравнения
	 * @param string $str2 Вторая строка для сравнения
	 *
	 * @return int 0 - строки равны без учета регистра; -1 - строки не равны без учета регистра
	 * */
	public static function mb_strcasecmp($str1, $str2)
	{
		//ВНИМАНИЕ! Если передаваемое значение ни строка, ни число, то проверять не нужно, так как будут некорректные результаты при приведении типов.
		if ((!is_numeric($str1) AND !is_string($str1)) OR (!is_numeric($str2) AND !is_string($str2))) return false;

		if (0 === mb_strlen($str1) && 0 === mb_strlen($str2))
		{
			return 0;
		}

		//Если длины строк равны и одна из строк является подстрокой второй и при этом входит с нолевого символа (без учета регистра), то значит эти строки равны
		if
		(
			(mb_strlen($str1) === mb_strlen($str2))
			&&
			(0 === mb_stripos($str1, $str2))
		)
		{
			return 0;
		}
		else
		{
			return -1;
		}
	}

	//*********************************************************************************

	/**
	 * Преобразует первый символ строки $str к верхнему регистру. Если строка пуста, то возвращает пустую строку
	 *
	 * @param string $str Исходная строка
	 *
	 * @return string Результирующая строка
	 * */
	public static function mb_ucfirst($str)
	{
		//ВНИМАНИЕ! Если передаваемое значение ни строка, ни число, то проверять не нужно, так как будут некорректные результаты при приведении типов.
		if (!is_numeric($str) AND !is_string($str)) return $str;

		if (0 === mb_strlen($str)) return $str;

		return mb_strtoupper(mb_substr($str, 0, 1)).mb_substr($str, 1);
	}

	//*********************************************************************************

	public static function getImageType($img)
	{
		//Получаем параметры изображения
		$imageParameter = getimagesize($img);

		//Проверяем тип изображения, и взависимотси от типа, подготавливаем изображение к обработке
		if ($imageParameter[2] === 2)
		{
			return "jpg";
		}
		elseif ($imageParameter[2] === 3)
		{
			return "png";
		}
		elseif ($imageParameter[2] === 1)
		{
			return "gif";
		}
		elseif ($imageParameter[2] === 18)
		{
			return "webp";
		}
		else
		{
			return(false);
		}
	}

	//*********************************************************************************

	public static function resizeImage($fileImage, $destFileName, $w, $h, $fullPreview = true)
	{
		//Получаем параметры изображения
		$imageParameter = getimagesize($fileImage);

		//Проверяем тип изображения, и взависимотси от типа, подготавливаем изображение к обработке
		if($imageParameter[2] === 2)
		{
			$ext = "jpg";
			$srcImage = imagecreatefromjpeg($fileImage);
		}
		else
		{
			if($imageParameter[2] === 3)
			{
				$ext = "png";
				$srcImage = imagecreatefrompng($fileImage);
			}
			else
			{
				if ($imageParameter[2] === 1)
				{
					$ext = "gif";
					$srcImage = imagecreatefromgif($fileImage);
				}
				else
				{
					return(false);
				}
			}
		}

		//Проверяем нужно ли вобще обрабатывать изображение
		if(($imageParameter[0] <= $w) && ($imageParameter[1] <= $h))
		{
			//Копировать изображение в папку назначения
			if(copy($fileImage, $destFileName.".".$ext))
			{
				return($destFileName.".".$ext);
			}
			else
			{
				return(false);
			}
		}
		/*
			//В случае если включенно кадрирование, проверяем чтобы строны W и H изображения были больше или равны W и H в которые нужно кадрировать
			if(!$fullPreview)
			{
				  if(($imageParameter[0] <= $w) || ($imageParameter[1] <= $h))
				  {
					  $fullPreview = true;
				  }
			}
		*/
		//Расчет коэфициэнтов отношения W к H изображений
		$ratio = $w / $h;
		$ratioSrc = $imageParameter[0] / $imageParameter[1];


		//Делаем уменьшеную копию изображения
		if($fullPreview)
		{
			//Если нужно делать превью полного вида, то пересчитываем W или H резльтирующего изображения
			if($fullPreview)
			{
				if($ratio > $ratioSrc)
				{
					$w = $h * $ratioSrc;
				}
				else
				{
					$h = $w / $ratioSrc;
				}
			}

			//Создаем заготовку для уменьшиной копии изображения
			$destImage = imagecreatetruecolor($w, $h);

			//Делаем прозрачный фон
			imagesavealpha($destImage, true);
			$alphaDest = imagecolorallocatealpha($destImage, 0, 0, 0, 127);
			imagefill($destImage, 0, 0, $alphaDest);

			//Уменьшаем изображение
			imagecopyresampled($destImage, $srcImage, 0, 0, 0, 0, $w, $h, $imageParameter[0], $imageParameter[1]);
		}
		else
		{
			//Если хотябы одна сторона исходного изображения влазит в область кадрирования, то предварительное уменьшение изображения уже не требуется, значит нужно просто кадрировать
			if(($imageParameter[0] <= $w) || ($imageParameter[1] <= $h))
			{
				//ПРОСТОЕ КАДРИРОВАНИЕ БЕЗ ПРЕДВАРИТЕЛЬНОГО УМЕНЬШЕНИЯ

				//Сначало обявляем новые переменные ширини и высоты результирующей области кадрирования, которую предстоит расчитать ниже
				$wResize = $w;
				$hResize = $h;

				//Расчитываем первоначальные координаты верхнего левого угла области, которую будем вырезать из изображения. А далее эти координаты пересчитаются при необходимости
				$srcX = ($imageParameter[0] / 2) - ($wResize / 2);
				$srcY = ($imageParameter[1] / 2) - ($hResize / 2);

				//Если ШИРИНА изображения влазит в область кадривания, то кадрируем максимум по шиирине исходного изображение
				if ($imageParameter[0] <= $w)
				{
					$wResize = $imageParameter[0];

					//Координата X, с которой будет вырезатся изображение это левая граница этого изображения
					$srcX = 0;
				}
				//Если ВЫСОТА изображения влазит в область кадривания, то кадрируем максимум по высоте исходного изображение
				if ($imageParameter[1] <= $h)
				{
					$hResize = $imageParameter[1];

					//Координата Y, с которой будет вырезатся изображение это верхняя граница этого изображения
					$srcY = 0;
				}

				/* Создаем заготовку для уменьшеной копии оригинального изображения. [END] */

				//Создаем заготовку для уменьшиной копии изображения
				$destImage = imagecreatetruecolor($wResize, $hResize);

				//Делаем прозрачный фон
				imagesavealpha($destImage, true);
				$alphaDest = imagecolorallocatealpha($destImage, 0, 0, 0, 127);
				imagefill($destImage, 0, 0, $alphaDest);

				//Кадрируем изображение
				imagecopyresampled($destImage, $srcImage, 0, 0, $srcX, $srcY, $wResize, $hResize, $wResize, $hResize);
			}
			else
			{
				//КАДРИРОВАНИЕ С ПРЕДВАРИТЕЛЬНЫМ УМЕНЬШЕНИЕМ

				//Проверяем коэфициэнты отношения сторон изображений
				if($ratio > $ratioSrc)
				{
					//Расчет H для уменьшения оригинального изображения перед кадрированием
					$wResize = $w;
					$hResize = intval($wResize / $ratioSrc);

					//Пересчитываем SRC X и Y
					$srcX = 0;
					$srcY = ($hResize / 2) - ($h / 2);
				}
				else
				{
					//Расчет W для уменьшения оригинального изображения перед кадрированием
					$hResize = $h;
					$wResize = intval($hResize * $ratioSrc);

					//Пересчитываем SRC X и Y
					$srcX = ($wResize / 2) - ($w / 2);
					$srcY = 0;
				}

				/* Создаем заготовку для уменьшеной копии оригинального изображения. */

				//Создаем заготовку промежуточного изображения, уменьшеного до того, чтобы хотябы одной стороной вписатся в область кадрирования
				$destImageOrg = imagecreatetruecolor($wResize, $hResize);

				//Делаем прозрачный фон
				imagesavealpha($destImageOrg, true);
				$alphaDest = imagecolorallocatealpha($destImageOrg, 0, 0, 0, 127);
				imagefill($destImageOrg, 0, 0, $alphaDest);

				//Создаем уменьшенную копию оригинального изображения
				imagecopyresampled($destImageOrg, $srcImage, 0, 0, 0, 0, $wResize, $hResize, $imageParameter[0], $imageParameter[1]);
				//Удаляем источник оригинального изображения. Теперь будем работать с уменьшиной копией
				unset($srcImage);

				/* Создаем заготовку для уменьшеной копии оригинального изображения. [END] */

				//Создаем заготовку для уменьшиной копии изображения
				$destImage = imagecreatetruecolor($w, $h);

				//Делаем прозрачный фон
				imagesavealpha($destImage, true);
				$alphaDest = imagecolorallocatealpha($destImage, 0, 0, 0, 127);
				imagefill($destImage, 0, 0, $alphaDest);

				//Кадрируем изображение
				imagecopyresampled($destImage, $destImageOrg, 0, 0, $srcX, $srcY, $w, $h, $w, $h);
			}
		}

		//Сохраняем копию на диск
		if($imageParameter[2] === 2)
		{
			if(imagejpeg($destImage, $destFileName.".".$ext, 75))
			{
				return($destFileName.".".$ext);
			}
			else
			{
				return(false);
			}
		}
		else
		{
			if($imageParameter[2] === 3)
			{
				if(imagepng($destImage, $destFileName.".".$ext, 2))
				{
					return($destFileName.".".$ext);
				}
				else
				{
					return(false);
				}
			}
			else
			{
				if ($imageParameter[2] === 1)
				{
					if(imagegif($destImage, $destFileName.".".$ext))
					{
						return($destFileName.".".$ext);
					}
					else
					{
						return(false);
					}
				}
			}
		}

		return(false);
	}

	//*********************************************************************************

	public static function getHtml_phones($phones, $addClass = "")
	{
		$objSTemplate = STemplate::getInstance();

		$html = "";

		//Разбиваем текст на массив с номерами
		$phoneArray = preg_split("#\\r\\n#iu", $phones, -1, PREG_SPLIT_NO_EMPTY);

		foreach ($phoneArray AS $phone)
		{
			$data =
				[
					"phoneA" => Func::toTelephoneSearch($phone),
					"phone" => $phone,
				];
			$html .= $objSTemplate->getHtml("func", "phoneListItem", $data);
		}

		$data =
			[
				"addClass" => $addClass,
				"phoneList" => $html,
			];
		return $objSTemplate->getHtml("func", "phoneBlock", $data);
	}

	//*********************************************************************************

	public static function getHtml_emails($emails, $addClass = "")
	{
		$objSTemplate = STemplate::getInstance();

		$html = "";

		//Разбиваем текст на массив с email
		$emailArray = preg_split("#\\r\\n#iu", $emails, -1, PREG_SPLIT_NO_EMPTY);

		foreach ($emailArray AS $email)
		{
			$data =
				[
					"email" => $email,
				];
			$html .= $objSTemplate->getHtml("func", "emailListItem", $data);
		}

		$data =
			[
				"addClass" => $addClass,
				"emailList" => $html,
			];
		return $objSTemplate->getHtml("func", "emailBlock", $data);
	}

	//*********************************************************************************
}


?>