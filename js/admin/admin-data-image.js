$(function()
{
	AdminDataImage.init();
});

var AdminDataImage =
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
			fileName: "/CAAdminDataImageAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminDataImage.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/data-image/" + data.dataId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminDataImageEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminDataImage.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function(data)
	{
		window.location.href = "/admin/data-image/" + data.dataId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(dataImageId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данное изображение?",
			"AdminDataImage.deleteDo",
			dataImageId
		);
	},

	deleteDo: function(dataImageId)
	{
		var settings =
		{
			fileName: "/CAAdminDataImageDelete/",
			parameters: { dataImageId: dataImageId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminDataImage.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
