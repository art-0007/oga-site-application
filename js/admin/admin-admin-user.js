$(function()
{
	AdminAdminUser.init();
});

var AdminAdminUser =
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
			fileName: "/CAAdminAdminUserAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminAdminUser.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function()
	{
		window.location.href = "/admin/admin-user/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminAdminUserEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminAdminUser.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		window.location.href = "/admin/admin-user/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(adminUserId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данных поользователей админ паренели?",
			"AdminAdminUser.deleteDo",
			adminUserId
		);
	},

	deleteDo: function(adminUserId)
	{
		var settings =
		{
			fileName: "/CAAdminAdminUserDelete/",
			parameters: { adminUserId: adminUserId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminAdminUser.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
