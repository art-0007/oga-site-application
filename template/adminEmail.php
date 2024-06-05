<!-- Коренной шаблон списка отправленых писем (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			{toolbarButton}
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="emailList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>Тема</p></td>
			<td align="center"><p>Дата и время</p></td>
			<td align="center"><p>Файл</p></td>
			<td colspan="2"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="5"></td>
		</tr>
		{emailList}
		</table>
	</div>
</div>
[/content]

<!-- Дополнительные кнопки тулбара -->
[toolbarButton]
<td class="filled"><p><a class="up" href="/admin/email/" title="Вверх"></a></p></td>
<td class="tdSeparator widht15px">&nbsp;</td>
[/toolbarButton]

<!-- Список старических страниц пуст -->
[emailList_empty]
<tr>
	<td colspan="5">
		<p>Список писем пуст!</p>
	</td>
</tr>
[/emailList_empty]

<!-- Елемент списка старических страниц -->
[emailListItem]
<tr class="line {zebra}">
	<td><p>{subject}</p></td>
	<td align="center"><p>{date} / {time}</p></td>
	<td align="center"><p>{file}</p></td>
	<td class="button"><p><a class="view" href="javascript: void(0);" onclick="window.location.href = '/admin/email/view/{id}/';" title="Посмотреть"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminEmail.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/emailListItem]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Страница просмотра письма -->
[content_view]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			{toolbarButton}
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="emailViewContent">
		<p><strong><em>Тема</em></strong>: {subject}</p>
		<p><strong><em>Дата</em></strong>: {date} / {time}</p>
		<p><strong><em>Прикрепленный файл</em></strong>: {file}</p>
		<hr>
		<div>{content}</div>
	</div>
</div>
[/content_view]

