$(function()
{
	AdminDataColor.init();
});

var AdminDataColor =
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
			fileName: "/CAAdminDataColorAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminDataColor.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/data-color/" + data.dataSizeId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminDataColorEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminDataColor.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function(data)
	{
		window.location.href = "/admin/data-color/" + data.dataSizeId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(dataColorId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данный размер?",
			"AdminDataColor.deleteDo",
			dataColorId
		);
	},

	deleteDo: function(dataColorId)
	{
		var settings =
		{
			fileName: "/CAAdminDataColorDelete/",
			parameters: { dataColorId: dataColorId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminDataColor.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
