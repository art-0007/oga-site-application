<!-- Коренной шаблон списка каталогов (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			{toolbarButton}
			<td class="filled"><p><a class="addCatalog" {addCatalogHref} title="Создать каталог"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td class="filled"><p><a class="add" {addDataHref} title="Создать товар"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div id="catalogAndDataListBlock" class="articleList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		{tableHeader}
		{catalogContent}
		</table>
	</div>
</div>
[/content]

<!-- Дополнительные кнопки тулбара -->
[toolbarButton]
<td class="filled"><p><a class="up" href="/admin/catalog/{catalogId}/" title="Вверх"></a></p></td>
<td class="tdSeparator widht15px">&nbsp;</td>
[/toolbarButton]

[tableHeader_catalog]
<tr class="trHeader">
	<td width="100"><p>Изображение</p></td>
	<td><p>Наименование</p></td>
	<td align="center"><p>Позиция</p></td>
	<td align="center"><p>Отображается <br />на лице</p></td>
	<td colspan="2"></td>
</tr>
<tr class="trSeparator">
	<td colspan="6"></td>
</tr>
[/tableHeader_catalog]

[tableHeader_data]
<tr class="trHeader">
	<td width="50"><p>Изоб-ние</p></td>
	<td><p>Артикул</p></td>
	<td><p>Наименование</p></td>
	<td align="center"><p>Цена</p></td>
	<td align="center"><p>Старая<br /> цена</p></td>
	<td  align="center" width="50"><p>Виден</p></td>
	<td  align="center" width="50"><p>Наличие</p></td>
	<td  align="center" width="60"><p>Новые<br />поступления</p></td>
	<td  align="center" width="90"><p>Акционые<br />предложения</p></td>
	<td  align="center" width="55"><p>Лидеры<br />продаж</p></td>
	<td colspan="4"></td>
</tr>
<tr class="trSeparator">
	<td colspan="13"></td>
</tr>
[/tableHeader_data]

<!-- Список каталогов товаров -->
[catalogList_empty]
<tr>
	<td colspan="6">
		<p>Список каталогов товаров пуст!</p>
	</td>
</tr>
[/catalogList_empty]

<!-- Список товаров -->
[dataList_empty]
<tr>
	<td colspan="13">
		<p>Список товаров пуст!</p>
	</td>
</tr>
[/dataList_empty]

<!-- Елемент списка каталогов товаров (каталог) -->
[catalogListIteam]
<tr id="{id}" class="line {zebra}">
	<td><p><img src="{imgSrc}" alt="" height="25" /></p></td>
	<td class="cursor" onclick="AdminCatalog.showAndHideContent({id});"><p style="font-size: 14px; font-weight: bold; color: #000000;">{title}</p></td>
	<td align="center"><p>{position}</p></td>
	<td align="center"><p>{show}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/catalog/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminCatalog.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
<tr id="catalog-content-{id}" class="line content hide">
    <td colspan="6"></td>
</tr>
[/catalogListIteam]

<!-- Елемент списка товаров -->
[dataListIteam]
<tr class="line {zebra}">
	<td><p><img src="{imgSrc}" alt="" height="25" /></p></td>
	<td><p>{article}</p></td>
	<td><p>{title}</p></td>
	<td align="right">
		<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminData.priceHotEdit(this); return false;">
			<input type="hidden" name="hotEditKey" value="true" />
			<input type="hidden" name="id" value="{id}" />
			<input type="text" name="price" value="{price}" />
		</form>
	</td>
	<td align="right">
		<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminData.priceHotEdit(this); return false;">
			<input type="hidden" name="hotEditKey" value="true" />
			<input type="hidden" name="id" value="{id}" />
			<input type="text" name="priceOld" value="{priceOld}" />
		</form>
	</td>
	<td align="center"><p>{show}</p></td>
	<td align="center"><p>{notAvailable}</p></td>
	<td align="center"><p>{newOffers}</p></td>
	<td align="center"><p>{promotionalOffers}</p></td>
	<td align="center"><p>{salesLeaders}</p></td>
	<td class="button"><p><a class="insert_image" href="javascript: void(0);" onclick="window.location.href = '/admin/data-image/{id}/';" title='Изображения товара "{title}"'></a></p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/data/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminData.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/dataListIteam]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

[catalogContent]
<table class="width100">
    {html}
</table>
[/catalogContent]

[catalogContent_empty]
<p><span>Каталог пуст!</span> <a class="addCatalog" href="/admin/catalog/add/{catalogId}/" title="Создать каталог"></a> <a class="add" href="/admin/data/add/{catalogId}/" title="Создать товар"></a></p>
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

	<div class="title">Часть ЧПУ адреса каталога</div>
	<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>

	<div class="title">Позиция каталога</div>
	<div class="content"><input type="text" name="position" value="{position}" /></div>

	<div class="title">Текст заголовка страницы</div>
	<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

	<div class="title">Краткое описание каталога</div>
	<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

	<div class="title">Текст каталога</div>
	<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>

	<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
    <div class="content"></div>
    <div class="seo displayNone">
		<div class="title">metaTitle</div>
		<div class="content"><textarea name="metaTitle">{metaTitle}</textarea></div>

		<div class="title">metaKeywords</div>
		<div class="content"><textarea name="metaKeywords">{metaKeywords}</textarea></div>

		<div class="title">metaDescription</div>
		<div class="content"><textarea name="metaDescription">{metaDescription}</textarea></div>
	</div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.parent.window.$.fancybox.close();">Отменить</a></div>

	</form>
</div>
[/adminCatalogEdit]
