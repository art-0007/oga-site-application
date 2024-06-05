$(function()
{
	AdminUser.init();
});

var AdminUser =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
	},

	//--------------------------------------------------------------------------------------------------------

	generatePassword: function()
	{
		$("input[name='password']", ".editForm")
		.parent()
		.html("<input type='text' name='password' value='" + Func.getRandomString(10) + "'>");
	},

	//--------------------------------------------------------------------------------------------------------

	add: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminUserAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminUser.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/user/edit/" + data.userId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminUserEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminUser.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		window.location.href = "/admin/user/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(userId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данных покупателей?",
			"AdminUser.deleteDo",
			userId
		);
	},

	deleteDo: function(userId)
	{
		var settings =
		{
			fileName: "/CAAdminUserDelete/",
			parameters: { userId: userId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminUser.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
