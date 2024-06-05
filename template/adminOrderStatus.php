<!-- Коренной шаблон списка (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="filled"><p><a class="add" href="/admin/order-status/add/" title="Создать статус заказа"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div id="orderStatusListBlock" class="orderStatusList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>Наименование</p></td>
			<td><p>Имя для разработчика</p></td>
			<td align="center" width="100"><p>Позиция</p></td>
			<td align="center" width="100"><p>Бызовый</p></td>
			<td colspan="2"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="6"></td>
		</tr>
		{orderStatusList}
		</table>
	</div>
</div>
[/content]

<!-- Список меток товара -->
[orderStatusList_empty]
<tr>
	<td colspan="6">
		<p>Список пуст!</p>
	</td>
</tr>
[/orderStatusList_empty]

<!-- Елемент списка меток товара -->
[orderStatusListIteam]
<tr id="order-status-id-{id}" class="line {zebra}">
	<td><p>{title}</p></td>
	<td><p>{devName}</p></td>
	<td align="center"><p>{position}</p></td>
	<td align="center"><p>{base}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/order-status/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminOrderStatus.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/orderStatusListIteam]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления -->
[adminOrderStatusAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminOrderStatus.add(this); return false;">

	<div class="title required">Наименование</div>
	<div class="content"><input type="text" name="title" /></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/order-status/';">Отменить</a></div>
	</form>
</div>
[/adminOrderStatusAdd]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы редактированя -->
[adminOrderStatusEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminOrderStatus.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Ид - {id}</div>
		<div class="content"></div>

		<div class="title required">Наименование</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Операции с остатками</div>
		<div class="content"><select name="quantityOperationKey">{quantityOperationSelect}</select></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/order-status/'">Отменить</a></div>
	</form>
</div>
[/adminOrderStatusEdit]
