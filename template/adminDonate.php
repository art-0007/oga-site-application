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

	<div class="donateList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>Проект</p></td>
			<td><p>Система</p></td>
			<td><p>Код</p></td>
			<td><p>Сумма</p></td>
			<td colspan="1"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="5"></td>
		</tr>
		{donateList}
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
[donateList_empty]
<tr>
	<td colspan="5">
		<p>Список пуст!</p>
	</td>
</tr>
[/donateList_empty]

<!-- Елемент списка старических страниц -->
[donateListItem]
<tr class="line {zebra}">
	<td><p>{progectTitle}</p></td>
	<td><p>{onlinePaySistemTitle}</p></td>
	<td><p>{code}</p></td>
	<td><p>{sum}</p></td>
	<td><p><a href="/admin/online-pay-transaction/list/{id}/">Транзакции ({transactionAmount})</a></p></td>
</tr>
[/donateListItem]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->
