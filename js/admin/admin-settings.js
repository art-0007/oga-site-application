$(function()
{
	AdminSettings.init();
});

var AdminSettings =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminSettingsEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminSettings.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
