<!-- Коренной шаблон списка статических страниц (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="filled"><p><a class="add" href="/admin/page/add/" title="Добавить"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="staticPageList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>Наименование</p></td>
			<td><p>Имя для разработчика</p></td>
			<td><p>URL страницы</p></td>
			<td align="center"><p>Позиция</p></td>
			<td colspan="2"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="6"></td>
		</tr>
		{staticPageList}
		</table>
	</div>
</div>
[/content]

<!-- Список старических страниц пуст -->
[staticPageList_empty]
<tr>
	<td colspan="6">
		<p>Список статических страниц пуст!</p>
	</td>
</tr>
[/staticPageList_empty]

<!-- Елемент списка старических страниц -->
[staticPageListIteam]
<tr class="line {zebra}">
	<td><p>{title}</p></td>
	<td><p>{devName}</p></td>
	<td><p>{urlName}</p></td>
	<td align="center"><p>{position}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/page/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminPage.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/staticPageListIteam]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления -->
[adminPageAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminPage.add(this); return false;">

	<div class="title required">Наименование страницы</div>
	<div class="content"><input type="text" name="title" /></div>

	<div class="title required">Имя для разработчика</div>
	<div class="content"><input type="text" name="devName" /></div>

	<div class="title required">URL страницы</div>
	<div class="content"><input type="text" name="urlName" /></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/page/';">Отменить</a></div>

	</form>
</div>
[/adminPageAdd]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы редактированя -->
[adminPageEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminPage.edit(this); return false;">
		<input type="hidden" name="id" value="{pageId}" />

		<div class="title required">Наименование страницы</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title required">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title required">URL страницы</div>
		<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>

		<div class="title"><img src="{imgSrc1}" style="max-width: 200px;" alt="" />
			<br />
			Изображение страницы №1
			<br />
			Рекомендуемый размер изображение: ({imgWidth_1}X{imgHeight_1})
			<br />
			Если (0Х0) - Размеры не указаны
		</div>
		<div class="content"><input type="file" name="fileName1" /></div>

		<div class="title"><a href="javascript: void(0)" onclick="$('.img').toggle();">Pазмеры изображений страницы</a></div>
		<div class="content"></div>
		<div class="img displayNone">
			<div class="title">Размеры изображения страницы №1 (ШхВ)</div>
			<div class="content"><input class="imgSize" type="text" name="imgWidth_1" value="{imgWidth_1}" /> x <input class="imgSize" type="text" name="imgHeight_1" value="{imgHeight_1}" /></div>
			<div class="comment">Если 0 - то изображение будет загружаться без изменений</div>
		</div>

		<div class="title">Позиция страницы</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="displayNone">
			<div class="title">Краткое описание</div>
			<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>
		</div>

		<div class="title">Текст страницы</div>
		<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>

		{map}

		<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
		<div class="content"></div>
		<div class="seo displayNone">
			<div class="title">Текст заголовка страницы</div>
			<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

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
[/adminPageEdit]

<!-- Шаблон страницы редактированя -->
[adminPageEdit_about]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminPage.edit(this); return false;">
		<input type="hidden" name="id" value="{pageId}" />

		<div class="title required">Наименование страницы</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title required">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title required">URL страницы</div>
		<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>

		<div class="title"><img src="{imgSrc1}" style="max-width: 200px;" alt="" />
			<br />
			Изображение страницы №1
			<br />
			Рекомендуемый размер изображение: ({imgWidth_1}X{imgHeight_1})
			<br />
			Если (0Х0) - Размеры не указаны
		</div>
		<div class="content"><input type="file" name="fileName1" /></div>

		<div class="title"><a href="javascript: void(0)" onclick="$('.img').toggle();">Pазмеры изображений страницы</a></div>
		<div class="content"></div>
		<div class="img displayNone">
			<div class="title">Размеры изображения страницы №1 (ШхВ)</div>
			<div class="content"><input class="imgSize" type="text" name="imgWidth_1" value="{imgWidth_1}" /> x <input class="imgSize" type="text" name="imgHeight_1" value="{imgHeight_1}" /></div>
			<div class="comment">Если 0 - то изображение будет загружаться без изменений</div>
		</div>

		<div class="title">Позиция страницы</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Видео</div>
		<div class="content"><textarea name="addField_lang_1">{addField_lang_1}</textarea></div>

		<div class="title">Краткое описание</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="title">Текст страницы</div>
		<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>


		<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
		<div class="content"></div>
		<div class="seo displayNone">
			<div class="title">Текст заголовка страницы</div>
			<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

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
[/adminPageEdit_about]

<!-- Шаблон страницы редактированя -->
[adminPageEdit_contacts]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminPage.edit(this); return false;">
		<input type="hidden" name="id" value="{pageId}" />

		<div class="title required">Наименование страницы</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title required">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title required">URL страницы</div>
		<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>

		<div class="title"><img src="{imgSrc1}" style="max-width: 200px;" alt="" />
			<br />
			Изображение страницы №1
			<br />
			Рекомендуемый размер изображение: ({imgWidth_1}X{imgHeight_1})
			<br />
			Если (0Х0) - Размеры не указаны
		</div>
		<div class="content"><input type="file" name="fileName1" /></div>

		<div class="title"><a href="javascript: void(0)" onclick="$('.img').toggle();">Pазмеры изображений страницы</a></div>
		<div class="content"></div>
		<div class="img displayNone">
			<div class="title">Размеры изображения страницы №1 (ШхВ)</div>
			<div class="content"><input class="imgSize" type="text" name="imgWidth_1" value="{imgWidth_1}" /> x <input class="imgSize" type="text" name="imgHeight_1" value="{imgHeight_1}" /></div>
			<div class="comment">Если 0 - то изображение будет загружаться без изменений</div>
		</div>

		<div class="title">Позиция страницы</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="displayNone">
			<div class="title">Краткое описание</div>
			<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>
		</div>

		<div class="title">Дополнительная информация</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="title">Текст страницы</div>
		<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>

		<div class="title">Карта</div>
		<div class="content"><textarea name="map">{map}</textarea></div>

		<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
		<div class="content"></div>
		<div class="seo displayNone">
			<div class="title">Текст заголовка страницы</div>
			<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

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
[/adminPageEdit_contacts]
