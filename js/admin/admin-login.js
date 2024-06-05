$(function()
{
	AdminLogin.init();
});

var AdminLogin =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		//Переводим фокус на инпут с логином для удобства ввода
		$("#id_email").focus();
	},

	//--------------------------------------------------------------------------------------------------------

	login: function(formP)
	{
		var settings =
		{
			fileName: "/CAAdminLogin/",
			parameters: { q: formP },
			messageType: "float",
			showOkMessage: false,
			okCallBackFn: "AdminLogin.login_ok"
		};
		AjaxRequest.send(settings);
	},

	login_ok: function(data)
	{
		window.location.href = "/";
	},

	//--------------------------------------------------------------------------------------------------------

	logout: function()
	{
		var settings =
		{
			fileName: "/CAAdminLogout/",
			showOkMessage: false,
			okCallBackFn: function(){window.location.reload(true);}
		};
		AjaxRequest.send(settings);
	}

	//--------------------------------------------------------------------------------------------------------
};
