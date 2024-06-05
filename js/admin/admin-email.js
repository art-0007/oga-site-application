$(function()
{
	AdminEmail.init();
});

var AdminEmail =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(emailId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данное письмо?",
			"AdminEmail.deleteDo",
			emailId
		);
	},

	deleteDo: function(emailId)
	{
		var settings =
		{
			fileName: "/CAAdminEmailDelete/",
			parameters: { emailId: emailId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminEmail.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
