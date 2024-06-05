<?php

/**
 * Перечисление. Хранит операции с остатками
 */
class EQuantityOperation
{
	const none = 0;
	const minusQuantity = 1;
	const plusQuantity = 2;

	/**
	 * @var array Массив переводов наименований операции с остатками
	 */
	public static $entityTitleArray = array
	(
		0 => "Не выполнять никаких операций",
		1 => "Списывать остатки",
		2 => "Возвращать остатки",
	);
}

?>