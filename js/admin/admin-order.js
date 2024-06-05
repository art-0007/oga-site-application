$(function()
{
	AdminOrder.init();
});

var AdminOrder =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		AdminFancyboxTinymce.initTinymce();
	},

	//--------------------------------------------------------------------------------------------------------

	add: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminOrderAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminOrder.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.reload(true);
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminOrderEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminOrder.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		//window.location.href = "/admin/order/";
		window.location.reload(true);
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(orderId)
	{
		if ("undefined" == typeof(orderId))
  		{
			orderId = null;
  		}

		PopupMessage.confirm
		(
			"Вы действительно хотите удалить выбранные заказы?",
			"AdminOrder.deleteDo",
			orderId
		);
	},

	deleteDo: function(orderId)
	{
		if (null === orderId)
		{
			orderId = AdminHotEdit.getSelectedRowsIdArray("order");
		}

		var settings =
		{
			fileName: "/CAAdminOrderDelete/",
			parameters: { orderId: orderId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminOrder.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
