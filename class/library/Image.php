<?php

/**
 * Работа с изображениями (изменение размеров, накладывание вотермарков, вырезание области). Работает с библиотекой GD
 *
 * @package Astrid Framework
 * @author Александр Шевяков
 * @author Игорь Михальчук
 * @version 1.1
 * @link http://www.it-island.com/astrid/ IT-Island:Astrid
 * */

class Image
{
	/**
	 * Содержит текст последней ошибки работы класса
	 * @var string
	 * */
	public $error = "";

	/**
	 * Указывает является ли последняя ошибка критиеской или нет
	 * @var string
	 * */
	public $errorIsFatal = false;

	private static $obj = null;

	private $imageQualityJPG = 75;
	private $imageQualityPNG = 2;

	//*********************************************************************************

	protected function __construct()
	{
	}

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new Image();
		}

		return self::$obj;
	}

	//*********************************************************************************

	/**
	 * Возвращает массив параметров файла изображения используя для этого функцию getimagesize (но при этом не использует индексы массива параметров возвращаемые непосредственное ей)
	 *
	 * @param string $filePath Абсолютный путь к файлу изображения
	 *
	 * @return mixed FALSE - в случае ошибки; array - массив параметров изображения ("width" => "ширина", "height" => "высота", "type" => "EImageType - тип изображения")
	 * */
	public function getImageParameters($filePath)
	{
	   	$imageParametersArray = @getimagesize($filePath);
	   	//Проверяем на ошибку работы функции (функция в случае ошибки по разным документациям возвращает то NULL то FALSE, потому я проверяю на оба этих значения)
		if ((false === $imageParametersArray) || is_null($imageParametersArray))
		{
			$this->error = "getimagesize return false";
			$this->errorIsFatal = true;
			return false;
		}

		//Переводим параметры в int, но функция должна конечно была их возвратить тоже в int
		return array
		(
			"width" => (int)$imageParametersArray[0],
			"height" => (int)$imageParametersArray[1],
			"type" => (int)$imageParametersArray[2],
		);
	}

	//*********************************************************************************

	/**
	 * Возвращает тип изображения (данный параметр входит в перечисление EImageType). Проверяет является ли файл $filePath поддерживаемым изображением
	 * В случае ошибки, заполняет текстом ошибки переменную класса #error
	 *
	 * @param string $filePath Абсолютный путь к файлу изображения
	 *
	 * @return mixed FALSE - в случае ошибки; EImageType - тип изображения
	 * */
	public function getImageType($filePath)
	{
		//Проверяем существования файла
		if (false === $this->checkFileExists($filePath)) return false;

	   	//Получаем параметры изображения
	   	if (false === ($imageParametersArray = $this->getImageParameters($filePath))) return false;

		//Проверяем тип изображения
		if
		(
			($imageParametersArray["type"] === EImageType::GIF)
			||
			($imageParametersArray["type"] === EImageType::JPG)
			||
			($imageParametersArray["type"] === EImageType::PNG)
		)
		{
			return $imageParametersArray["type"];
		}
		else
		{
			$this->error = "Тип изображения не поддерживается [".$imageParametersArray["type"]."]";
			$this->errorIsFatal = true;
			return false;
		}
	}

	//*********************************************************************************

	/**
	 * Определяет действительный формат изображения (посредством использования функций работы с изображениями) и возвращает текстовую строку основного расширения этого типа
	 *
	 * @param string $filePath Абсолютный путь к файлу
	 * @param bool $getWithDot Ключ указывающий будет ли возвращаемый текст содержать дополнительно первым символом точку
	 *
	 * @return mixed FALSE - в случае ошибки; string - расширение файла
	 * */
	public function getImageExtension($filePath, $getWithDot = false)
	{
		$this->error = "";
		$this->errorIsFatal = false;

		//Проверяем существования файла
		if (false === $this->checkFileExists($filePath)) return false;

	   	//Получаем параметры изображения
	   	if (false === ($imageType = $this->getImageType($filePath))) return false;

		//Проверяем тип изображения, и в зависимотси от типа возвращаем соответствующее расширение
		switch($imageType)
  		{
  			case EImageType::GIF:
  			{
				return ($getWithDot === true) ? ".gif" : "gif";
  				break;
  			}
  			case EImageType::JPG:
  			{
				return ($getWithDot === true) ? ".jpg" : "jpg";
  				break;
  			}
  			case EImageType::PNG:
  			{
				return ($getWithDot === true) ? ".png" : "png";
  				break;
  			}
  			default:
  			{
				$this->error = "Тип изображения не поддерживаеться [".$imageParametersArray["type"]."]";
				$this->errorIsFatal = true;
				return false;
  			}
  		}
	}

	//*********************************************************************************

	/**
	 * Определяет является ли указаный файл изображением (изображением плддерживаемого типа).
	 * Необходимо пользоваться данным методом перед тем как работать с другими методами данного класса, так как они ориентирутся на то, что переданные им файлы являются изображениями.
	 *
	 * @param string $filePath Абсолютный путь к файлу
	 *
	 * @return bool TRUE - изображение, FALSE - не изображение, или произошла ошибка
	 * */
	public function isImage($filePath)
	{
		$this->error = "";
		$this->errorIsFatal = false;

		//Проверяем существования файла
		if (false === $this->checkFileExists($filePath)) return false;

	   	//Получаем параметры изображения
	   	if (false === ($imageType = $this->getImageType($filePath))) return false;

		//Проверяем тип изображения
		if
		(
			($imageType === EImageType::GIF)
			||
			($imageType === EImageType::JPG)
			||
			($imageType === EImageType::PNG)
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

	/**
	 * Изменяет тип файла изображения $src (а ткаже его качество). Сохраняет результирующее изображение по адресу $dst.
	 * Параметр $quality должен передаватся в формате соответсвующем определенному типа $type.
	 * В случае ошибки работы, заполняет переменную класса $error текстом ошибки и возвращает FALSE.
	 * В случае успеха возвращает TRUE.
	 *
	 * @param string $src Абсолютный адрес файла исходного изображения
	 * @param string $dst Абсолютный адрес файла результирующего изображения
	 * @param int $type Тип результирующего изображения
	 * @param int $quality Качество результирующего изображения. Значение зависит от конкретного типа
	 *
	 * @return bool TRUE - успех, FALSE - ошибка
	 * */
	public function changeTypeImage($src, $dst, $type, $quality = null)
	{
		$this->error = "";
		$this->errorIsFatal = false;

		//Проверяем существования файла
		if (false === $this->checkFileExists($src)) return false;

		//Если качетво не передавалось, то определяем качество, как качество по умолчанию
		if (is_null($quality))
		{
			//Определяем качество по умолчанию (только не для GIF, для которого оно не имеет смысл)
			if ($type !== EImageType::GIF)
				$quality = $this->getDefaultImageQuality($type);
		}
		else
		{
			//Проверяем коректность передачи типа и качества
			switch($type)
			{
				case EImageType::GIF:
				{
					//Для GIF качество не имеет смысл
					break;
				}
				case EImageType::JPG:
				{
					$quality = (int)$quality;
					if (0 > $quality || $quality > 100)
					{
						$this->error = "Качество JPG имеет неверный формат [".$quality."]";
						$this->errorIsFatal = true;
						return false;
					}

					break;
				}
				case EImageType::PNG:
				{
					$quality = (int)$quality;
					if (0 > $quality || $quality > 9)
					{
						$this->error = "Качество PNG имеет неверный формат [".$quality."]";
						$this->errorIsFatal = true;
						return false;
					}

					break;
				}
				default:
				{
					$this->error = "Некорректный тип изображения [".$type."]";
					$this->errorIsFatal = true;
					return false;
				}
			}
		}

		//Получаем параметры изображения
	   	if (false === ($imageParametersArray = $this->getImageParameters($src)))
	   	{
	   		return false;
	   	}

		//Сначала определяем переменную, в которую поместим ресурс изображения (она будет передана далее в метод как ссылка)
		$imageResource = null;

		//Определяем тип изображения, и взависимотси от типа, подготавливаем ресурс изображения к обработке
		if (false === $this->getImageResource($src, $imageResource, $imageParametersArray))
		{
			return false;
		}

		//Сохраняем на диск
		return $this->saveImage($imageResource, $dst, $type, $quality);
	}

	//*********************************************************************************

	/**
	 * Изменяет размеры изображения $src, сохраняя пропорции. Сохраняет результирующее изображение по адресу $dst.
	 * В случае ошибки работы, заполняет переменную класса $error текстом ошибки и возвращает FALSE.
	 * В случае успеха возвращает TRUE.
	 *
	 * @param string $src Абсолютный адрес файла исходного изображения
	 * @param string $dst Абсолютный адрес файла результирующего изображения
	 * @param int $width Ширина результирующего изображения
	 * @param int $height Высота результирующего изображения
	 * @param bool $keepRatioKey Ключ указывающий сохранять ли пропорции, при изменении размеров изображения
	 * @param bool $expansionKey Ключ указывающий увеличивать ли изображение, если его размеры меньше размеров назначения
	 *
	 * @return bool TRUE - успех, FALSE - ошибка
	 * */
	public function resizeImage($src, $dst, $width, $height, $keepRatioKey, $expansionKey)
	{
		$this->error = "";
		$this->errorIsFatal = false;

		//Проверяем существования файла
		if (false === $this->checkFileExists($src)) return false;

		//Проверяем, чтобы ширина была целым числом, больше нуля
		if (!Reg::isNum($width) || (int)$width <= 0)
		{
			$this->error = "Некорректный параметр ширины результирующего изображения";
			$this->errorIsFatal = true;
			return false;
		}
		$width = (int)$width;

		//Проверяем, чтобы высота была целым числом, больше нуля
		if (!Reg::isNum($height) || (int)$height <= 0)
		{
			$this->error = "Некорректный параметр высоты результирующего изображения";
			$this->errorIsFatal = true;
			return false;
		}
		$height = (int)$height;

		//Получаем параметры изображения
	   	if (false === ($imageParametersArray = $this->getImageParameters($src)))
	   	{
	   		return false;
	   	}

		//Если ключ "увеливать изображение, если оно меньше" не выставлен, то нужно проверить не меньше ли оно, в этом случае не нужно ничего будет делать вообще
		if (false === $expansionKey)
		{
			//Проверяем нужно ли вообще обрабатывать изображение
			if(($imageParametersArray["width"] <= $width) && ($imageParametersArray["height"] <= $height))
			{
				//Копируем изображение в папку назначения (без обработки), если это нужно
				if (0 !== Func::mb_strcmp($src, $dst))
				{
					if(@copy($src, $dst))
					{
						return true;
					}
					else
					{
						$this->error = "Ошибка копирования файла по адресу назначения [src=".$src."; dst=".$dst."]";
						$this->errorIsFatal = true;
						return false;
					}
				}
				else
				{
					return true;
				}
			}
		}

		//Производим набор операций по измененю размеров изображения

		//Если ключ "сохранять пропорции" выставлен, то необходимо пересчитать размеры результирующего изображения, для того, чтобы изменять размер сохраняя пропорции
		if (true === $keepRatioKey)
		{
			//Расчет коэфициэнтов (Коэфициенты не нужно приводить к INT, они должны быть дробными)
			$ratio = $width / $height;
			$ratioSrc = $imageParametersArray["width"] / $imageParametersArray["height"];

			if($ratio > $ratioSrc)
			{
				$width = $height * $ratioSrc;
				$width = (int)$width;
			}
			else
			{
				$height = $width / $ratioSrc;
				$height = (int)$height;
			}
		}

		/**
		 * ВНИМАНИЕ! Существует ситуация, при которой, расчитанные размеры изображения могут быть равны нулю,
		 * так как были меньше единицы и при преобразовании в тип INT приравнялись к нулю.
		 * Например, при сохранениии проорций, изображение сжалось по одной из сторон так сильно,
		 * с целью вписатся в требуемый размер, что вторая сторона при этом стала меньше единицы.
		 *
		 * Проверяем такую ситуацию и выдаем специальное сообщение
		 * */
	 	if (0 === $width || 0 === $height)
	 	{
	 		$this->error = "При изменении размеров, одна из сторон результирующего изображения меньше одного пикселя";
	 		$this->errorIsFatal = false;
	 		return false;
	 	}

		//Сначала определяем переменную, в которую поместим ресурс изображения (она будет передана далее в метод как ссылка)
		$imageResource = null;

		//Определяем тип изображения, и в зависимоcти от типа, подготавливаем ресурс изображения к обработке
		if (false === $this->getImageResource($src, $imageResource, $imageParametersArray))
		{
			return false;
		}

		//Сначала определяем переменную, в которую поместим ресурс изображения (она будет передана далее в метод как ссылка)
		$dstImageResource = null;

		//Создаем заготовку для уменьшеной копии изображения
		if (false === $this->createImageResource($dstImageResource, $width, $height)) return false;

		//Делаем уменьшеную копию изображения
		if
		(
			false === $this->copyImageResourceOnResource
			(
				$dstImageResource,
				$imageResource,
				0,
				0,
				0,
				0,
				$width,
				$height,
				$imageParametersArray["width"],
				$imageParametersArray["height"]
			)
		)
		{
			return false;
		}

		//Очищаем память
		if (false === $this->clearImageResource($imageResource)) return false;

		//Сохраняем копию на диск
		return $this->saveImage($dstImageResource, $dst, $imageParametersArray["type"]);
	}

	//*********************************************************************************

	/**
	 * Налаживает изображение вотермарка $srcWatermark на исходное изображение $src. Результирующее изображение сохраняется по адресу $dst.
	 * В случае ошибки работы, заполняет переменную класса $error текстом ошибки и возвращает FALSE.<br>
	 * В случае успеха возвращает TRUE.
	 *
	 * @param string $src Абсолютный адрес файла исходного изображения
	 * @param string $dst Абсолютный адрес файла результирующего изображения
	 * @param string $srcWatermark Абсолютный адрес файла изображения вотермарка
	 * @param array $watermarkOptions массив настроек позиционирования вотермарка<br>
	 * "position" => EImagePosition;<br>
	 * "marginX" => "0",//Отступ по иси X, слева или справа от вотермарка, в зависимости от того куда он позиционируется;<br>
	 * "marginY" => "0",//Отступ по иси Y, сверху или снизу от вотермарка, в зависимости от того куда он позиционируется;<br>
	 * "x" => "0",//Четкая кордината вотермарка по оси X на плоскости изображения. Учитывается, если position=EImagePosition::fixed;<br>
	 * "y" => "0",//Четкая кордината вотермарка по оси Y на плоскости изображения. Учитывается, если position=EImagePosition::fixed.<br>
	 *
	 * @return bool TRUE - успех, FALSE - ошибка
	 * */
	public function addWatermark($src, $dst, $srcWatermark, $watermarkOptions)
	{
		$this->error = "";
		$this->errorIsFatal = false;

		//Проверяем существования файла
		if (false === $this->checkFileExists($src)) return false;
		//Проверяем существования файла
		if (false === $this->checkFileExists($srcWatermark)) return false;

		//------------------------------------------------------------

		//Получаем параметры изображения
	   	if (false === ($imageParametersArray = $this->getImageParameters($src))) return false;

		//Сначала определяем переменную, в которую поместим ресурс изображения (она будет передана далее в метод как ссылка)
		$imageResource = null;

		//Определяем тип изображения, и в зависимотси от типа, подготавливаем ресурс изображения к обработке
		if (false === $this->getImageResource($src, $imageResource, $imageParametersArray))
		{
			return false;
		}

		//------------------------------------------------------------

		//Получаем параметры изображения вотермарка
	   	if (false === ($watermarkImageParametersArray = $this->getImageParameters($srcWatermark)))
	   	{
	   		return false;
	   	}

		//Сначала определяем переменную, в которую поместим ресурс изображения вотермарка (она будет передана далее в метод как ссылка)
		$imageResourceWatermark = null;

		//Определяем тип изображения вотермарка, и в зависимотси от типа, подготавливаем ресурс изображения вотермарка к обработке
		if (false === $this->getImageResource($srcWatermark, $imageResourceWatermark))
		{
			return false;
		}

		//------------------------------------------------------------
/*
		//ЗАКОМЕНТИРОВАНО, так как связь с сохранением палитры длясохранения прозрачности не подтвердилась на нескольких экспериментах
		//Сохраняем альфа палитру, чтобы сохранить эффект прозпрачности, если он есть
		//ВНИМАНИЕ! Не удалять, иначе не будет работать прозрачность, если она есть на вотермарке
		if (false === imagesavealpha($imageResourceWatermark, true))
		{
			$this->error = "imagesavealpha return false";
			$this->errorIsFatal = true;
			return false;
		}
*/
		//Расчитываем координаты верхней левой точки наложения водяного знака
		$objImageInscribe = ImageInscribe::getInstance();
		if (false === ($inscribeAreaProperties = $objImageInscribe->getInscribeAreaProperties($watermarkOptions, $imageParametersArray["width"], $imageParametersArray["height"], $watermarkImageParametersArray["width"], $watermarkImageParametersArray["height"])))
		{
			$this->error = $objImageInscribe->error;
			$this->errorIsFatal = $objImageInscribe->errorIsFatal;
			return false;
		}

		//Налаживаем водяной знак
		if
		(
			false === $this->copyImageResourceOnResource
			(
				$imageResource,
				$imageResourceWatermark,
				$inscribeAreaProperties["imgX"],
				$inscribeAreaProperties["imgY"],
				$inscribeAreaProperties["areaX"],
				$inscribeAreaProperties["areaY"],
				$inscribeAreaProperties["newAreaWidth"],
				$inscribeAreaProperties["newAreaHeight"],
				$inscribeAreaProperties["newAreaWidth"],
				$inscribeAreaProperties["newAreaHeight"]
			)
		)
		{
			return false;
		}

		//Очищаем память от ресурса вотермарка, но не трогаем ресурс самого изображения, так как далее он нам нужен
		if (false === $this->clearImageResource($imageResourceWatermark)) return false;

		//Сохраняем на диск
		return $this->saveImage($imageResource, $dst, $imageParametersArray["type"]);
	}

	//*********************************************************************************

	/**
	 * Вырезает из изображения $src область указаных размеров. Сохраняет результирующее изображение по адресу $dst.
	 * В случае ошибки работы, заполняет переменную класса $error текстом ошибки и возвращает FALSE.
	 * В случае успеха возвращает TRUE.
	 *
	 * @param string $src Абсолютный адрес файла исходного изображения
	 * @param string $dst Абсолютный адрес файла результирующего изображения
	 * @param int $width Ширина вырезаемой области
	 * @param int $height Высота вырезаемой области
	 * @param array $options Массив параметров указывающих тип и детали расположения области
	 * "position" => EImagePosition;<br>
	 * "marginX" => "0",//Отступ по иси X, слева или справа от вотермарка, в зависимости от того куда он позиционируется;<br>
	 * "marginY" => "0",//Отступ по иси Y, сверху или снизу от вотермарка, в зависимости от того куда он позиционируется;<br>
	 * "x" => "0",//Четкая кордината вотермарка по оси X на плоскости изображения. Учитывается, если position=EImagePosition::fixed;<br>
	 * "y" => "0",//Четкая кордината вотермарка по оси Y на плоскости изображения. Учитывается, если position=EImagePosition::fixed.<br>
	 *
	 * @return bool TRUE - успех, FALSE - ошибка
	 * */
	public function cropImage($src, $dst, $width, $height, $options)
	{
		$this->error = "";
		$this->errorIsFatal = false;

		//Проверяем существования файла
		if (false === $this->checkFileExists($src)) return false;

		//Проверяем, чтобы ширина была целым число, больше нуля
		if (!Reg::isNum($width) || (int)$width <= 0)
		{
			$this->error = "Некорректный параметр ширины вырезаемой области";
			$this->errorIsFatal = true;
			return false;
		}
		$width = (int)$width;

		//Проверяем, чтобы высота была целым число, больше нуля
		if (!Reg::isNum($height) || (int)$height <= 0)
		{
			$this->error = "Некорректный параметр высоты вырезаемой области";
			$this->errorIsFatal = true;
			return false;
		}
		$height = (int)$height;

		//Получаем параметры изображения
	   	if (false === ($imageParametersArray = $this->getImageParameters($src)))
	   	{
	   		return false;
	   	}

		//Сначала определяем переменную, в которую поместим ресурс изображения (она будет передана далее в метод как ссылка)
		$imageResource = null;

		//Определяем тип изображения, и в зависимотси от типа, подготавливаем ресурс изображения к обработке
		if (false === $this->getImageResource($src, $imageResource, $imageParametersArray))
		{
			return false;
		}

		//Производим набор операций по вырезанию области из изображения

		//Расчитываем параметры для вписываемой области (как координаты куда ее вписать, так и какую часть области взять для вписывания, если она не влазит полностью)
		$objImageInscribe = ImageInscribe::getInstance();
		if (false === ($inscribeAreaProperties = $objImageInscribe->getInscribeAreaProperties($options, $imageParametersArray["width"], $imageParametersArray["height"], $width, $height)))
		{
			$this->error = $objImageInscribe->error;
			$this->errorIsFatal = $objImageInscribe->errorIsFatal;
			return false;
		}

		//Сначала определяем переменную, в которую поместим ресурс изображения (она будет передана далее в метод как ссылка)
		$dstImageResource = null;

		//Создаем заготовку для вырезаемой области изображения
		if (false === $this->createImageResource($dstImageResource, $inscribeAreaProperties["newAreaWidth"], $inscribeAreaProperties["newAreaHeight"])) return false;

		//Создаем изображение вырезаной области
		if
		(
			false === $this->copyImageResourceOnResource
			(
				$dstImageResource,
				$imageResource,
				0,
				0,
				$inscribeAreaProperties["imgX"],
				$inscribeAreaProperties["imgY"],
				$inscribeAreaProperties["newAreaWidth"],
				$inscribeAreaProperties["newAreaHeight"],
				$inscribeAreaProperties["newAreaWidth"],
				$inscribeAreaProperties["newAreaHeight"]
			)
		)
		{
			return false;
		}

		//Очищаем память, удаляя объект исходного изображения
		if (false === $this->clearImageResource($imageResource)) return false;

		//Сохраняем копию на диск
		return $this->saveImage($dstImageResource, $dst, $imageParametersArray["type"]);
	}

	//*********************************************************************************

	/**
	 * Сперва уменьшает изображение $src до того как одна из его сторон влезет в указаный для нее размер ($width или $height, соответственно).
	 * Далее, вырезает из изображения $src область указаных размеров. Сохраняет результирующее изображение по адресу $dst.
	 * В случае ошибки работы, заполняет переменную класса $error текстом ошибки и возвращает FALSE.
	 * В случае успеха возвращает TRUE.
	 *
	 * @param string $src Абсолютный адрес файла исходного изображения
	 * @param string $dst Абсолютный адрес файла результирующего изображения
	 * @param int $width Ширина вырезаемой области
	 * @param int $height Высота вырезаемой области
	 *
	 * @return bool TRUE - успех, FALSE - ошибка
	 * */
	public function smartCropImage($src, $dst, $width, $height)
	{
		$this->error = "";
		$this->errorIsFatal = false;

		//Проверяем существования файла
		if (false === $this->checkFileExists($src)) return false;

		//Проверяем, чтобы ширина была целым числом, больше нуля
		if (!Reg::isNum($width) || (int)$width <= 0)
		{
			$this->error = "Некорректный параметр ширины вырезаемой области";
			$this->errorIsFatal = true;
			return false;
		}
		$width = (int)$width;

		//Проверяем, чтобы высота была целым числом, больше нуля
		if (!Reg::isNum($height) || (int)$height <= 0)
		{
			$this->error = "Некорректный параметр высоты вырезаемой области";
			$this->errorIsFatal = true;
			return false;
		}
		$height = (int)$height;

		//Получаем параметры изображения
	   	if (false === ($imageParametersArray = $this->getImageParameters($src))) return false;

		//Сначала определяем переменную, в которую поместим ресурс изображения (она будет передана далее в метод как ссылка)
		$imageResource = null;

		//Определяем тип изображения, и в зависимотси от типа, подготавливаем ресурс изображения к обработке
		if (false === $this->getImageResource($src, $imageResource, $imageParametersArray))
		{
			return false;
		}

		/**
		 * [1] Если хотябы одна сторона исходного изображения меньше или равна соответствующей ей стороне области кадрирования, то необходимо просто кадрировать данное изображение и больше никаких действий
		 * [2] ИНАЧЕ
		 * [2.1] Вычислить соотношения сторон для изображения и для области кадрирования
		 * [2.2] Из сравнения соотношений сторон определяем по какой стороне необходимо уменьшить изображение до размера области кадрирования
		 * [2.3] После этого расчитываем другую сторону области кадлрирования пропорционально соотношению сторон изобраения (для того, чтобы в следующем этапе изменить размер изображения пропорционально)
		 * [2.4] Изменяем размер изображения до полученных размеров (это будет процесс уменьшения, так как в пункте [1] будет откинута ситуация, когда изображение будет увеличиватся на этом этапе)
		 * [2.5] После предыдущего этапа изображение впишется как минимум одной стороной в исходную область кадрирования. Это нам и нужно
		 * [2.6] (процесс происходит вместе с пунктом [2.3]) Расчитываем расположение исходной области кадрирования на изображении измененных размеров, с учетом условия расположения ее по центру. Т.е. центрируем либо по горизонтали либо по вертикали в зависимости от того какая сторона больше исходной облати кадрирования
		 * [2.7] Вырезаем расчитанную область в изображении в расчитанном месте. Это и есть наш кадр
		 * */

		//[1]
  		if(($imageParametersArray["width"] <= $width) || ($imageParametersArray["height"] <= $height))
  		{
			//Создаем массив опций кадрирования
			$cropOptions = array
			(
				"position" => EImagePosition::center,
			);

  			return $this->cropImage($src, $dst, $width, $height, $cropOptions);
  		}

		//------------------------------------------------------------

		//[2]

		//Расчет коэфициэнтов отношения $width к $height области кадрирования и изображения
		$areaRatio = $width / $height;
		$srcRatio = $imageParametersArray["width"] / $imageParametersArray["height"];

		//------------------------------------------------------------

		//[2.1, 2.2, 2.3, 2.6]
		//Проверяем соотношение коэфициэнтов отношения сторон изображений
		if($areaRatio > $srcRatio)
		{
			//Ширина остается такой же как у области кадрирования
			$wResize = $width;
			//Расчитываем высоту для уменьшения оригинального изображения перед кадрированием
			$hResize = intval($wResize / $srcRatio);

			//Расчитываем координаты расположения области кадрирования на изображении измененных размеров
			$srcX = 0;
			$srcY = ($hResize / 2) - ($height / 2);
		}
		else
		{
			//Высота остается такой же как у области кадрирования
			$hResize = $height;
			//Расчитываем ширину для уменьшения оригинального изображения перед кадрированием
			$wResize = intval($hResize * $srcRatio);

			//Расчитываем координаты расположения области кадрирования на изображении измененных размеров
			$srcX = ($wResize / 2) - ($width / 2);
			$srcY = 0;
		}

		//------------------------------------------------------------

		//[2.4] Изменяем размеры исходного изображения до расчитаных величин (до тогоо как одна из сторон влезит в исходную область кадрирования)

		//Сначала определяем переменную, в которую поместим ресурс изображения (она будет передана далее в метод как ссылка)
		$dstImageResizeResource = null;

		//Создаем заготовку для уменьшеной копии изображения
		if (false === $this->createImageResource($dstImageResizeResource, $wResize, $hResize)) return false;

		//Делаем уменьшенную копию изображения
		if
		(
			false === $this->copyImageResourceOnResource
			(
				$dstImageResizeResource,
				$imageResource,
				0,
				0,
				0,
				0,
				$wResize,
				$hResize,
				$imageParametersArray["width"],
				$imageParametersArray["height"]
			)
		)
		{
			return false;
		}

		//------------------------------------------------------------

		//[2.7] Вырезаем расчитанную область в расчитанном месте в уже подогнанном под необходимые размеры изображении

		//Сначала определяем переменную, в которую поместим ресурс изображения (она будет передана далее в метод как ссылка)
		$dstImageResource = null;

		//Создаем заготовку для вырезаемой области изображения
		if (false === $this->createImageResource($dstImageResource, $width, $height)) return false;

		//Создаем изображение вырезаной области
		if
		(
			false === $this->copyImageResourceOnResource
			(
				$dstImageResource,
				$dstImageResizeResource,
				0,
				0,
				$srcX,
				$srcY,
				$width,
				$height,
				$width,
				$height
			)
		)
		{
			return false;
		}

		//Сохраняем копию на диск
		return $this->saveImage($dstImageResource, $dst, $imageParametersArray["type"]);
	}

	//*********************************************************************************

	/**
	 * Формирует ресурс изображения $filePath и помещает его в переменную $imageResource, которую принимает как ссылку.
	 * Если параметр $imageParametesArray передается, то использует его для обработки, иначе вызывает предварительно метод для получения этого параметра (сделано в целях не делать лишнее действие)
	 *
	 * @param string $filePath Абсолютный адрес файла изображения
	 * @param resource $imageResource Ресурс изображения (принимается по ссылке; сюда юудет помещен ресурс изображения)
	 * @param array $imageParametesArray Массив параметров изображения возвращаемых методом $this->getImageParameters()
	 *
	 * @return bool FALSE - ошибка; TRUE -  успех
	 *
	 * */
	private function getImageResource($filePath, &$imageResource, $imageParametesArray = null)
	{
		//Если не передается массив параметров изображения, то производим его инициализацию (это сделано для того, чтобы не делать лишних действий, если в вызывающей функции уже есть этот массив параметров изображения)
		if (is_null($imageParametesArray))
		{
			$imageParametesArray = $this->getImageParameters($filePath);
		}

		//Производим формирование ресурса изображения, в зависимости от типа изображения
		//Рессурс помещается в переменную, ссылку на которую получил данный метод (это сделано для экономии используемой памяти)
		switch($imageParametesArray["type"])
  		{
  			case EImageType::GIF:
  			{
				$imageResource = @imagecreatefromgif($filePath);
  				break;
  			}
  			case EImageType::JPG:
  			{
				$imageResource = @imagecreatefromjpeg($filePath);
  				break;
  			}
  			case EImageType::PNG:
  			{
				$imageResource = @imagecreatefrompng($filePath);
  				break;
  			}
  			default:
  			{
				$this->error = "Файл изображения имеет недопустимый тип";
				$this->errorIsFatal = true;
				return false;
  			}
  		}

		//Проверяем на ошибку работы функции (функция в случае ошибки по разным документациям возвращает то NULL то FALSE, потому я проверяю на оба этих значения)
		if ((false === $imageResource) || is_null($imageResource))
		{
			$this->error = "imagecreatefrom* return false";
			$this->errorIsFatal = true;
			return false;
		}
		else
		{
			return true;
		}
	}

	//*********************************************************************************

	/**
	 * Сохраняет изображение на диск из ресурса $imageResource выходного типа $imageType и качества $quality по абсолютному адресу $dstFileName
	 *
	 * @param resource $imageResource Ресурс изображения
	 * @param string $dstFileName Абсолютный адрес, по которому будет сохранено изображение
	 * @param EImageType #imageType Тип изображения, с которым нужено его сохранить
	 * @param mixed $quality Качество изображение, которое сохраняется. Если не передяется, то метод определяет его как качество по умолчанию для определенного типа
	 *
	 * @return bool FALSE - ошибка; TRUE -  успех
	 *
	 * */
	private function saveImage(&$imageResource, $dstFileName, $imageType, $quality = null)
	{
		//Если качество не передавалось, то достаем дефолтное значения качества для данного типа из настроек
		if (is_null($quality))
		{
			//Получаем качество только не для GIF, так как для него нет такого понятия как качество
			if (EImageType::GIF !== $imageType)
				if (false === ($quality = $this->getDefaultImageQuality($imageType))) return false;
		}

		$errorMessage = "";//Хранит часть текста ошибки указывающую на то, какая функция участвовала
		$result = true;

		switch($imageType)
  		{
  			case EImageType::GIF:
  			{
				$result = imagegif($imageResource, $dstFileName);
				$errorMessage = "imagegif";
  				break;
  			}
  			case EImageType::JPG:
  			{
				$result = imagejpeg($imageResource, $dstFileName, $quality);
				$errorMessage = "imagejpeg";
  				break;
  			}
  			case EImageType::PNG:
  			{
				$result = imagepng($imageResource, $dstFileName, $quality);
				$errorMessage = "imagepng";
  				break;
  			}
  			default:
  			{
				//Очищаем память
				if (false === $this->clearImageResource($imageResource)) return false;

				$this->error = "Невозможно сохранить изображение в указанном типе, данный тип не поддерживаеться [".$imageType."]";
				$this->errorIsFatal = true;
				return false;
  			}
  		}

		//Очищаем память удаляя ресурс изображения из памяти. ВНИМАНИЕ! Про это нужно помнить поль вызова этого метода в вызывающем коде
		if (false === $this->clearImageResource($imageResource)) return false;

		//Проверяем сработала ли функция сохранения на диск корректно
		if($result)
		{
			return true;
		}
		else
		{
			$this->error = "Ошибка создания обработаного файла по адресу назначения [".$errorMessage.": ".$dstFileName."]";
			$this->errorIsFatal = true;
			return false;
		}
	}

	//*********************************************************************************

	/**
	 * Опредялет и возвращает значение по умолчанию качества изображения для типа $imageType
	 *
	 * @param EImageType $imageType Тип изображения
	 *
	 * @return mixed FALSE - ошибка; int - качество по умолчанию для типа $imageType
	 * */
	private function getDefaultImageQuality($imageType)
	{
		switch($imageType)
  		{
  			case EImageType::JPG:
  			{
				return $this->imageQualityJPG;
  				break;
  			}
  			case EImageType::PNG:
  			{
				return $this->imageQualityPNG;
  				break;
  			}
  			default:
  			{
				$this->error = "Параметр качества для данного типа изображения не зарегистрирован [".$imageType."]";
				$this->errorIsFatal = true;
				return false;
  			}
  		}
	}

	//*********************************************************************************

	/**
	 * Создает ресурс изображения с размерами $width на $height
	 *
	 * @param resource $imageResource Ресурс изображения (принимается по ссылке). Сюда помещается ресурс изображения после его создания
	 *
	 * @return bool FALSE - ошибка; TRUE -  успех
	 * */
	private function createImageResource(&$imageResource, $width, $height)
	{
		$imageResource = @imagecreatetruecolor($width, $height);
		//Проверяем на ошибку работы функции (функция в случае ошибки по разным документациям возвращает то NULL то FALSE, потому я проверяю на оба этих значения)
		if ((false === $imageResource) || is_null($imageResource))
		{
			$this->error = "imagecreatetruecolor return false";
			$this->errorIsFatal = true;
			return false;
		}

		//Делаем прозрачный фон
		if (false === @imagesavealpha($imageResource, true))
		{
			$this->error = "imagesavealpha return false";
			$this->errorIsFatal = true;
			return false;
		}
		if (false === ($alphaDest = @imagecolorallocatealpha($imageResource, 0, 0, 0, 127)))
		{
			$this->error = "imagecolorallocatealpha return false";
			$this->errorIsFatal = true;
			return false;
		}
		if (false === @imagefill($imageResource, 0, 0, $alphaDest))
		{
			$this->error = "imagefill return false";
			$this->errorIsFatal = true;
			return false;
		}

		return true;
	}

	//*********************************************************************************

	/**
	 * Накладывает одно изображение на другое используся их ресурсы.
	 * Берет участок изображения $srcImageResource с верхней левой точки {$srcX;$srcY} размерами $srcWidth на $srcHeight и накладывает на изображение $dstImageResource с верхней левой точки {$dstX;$dstY} размерами $dstWidth на $dstHeight. При этом, если области не равны, то изменяет размер первой области подганяя под вторую
	 *
	 * @param resource $dstImageResource Ресурс изображения назначения (принимается по ссылке)
	 * @param resource $srcImageResource Ресурс изображения источника (принимается по ссылке)
	 * @param int $dstX Координата по оси X верхней левой точки на изображении назначения, в которой будет производится наложение
	 * @param int $dstY Координата по оси Y верхней левой точки на изображении назначения, в которой будет производится наложение
	 * @param int $dstX Координата по оси X верхней левой точки на изображении источника, с которой будет братся копируемая область
	 * @param int $dstY Координата по оси Y верхней левой точки на изображении источника, с которой будет братся копируемая область
	 * @param int $dstWidth Ширина области на изображении назначения, в которую будет копироватся область из изображения источника
	 * @param int $dstHeight Высота области на изображении назначения, в которую будет копироватся область из изображения источника
	 * @param int $srcWidth Ширина области на изображении источнике, которая будетк копироватся
	 * @param int $srcHeight Высота области на изображении источнике, которая будетк копироватся
	 *
	 * @return bool FALSE - ошибка; TRUE -  успех
	 * */
	private function copyImageResourceOnResource(&$dstImageResource, &$srcImageResource, $dstX, $dstY, $srcX, $srcY, $dstWidth, $dstHeight, $srcWidth, $srcHeight)
	{
		if
		(
			false === imagecopyresampled
			(
				$dstImageResource,
				$srcImageResource,
				$dstX,
				$dstY,
				$srcX,
				$srcY,
				$dstWidth,
				$dstHeight,
				$srcWidth,
				$srcHeight
			)
		)
		{
			$this->error = "imagecopyresampled return false";
			$this->errorIsFatal = true;
			return false;
		}
		else
		{
			return true;
		}
	}

	//*********************************************************************************

	/**
	 * Очищает память удаляя ресурс изображения $imageResource
	 *
	 * @param resource $imageResource Ресурс изображения
	 *
	 * @return bool FALSE - ошибка; TRUE -  успех
	 * */
	private function clearImageResource(&$imageResource)
	{
		if (false === @imagedestroy($imageResource))
		{
			$this->error = "imagedestroy return false";
			$this->errorIsFatal = true;
			return false;
		}
		else
		{
			return true;
		}
	}

	//*********************************************************************************

	/**
	 * Проверяет сущестования файла #filePath
	 *
	 * @param string $filePath Абсолютный адрес файла
	 *
	 * @return bool FALSE - ошибка; TRUE -  успех
	 * */
	private function checkFileExists($filePath)
	{
		//Проверяем существования файла
		if (!file_exists($filePath))
		{
			$this->error = "Файл не найден [".$filePath."]";
			$this->errorIsFatal = true;
			return false;
		}
		else
		{
			return true;
		}
	}

	//*********************************************************************************

}
?>