$(function()
{
	AdminOrderPayType.init();
});

var AdminOrderPayType =
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
			fileName: "/CAAdminOrderPayTypeAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminOrderPayType.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/order-pay-type/edit/" + data.orderPayTypeId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminOrderPayTypeEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminOrderPayType.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function(data)
	{
		window.location.href = "/admin/order-pay-type/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(orderPayTypeId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данные типы оплаты заказов?",
			"AdminOrderPayType.deleteDo",
			orderPayTypeId
		);
	},

	deleteDo: function(orderPayTypeId)
	{
		var settings =
		{
			fileName: "/CAAdminOrderPayTypeDelete/",
			parameters: { orderPayTypeId: orderPayTypeId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminOrderPayType.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
