<!-- Коренной шаблон списка каталогов (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table class="width100" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="filled"><p><a class="addCatalog" href="/admin/catalog/add/0/" title="Создать родительский каталог"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div id="catalogAndDataListBlock" class="articleList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
        <tr class="trHeader">
        	<td width="100"><p>Изображение</p></td>
        	<td><p>Наименование</p></td>
        	<td width="100" align="center"><p>Позиция</p></td>
        	<td width="100" align="center"><p>Отображается <br />на лице</p></td>
        	<td colspan="2"></td>
        </tr>
        <tr class="trSeparator">
        	<td colspan="6"></td>
        </tr>
		{catalogContent}
		</table>
	</div>
</div>
[/content]

<!-- Список каталогов товаров -->
[catalogList_empty]
<tr>
	<td colspan="6">
		<p>Список каталогов товаров пуст!</p>
	</td>
</tr>
[/catalogList_empty]

<!-- Елемент списка каталогов товаров (каталог) -->
[catalogListIteam]
<tr id="{id}" class="line {zebra}">
	<td width="100"><p><img src="{imgSrc}" alt="" height="25" /></p></td>
	<td width="*" class="cursor" onclick="AdminCatalog.showAndHideContent({id});"><p style="font-size: 14px; font-weight: bold; color: #000000;">{title}</p></td>
	<td width="100" align="center"><p>{position}</p></td>
	<td width="100" align="center"><p><a class="button show {show}" href="javascript: void(0);" onclick="AdminCatalog.showOrHideCatalog({id});" title="Отобразить / Скрыть"></a></p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/catalog/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminCatalog.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
<tr id="catalog-content-{id}" class="line content hide">
    <td colspan="6">
        <table class="width100" cellpadding="0" cellspacing="0" border="0">
        <tr>
        	<td><p><a class="addCatalog" {addCatalogHref} title="Создать каталог"></a> <a class="add" {addDataHref} title="Создать товар"></a></p></td>
        </tr>
        <tr>
        	<td class="dataList"></td>
        </tr>
        </table>    
    </td>
</tr>
[/catalogListIteam]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

[catalogContent]
<table class="width100">
    {html}
</table>
[/catalogContent]

[catalogContent_empty]
<p>
	<span>Каталог пуст!</span>
	<a class="addCatalog" href="/admin/catalog/add/{catalogId}/" title="Создать каталог"></a>
	<a class="add" href="/admin/data/add/{catalogId}/" title="Создать товар"></a>
</p>
[/catalogContent_empty]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления -->
[adminCatalogAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminCatalog.add(this); return false;">
	<input type="hidden" name="catalogId" value="{id}" />

	<div class="title required">Наименование каталога</div>
	<div class="content"><input type="text" name="title" /></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/catalog/{id}/';">Отменить</a></div>

	</form>
</div>
[/adminCatalogAdd]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы редактированя -->
[adminCatalogEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminCatalog.edit(this); return false;">
	<input type="hidden" name="id" value="{id}" />

	<div class="title">Ид каталога - {id}</div>
	<div class="content"></div>

	<div class="title required">Наименование каталога</div>
	<div class="content"><input type="text" name="title" value="{title}" /></div>

	<div class="title"><img src="{imgSrc}" width="200" alt="" /><br />Изображение каталога</div>
	<div class="content"><input type="file" name="fileName" /></div>

	<div class="title">Отображать каталог на сайте</div>
	<div class="title checkbox">
		<table cellspacing="0" cellpadding="0" border="0">
			<tbody>
				<tr>
					<td>
						<input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}>
					</td>
					<td>
						<label style="cursor: pointer;" for="showKey">Отображать</label>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="title">Позиция каталога</div>
	<div class="content"><input type="text" name="position" value="{position}" /></div>

	<div class="title">Краткое описание каталога</div>
	<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

	<div class="title">Текст каталога</div>
	<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>

	<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
    <div class="content"></div>
    <div class="seo displayNone">
	    <div class="title">Часть ЧПУ адреса каталога. <a href="javascript: void(0)" onclick="TranslitUrlName.setTranslit();">Преобразовать наименование в URL</a></div>
	    <div class="content"><input type="text" name="urlName" value="{urlName}" />-c{id}</div>
	    <div class="comment">Если поле будет пустое то ЧПУ будет преобразованно из наменования.<br /> Суфикс "-c{id}" добавляется автоматически</div>

	    <div class="title">Текст заголовка страницы H1</div>
	    <div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

	    <div class="title">metaTitle</div>
		<div class="content"><textarea name="metaTitle">{metaTitle}</textarea></div>

		<div class="title">metaKeywords</div>
		<div class="content"><textarea name="metaKeywords">{metaKeywords}</textarea></div>

		<div class="title">metaDescription</div>
		<div class="content"><textarea name="metaDescription">{metaDescription}</textarea></div>
	</div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/catalog/{id}/">Отменить</a></div>

	</form>
</div>
[/adminCatalogEdit]
