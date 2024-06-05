$(function()
{
	AdminOrderDeliveryType.init();
});

var AdminOrderDeliveryType =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
	},

	//--------------------------------------------------------------------------------------------------------

	add: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminOrderDeliveryTypeAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminOrderDeliveryType.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/order-delivery-type/edit/" + data.orderDeliveryTypeId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminOrderDeliveryTypeEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminOrderDeliveryType.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function(data)
	{
		window.location.href = "/admin/order-delivery-type/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(orderDeliveryTypeId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данные типы доставки заказов?",
			"AdminOrderDeliveryType.deleteDo",
			orderDeliveryTypeId
		);
	},

	deleteDo: function(orderDeliveryTypeId)
	{
		var settings =
		{
			fileName: "/CAAdminOrderDeliveryTypeDelete/",
			parameters: { orderDeliveryTypeId: orderDeliveryTypeId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminOrderDeliveryType.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
