<!-- Коренной шаблон списка товаров (админка) -->
[content]
<div id="dataListBlock-{catalogId}" class="articleList dataListBlock">
	<table class="width100 list" cellpadding="0" cellspacing="0" border="0">
    <tr class="trHeader">
    	<td width="50"><p>Изоб-ние</p></td>
    	<td><p>Артикул</p></td>
    	<td><p>Наименование</p></td>
    	<td align="center"><p>Цена</p></td>
    	<td width="25" align="center"><p>&nbsp;</p></td>
    	<td align="center"><p>Старая цена</p></td>
	    <td align="center" width="50"><p>Остатки</p></td>
    	<td align="center" width="50"><p>Виден</p></td>
    	<td align="center" width="50"><p>Наличие</p></td>
    	<td colspan="4"></td>
    </tr>
    <tr class="trSeparator">
    	<td colspan="13"></td>
    </tr>
	{dataContent}
	</table>
</div>
[/content]

<!-- Список товаров -->
[dataList_empty]
<tr>
	<td colspan="13">
		<p>Список товаров пуст!</p>
	</td>
</tr>
[/dataList_empty]

<!-- Елемент списка товаров -->
[dataListIteam]
<tr id="data-id-{id}" class="line {zebra}">
	<td><p><img src="{imgSrc}" alt="" height="25" /></p></td>
	<td><p>{article}</p></td>
	<td><p>{title}</p></td>
	<td align="center">
		<form class="priceHotEditForm" autocomplete="off" enctype="multipart/form-data" onsubmit="AdminData.priceHotEdit(this); return false;">
			<input type="hidden" name="hotEditKey" value="true" />
			<input type="hidden" name="id" value="{id}" />
			<input type="text" name="price" value="{price}" />
		</form>
	</td>
	<td align="center"><p><a class="price {priceAddClass}" href="javascript: void(0);" onclick="AdminData.setOldPriceOfCurrentData({id});" title="Установить старую цену текущей"></a></p></td>
	<td align="center">
		<form class="priceOldHotEditForm" autocomplete="off" enctype="multipart/form-data" onsubmit="AdminData.priceOldHotEdit(this); return false;">
			<input type="hidden" name="hotEditKey" value="true" />
			<input type="hidden" name="id" value="{id}" />
			<input type="text" name="priceOld" value="{priceOld}" />
		</form>
	</td>
	<td align="center">
		<form class="quantityHotEditForm" autocomplete="off" enctype="multipart/form-data" onsubmit="AdminData.quantityHotEdit(this); return false;">
			<input type="hidden" name="hotEditKey" value="true" />
			<input type="hidden" name="id" value="{id}" />
			<input type="text" name="quantity" value="{quantity}" />
		</form>
	</td>
	<td align="center"><p><a class="show button {show}" href="javascript: void(0);" onclick="AdminData.showOrHideData({id});" title="Отобразить / Скрыть"></a></p></td>
	<td align="center"><p><a class="availability button {availability}" href="javascript: void(0);" onclick="AdminData.availabilityData({id});" title="Есть в наличии / Нет в наличии"></a></p></td>

<!-- 

	<td align="center" class="promotionalOffersKey">{promotionalOffersKey}</td>
	<td align="center" class="salesLeadersKey">{salesLeadersKey}</td>
 -->

	<td class="button"><p><a class="dataMark {dataMarkAddClass}" href="javascript: void(0);" onclick="AdminData.dataMarkListFormLoad({id});" title="Метки товара"><i class="fa fa-tags" aria-hidden="true"></i></a></p></td>
	<td class="button"><p><a class="insert_image" href="javascript: void(0);" onclick="window.location.href = '/admin/data-image/{id}/';" title='Изображения товара "{title}"'></a></p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/data/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminData.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/dataListIteam]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!--  -->
[mark]
<p><a class="mark button {addClass} {name}" href="javascript: void(0);" onclick="AdminData.setMarkData({id}, {key}, '{name}');" title="Метка товара"></a></p>
[/mark]

<!-- Шаблон пустого списка брендов -->
[brandList_empty]
<option value="0">[БРЕНДОВ НЕТ]</option>
[/brandList_empty]

<!-- Шаблон елемента списка брендов -->
[brandItemList]
<option value="{id}">{title}</option>
[/brandItemList]

<!-- Шаблон елемента списка брендов (выбранный) -->
[brandItemList_selected]
<option value="{id}" selected="selected">{title}</option>
[/brandItemList_selected]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления -->
[adminDataAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminData.add(this); return false;">
	<input type="hidden" name="catalogId" value="{catalogId}" />

	<div class="title required">Артикул <a href="javascript: void(0)" onclick="AdminData.generateArticle()">[сгенерировать]</a></div>
	<div class="content"><input type="text" name="article" /></div>

	<div class="title required">Наименование товара</div>
	<div class="content"><input type="text" name="title" /></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/catalog/{catalogId}/">Отменить</a></div>

	</form>
</div>
[/adminDataAdd]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы редактированя -->
[adminDataEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminData.edit(this); return false;">
	<input type="hidden" name="id" value="{id}" />

	<div class="title required">Артикул <a href="javascript: void(0)" onclick="AdminData.generateArticle()">[сгенерировать]</a></div>
	<div class="content"><input type="text" name="article" value="{article}" /></div>

	<div class="title required">Наименование товара</div>
	<div class="content"><input type="text" name="title" value="{title}" /></div>

	<div class="title">Отображать товар на сайте</div>
	<div class="title checkbox">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="showKey" type="checkbox" name="showKey" value="yes" {showKey_checked} /></td>
			<td><label for="showKey" style="cursor: pointer;">Отображать</label></td>
		</tr>
		</table>
	</div>

	<div class="title">Наличие</div>
	<div class="title checkbox">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="notAvailableKey" type="checkbox" name="notAvailableKey" value="yes" {notAvailableKey_checked} /></td>
			<td><label for="notAvailableKey" style="cursor: pointer;">Нет в наличии</label></td>
		</tr>
		</table>
	</div>
<!--
	<div class="title">Метки товара</div>
	<div class="title checkbox" style="display: inline-block;; margin-right: 50px;">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="newOffersKey" type="checkbox" name="newOffersKey" value="yes" {newOffersKey_checked} /></td>
			<td><label for="newOffersKey" style="cursor: pointer;">Новые поступления</label></td>
		</tr>
		</table>
	</div>
	<div class="title checkbox" style="display: inline-block;; margin-right: 50px;">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="promotionalOffersKey" type="checkbox" name="promotionalOffersKey" value="yes" {promotionalOffersKey_checked} /></td>
			<td><label for="promotionalOffersKey" style="cursor: pointer;">Акционные предложения</label></td>
		</tr>
		</table>
	</div>
	<div class="title checkbox" style="display: inline-block;; margin-right: 50px;">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="salesLeadersKey" type="checkbox" name="salesLeadersKey" value="yes" {salesLeadersKey_checked} /></td>
			<td><label for="salesLeadersKey" style="cursor: pointer;">Лучшие товары</label></td>
		</tr>
		</table>
	</div>
-->
	<div class="title required">Цена</div>
	<div class="content"><input type="text" name="price" value="{price}" /></div>
	<div class="comment">Цена вводится в долларах</div>

	<div class="title required">Старая цена</div>
	<div class="content"><input type="text" name="priceOld" value="{priceOld}" /></div>
	<div class="comment">Если 0 - то старая цена не выводится</div>

	<div class="title">Каталог товара</div>
	<div class="content"><select name="catalogId">{сatalogSelect}</select></div>

	<div class="title">Остатки</div>
	<div class="content"><input type="text" name="quantity" value="{quantity}" /></div>

	<div class="title">Описание товара</div>
	<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

<!--	<div class="title">Текст товара</div>-->
<!--	<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>-->

	<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
    <div class="content"></div>
    <div class="seo displayNone">
	    <div class="title">Часть ЧПУ адреса каталога. <a href="javascript: void(0)" onclick="TranslitUrlName.setTranslit();">Преобразовать наименование в URL</a></div>
	    <div class="content"><input type="text" name="urlName" value="{urlName}" />-o{id}</div>
	    <div class="comment">Если поле будет пустое то ЧПУ будет преобразованно из наменования.<br /> Суфикс "-o{id}" добавляется автоматически</div>

	    <div class="title">Текст заголовка страницы H1</div>
	    <div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

	    <div class="title">metaTitle</div>
		<div class="content"><textarea name="metaTitle">{metaTitle}</textarea></div>

		<div class="title">metaKeywords</div>
		<div class="content"><textarea name="metaKeywords">{metaKeywords}</textarea></div>

		<div class="title">metaDescription</div>
		<div class="content"><textarea name="metaDescription">{metaDescription}</textarea></div>
	</div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/catalog/{catalogId}/?dataId={id}">Отменить</a></div>

	</form>
</div>
[/adminDataEdit]

[addParameterLine]
<tr id="tr-{index}">
	<td style="width: 250px;"><input type="text" name="options[{index}][title]" value="{optionsTitle}" placeholder="Название параметра"/></td>
	<td style="width: 15px;">&nbsp;</td>
	<td style="width: 250px;"><input type="text" name="options[{index}][value]" value="{optionsValue}" placeholder="Значение параметра" /></td>
	<td style="width: 10px;">&nbsp;</td>
	<td style="width: 150px;"><a style="display: block;" href="javascript:void(0);" onclick="AdminData.addParameterLine({index});">Добавить строку</a><a style="display: block; margin-top: 5px;" href="javascript:void(0);" onclick="AdminData.deleteParameterLine({index})">Удалить строку</a></td>
</tr>
<tr id="tr2-{index}">
	<td colspan="5">&nbsp;</td>
</tr>
[/addParameterLine]