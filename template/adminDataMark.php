<!-- Коренной шаблон списка меток товара (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="filled"><p><a class="add" href="/admin/data-mark/add/" title="Создать метку товара"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div id="dataMarkListBlock" class="articleList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td width="100"><p>Изображение</p></td>
			<td><p>Наименование</p></td>
			<td><p>Наименование блока</p></td>
			<td><p>Имя для разработчика</p></td>
			<td align="center" width="100"><p>Позиция</p></td>
			<td align="center" width="100"><p>Отображать ли товары с этой меткой на главной</p></td>
			<td colspan="2"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="8"></td>
		</tr>
		{dataMarkList}
		</table>
	</div>
</div>
[/content]

<!-- Список меток товара -->
[dataMarkList_empty]
<tr>
	<td colspan="8">
		<p>Список меток товара пуст!</p>
	</td>
</tr>
[/dataMarkList_empty]

<!-- Елемент списка меток товара -->
[dataMarkListIteam]
<tr id="data-mark-id-{id}" class="line {zebra}">
	<td><p><img src="{imgSrc}" alt="" height="25" /></p></td>
	<td><p>{title}</p></td>
	<td><p>{blockTitle}</p></td>
	<td><p>{devName}</p></td>
	<td align="center"><p>{position}</p></td>
	<td align="center"><p><a class="show button {show}" href="javascript: void(0);" onclick="AdminDataMark.showOrHideDataMarkOnIndex({id});" title="Отобразить / Скрыть"></a></p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/data-mark/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminDataMark.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/dataMarkListIteam]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления -->
[adminDataMarkAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminDataMark.add(this); return false;">

	<div class="title required">Наименование метки</div>
	<div class="content"><input type="text" name="title" /></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/data-mark/';">Отменить</a></div>

	</form>
</div>
[/adminDataMarkAdd]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы редактированя -->
[adminDataMarkEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminDataMark.edit(this); return false;">
	<input type="hidden" name="id" value="{id}" />

	<div class="title">Ид метки - {id}</div>
	<div class="content"></div>

	<div class="title required">Наименование метки</div>
	<div class="content"><input type="text" name="title" value="{title}" /></div>

	<div class="title checkbox">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="showDataMarkOnIndexKey" type="checkbox" name="showDataMarkOnIndexKey" value="yes" {showDataMarkOnIndexKey_checked} /></td>
			<td><label for="showDataMarkOnIndexKey" style="cursor: pointer;">Отображать ли товары с этой меткой на главной</label></td>
		</tr>
		</table>
	</div>

	<div class="title">Наименование блока списка товаров с этой меткой</div>
	<div class="content"><input type="text" name="blockTitle" value="{blockTitle}" /></div>

	<div class="title">Имя для разработчика</div>
	<div class="content"><input type="text" name="devName" value="{devName}" /></div>

	<div class="title">Позиция метки товара</div>
	<div class="content"><input type="text" name="position" value="{position}" /></div>

	<div class="title checkbox">
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><input id="dataImageKey" type="checkbox" name="dataImageKey" value="true" {dataImageKey_checked} /></td>
		<td><label for="dataImageKey">Использовать как изображение на товаре (воблер)</label></td>
	</tr>
	</table>
	</div>

	<div id="dataImageKey_div" style="display: {dataImage_div_display}; margin: 20px 0px 0px 20px;">
	
		<div class="comment" style="margin-top: 10px;"><strong>ВНИМАНИЕ!</strong> Изображение на товаре и его настройки различны для каждого из языков</div>
	
		<div class="title required">Файл изображения отображаемого на изображении товара (воблер)</div>
		<div class="content"><input size="53" type="file" name="fileName"></div>
		<div class="comment">Размеры изображения не меняются.<br>Если вы не хотите менять текущее изображение, то оставьте его поле пустым</div>
		<div style="margin: 10px 0px 10px 0px;">{dataImageFile_img}</div>
	
		<div class="comment">Выберите позицию изображения на изображении товара и задайте его отступы от соответствующих границ изображения товара</div>
		<div>
			<table cellpadding="0" cellspacing="0" border="0" style="background-color: #f7f7f7; border: 1px solid #D2D2D2;">
			<tr>
				<td height="19">&nbsp;</td>
				<td align="center"><input type="text" name="dataImageMarginY_topLeft" value="{dataImageMarginY_topLeft}" style="width: 30px; text-align: center;" onfocus="AdminDataMark.selectDataImagePosition(1)"></td>
				<td rowspan="7" width="30">&nbsp;</td>
				<td align="center"><input type="text" name="dataImageMarginY_topCenter" value="{dataImageMarginY_topCenter}" style="width: 30px; text-align: center;" onfocus="AdminDataMark.selectDataImagePosition(2)"></td>
				<td rowspan="7" width="30">&nbsp;</td>
				<td align="center"><input type="text" name="dataImageMarginY_topRight" value="{dataImageMarginY_topRight}" style="width: 30px; text-align: center;" onfocus="AdminDataMark.selectDataImagePosition(3)"></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="center" height="19"><input type="text" name="dataImageMarginX_topLeft" value="{dataImageMarginX_topLeft}" style="width: 30px; text-align: center;" onfocus="AdminDataMark.selectDataImagePosition(1)"></td>
				<td align="center" class="{dataImagePositionTopLeft_td_class}"><input type="radio" name="dataImagePosition" value="1" {dataImagePositionTopLeft_checked}></td>
				<td align="center" class="{dataImagePositionTopCenter_td_class}"><input type="radio" name="dataImagePosition" value="2" {dataImagePositionTopCenter_checked}></td>
				<td align="center" class="{dataImagePositionTopRight_td_class}"><input type="radio" name="dataImagePosition" value="3" {dataImagePositionTopRight_checked}></td>
				<td align="center"><input type="text" name="dataImageMarginX_topRight" value="{dataImageMarginX_topRight}" style="width: 30px; text-align: center;" onfocus="AdminDataMark.selectDataImagePosition(3)"></td>
			</tr>
			<tr>
				<td colspan="2" height="19">&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" height="19"><input type="text" name="dataImageMarginX_leftCenter" value="{dataImageMarginX_leftCenter}" style="width: 30px; text-align: center;" onfocus="AdminDataMark.selectDataImagePosition(4)"></td>
				<td align="center" class="{dataImagePositionLeftCenter_td_class}"><input type="radio" name="dataImagePosition" value="4" {dataImagePositionLeftCenter_checked}></td>
				<td align="center" class="{dataImagePositionCenter_td_class}"><input type="radio" name="dataImagePosition" value="5" {dataImagePositionCenter_checked}></td>
				<td align="center" class="{dataImagePositionRightCenter_td_class}"><input type="radio" name="dataImagePosition" value="6" {dataImagePositionRightCenter_checked}></td>
				<td align="center"><input type="text" name="dataImageMarginX_rightCenter" value="{dataImageMarginX_rightCenter}" style="width: 30px; text-align: center;" onfocus="AdminDataMark.selectDataImagePosition(6)"></td>
			</tr>
			<tr>
				<td colspan="2" height="19">&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" height="19"><input type="text" name="dataImageMarginX_bottomLeft" value="{dataImageMarginX_bottomLeft}" style="width: 30px; text-align: center;" onfocus="AdminDataMark.selectDataImagePosition(7)"></td>
				<td align="center" class="{dataImagePositionBottomLeft_td_class}"><input type="radio" name="dataImagePosition" value="7" {dataImagePositionBottomLeft_checked}></td>
				<td align="center" class="{dataImagePositionBottomCenter_td_class}"><input type="radio" name="dataImagePosition" value="8" {dataImagePositionBottomCenter_checked}></td>
				<td align="center" class="{dataImagePositionBottomRight_td_class}"><input type="radio" name="dataImagePosition" value="9" {dataImagePositionBottomRight_checked}></td>
				<td align="center"><input type="text" name="dataImageMarginX_bottomRight" value="{dataImageMarginX_bottomRight}" style="width: 30px; text-align: center;" onfocus="AdminDataMark.selectDataImagePosition(9)"></td>
			</tr>
			<tr>
				<td height="19">&nbsp;</td>
				<td align="center"><input type="text" name="dataImageMarginY_bottomLeft" value="{dataImageMarginY_bottomLeft}" style="width: 30px; text-align: center;" onfocus="AdminDataMark.selectDataImagePosition(7)"></td>
				<td align="center"><input type="text" name="dataImageMarginY_bottomCenter" value="{dataImageMarginY_bottomCenter}" style="width: 30px; text-align: center;" onfocus="AdminDataMark.selectDataImagePosition(8)"></td>
				<td align="center"><input type="text" name="dataImageMarginY_bottomRight" value="{dataImageMarginY_bottomRight}" style="width: 30px; text-align: center;" onfocus="AdminDataMark.selectDataImagePosition(9)"></td>
				<td>&nbsp;</td>
			</tr>
			</table>
		</div>
	</div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/data-mark/'">Отменить</a></div>

	</form>
</div>
[/adminDataMarkEdit]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон списка меток товара -->
[dataMarkListPopuapForm]
<div id="dataMarkListFormLoadPopupMessageOk" class="dataMarkListFormLoadPopupMessageOk">
	<h3>Список меток товара</h3>
	<div class="editForm">
		<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminData.setDataMark(this); return false;">
		<input type="hidden" name="dataId" value="{dataId}" />
	
		{dataMarkList}
	
		<div class="buttons"><button class="button" type="submit">Сохранить</button> или <a href="javascript: void(0);" onclick="AdminData.dataMarkListFormLoadPopupMessageOk.close();">Отменить</a></div>
	
		</form>
	</div>
</div>
[/dataMarkListPopuapForm]


<!-- Елемент списка меток товара -->
[dataMarkListItemPopuapForm]
<div class="title checkbox">
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><input id="dataMark{id}" type="checkbox" name="dataMark{id}" value="yes" {checked} /></td>
		<td><label for="dataMark{id}" style="cursor: pointer;">{title}</label></td>
	</tr>
	</table>
</div>
[/dataMarkListItemPopuapForm]

