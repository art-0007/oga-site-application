$(function()
{
	AdminLangList.init();
});

var AdminLangList =
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
			fileName: "/CAAdminLangAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminLangList.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/lang/edit/" + data.langId + "/"
		//window.parent.window.location.reload(true);
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminLangEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminLangList.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		window.location.href = "/admin/lang/list/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(langId)
	{
		if ("undefined" == typeof(langId))
  		{
			langId = null;
  		}

		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данныq язык?",
			"AdminLangList.deleteDo",
			langId
		);
	},

	deleteDo: function(langId)
	{
		if (null === langId)
		{
			langId = AdminHotEdit.getSelectedRowsIdArray("lang");
		}

		var settings =
		{
			fileName: "/CAAdminLangDelete/",
			parameters: { langId: langId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminLangList.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
