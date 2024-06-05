$(function()
{
	AdminOnlinePaySystemList.init();
});

var AdminOnlinePaySystemList =
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
			fileName: "/CAAdminOnlinePaySystemEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminOnlinePaySystemList.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		window.location.href = "/admin/online-pay-system/list/";
	}

	//--------------------------------------------------------------------------------------------------------
};
