<!-- Коренной шаблон списка статических текстов (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="filled"><p><a class="add" href="/admin/static-html/add/" title="Добавить"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="staticHtmlList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>Имя переменной</p></td>
			<td><p>Значение переменной</p></td>
			<td colspan="2"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="4"></td>
		</tr>
		{staticHtmlList}
		</table>
	</div>
</div>
[/content]

<!-- Список старических текстов пуст -->
[staticHtmlList_empty]
<tr>
	<td colspan="4">
		<p>Список статических текстов пуст!</p>
	</td>
</tr>
[/staticHtmlList_empty]

<!-- Елемент списка старических текстов -->
[staticHtmlListIteam]
<tr class="line {zebra}">
	<td><p>{name}</p></td>
	<td><p>{html}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/static-html/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminStaticHtml.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/staticHtmlListIteam]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления -->
[adminStaticHtmlAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminStaticHtml.add(this); return false;">

	<div class="title required">Имя переменной</div>
	<div class="content"><input type="text" name="name"></div>
	<div class="comment">Переменные в шаблоннах именнуются начиная с "sh_"</div>

	<div class="title required">Значенние переменной</div>
	<div class="content"><textarea name="html"></textarea></div>

	<div class="title checkbox">
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><input id="autoReplaceKey_forAddForm" type="checkbox" name="autoReplaceKey" checked="checked"></td>
		<td><label for="autoReplaceKey_forAddForm">Автоматически заменять переменную в шаблоне</label></td>
	</tr>
	</table>
	</div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/static-html/';">Отменить</a></div>

	</form>
</div>
[/adminStaticHtmlAdd]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы редактированя -->
[adminStaticHtmlEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminStaticHtml.edit(this); return false;">
	<input type="hidden" name="staticHtmlId" value="{staticHtmlId}">
	<input type="hidden" name="langId" value="{langId}">

	<div class="title required">Имя переменной</div>
	<div class="content"><input type="text" name="name" value="{name}"></div>
	<div class="comment">Переменные в шаблоннах именнуются начиная с "sh_"</div>

	<div class="title required">Значенние переменной</div>
	<div class="content"><textarea name="html">{html}</textarea></div>

	<div class="title checkbox">
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><input id="autoReplaceKey_forAddForm" type="checkbox" name="autoReplaceKey" {checked}></td>
		<td><label for="autoReplaceKey_forAddForm">Автоматически заменять переменную в шаблоне</label></td>
	</tr>
	</table>
	</div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/static-html/';">Отменить</a></div>

	</form>
</div>
[/adminStaticHtmlEdit]
