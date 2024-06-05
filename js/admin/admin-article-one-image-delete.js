$(function()
{
	AdminArticleOneImageDelete.init();
});

var AdminArticleOneImageDelete =
{
	init: function()
	{
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(articleId, fieldName, imgSrc)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данное изображения статьи?",
			"AdminArticleOneImageDelete.deleteDo",
			{articleId: articleId, fieldName: fieldName, imgSrc: imgSrc}
		);
	},

	deleteDo: function(data)
	{
		var settings =
		{
			fileName: "/CAAdminArticleOneImageDelete/",
			parameters: { articleId: data.articleId, fieldName: data.fieldName, imgSrc: data.imgSrc },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminArticleOneImageDelete.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
