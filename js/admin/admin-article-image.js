$(function()
{
	AdminArticleImage.init();
});

var AdminArticleImage =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		AdminFancyboxTinymce.initTinymce();
	},

	//--------------------------------------------------------------------------------------------------------

	add: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminArticleImageAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminArticleImage.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/article-image/" + data.articleId;
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminArticleImageEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminArticleImage.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function(data)
	{
		window.location.href = "/admin/article-image/" + data.articleId;
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(articleImageId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данное изображения статьи?",
			"AdminArticleImage.deleteDo",
			articleImageId
		);
	},

	deleteDo: function(articleImageId)
	{
		var settings =
		{
			fileName: "/CAAdminArticleImageDelete/",
			parameters: { articleImageId: articleImageId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminArticleImage.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
