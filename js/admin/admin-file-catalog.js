$(function()
{
	AdminFileCatalog.init();
});

var AdminFileCatalog =
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
			fileName: "/CAAdminFileCatalogAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminFileCatalog.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/file/" + data.fileCatalogId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminFileCatalogEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminFileCatalog.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function(data)
	{
		window.location.href = "/admin/file/" + data.fileCatalogId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(fileCatalogId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данные каталоги?",
			"AdminFileCatalog.deleteDo",
			fileCatalogId
		);
	},

	deleteDo: function(fileCatalogId)
	{
		var settings =
		{
			fileName: "/CAAdminFileCatalogDelete/",
			parameters: { fileCatalogId: fileCatalogId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminFileCatalog.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
