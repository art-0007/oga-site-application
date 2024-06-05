$(function()
{
	AdminSliderImageCatalog.init();
});

var AdminSliderImageCatalog =
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
			fileName: "/CAAdminSliderImageCatalogAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminSliderImageCatalog.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/slider-image-catalog/edit/" + data.sliderImageCatalogId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminSliderImageCatalogEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminSliderImageCatalog.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function(data)
	{
		window.location.href = "/admin/slider-image/" + data.sliderImageCatalogId;
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(sliderImageCatalogId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данные каталоги?",
			"AdminSliderImageCatalog.deleteDo",
			sliderImageCatalogId
		);
	},

	deleteDo: function(sliderImageCatalogId)
	{
		var settings =
		{
			fileName: "/CAAdminSliderImageCatalogDelete/",
			parameters: { sliderImageCatalogId: sliderImageCatalogId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminSliderImageCatalog.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
