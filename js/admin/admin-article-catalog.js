$(function()
{
	AdminArticleCatalog.init();
});

var AdminArticleCatalog =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		AdminFancyboxTinymce.initTinymce();
	},

	//--------------------------------------------------------------------------------------------------------

	showAndHide: function(fThis)
	{
		if ($("#" + fThis).hasClass("hide"))
		{
			$("#" + fThis)
			.removeClass("hide")
			.addClass("show");
		}
		else
		{
			$("#" + fThis)
			.removeClass("show")
			.addClass("hide");
		}
	},

	//--------------------------------------------------------------------------------------------------------

	add: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminArticleCatalogAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminArticleCatalog.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/article-catalog/edit/" + data.articleCatalogId + "/";
		//window.parent.window.location.reload(true);
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminArticleCatalogEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminArticleCatalog.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function(data)
	{
		window.location.href = "/admin/article/" + _parentArticleCatalogId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(articleCatalogId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данные каталоги?",
			"AdminArticleCatalog.deleteDo",
			articleCatalogId
		);
	},

	deleteDo: function(articleCatalogId)
	{
		var settings =
		{
			fileName: "/CAAdminArticleCatalogDelete/",
			parameters: { articleCatalogId: articleCatalogId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminArticleCatalog.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
