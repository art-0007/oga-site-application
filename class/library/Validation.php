<?php

/*
	exist -	Проверяет существование переменной
	trim - Обрезает пробелы
	md5 - Берет md5 хеш
	isEmpty - Проверяет чтобы переменная была пустой
	isNoEmpty - Проверяет чтобы переменная не была пустой
	isNum - проверяет чтобы переменная была числом
	isString - проверяет чтобы переменная была строкой вида a-Z
	isURL - проверяет чтобы переменная была URL вида a-Z0-9\-\.
	isEmail - Проверяет чтобы значение было e-mail адресом
	isUploadedFile - Проверяет чтобы данный объект был файлом загружаемым на сервер с помощью php
	defaultValue[значение] - Значение по умолчанию (в случае если переменной нет, но ее нужно создать и заполнить каким то значением)
	exactLength[int] - Проверяет чтобы длина строки, соответсвувала значению
	minLength[int] - Проверяет минимальную длину строки
	maxLength[int] - Проверяет максимальную длину строки
	matches[имя переменной с которой нужно сравнить] - проверяет на соответсвие две переменные (для строк и чисел). Переменная с которой сравнивается, должна быть обработана до сравнения.
	iMatches[имя переменной с которой нужно сравнить] - проверяет на соответсвие две переменные без учета регистра (для строк). Переменная с которой сравнивается, должна быть обработана до сравнения.

	setType[bool, int, float, string] - Устанавливает тип переменной

	checkbox - отрабатывает переменную как чекбокс. заполняет резльтат: TRUE - переменная должна существования и ее значение должно быть отлично от нуля и пустой строки, FALSE - если переменная не существует или ее значение равно нулю или пустой строке
*/


/**
 * Обрабатывает переменные из глобальных массивов в соответсвии с динамическим набором правил
 * */
class Validation
{
	//*********************************************************************************

	public $error = null; //Массив с ответом
	public $vars = array(); //Массив переменных

	private static $obj = null;

	/** exist -	Проверяет существование переменной */
	const exist = "exist";
	const trim = "trim";
	const md5 = "md5";
	const isEmpty = "isEmpty";
	const isNoEmpty = "isNoEmpty";
	const isNum = "isNum";
	const isString = "isString";
	const isURL = "isURL";
	const isCode = "isCode";
	const isEmail = "isEmail";
	const isUploadedFile = "isUploadedFile";
	const defaultValue = "defaultValue";
	const exactLength = "exactLength";
	const minLength = "minLength";
	const maxLength = "maxLength";
	const matches = "matches";
	const iMatches = "iMatches";
	const setType = "setType";
	const checkbox = "checkbox";

	//*********************************************************************************

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new Validation();
		}

		return self::$obj;
	}

	//*********************************************************************************

	private function __construct()
	{
	}

	//*********************************************************************************

	private function __clone()
	{
	}

	//*********************************************************************************

	//Подготавливает клас к новой проверке
	public function newCheck()
	{
  		$this->vars = array();
  		$this->error = "";
	}

	//*********************************************************************************

	//Проверяет входящие данные
 	public function checkVars($varName = "", $rulesArray = array(), $dataArray = array())
 	{
		if(empty($varName) OR !is_array($rulesArray) OR count($rulesArray) === 0 OR !is_array($dataArray))
		{
			return false;
		}

		//Очищаем ошибку
		$this->error = "";
		//Ключ, отвечающий за существование ошибок
		$errorKey = false;

		//Проверяем существует ли переменная в масиве который нужно проверить, если нет, то усианавливается значение по умолчанию
		if(isset($dataArray[$varName]))
		{
			$this->vars[$varName] = $dataArray[$varName];
		}
		else
		{
			$this->vars[$varName] = $this->getDefaultValueFromRulesArray($rulesArray);
		}

 		//Обходим все правила которые нужно проверить
		foreach($rulesArray as $ruleName => $errorText)
		{
			if(!$this->checkRule($varName, $ruleName, $dataArray))
			{
				if(empty($errorText))
				{
					$errorKey = true;

					$this->error = $this->getRuleName($ruleName, true);
					break;
				}
				else
				{
					$objSOutput = SOutput::getInstance();
					$objSOutput->error($errorText, "");
					exit(); //На всякий случай, не должен никогда сработать
				}
			}
		}

		if(!$errorKey)
		{
			return true;
		}
		else
		{
			return false;
		}
 	}

	//*********************************************************************************

	//Возвращает имя правила
	private function getRuleName($rule, $matches = false)
	{
		if($matches)
		{
			if(mb_strpos($rule, "[") === false OR mb_strpos($rule, "matches") !== false OR mb_strpos($rule, "iMatches") !== false)
			{
				return $rule;
			}
			else
			{
				return mb_substr($rule, 0, mb_strpos($rule, "["));
			}
		}
		else
		{
			if(mb_strpos($rule, "[") === false)
			{
				return $rule;
			}
			else
			{
				return mb_substr($rule, 0, mb_strpos($rule, "["));
			}
		}
	}

	//*********************************************************************************

	//Достает значение с записи вида имя_правила[значение]
	private function getValueFromRule($rule)
	{
		if(preg_match("#^".$this->getRuleName($rule)."\[(.+)\]$#iu", $rule, $matches))
		{
			return $matches[1];
		}
	}

	//*********************************************************************************

	//Достает значение с записи вида dafault[значение]
	private function getDefaultValueFromRulesArray($rulesArray)
	{
		if(isset($rulesArray[self::defaultValue]))
		{
			return $rulesArray[self::defaultValue];
		}
		else
		{
			return "";
		}
	}

	//*********************************************************************************

	//Проверяет правило
	private function checkRule($varName, $rule, $dataArray = array())
	{
		$localRule = $this->getRuleName($rule);
		//echo "<p>Local rule: ".$localRule."</p>";

		switch($localRule)
		{
			//Проверяет существование переменной
			case self::exist:
			{
				return $this->_exist($varName, $dataArray);
			}

			//Обрезает пробелы
			case self::trim:
			{
				return $this->_trim($varName);
			}

			//Берет md5 хеш
			case self::md5:
			{
				return $this->_md5($varName);
			}

			//Проверяет, чтобы переменная была пустой
			case self::isEmpty:
			{
				return $this->_isEmpty($varName);
			}

			//Проверяет, чтобы переменная была не пустой
			case self::isNoEmpty:
			{
				return $this->_isNoEmpty($varName);
			}

			//Проверяет чтобы переменная была числом
			case self::isNum:
			{
				return $this->_isNum($varName);
			}

			//Проверяет чтобы переменная была строкой
			case self::isString:
			{
				return $this->_isString($varName);
			}

			//Проверяет чтобы переменная была URL
			case self::isURL:
			{
				return $this->_isURL($varName);
			}

			case self::isCode:
			{
				return $this->_isCode($varName);
			}

			//Проверяет email
			case self::isEmail:
			{
				return $this->_isEmail($varName);
			}

			//Проверяет чтобы данный объект был файлом загружаемым на сервер с помощью php
			case self::isUploadedFile:
			{
				return $this->_isUploadedFile($varName);
			}

			//Проверяет соттветсвие кол-ва символов
			case self::exactLength:
			{
				return $this->_exactLength($varName, $rule);
			}

			//Проверяет минимальное кол-во символов
			case self::minLength:
			{
				return $this->_minLength($varName, $rule);
			}

			//Проверяет минимальное кол-во символов
			case self::maxLength:
			{
				return $this->_maxLength($varName, $rule);
			}

			//Значение по умолчанию
			case self::matches:
			{
				return $this->_matches($varName, $rule);
			}

			//Значение по умолчанию
			case self::iMatches:
			{
				return $this->_iMatches($varName, $rule);
			}

			//Приводит переменную к указанному типу
			case self::setType:
			{
				return $this->_setType($varName, $rule);
			}

			//Приводит переменную к указанному типу
			case self::checkbox:
			{
				return $this->_checkbox($varName);
			}

			//Значение по умолчанию
			case self::defaultValue:
			{
				return true;
			}
		}
	}

	//*********************************************************************************

	private function _exist($varName, $dataArray)
	{
		//Проверяем существует ли переменная в масиве который нужно проверить
		if(isset($dataArray[$varName]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************

	private function _trim($varName)
	{
		$this->vars[$varName] = trim($this->vars[$varName]);

		return true;
	}

	//*********************************************************************************

	private function _md5($varName)
	{
		$this->vars[$varName] = md5($this->vars[$varName], false);

		return true;
	}

	//*********************************************************************************

	private function _isEmpty($varName)
	{
		if(mb_strlen($this->vars[$varName]) === 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************

	private function _isNoEmpty($varName)
	{
		if(mb_strlen($this->vars[$varName]) !== 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************

	private function _isNum($varName)
	{
		if(Reg::isNum($this->vars[$varName]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************

	private function _isString($varName)
	{
		if(Reg::isString($this->vars[$varName]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************

	private function _isURL($varName)
	{
		if(Reg::isURL($this->vars[$varName]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************

	private function _isCode($varName)
	{
		if(Reg::isCode($this->vars[$varName]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************

	private function _isEmail($varName)
	{
		if(Reg::isEmail($this->vars[$varName]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************

	private function _isUploadedFile($varName)
	{
		if(true === @is_uploaded_file($this->vars[$varName]["tmp_name"]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************

	//Провреяет максимальное кол-во символов переменной
	private function _exactLength($varName, $rule)
	{
  		if(mb_strlen($this->vars[$varName]) === (int)$this->getValueFromRule($rule))
  		{
  			return true;
  		}
  		else
  		{
  			return false;
  		}
	}

	//*********************************************************************************

	//Провреяет минимальное кол-во символов переменной
	private function _minLength($varName, $rule)
	{
  		if(mb_strlen($this->vars[$varName]) >= (int)$this->getValueFromRule($rule))
  		{
  			return true;
  		}
  		else
  		{
  			return false;
  		}
	}

	//*********************************************************************************

	//Провреяет максимальное кол-во символов переменной
	private function _maxLength($varName, $rule)
	{
  		if(mb_strlen($this->vars[$varName]) <= (int)$this->getValueFromRule($rule))
  		{
  			return true;
  		}
  		else
  		{
  			return false;
  		}
	}

	//*********************************************************************************

	//Провреяет соттветсвие значений переменных с учетом регистра
	private function _matches($varName, $rule)
	{
		if(Func::mb_strcmp((string)$this->vars[$varName], (string)$this->vars[$this->getValueFromRule($rule)]) === 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************

	//Провреяет соттветсвие значений переменных без учета регистра
	private function _iMatches($varName, $rule)
	{
		if(0 === Func::mb_strcasecmp((string)$this->vars[$varName], (string)$this->vars[$this->getValueFromRule($rule)]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	//*********************************************************************************

	//Провреяет соттветсвие значений переменных без учета регистра
	private function _setType($varName, $rule)
	{
		$type = $this->getValueFromRule($rule);

		switch($type)
		{
			case "bool":
			{
				$this->vars[$varName] = (bool)$this->vars[$varName];
				break;
			}

			case "int":
			{
				$this->vars[$varName] = (int)$this->vars[$varName];
				break;
			}

			case "float":
			{
				$this->vars[$varName] = (float)$this->vars[$varName];
				break;
			}

			case "string":
			{
				$this->vars[$varName] = (string)$this->vars[$varName];
				break;
			}
		}

		return true;
	}

	//*********************************************************************************

	//Если переменная пришла, то ее значение устанавливается в true иначе в false
	private function _checkbox($varName)
	{
		if(!empty($this->vars[$varName]))
		{
			$this->vars[$varName] = true;
		}
		else
		{
			$this->vars[$varName] = false;
		}
	}

	//*********************************************************************************

}

?>