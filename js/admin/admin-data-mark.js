$(function()
{
	AdminDataMark.init();
});

var AdminDataMark =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		AdminFancyboxTinymce.initTinymce();

		this.initEevents();
	},

	//--------------------------------------------------------------------------------------------------------

	initEevents: function()
	{
		//Инициализируем событие клика на радиобаттонах позиций изображения на изображении товара

		$(".editForm input[name='dataImagePosition']")
		.unbind("click")
		.bind("click", function(){
			AdminDataMark.selectDataImagePosition($(this).val());
		});

		//--------------------------------------------------------------------------

		//Инициализируем событие клика на чекбоксе "Использовать как изображение на товаре (воблер)", что разворачивает или сворачивает зависимый html блок
		$(".editForm input[name='dataImageKey']")
		.unbind("click")
		.bind("click", function(){
			if ($(this).prop("checked"))
			{
				$(".editForm #dataImageKey_div").slideDown(500);
			}
			else
			{
				$(".editForm #dataImageKey_div").slideUp(500);
			}
		});
	},

	//--------------------------------------------------------------------------------------------------------

	add: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminDataMarkAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminDataMark.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/data-mark/edit/" + data.dataMarkId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminDataMarkEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminDataMark.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function(data)
	{
		window.location.href = "/admin/data-mark/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(dataMarkId)
	{
		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данные метки?",
			"AdminDataMark.deleteDo",
			dataMarkId
		);
	},

	deleteDo: function(dataMarkId)
	{
		var settings =
		{
			fileName: "/CAAdminDataMarkDelete/",
			parameters: { dataMarkId: dataMarkId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminDataMark.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	},

	//--------------------------------------------------------------------------------------------------------

	showOrHideDataMarkOnIndex: function(dataMarkId)
	{
       //Подгружаем информацию
		var settings =
		{
			fileName: "/CAAdminShowOrHideDataMarkOnIndex/",
			parameters: { dataMarkId: dataMarkId },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminDataMark.showOrHideDataMarkOnIndex_ok"
		};
		AjaxRequest.send(settings);
	},

	showOrHideDataMarkOnIndex_ok: function(data)
	{
        $("a.show", "#dataMarkListBlock table tr[id='data-mark-id-" + data.dataMarkId + "']")
        .removeClass("on")
        .removeClass("off")
        .addClass(data.addClass);
	},

	//--------------------------------------------------------------------------------------------------------

	deselectAllDataImagePosition: function()
	{
		$(".editForm input[name='dataImagePosition']").each(function(){
			$(this)
			.parent()
			.removeClass("dataMarkDataImagePostion_selected");
		});
	},

	//--------------------------------------------------------------------------------------------------------

	selectDataImagePosition: function(position)
	{
		AdminDataMark.deselectAllDataImagePosition();

		$(".editForm input[name='dataImagePosition'][value='" + position + "']")
		.prop("checked", true)
		.parent()
		.addClass("dataMarkDataImagePostion_selected");
	}

	//--------------------------------------------------------------------------------------------------------
};
