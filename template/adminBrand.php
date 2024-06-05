<!-- Коренной шаблон списка брендов (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			{toolbarButton}
			<td class="filled"><p><a class="add" href="/admin/brand/add/" title="Создать бренд"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="articleList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td width="100"><p>Изображение</p></td>
			<td><p>Наименование</p></td>
			<td align="center"><p>Позиция</p></td>
			<td align="center"><p>Отображение</p></td>
			<td colspan="2"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="6"></td>
		</tr>
		{brandContent}
		</table>
	</div>
</div>
[/content]

<!-- Дополнительные кнопки тулбара -->
[toolbarButton]
<td class="filled"><p><a class="up" href="/admin/brand/" title="Вверх"></a></p></td>
<td class="tdSeparator widht15px">&nbsp;</td>
[/toolbarButton]

<!-- Список брендов товаров -->
[brandList_empty]
<tr>
	<td colspan="6">
		<p>Список брендов пуст!</p>
	</td>
</tr>
[/brandList_empty]

<!-- Елемент списка брендов товаров (каталог) -->
[brandListIteam]
<tr class="line {zebra}">
	<td><p><img src="{imgSrc}" alt="" height="25" /></p></td>
	<td class="cursor"><p style="font-size: 14px; font-weight: bold; color: #000000;">{title}</p></td>
	<td align="center"><p>{position}</p></td>
	<td align="center"><p>{position}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/brand/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminBrand.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/brandListIteam]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления -->
[adminBrandAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminBrand.add(this); return false;">
	<input type="hidden" name="brandId" value="{id}" />

	<div class="title required">Наименование бренда</div>
	<div class="content"><input type="text" name="title" /></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/brand/';">Отменить</a></div>

	</form>
</div>
[/adminBrandAdd]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы редактированя -->
[adminBrandEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminBrand.edit(this); return false;">
	<input type="hidden" name="id" value="{id}" />

	<div class="title">Ид бренда - {id}</div>
	<div class="content"></div>

	<div class="title required">Наименование бренда</div>
	<div class="content"><input type="text" name="title" value="{title}" /></div>

	<div class="title"><img src="{imgSrc}" width="200" alt="" /><br />Изображение бренда</div>
	<div class="content"><input type="file" name="fileName" /></div>

	<div class="title">Часть ЧПУ адреса бренда</div>
	<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>

	<div class="title">Позиция бренда</div>
	<div class="content"><input type="text" name="position" value="{position}" /></div>

	<div class="title">Текст заголовка страницы</div>
	<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

	<div class="title">Краткое описание бренда</div>
	<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

	<div class="title">Текст бренда</div>
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
[/adminBrandEdit]
