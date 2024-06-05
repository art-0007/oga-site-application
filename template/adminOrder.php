<!-- Коренной шаблон списка заказов (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="orderStatus"><select name="orderStatuId" onchange="window.location.href='/admin/order/?orderStatusId='+$(':selected', this).val();">{orderStatusSelect}</select></td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="orderList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>Код заказа</p></td>
			<td><p>Статус заказа</p></td>
			<td><p>Информация о покупателе</p></td>
			<td><p>Информация о доставке и оплате</p></td>
			<td align="center"><p>IP адресс <br />пользователя</p></td>
			<td align="center"><p>Кол-во<br />товаров</p></td>
			<td align="right"><p>Стоимость<br />заказа</p></td>
			<td align="right"><p>Дата и время создания</p></td>
			<td colspan="2"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="9"></td>
		</tr>
		{orderList}
		</table>
	</div>
</div>
[/content]

<!-- Список заказов пуст -->
[orderList_empty]
<tr>
	<td colspan="9">
		<p>Список заказов пуст!</p>
	</td>
</tr>
[/orderList_empty]

<!-- Елемент списка заказов -->
[orderListIteam]
<tr class="line {zebra}" valign="top">
	<td class="cursor" onclick="window.location.href = '/admin/order/view/{id}/'"><p>{code}</p></td>
	<td><p>{orderStatusTitle}</p></td>
	<td>
		<p>{phone}</p>
		<p>{email}</p>
		<p>{fio}</p>
	</td>
	<td>
		<p>{orderDeliveriTypeTitle}</p>
		<p>{orderPayTypeTitle}</p>
		<p>{city}</p>
		<p>{street} <br /> {storeAddress}</p>
	</td>
	<td align="center"><p>{ip}</p></td>
	<td align="center"><p>{offerAmount}</p></td>
	<td align="right"><p>{orderPriceResult}</p></td>
	<td align="right"><p>{time}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/order/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminOrder.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/orderListIteam]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Коренной шаблон просмотра заказа (админка) -->
[content_view]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="filled"><p><a class="up" href="/admin/order/" title="Вверх"></a></p></td>
			<td class="tdSeparator widht15px">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="orderOfferList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>Артикул</p></td>
			<td><p>Наименование</p></td>
			<td align="right"><p>Цена</p></td>
			<td align="center"><p>Кол-во</p></td>
			<td align="right"><p>Стоимость</p></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="5"></td>
		</tr>
		{orderOfferList}
		</table>
	</div>
</div>
[/content_view]

<!-- Список товаров в заказе пуст -->
[orderOfferList_empty]
<tr>
	<td colspan="7">
		<p>Список товаров в заказе пуст!</p>
	</td>
</tr>
[/orderOfferList_empty]

<!-- Елемент списка товаров в заказе -->
[orderOfferListItem]
<tr class="line {zebra}">
	<td><p>{article}</p></td>
	<td><p>{title}</p></td>
	<td align="right"><p>{price}</p></td>
	<td align="center"><p>{offerAmount}</p></td>
	<td align="right"><p>{cost}</p></td>
</tr>
[/orderOfferListItem]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы редактированя -->
[adminOrderEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm ">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminOrder.edit(this); return false;">
	<input type="hidden" name="orderId" value="{orderId}" />

	<div class="title required">ИД - {orderId}</div>
	<div class="content"></div>

	<div class="title required">Статус заказа</div>
	<div class="content"><select name="orderStatusId">{orderStatusSelect}</select></div>

	<div class="row mt-30">
		<div class="col">
			<div class="title required">Тип доставки заказа</div>
			<div class="content"><select name="orderDeliveryTypeId">{orderDeliveryTypeSelect}</select></div>

			<div class="title required">Тип оплаты заказа</div>
			<div class="content"><select name="orderPayTypeId">{orderPayTypeSelect}</select></div>

			<div class="title">Город</div>
			<div class="content"><input type="text" name="city" value="{city}" /></div>

			<div class="title">Адрес (Улица)</div>
			<div class="content"><input type="text" name="street" value="{street}" /></div>

			<div class="title">Адрес склада / Номер отделения</div>
			<div class="content"><input type="text" name="storeAddress" value="{storeAddress}" /></div>

			<div class="title">Комментарий администратора</div>
			<div class="content"><textarea name="adminComment">{adminComment}</textarea></div>

			<div class="title">Скидка на заказ</div>
			<div class="content"><input type="text" name="discount" value="{discount}" /></div>

			<div class="title">Скидка на заказ</div>
			<div class="content"><input type="text" name="discount" value="{discount}" /></div>

		</div>
		<div class="col">
			<div class="title">Телефон</div>
			<div class="content"><input type="text" name="phone" value="{phone}" /></div>

			<div class="title">Email</div>
			<div class="content"><input type="text" name="email" value="{email}" /></div>

			<div class="title">Фамилия</div>
			<div class="content"><input type="text" name="lastName" value="{lastName}" /></div>

			<div class="title">Имя</div>
			<div class="content"><input type="text" name="firstName" value="{firstName}" /></div>

			<div class="title">Отчество</div>
			<div class="content"><input type="text" name="middleName" value="{middleName}" /></div>

			<div class="title">Комментарий покупателя</div>
			<div class="content"><textarea name="userComment">{userComment}</textarea></div>
		</div>
	</div>

	<div class="orderOfferList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
			<tr class="trHeader">
				<td><p>Артикул</p></td>
				<td><p>Наименование</p></td>
				<td align="right"><p>Цена</p></td>
				<td align="center"><p>Кол-во</p></td>
				<td align="right"><p>Стоимость</p></td>
			</tr>
			<tr class="trSeparator">
				<td colspan="5"></td>
			</tr>
			{orderOfferList}
		</table>

		<table class="orderSumInfo" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td class="title"><p>Стоимость товаров:</p></td>
				<td class="sum"><p>{orderOfferPrice} ₴</p></td>
			</tr>
			<tr>
				<td class="title"><p>Скидка ({discount}%)</p></td>
				<td class="sum"><p>{discountSum} ₴</p></td>
			</tr>
			<tr>
				<td class="title"><p>Итого:</p></td>
				<td class="sum"><p>{orderPriceResult} ₴</p></td>
			</tr>
		</table>
	</div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/order/">Отменить</a></div>

	</form>
</div>
[/adminOrderEdit]
