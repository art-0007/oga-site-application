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

	<div class="onlinePaySystemList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>Имя</p></td>
			<td><p>Имя для разработчика</p></td>
			<td><p>Позиция</p></td>
			<td colspan="1"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="4"></td>
		</tr>
		{onlinePaySystemList}
		</table>
	</div>
</div>
[/content]

<!-- Дополнительные кнопки тулбара -->
[toolbarButton]
<td class="filled"><p><a class="up" href="/admin/online-pay-system/list/" title="Вверх"></a></p></td>
<td class="tdSeparator widht15px">&nbsp;</td>
[/toolbarButton]

<!-- Список старических страниц пуст -->
[onlinePaySystemList_empty]
<tr>
	<td colspan="7">
		<p>Список пуст!</p>
	</td>
</tr>
[/onlinePaySystemList_empty]

<!-- Елемент списка старических страниц -->
[onlinePaySystemListItem]
<tr class="line {zebra}">
	<td><p>{title}</p></td>
	<td><p>{devName}</p></td>
	<td><p>{position}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/online-pay-system/{id}/';" title="Редактировать"></a></p></td>
</tr>
[/onlinePaySystemListItem]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления статьи -->
[adminOnlinePaySystemAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminOnlinePaySystemList.add(this); return false;">
		<input type="hidden" name="onlinePaySystemeCatalogId" value="{onlinePaySystemeCatalogId}" />

		<div class="title required">Имя</div>
		<div class="content"><input type="text" name="name" /></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/online-pay-system/list/">Отменить</a></div>

	</form>
</div>
[/adminOnlinePaySystemAdd]

<!-- Шаблон страницы редактирования статьи  -->
[adminOnlinePaySystemEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminOnlinePaySystemList.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id систмы - {id}</div>
		<div class="content"></div>

		<div class="title">{inputTitleName}</div>
		<div class="content"><p>{title}</p></div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><p>{devName}</p></div>

		{onlinePaySystemSettings}

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/online-pay-system/list/">Отменить</a></div>

	</form>
</div>
[/adminOnlinePaySystemEdit]

[onlinePaySystemSettings_1]
<div class="title">Webhook url</div>
<div class="content"><p>{frontUrl}/online-pay/process/?opsId=1</p></div>

<div class="title">Publishable key</div>
<div class="content"><input type="text" name="public_key" value="{public_key}" /></div>

<div class="title">Secret key</div>
<div class="content"><input type="text" name="secret_key" value="{secret_key}" /></div>
[/onlinePaySystemSettings_1]

[onlinePaySystemSettings_2]
<div class="title">Режим sandbox</div>
<div class="title checkbox">
	<table cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>
			<td><input id="sandboxKey" type="checkbox" value="yes" name="sandboxKey" {sandboxKey_checked}></td>
			<td><label style="cursor: pointer;" for="sandboxKey">Да</label></td>
		</tr>
		</tbody>
	</table>
</div>

<div class="title">Client ID</div>
<div class="content"><input type="text" name="client_id" value="{client_id}" /></div>

<div class="title">Secret</div>
<div class="content"><input type="text" name="secret_key" value="{secret_key}" /></div>
[/onlinePaySystemSettings_2]

