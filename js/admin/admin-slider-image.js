$(function()
{
	AdminSliderImage.init();
});

var AdminSliderImage =
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
			fileName: "/CAAdminSliderImageAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminSliderImage.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/slider-image/edit/" + data.sliderImageId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminSliderImageEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminSliderImage.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function(data)
	{
		window.location.href = "/admin/slider-image/" + data.sliderImageCatalogId;
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(sliderImageId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данное изображения слайдера?",
			"AdminSliderImage.deleteDo",
			sliderImageId
		);
	},

	deleteDo: function(sliderImageId)
	{
		var settings =
		{
			fileName: "/CAAdminSliderImageDelete/",
			parameters: { sliderImageId: sliderImageId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminSliderImage.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
