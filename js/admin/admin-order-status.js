$(function()
{
	AdminOrderStatus.init();
});

var AdminOrderStatus =
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
			fileName: "/CAAdminOrderStatusAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminOrderStatus.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/order-status/edit/" + data.orderStatusId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminOrderStatusEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminOrderStatus.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function(data)
	{
		window.location.href = "/admin/order-status/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(orderStatusId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данные статусы?",
			"AdminOrderStatus.deleteDo",
			orderStatusId
		);
	},

	deleteDo: function(orderStatusId)
	{
		var settings =
		{
			fileName: "/CAAdminOrderStatusDelete/",
			parameters: { orderStatusId: orderStatusId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminOrderStatus.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
