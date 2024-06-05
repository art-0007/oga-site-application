$(function()
{
	AdminDataSize.init();
});

var AdminDataSize =
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
			fileName: "/CAAdminDataSizeAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminDataSize.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/data-size/" + data.dataId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminDataSizeEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminDataSize.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function(data)
	{
		window.location.href = "/admin/data-size/" + data.dataId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(dataSizeId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данный размер?",
			"AdminDataSize.deleteDo",
			dataSizeId
		);
	},

	deleteDo: function(dataSizeId)
	{
		var settings =
		{
			fileName: "/CAAdminDataSizeDelete/",
			parameters: { dataSizeId: dataSizeId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminDataSize.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
