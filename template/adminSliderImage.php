<!-- Коренной шаблон списка изображений слайдера (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			{toolbarButton}
			<td class="filled"><p><a class="addCatalog" {addSliderImageCatalogHref} title="Создать каталог"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td class="filled"><p><a class="add" {addSliderImageHref} title="Создать слайдер"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="sliderImageList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		{tableHeader}
		{sliderImageContent}
		</table>
	</div>
</div>
[/content]

<!-- Дополнительные кнопки тулбара -->
[toolbarButton]
<td class="filled"><p><a class="up" href="/admin/slider-image/{sliderImageCatalogId}/" title="Вверх"></a></p></td>
<td class="tdSeparator widht15px">&nbsp;</td>
[/toolbarButton]

[tableHeader_catalog]
<tr class="trHeader">
	<td><p>Наименование</p></td>
	<td align="center"><p>Имя для разработчика</p></td>
	<td align="center"><p>Позиция</p></td>
	<td colspan="2"></td>
</tr>
<tr class="trSeparator">
	<td colspan="5"></td>
</tr>
[/tableHeader_catalog]

[tableHeader_sliderImage]
<tr class="trHeader">
	<td><p>Изображение</p></td>
	<td><p>Наименование</p></td>
	<td><p>Ссылка</p></td>
	<td align="center"><p>Позиция</p></td>
	<td align="center"><p>Видно</p></td>
	<td colspan="2"></td>
</tr>
<tr class="trSeparator">
	<td colspan="7"></td>
</tr>
[/tableHeader_sliderImage]

<!-- Список каталогов слайдера пуст -->
[sliderImageCatalogList_empty]
<tr>
	<td colspan="4">
		<p>Список каталогов слайдера пуст!</p>
	</td>
</tr>
[/sliderImageCatalogList_empty]

<!-- Список изображений слайдера пуст -->
[sliderImageList_empty]
<tr>
	<td colspan="7">
		<p>Список изображений слайдера пуст!</p>
	</td>
</tr>
[/sliderImageList_empty]

<!-- ************************************************************************************************* -->
<!-- ************************************************************************************************* -->

<!-- Елемент списка каталогов статей (каталог) -->
[sliderImageCatalogListItem]
<tr class="line {zebra}">
	<td class="cursor" onclick="window.location.href = '{href}'"><p style="font-size: 14px; font-weight: bold; color: #000000;">{title}</p></td>
	<td align="center"><p>{devName}</p></td>
	<td align="center"><p>{position}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/slider-image-catalog/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminSliderImageCatalog.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/sliderImageCatalogListItem]

<!-- Елемент списка изображений слайдера -->
[sliderImageListItem]
<tr class="line {zebra}">
	<td><p><img src="{imgSrc}" alt="" height="25"></p></td>
	<td><p>{title}</p></td>
	<td><p>{href}</p></td>
	<td align="center"><p>{position}</p></td>
	<td align="center"><p>{show}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/slider-image/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminSliderImage.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/sliderImageListItem]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления  слайдера -->
[adminSliderImageAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminSliderImage.add(this); return false;">
	<input type="hidden" name="sliderImageCatalogId" value="{sliderImageCatalogId}" />

	<div class="title required">Наименование слайдера</div>
	<div class="content"><input type="text" name="title" /></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/slider-image/{sliderImageCatalogId}/';">Отменить</a></div>

	</form>
</div>
[/adminSliderImageAdd]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы редактированя -->
[adminSliderImageEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminSliderImage.edit(this); return false;">
		<input type="hidden" name="id" value="{sliderImageId}" />

		<div class="title required">Наименование слайдера</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title"><img src="{imgSrc}" width="200" alt="" />
			<br />
			Изображение слайдера
			<br />
			Рекомендуемый размер изображение: ({imgWidth_1}X{imgHeight_1})
			<br />
			Если (0Х0) - Размеры не указаны
		</div>
		<div class="content"><input type="file" name="fileName" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
						<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Позиция слайдера</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Текст слайдера</div>
		<div class="content"><textarea class="textareaTinymce tinymce" name="text">{text}</textarea></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/slider-image/{sliderImageCatalogId}/';">Отменить</a></div>

	</form>
</div>
[/adminSliderImageEdit]

<!--
		<div class="title">Ссылка слайдера</div>
		<div class="content"><input type="text" name="href" value="{href}" /></div>

		<div class="title">Значение атребута onclick</div>
		<div class="content"><input type="text" name="onclick" value="{onclick}" /></div>


		<div class="title">Текст кнопки</div>
		<div class="content"><input type="text" name="btnText" value="{btnText}" /></div>

		<div class="title">Описание слайдера</div>
		<div class="content"><textarea class="textareaTinymce tinymce" name="description">{description}</textarea></div>

		<div class="title">Текст слайдера</div>
		<div class="content"><textarea class="textareaTinymce tinymce" name="text">{text}</textarea></div>


-->

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления каталога -->
[adminSliderImageCatalogAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminSliderImageCatalog.add(this); return false;">
	<input type="hidden" name="sliderImageCatalogId" value="{sliderImageCatalogId}" />

	<div class="title required">Наименование каталога</div>
	<div class="content"><input type="text" name="title" /></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/slider-image/{sliderImageCatalog_id}/';">Отменить</a></div>

	</form>
</div>
[/adminSliderImageCatalogAdd]

<!-- Шаблон страницы редактированя каталога -->
[adminSliderImageCatalogEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminSliderImageCatalog.edit(this); return false;">
	<input type="hidden" name="id" value="{sliderImageCatalogId}" />

	<div class="title required">Наименование каталога</div>
	<div class="content"><input type="text" name="title" value="{title}" /></div>

	<div class="title">Имя для разработчика</div>
	<div class="content"><input type="text" name="devName" value="{devName}" /></div>

	<div class="title">Позиция каталога</div>
	<div class="content"><input type="text" name="position" value="{position}" /></div>

	<div class="title"><a href="javascript: void(0)" onclick="$('.img').toggle();">Pазмеры изображений слайдов в внутри каталога</a></div>
    <div class="content"></div>
    <div class="img displayNone">
		<div class="title">Размеры изображения (ШхВ)</div>
		<div class="content"><input class="imgSize" type="text" name="imgWidth_1" value="{imgWidth_1}" /> x <input class="imgSize" type="text" name="imgHeight_1" value="{imgHeight_1}" /></div>
		<div class="comment">Если 0 - то изображение будет загружаться без изменений</div>
	</div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/slider-image/{sliderImageCatalog_id}/';">Отменить</a></div>

	</form>
</div>
[/adminSliderImageCatalogEdit]
