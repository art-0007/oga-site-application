<!-- Коренной шаблон списка языков (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			{toolbarButton}
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="onlinePayTransactionList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>ID</p></td>
			<td><p>Статус</p></td>
			<td><p>Время</p></td>
			<td colspan="1"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="4"></td>
		</tr>
		{onlinePayTransactionList}
		</table>

		{paginationList}
	</div>
</div>
[/content]

<!-- Дополнительные кнопки тулбара -->
[toolbarButton]
<td class="filled"><p><a class="up" href="/admin/donate/list/" title="Вверх"></a></p></td>
<td class="tdSeparator widht15px">&nbsp;</td>
[/toolbarButton]

<!-- Список старических страниц пуст -->
[onlinePayTransactionList_empty]
<tr>
	<td colspan="4">
		<p>Список пуст!</p>
	</td>
</tr>
[/onlinePayTransactionList_empty]

<!-- Елемент списка старических страниц -->
[onlinePayTransactionListItem]
<tr class="line {zebra}">
	<td><p>{uniqueId}</p></td>
	<td><p>{status}</p></td>
	<td><p>{date}</p></td>
	<td><p><a href="/admin/online-pay-transaction-request/list/{id}/">Запросы от системы онлайн оплаты ({requestAmount})</a></p></td>
</tr>
[/onlinePayTransactionListItem]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->
