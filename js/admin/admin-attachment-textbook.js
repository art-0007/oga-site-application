$(function()
{
	AdminAttachmentTextbook.init();
});

var AdminAttachmentTextbook =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
	},

	//--------------------------------------------------------------------------------------------------------

	attachment: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminAttachmentTextbook/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminAttachmentTextbook.attachment_ok",
		};
		AjaxRequest.send(settings);
	},

	attachment_ok: function(data)
	{
		window.parent.window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
