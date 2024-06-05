$(function()
{
	AdminStaticHtml.init();
});

var AdminStaticHtml =
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
			fileName: "/CAAdminStaticHtmlAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminStaticHtml.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function()
	{
		window.location.href = "/admin/static-html/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminStaticHtmlEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminStaticHtml.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		window.location.href = "/admin/static-html/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(staticHtmlId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данный статический html?",
			"AdminStaticHtml.deleteDo",
			staticHtmlId
		);
	},

	deleteDo: function(staticHtmlId)
	{
		var settings =
		{
			fileName: "/CAAdminStaticHtmlDelete/",
			parameters: { staticHtmlId: staticHtmlId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminStaticHtml.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
