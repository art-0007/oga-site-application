<!-- Коренной шаблон списка файлов хранилища (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			{toolbarButton}
			<td class="filled"><p><a class="addCatalog" href="/admin/file-catalog/add/{fileCatalogId}/" title="Создать каталог"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td class="filled">
				<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminFile.add(this); return false;">
				<input class="left99999" type="hidden" name="fileCatalogId" value="{fileCatalogId}">
				<input class="left99999" type="file" name="fileName" onchange="AdminFile.change(this)">

				<p><a class="add" href="javascript:void(0);" onclick="AdminFile.addInToolbar(this)" title="Загрузить файл"></a></p>
				</form>
			</td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="fileList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td width="25"><p>&nbsp;</p></td>
			<td width="25"><p>&nbsp;</p></td>
			<td width="25"><p>&nbsp;</p></td>
			<td><p>Изображение</p></td>
			<td><p>Имя</p></td>
			<td><p>Имя оригинального файла</p></td>
			<td colspan="3"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="8"></td>
		</tr>
		{fileCatalogList}
		<tr class="trSeparator">
			<td colspan="8"></td>
		</tr>
		{fileList}
		</table>
	</div>
</div>
[/content]

<!-- Дополнительные кнопки тулбара -->
[toolbarButton]
<td class="filled"><p><a class="up" href="/admin/file/{fileCatalogId}/" title="Вверх"></a></p></td>
<td class="tdSeparator widht15px">&nbsp;</td>
[/toolbarButton]

<!-- Список файлов пуст -->
[fileList_empty]
<tr>
	<td colspan="7">
		<p>Список файлов пуст!</p>
	</td>
</tr>
[/fileList_empty]

<!-- Елемент списка файлов хранилища (каталог) -->
[fileCatalogListIteam]
<tr class="line {zebra}">
	<td class="cursor" onclick="window.location.href = '{href}'"><p><img src="{imgSrcType}" alt="" height="25"></p></td>
	<td colspan="3" class="cursor" onclick="window.location.href = '{href}'"><p style="font-size: 14px; font-weight: bold;">{title}</p></td>
	<td colspan="2"><p>&nbsp;</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/file-catalog/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminFileCatalog.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/fileCatalogListIteam]

<!-- Елемент списка файлов хранилища -->
[fileListIteam]
<tr class="line {zebra}">
	<td class="button"><p><a class="download"  href="{href}" title="Скачать"></a></p></td>
	<td class="button"><p><a class="insert_image" href="javascript: void(0);" onclick="AdminFile.isertImage_inRichTextEditor('{filePath}')" title="Вставить файл как изображение"></a></p></td>
	<td class="button"><p><a class="insert_file" href="javascript: void(0);" onclick="AdminFile.isertFile_inRichTextEditor('{name}', '{nameOriginal}')" title="Вставить файл как ссылку"></a></p></td>
	<td><p><img src="{imgSrcType}" alt="" height="25"></p></td>
	<td><p>{name}</p></td>
	<td><p>{nameOriginal}</p></td>
	<td><p>&nbsp;</p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminFile.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/fileListIteam]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления файла -->
[adminFileAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminFile.add(this); return false;">
	<input type="hidden" name="fileCatalogId" value="{fileCatalogId}">

	<div class="title required">Файл</div>
	<div class="content"><input type="file" name="fileName"></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/file/{fileCatalogId}/';">Отменить</a></div>

	</form>
</div>
[/adminFileAdd]

<!-- Шаблон страницы добавления каталога -->
[adminFileCatalogAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminFileCatalog.add(this); return false;">
	<input type="hidden" name="fileCatalogId" value="{fileCatalogId}">

	<div class="title required">Наименование каталога</div>
	<div class="content"><input type="text" name="title"></div>

	<div class="title">Имя для разработчика</div>
	<div class="content"><input type="text" name="devName"></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/file/{fileCatalogId}/';">Отменить</a></div>

	</form>
</div>
[/adminFileCatalogAdd]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы редактированя rfnfkjuf -->
[adminFileCatalogEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminFileCatalog.edit(this); return false;">
	<input type="hidden" name="fileCatalogId" value="{fileCatalogId}">

	<div class="title">ИД каталога - {fileCatalogId}</div>
	<div class="content"></div>

	<div class="title required">Наименование каталога</div>
	<div class="content"><input type="text" name="title" value="{title}"></div>

	<div class="title">Имя для разработчика</div>
	<div class="content"><input type="text" name="devName" value="{devName}"></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/file/{fileCatalog_id}/';">Отменить</a></div>

	</form>
</div>
[/adminFileCatalogEdit]
