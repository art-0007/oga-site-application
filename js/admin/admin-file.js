$(function()
{
	AdminFile.init();
});

var AdminFile =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
	},

	//--------------------------------------------------------------------------------------------------------

	addInToolbar: function(fThis)
	{
		$(fThis).parents("form").find("input[type='file']").click();
	},

	//--------------------------------------------------------------------------------------------------------

	change: function(fThis)
	{
		$(fThis).parents("form").submit();
	},

	//--------------------------------------------------------------------------------------------------------

	isertImage_inRichTextEditor: function(filePath)
	{
		if ("undefined" == typeof(window.parent.tinymce.activeEditor))
		{
			alert("Ошибка работы RichTextEditor");
			return;
		}

		window.parent.tinymce.activeEditor.insertContent("<img src='" + filePath + "'>");
		window.parent.tinymce.activeEditor.windowManager.close();
	},

	//--------------------------------------------------------------------------------------------------------

	isertFile_inRichTextEditor: function(name, nameOriginal)
	{
		if ("undefined" == typeof(window.parent.tinymce.activeEditor))
		{
			alert("Ошибка работы RichTextEditor");
			return;
		}

		window.parent.tinymce.activeEditor.insertContent("<a href='/download/?fileName=" + name + "'>" + nameOriginal + "</a>");
		window.parent.tinymce.activeEditor.windowManager.close();
	},

	//--------------------------------------------------------------------------------------------------------

	add: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminFileAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminFile.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/file/" + data.fileCatalogId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(fileId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данные файлы?",
			"AdminFile.deleteDo",
			fileId
		);
	},

	deleteDo: function(fileId)
	{
		var settings =
		{
			fileName: "/CAAdminFileDelete/",
			parameters: { fileId: fileId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminFile.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
