$(function()
{
	AdminCatalog.init();
});

var AdminCatalog =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		AdminFancyboxTinymce.initTinymce();

        if ("CAdminCatalog" == _router && "undefined" != typeof(_catalogId) && _catalogId > 0)
        {
    		var dataId = 0;

            if ("undefined" != typeof(_dataId))
            {
        		dataId = _dataId;
            }

            this.showAndHideContent(_catalogId, dataId);
        }
	},

	//--------------------------------------------------------------------------------------------------------

	add: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminCatalogAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminCatalog.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/catalog/edit/" + data.catalogId + "/";
    },

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminCatalogEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminCatalog.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		window.location.href = "/admin/catalog/" + _parentCatalogId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(catalogId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данный каталог?",
			"AdminCatalog.deleteDo",
			catalogId
		);
	},

	deleteDo: function(catalogId)
	{
		var settings =
		{
			fileName: "/CAAdminCatalogDelete/",
			parameters: { catalogId: catalogId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminCatalog.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	},

	//--------------------------------------------------------------------------------------------------------

    //Отобразить / Скрыть каталог
	showOrHideCatalog: function(catalogId)
	{
       //Подгружаем информацию
		var settings =
		{
			fileName: "/CAAdminShowOrHideCatalog/",
			parameters: { catalogId: catalogId },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminCatalog.showOrHideCatalog_ok"
		};
		AjaxRequest.send(settings);
	},

	showOrHideCatalog_ok: function(data)
	{
        $("a.show", "#catalogAndDataListBlock table tr[id='" + data.catalogId + "']")
        .removeClass("on")
        .removeClass("off")
        .addClass(data.addClass);
	},

	//--------------------------------------------------------------------------------------------------------

    //Добавляем или удаляем блок с содержимым каталога
	showAndHideContent: function(catalogId, dataId)
	{
		//Данные о посещении
		dataId = dataId || 0;

	   //Удаляем
	   if ($("tr[id='catalog-content-" + catalogId + "']", "#catalogAndDataListBlock").hasClass("active"))
       {
            $("tr[id='" + catalogId + "']", "#catalogAndDataListBlock").removeClass("active");
            $("tr[id='data-id-" + dataId + "']", "#catalogAndDataListBlock").removeClass("active");

            $("tr[id='catalog-content-" + catalogId + "']", "#catalogAndDataListBlock")
            .removeClass("active")
            .slideUp("slow", function()
            {
                $("tr[id='catalog-content-" + catalogId + "'] td.dataList", "#catalogAndDataListBlock").empty();
            });

            return;
       }

       //Подгружаем информацию
		var settings =
		{
			fileName: "/CAAdminCatalogShowContent/",
			parameters: { catalogId: catalogId, dataId: dataId },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminCatalog.showAndHideContent_ok"
		};
		AjaxRequest.send(settings);
	},

	showAndHideContent_ok: function(data)
	{
		$("tr[id='catalog-content-" + data.catalogId + "'] td.dataList", "#catalogAndDataListBlock")
        .html(data.html)
        .parents("tr[id='catalog-content-" + data.catalogId + "']")
        .addClass("active")
        .slideDown("slow");

        $("tr[id='" + data.catalogId + "']", "#catalogAndDataListBlock").addClass("active");
        $("tr[id='data-id-" + data.dataId + "']", "#catalogAndDataListBlock").addClass("active");
	}

	//--------------------------------------------------------------------------------------------------------
};
