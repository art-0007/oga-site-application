<!-- Коренной шаблон списка изображений товара (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="filled"><p><a class="up" href="/admin/catalog/{catalogId}/?dataId={dataId}" title="Вверх"></a></p></td>
			<td class="tdSeparator widht15px">&nbsp;</td>
			<td class="filled"><p><a class="add" href="/admin/data-image/add/{dataId}/" title="Создать изображение товара"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="articleList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>Изображение</p></td>
			<td align="center" width="100"><p>Позиция</p></td>
			<td align="center" width="100"><p>Основное</p></td>
			<td colspan="2"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="5"></td>
		</tr>
		{dataImageList}
		</table>
	</div>
</div>
[/content]

<!-- Список изображений товара -->
[dataImageList_empty]
<tr>
	<td colspan="5">
		<p>Список изображений товара пуст!</p>
	</td>
</tr>
[/dataImageList_empty]

<!-- Елемент списка изображений товара -->
[dataImageListIteam]
<tr class="line {zebra}">
	<td><p><img src="{imgSrc}" alt="" height="25" /></p></td>
	<td align="center"><p>{position}</p></td>
	<td align="center"><p>{defaultKey}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/data-image/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminDataImage.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/dataImageListIteam]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления -->
[adminDataImageAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminDataImage.add(this); return false;">
	<input type="hidden" name="dataId" value="{dataId}" />

	<div class="title required">Изображение товара</div>
	<div class="content"><input type="file" name="fileName" /></div>

	<div class="title">Позиция изображения</div>
	<div class="content"><input type="text" name="position" /></div>

	<div class="title checkbox">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="defaultKey" type="checkbox" name="defaultKey" value="yes" /></td>
			<td><label for="defaultKey" style="cursor: pointer;">Основное изображение товара</label></td>
		</tr>
		</table>
	</div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/data-image/{dataId}/';">Отменить</a></div>

	</form>
</div>
[/adminDataImageAdd]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы редактированя -->
[adminDataImageEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminDataImage.edit(this); return false;">
	<input type="hidden" name="id" value="{id}" />

	<div class="title">Ид изображения - {id}</div>
	<div class="content"></div>

	<div class="title required"><img src="{imgSrc}" width="200" alt="" /><br />Изображение товара</div>
	<div class="content"><input type="file" name="fileName" /></div>

	<div class="title">Позиция изображения</div>
	<div class="content"><input type="text" name="position" value="{position}" /></div>

	<div class="title checkbox">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="defaultKey" type="checkbox" name="defaultKey" value="yes" {defaultKey_checked} /></td>
			<td><label for="defaultKey" style="cursor: pointer;">Основное изображение товара</label></td>
		</tr>
		</table>
	</div>


	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/data-image/{dataId}/'">Отменить</a></div>

	</form>
</div>
[/adminDataImageEdit]
