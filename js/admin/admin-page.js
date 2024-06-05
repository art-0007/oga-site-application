$(function()
{
	AdminPage.init();
});

var AdminPage =
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
			fileName: "/CAAdminPageAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminPage.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/page/edit/" + data.pageId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminPageEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminPage.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		//window.location.reload(true);
		window.location.href = "/admin/page/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(pageId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данную статическую страницу?",
			"AdminPage.deleteDo",
			pageId
		);
	},

	deleteDo: function(pageId)
	{
		var settings =
		{
			fileName: "/CAAdminPageDelete/",
			parameters: { pageId: pageId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminPage.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
