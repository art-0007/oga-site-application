<!-- Коренной шаблон списка языков (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			{toolbarButton}
			<td class="filled"><p><a class="add" href="/admin/lang/add/" title="Создать язык"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="langList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td width="100"><p>Изображение (малое)</p></td>
			<td width="100"><p>Изображение (большое)</p></td>
			<td><p>Имя</p></td>
			<td><p>Код языка</p></td>
			<td align="center"><p>По умолчанию</p></td>
			<td colspan="2"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="7"></td>
		</tr>
		{langList}
		</table>
	</div>
</div>
[/content]

<!-- Дополнительные кнопки тулбара -->
[toolbarButton]
<td class="filled"><p><a class="up" href="/admin/lang/list/" title="Вверх"></a></p></td>
<td class="tdSeparator widht15px">&nbsp;</td>
[/toolbarButton]

<!-- Список старических страниц пуст -->
[langList_empty]
<tr>
	<td colspan="7">
		<p>Список языков пуст!</p>
	</td>
</tr>
[/langList_empty]

<!-- Елемент списка старических страниц -->
[langListItem]
<tr class="line {zebra}">
	<td><p><img src="{img}" alt="" height="25" /></p></td>
	<td><p><img src="{imgBig}" alt="" height="25" /></p></td>
	<td><p>{name}</p></td>
	<td><p>{code}</p></td>
	<td align="center"><p>{default}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/lang/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminLangList.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/langListItem]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления статьи -->
[adminLangAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminLangList.add(this); return false;">
		<input type="hidden" name="langeCatalogId" value="{langeCatalogId}" />

		<div class="title">С какого языка копировать текстовые данные</div>
		<div class="content"><select name="langId">{langSelect}</select></div>

		<div class="title required">Имя</div>
		<div class="content"><input type="text" name="name" /></div>

		<div class="title required">Код</div>
		<div class="content"><input type="text" name="code" /></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/lang/list/">Отменить</a></div>

	</form>
</div>
[/adminLangAdd]

<!-- Шаблон страницы редактирования статьи  -->
[adminLangEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminLangList.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id языка - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="name" value="{name}" /></div>

		<div class="title required">Код</div>
		<div class="content"><input type="text" name="code" value="{code}" /></div>

		<div class="title">
			<img src="{imgSrc1}" style="max-width: 200px;" alt="" />
			<br />
			Изображение (малое)
		</div>
		<div class="content"><input type="file" name="fileName1" /></div>

		<div class="title">
			<img src="{imgSrc2}" style="max-width: 200px;" alt="" />
			<br />
			Изображение (большое)
		</div>
		<div class="content"><input type="file" name="fileName2" /></div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Язык по умолчанию</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="defaultKey" type="checkbox" value="yes" name="defaultKey" {defaultKey_checked}></td>
					<td><label style="cursor: pointer;" for="defaultKey">Да</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/lang/list/">Отменить</a></div>

	</form>
</div>
[/adminLangEdit]

