<!-- Коренной шаблон списка изображений статьи (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="toolbar">
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		{toolbarButton}
		<td class="filled"><p><a class="add" {addArticleImageHref} title="Добавить изображение"></a></p></td>
		<td class="tdSeparator">&nbsp;</td>
		<td width="*">&nbsp;</td>
	</tr>
	</table>
</div>

<div class="sliderImageList">
	<table class="list" cellpadding="0" cellspacing="0" border="0">
	{tableHeader}
	{articleImageContent}
	</table>
</div>

[/content]

<!-- Дополнительные кнопки тулбара -->
[toolbarButton]
<td class="filled"><p><a class="up" href="/admin/article/{articleCatalogId}/" title="Вверх"></a></p></td>
<td class="tdSeparator widht15px">&nbsp;</td>
[/toolbarButton]

[tableHeader_articleImage]
<tr class="trHeader">
	<td><p>Изображение</p></td>
	<td><p>Наименование</p></td>
	<td><p>Ссылка</p></td>
	<td align="center"><p>Позиция</p></td>
	<td colspan="2"></td>
</tr>
<tr class="trSeparator">
	<td colspan="6"></td>
</tr>
[/tableHeader_articleImage]

<!-- Список изображений статьи пуст -->
[articleImageList_empty]
<tr>
	<td colspan="6"><p>Список изображений статьи пуст!</p></td>
</tr>
[/articleImageList_empty]

<!-- ************************************************************************************************* -->
<!-- ************************************************************************************************* -->

<!-- Елемент списка изображений статьи -->
[articleImageListItem]
<tr class="line {zebra}">
	<td><p><img src="{imgSrc}" alt="" height="25"></p></td>
	<td><p>{title}</p></td>
	<td><p>{href}</p></td>
	<td align="center"><p>{position}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/article-image/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminArticleImage.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/articleImageListItem]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления  слайдера -->
[adminArticleImageAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticleImage.add(this); return false;">
	<input type="hidden" name="articleId" value="{articleId}" />

	<div class="title required">Изображение</div>
	<div class="content"><input type="file" name="fileName" /></div>
<!-- 
	<div class="title">Ссылка изображения</div>
	<div class="content"><input type="text" name="href" /></div>

	<div class="title">Наименование изображения</div>
	<div class="content"><input type="text" name="title" /></div>

	<div class="title">Позиция изображения</div>
	<div class="content"><input type="text" name="position" /></div>
	<div class="title">Текст изображения</div>
	<div class="content"><textarea class="textareaTinymce" class="tinymce" name="text"></textarea></div>
 -->
	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/article-image/{articleId}/';">Отменить</a></div>

	</form>
</div>
[/adminArticleImageAdd]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы редактированя -->
[adminArticleImageEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticleImage.edit(this); return false;">
	<input type="hidden" name="id" value="{articleImageId}" />

	<div class="title required"><img src="{imgSrc}" width="200" alt="" /><br />Изображение</div>
	<div class="content"><input type="file" name="fileName" /></div>

<!-- 
	<div class="title">Ссылка изображения</div>
	<div class="content"><input type="text" name="href" value="{href}" /></div>

	<div class="title">Наименование изображения</div>
	<div class="content"><input type="text" name="title" value="{title}" /></div>
 -->

	<div class="title">Позиция изображения</div>
	<div class="content"><input type="text" name="position" value="{position}" /></div>

<!-- 
	<div class="title">Текст изображения</div>
	<div class="content"><textarea class="textareaTinymce" class="tinymce" name="text">{text}</textarea></div>
-->

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/article-image/{articleId}/';">Отменить</a></div>

	</form>
</div>
[/adminArticleImageEdit]
