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

	<div class="onlinePayTransactionRequestList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>Время</p></td>
			<td colspan="1"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="2"></td>
		</tr>
		{onlinePayTransactionRequestList}
		</table>
	</div>
</div>
[/content]

<!-- Дополнительные кнопки тулбара -->
[toolbarButton]
<td class="filled"><p><a class="up" href="/admin/online-pay-transaction/list/{donateId}/" title="Вверх"></a></p></td>
<td class="tdSeparator widht15px">&nbsp;</td>
[/toolbarButton]

<!-- Список старических страниц пуст -->
[onlinePayTransactionRequestList_empty]
<tr>
	<td colspan="2">
		<p>Список пуст!</p>
	</td>
</tr>
[/onlinePayTransactionRequestList_empty]

<!-- Елемент списка старических страниц -->
[onlinePayTransactionRequestListItem]
<tr class="line {zebra}">
	<td><p>{date}</p></td>
	<td><p><a href="/admin/online-pay-transaction-request/{id}/">Содержимое запроса</a></p></td>
</tr>
[/onlinePayTransactionRequestListItem]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Коренной шаблон списка языков (админка) -->
[content_view]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="toolbar">
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			{toolbarButton}
			<td width="*">&nbsp;</td>
		</tr>
	</table>
</div>

<div class="onlinePayTransactionRequestContent">
	{serverData}
</div>

[/content_view]

<!-- Дополнительные кнопки тулбара -->
[toolbarButton_view]
<td class="filled"><p><a class="up" href="/admin/online-pay-transaction-request/list/{onlinePayTransactionId}/" title="Вверх"></a></p></td>
<td class="tdSeparator widht15px">&nbsp;</td>
[/toolbarButton_view]

