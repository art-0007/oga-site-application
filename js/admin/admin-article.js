$(function()
{
	AdminArticle.init();
});

var AdminArticle =
{
	//--------------------------------------------------------------------------------------------------------

	defaultColor: "#1D1D1D",

	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		AdminFancyboxTinymce.initTinymce();

		//Инициализация плагинов дат и времен
		this.initDateTimePickers();

		this.initColorPickers(".colorSelector.colorHex", "colorHex");
	},

	//--------------------------------------------------------------------------------------------------------

	setInTextarea: function(title, selector)
	{
		var text = $(selector).val();

		text = text + "\r\n" + title;

		$(selector).val(text);
	},

	//--------------------------------------------------------------------------------------------------------

	//Инициализация плагинов дат и времен
	initDateTimePickers: function()
	{
		$(".datepicker").each(function(){
			$(this).datepicker({
				altField: '#actualDate',
				dateFormat: 'yy-mm-dd',
				duration: 'fast',
				showMonthAfterYear: false,
				changeMonth: true,
				changeYear: true
			});
		});
		$(".timepicker").each(function(){
			$(this).timepicker({
				timeOnlyTitle: 'Выберите время',
				timeText: 'Время',
				hourText: 'Часы',
				minuteText: 'Минуты',
				secondText: 'Секунды',
				currentText: 'Теперь',
				closeText: 'Закрыть'
			});
		});
	},

	//--------------------------------------------------------------------------------------------------------

	initColorPickers: function(selector, inputName)
	{
		$(selector).ColorPicker(
		{
			color: AdminArticle.defaultColor,
			onSubmit: function (hsb, hex, rgb, colpkr)
			{
				$(colpkr).ColorPickerHide();
			},
			onShow: function (colpkr)
			{
				$(colpkr).fadeIn(100);
				return false;
			},
			onHide: function (colpkr)
			{
				$(colpkr).fadeOut(100);
				return false;
			},
			onChange: function (hsb, hex, rgb)
			{
				$(selector + " div").css('backgroundColor', '#' + hex);
				$("[name='" + inputName + "']").val("#" + hex);
			}
		});
	},

	//--------------------------------------------------------------------------------------------------------

	add: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminArticleAdd/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminArticle.add_ok",
		};
		AjaxRequest.send(settings);
	},

	add_ok: function(data)
	{
		window.location.href = "/admin/article/edit/" + data.articleId + "/"
		//window.parent.window.location.reload(true);
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminArticleEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminArticle.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		window.location.href = "/admin/article/" + _articleCatalogId + "/";
	},

	//--------------------------------------------------------------------------------------------------------

	deleteConfirm: function(articleId)
	{
		if ("undefined" == typeof(articleId))
  		{
			articleId = null;
  		}

		PopupMessage.confirm
		(
			"Вы действительно хотите удалить данные статьи?",
			"AdminArticle.deleteDo",
			articleId
		);
	},

	deleteDo: function(articleId)
	{
		if (null === articleId)
		{
			articleId = AdminHotEdit.getSelectedRowsIdArray("article");
		}

		var settings =
		{
			fileName: "/CAAdminArticleDelete/",
			parameters: { articleId: articleId },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "AdminArticle.deleteDo_ok"
		};
		AjaxRequest.send(settings);
	},

	deleteDo_ok: function(data)
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
