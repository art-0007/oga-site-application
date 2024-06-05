$(function(){
	AdminPanel.init();
});

var AdminPanel =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		var heightAdminPanel = $(".adminPanelCarrier_div").outerHeight();
		//var heightHeader = $("header.headerCD").outerHeight();

		$(".headerCD").css("margin-top", heightAdminPanel + "px");
		$(".headerCD .fixedHeader").attr("data-top", heightAdminPanel + "px");
	},

	//--------------------------------------------------------------------------------------------------------

	logout: function()
	{
		var settings =
		{
			fileName: "/CAAdminLogout/",
			showOkMessage: false,
			okCallBackFn: function(){window.location.reload(true);}
		};
		AjaxRequest.send(settings);
	},

	//--------------------------------------------------------------------------------------------------------

	setCatalogInfo_inAdminPanel: function(catalogId)
	{
		var title = $("[data-admin-val='" + catalogId + "-input-title-2']").html();

		//Каталог

		$("a.add.catalog", ".adminPanelCarrier_div .topMenu")
		.attr("onclick", "AdminFancyboxPage.show('/admin/catalog/add/" + catalogId + "/');")
		.attr("title", 'Добавить новый каталог в каталог "' + title + '"');

		$("a.edit.catalog", ".adminPanelCarrier_div .topMenu")
		.attr("onclick", "AdminFancyboxPage.show('/admin/catalog/edit/" + catalogId + "/');")
		.attr("title", 'Редактировать каталог "' + title + '"');

		$("a.delete.catalog", ".adminPanelCarrier_div .topMenu")
		.attr("onclick", "AdminCatalog.deleteConfirm(" + catalogId + ");")
		.attr("title", 'Удалить каталог "' + title + '"');

		//Товар

		$("a.add.data", ".adminPanelCarrier_div .topMenu")
		.attr("onclick", "AdminFancyboxPage.show('/admin/data/add/" + catalogId + "/');")
		.attr("title", 'Добавить товар в каталог "' + title + '"');
	}

	//--------------------------------------------------------------------------------------------------------
};
