<?php

/**
 * Осуществляет работу с шаблонами
 *
 * @package System
 * */
class STemplate
{
	/**********************************************************************/

	/**
	 * @var string Строка, добавляемая после имени файла шаблона передаваемого в метод getHtml()
	 * */
	private $fileNamePostfix = ".php";

	/**
	 * @var array Массив шаблонов загруженных ранее из файла (используется как кеш)
	 * */
	private $templateArray = array();

	/**
	 * @var array Массив содержимого файлов шаблонов загруженных ранее из файла (используется как кеш)
	 * */
	private $templateFileContentArray = array();

	/**
	 * @var object Ссылка на объект данного класса, использующаяся в механизме "Класс - одиночка"
	 * */
	private static $obj = null;

	/**********************************************************************/

	public static function getInstance()
	{
		if(is_null(self::$obj))
		{
			self::$obj = new STemplate();
		}

		return self::$obj;
	}

	/**********************************************************************/

	private function __construct()
	{
	}

	/**********************************************************************/

	private function __clone()
	{
	}

	/**********************************************************************/

	/**
	 * Проверяет наличие шаблона
	 *
	 * @param string $templateFilePath Аболютный путь к файлу шаблона
	 * @param string $templateName Имя шаблона в файле
	 *
	 * @return boolean
	 * */
	public function isExistTemplate($templateFileName, $templateName)
	{
		//Определяем абсолютный путь к файлу шаблона
		$templateFilePath = $this->getFilePath($templateFileName);

		if (!isset($this->templateFileContentArray[$templateFilePath]))
		{
			$this->templateFileContentArray[$templateFilePath] = file_get_contents($templateFilePath);
		}

		if(preg_match("#\[".$templateName."\](.+)\[\/".$templateName."\]#siuU", $this->templateFileContentArray[$templateFilePath], $matches) !== 0)
		{
			return true;
		}

		return false;
	}

	//*********************************************************************************

	/**
	 * Возвращает строку шаблона $templateName, в которой заменены все переменные на их значения из массива $data
	 *
	 * @param string $templateFileName Имя файла шаблона. Может быть как аболютным так и относительным путем (относительно директории PATH."/".SConfig::$templateDir."/")
	 * @param string $templateName Имя шаблона в файле
	 * @param array $data Массив переменных и их значений, замена которых произвоится (индекс - это имя перменной, а значение - это значение переменной)
	 *
	 * @return string Шаблон загруженный из файла, и в котром заменены переменные на их значения
	 * */
	public function getHtml($templateFileName, $templateName, $data = array())
	{
		//Определяем абсолютный путь к файлу шаблона
		$templateFilePath = $this->getFilePath($templateFileName);

		if(!isset($this->templateArray[$templateFilePath][$templateName]))
		{
			$this->templateArray[$templateFilePath][$templateName] = $this->getTemplate($templateFilePath, $templateName);
		}

		//Считываем нужный шаблон
		$html = $this->templateArray[$templateFilePath][$templateName];

		//Добавляем константы в список для замены
		$data["TEMPLATE"] = SConfig::$templateDir;

		//Производим замену переменных шаблона на их значения
		foreach($data as $name => $value)
		{
			$html = strtr($html, array("{".$name."}" => $value));
		}

		return $html;
	}

	//*********************************************************************************

	/**
	 * Формрирует и возвращает абсолютный путь к файлу шаблона
	 *
	 * @param string $templateFileName Имя файла шаблона. Может быть как аболютным так и относительным путем (относительно директории PATH."/".SConfig::$templateDir."/")
	 *
	 * @return string Абсолютный путь к файлу шаблона
	 * */
	private function getFilePath($templateFileName)
	{
		//Добавляем к файлу постфикс
		$templateFileName .= $this->fileNamePostfix;

		//Проверяем какой путь у файла шаблона
		//Если не абсолютный то производим некоторые манипуляции, вчастности генерируем абсолютный путь к файлу шаблона
		if(!$this->isAbsolutePath($templateFileName))
		{
			//Директория с шаблонами
			$templateFileName = PATH."/".SConfig::$templateDir."/".$templateFileName;

			//Убиваем лишние прямые слешы, если таковые есть
			$this->tplDir = strtr($templateFileName, array("//" => "/"));

			//Проверяем существует ли данный файл
			if(!file_exists($templateFileName))
			{
				exit("Ошибка загрузки шаблона: Файл \"".$templateFileName."\" не найден");
			}
		}

		return $templateFileName;
	}

	/**********************************************************************/

	/**
	 * Загружает содержимое файла шаблона (или берет его из буфера) и достает оттуда сам шаблон с именем $templateName, после чего возвращает его
	 *
	 * @param string $templateFilePath Аболютный путь к файлу шаблона
	 * @param string $templateName Имя шаблона в файле
	 *
	 * @return string Шаблон загруженный из файла
	 * */
	private function getTemplate($templateFilePath, $templateName)
	{
		if (!isset($this->templateFileContentArray[$templateFilePath]))
		{
			$this->templateFileContentArray[$templateFilePath] = file_get_contents($templateFilePath);
		}

		if(preg_match("#\[".$templateName."\](.+)\[\/".$templateName."\]#siuU", $this->templateFileContentArray[$templateFilePath], $matches) !== 0)
		{
			return trim($matches[1]);
		}
		else
		{
			exit("В файле \"".$templateFilePath."\" шаблон \"".$templateName."\" не найден");
		}
	}

	/**********************************************************************/

	/**
	 * Проверяет является ли $templateFileName абсолютным путем или нет
	 *
	 * @param string $templateFileName Имя файла шаблона. Может быть как аболютным так и относительным путем (относительно директории PATH."/".SConfig::$templateDir."/")
	 *
	 * @return bool TRUE - абсолютный путь; FALSE - относительный путь
	 * */
	private function isAbsolutePath($templateFileName)
	{
		if
		(
			//Для Unix (ставим первой, так как проектам важнее работать быстрее на unix системах)
			0 === mb_strpos($templateFileName, "/")
			OR
			//Для Windows
			1 === preg_match("#^[a-z]+\:#iu", $templateFileName)
		)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**********************************************************************/
}

?>