<?php

/**
 * Перечисление. Хранит статусы транзакции онлайн оплаты
 */
class EOnlinePayTransactionStatus
{
	const ok = 1;
	const wait = 2;
	const error = 3;

	/** @var string[] Массив наименований статусов транзакций онлайн оплаты */
	const titleArray =
	[
		1 => "Оплата выполнена успешно",
		2 => "Ожидание оплаты",
		3 => "Ошибка оплаты",
	];
}

?>