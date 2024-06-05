$(function()
{
	AdminData.init();
});

var AdminData =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		AdminFancyboxTinymce.initTinymce();
	},

	//--------------------------------------------------------------------------------------------------------

	generateArticle: function()
	{
		$("input[name='article']", ".editForm")
		.parent()
		.html("<input type='text' name='article' value='" + Func.getRandomNum(5) + "'>");
	},

	//--------------------------------------------------------------------------------------------------------

	add: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminDataAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminData.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/data/edit/" + data.dataId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminDataEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminData.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		window.location.href = "/admin/catalog/" + _catalogId + "/?dataId=" + _dataId;
		//window.location.reload(true);
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(dataId)
	{
		if ("undefined" == typeof(dataId))
  		{
			dataId = null;
  		}

		PopupMessage.confirm
		(
			"Вы действительно хотите удалить отмеченные товары?",
			"AdminData.deleteDo",
			dataId
		);
	},

	deleteDo: function(dataId)
	{
		if (null === dataId)
		{
			dataId = AdminHotEdit.getSelectedRowsIdArray("data");
		}

		var settings =
		{
			fileName: "/CAAdminDataDelete/",
			parameters: { dataId: dataId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminData.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	},

	//--------------------------------------------------------------------------------------------------------

	priceHotEdit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminDataEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminData.priceHotEdit_ok",
		};
		AjaxRequest.send(settings);
	},

	priceHotEdit_ok: function()
	{
		//window.location.reload(true);
	},

	//--------------------------------------------------------------------------------------------------------

	priceOldHotEdit: function(fThis)
	{
		var settings =
			{
				fileName: "/CAAdminDataEdit/",
				parameters: { q: fThis },
				messageType: "poupup",
				showOkMessage: false,
				showErrorMessage: true,
				okCallBackFn: "AdminData.priceOldHotEdit_ok",
			};
		AjaxRequest.send(settings);
	},

	priceOldHotEdit_ok: function(data)
	{
		if (data.html > 0)
		{
			$("a.price", "#catalogAndDataListBlock table tr[id='data-id-" + data.id + "']").addClass("button left");
		}
	},

	//--------------------------------------------------------------------------------------------------------

	quantityHotEdit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminDataEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminData.quantityHotEdit_ok",
		};
		AjaxRequest.send(settings);
	},

	quantityHotEdit_ok: function(data)
	{
		if (0 === data.quantity)
		{
			$("a.price", "#catalogAndDataListBlock table tr[id='data-id-" + data.id + "']").addClass("button left");
		}
		else
		{

		}
	},

	//--------------------------------------------------------------------------------------------------------

    //Отобразить / Скрыть каталог
	showOrHideData: function(dataId)
	{
       //Подгружаем информацию
		var settings =
		{
			fileName: "/CAAdminShowOrHideData/",
			parameters: { dataId: dataId },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminData.showOrHideData_ok"
		};
		AjaxRequest.send(settings);
	},

	showOrHideData_ok: function(data)
	{
        $("a.show", "#catalogAndDataListBlock table tr[id='data-id-" + data.dataId + "']")
        .removeClass("on")
        .removeClass("off")
        .addClass(data.addClass);
	},

	//--------------------------------------------------------------------------------------------------------

    //Есть в наличии / Нет в наличии
	availabilityData: function(dataId)
	{
       //Подгружаем информацию
		var settings =
		{
			fileName: "/CAAdminAvailabilityData/",
			parameters: { dataId: dataId },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminData.availabilityData_ok"
		};
		AjaxRequest.send(settings);
	},

	availabilityData_ok: function(data)
	{
        $("a.availability", "#catalogAndDataListBlock table tr[id='data-id-" + data.dataId + "']")
        .removeClass("yes")
        .removeClass("no")
        .addClass(data.addClass);
	},

	//--------------------------------------------------------------------------------------------------------

    //Метки товара
	dataMarkListFormLoad: function(dataId)
	{
       //Подгружаем информацию
		var settings =
		{
			fileName: "/CAAdminDataMarkListFormLoad/",
			parameters: { dataId: dataId },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminData.dataMarkListFormLoad_ok"
		};
		AjaxRequest.send(settings);
	},

	dataMarkListFormLoad_ok: function(data)
	{
		//Удаляем html отвата
		$("#dataMarkListFormLoadPopupMessageOk").remove();
		//Вставляем форму отвата в тело сайта
		$("body").append(data.html);

        AdminData.dataMarkListFormLoadPopupMessageOk = $("#dataMarkListFormLoadPopupMessageOk").JEOverlay(
		{
			siteMinWidth: 600,
			//marginTop: 80,
			speed: 0,
			position: "fixed",
			closeOnEscape: true,
			zIndex: 9998,//Должен быть на две единицы больше чем при инициализации плагина для всплывающей формы, чтобы сообщения выводились поверх всплывающей формы
			bgSettings:
			{
				bgColor: '#000000',
				opacity: 0.8
			}
		});

		//Отображаем ответ
		AdminData.dataMarkListFormLoadPopupMessageOk.load();
		//Очищаем форму
		//$("#downloadQuestionnaireForm")[0].reset();
	},

	//--------------------------------------------------------------------------------------------------------

    //Метки товара
	setDataMark: function(dataId)
	{
       //Подгружаем информацию
		var settings =
		{
			fileName: "/CAAdminSetDataMark/",
			parameters: { dataId: dataId },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminData.setMarkData_ok"
		};
		AjaxRequest.send(settings);
	},

	setMarkData_ok: function(data)
	{
        AdminData.dataMarkListFormLoadPopupMessageOk.close();
	},

	//--------------------------------------------------------------------------------------------------------

    //Установить старую цену текущей
	setOldPriceOfCurrentData: function(dataId)
	{
        var oldPrice =  $("input[name='priceOld']", "#catalogAndDataListBlock table tr[id='data-id-" + dataId + "']").val();
        
        if (oldPrice <= 0)
        {
            return;
        }

		var settings =
		{
			fileName: "/CAAdminDataEdit/",
			parameters: { hotEditKey: true, id: dataId, price: oldPrice, priceOld: 0 },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true
		};
		AjaxRequest.send(settings);

        $("input[name='price']", "#catalogAndDataListBlock table tr[id='data-id-" + dataId + "']").val(oldPrice);
        $("input[name='priceOld']", "#catalogAndDataListBlock table tr[id='data-id-" + dataId + "']").val(0);

        //$("form.priceHotEditForm", "#catalogAndDataListBlock table tr[id='data-id-" + dataId + "']").submit();
        //$("form.priceOldHotEditForm", "#catalogAndDataListBlock table tr[id='data-id-" + dataId + "']").submit();

        $("a.price", "#catalogAndDataListBlock table tr[id='data-id-" + dataId + "']")
        .removeClass("button")
        .removeClass("left");
	}

	//--------------------------------------------------------------------------------------------------------
};
