$(function()
{
	AdminBrand.init();
});

var AdminBrand =
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
			fileName: "/CAAdminBrandAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminBrand.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/brand/edit/" + data.brandId + "/";	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminBrandEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminBrand.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		window.parent.window.location.reload(true);
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(brandId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данный бренд?",
			"AdminBrand.deleteDo",
			brandId
		);
	},

	deleteDo: function(brandId)
	{
		var settings =
		{
			fileName: "/CAAdminBrandDelete/",
			parameters: { brandId: brandId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminBrand.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.parent.window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
