$(function()
{
	AdminAttachmentDocuments.init();
});

var AdminAttachmentDocuments =
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
			fileName: "/CAAdminAttachmentDocuments/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminAttachmentDocuments.attachment_ok",
		};
		AjaxRequest.send(settings);
	},

	attachment_ok: function(data)
	{
		window.parent.window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
