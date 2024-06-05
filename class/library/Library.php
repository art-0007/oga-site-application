<?php

/**
 * Абстрактный класс предоставляющий набор методов и переменных, используемых в классах библиотек
 * */
abstract class Library extends Base
{
	/** @var string Текст последней ошибки */
	public $error = "";

	/** @var bool Флаг, указывающий выводить ли некритические ошибки. Если TRUE, то все методы в случае некритической ошибки будут возвращать FALSE, а ошибку записывать в $this->error */
	protected $showError = true;

	//*********************************************************************************

	protected function __construct()
	{
		parent::__construct();
	}

	//*********************************************************************************

	/**
	 * Устанавливает флаг отображения методами некритических ошибок или возвращения FALSE
	 *
	 * @param bool $showError Флаг, указывающий отображать ли некритическую ошибку в методах или возвращать FALSE
	 */
	public function setShowError($showError)
	{
		$this->showError = $showError;
	}

	//*********************************************************************************

	/**
	 * Выполняет процесс вывода ошибок
	 *
	 * @param string $error Текст ошибки
	 * @param bool $errorIsCritical Флаг, указывающий, что ошибка критическая
	 * @param bool $sendCriticalEmail Флаг, указывающий, что необходимо отправлять уведомление о критической ошибке
	 *
	 * @return bool
	 */
	protected function error($error, $errorIsCritical = false, $sendCriticalEmail = true)
	{
		if ($this->showError)
		{
			if ($errorIsCritical)
			{
				$this->objSOutput->critical($error, $sendCriticalEmail);
			}
			else
			{
				$this->objSOutput->error($error);
			}
		}

		$this->error = $error;
		return false;
	}

	//*********************************************************************************
}
?>