$(function()
{
	Header.init();
});

var Header =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		Header.getMobileMenu();

		Header.initFixedHeader();
	},

	//--------------------------------------------------------------------------------------------------------

	getMobileMenu: function()
	{
		if (0 === $("#headerCD #mobileMenuBlock").length)
		{
			var settings =
			{
				fileName: "/CAGetMobileMenu/",
				parameters: { },
				messageType: {ok: "float", error: "alert"},
				showOkMessage: false,
				showErrorMessage: false,
				okCallBackFn: "Header.getMobileMenu_ok",
				nonBlockingCall: true
			};
			AjaxRequest.send(settings);
		}
	},

	getMobileMenu_ok: function(data)
	{
		//Выводим меню в шапке
		$("#headerCD").append(data.html);
	},

	//--------------------------------------------------------------------------------------------------------

	initFixedHeader: function()
	{
		//var fixedHeaderOffset = $("#fixedHeader").offset();
		//var contentCDOffset = $("#contentCD").offset();
		//var fixedHeaderHeight = $("#fixedHeader").outerHeight();

		//var top = fixedHeaderOffset.top;

		$(window).scroll(function()
		{
			var scrollTop = $(window).scrollTop();

			if (scrollTop > 0)
			{
				$("#headerCD").addClass("scroll");
			}
			else
			{
				$("#headerCD").removeClass("scroll");
			}
		});
	},

	//--------------------------------------------------------------------------------------------------------

	//Запускается при сабмите формы поиска
	search: function(fThis)
	{
		//Запускаем поиск, только в случае если введена поисковая фраза
		if($("input[name='searchString']", fThis).val() !== "")
		{
			this.ajaxSearch(fThis);
		}
	},

	//Поиск в форме фиксированной шапки
	ajaxSearch: function(fThis)
	{
		var settings =
		{
			fileName: "/CASearch/",
			parameters: { q: fThis },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "Header.ajaxSearch_ok",
		};
		AjaxRequest.send(settings);
	},

	ajaxSearch_ok: function(data)
	{
		if(data.redirectUrl !== "")
		{
			//редиректим на новую страницу
			window.location.href = data.redirectUrl;
		}
		else
		{
			//Редирект на страницу поиска
			window.location.href = "/search/?searchString=" + data.searchString;
		}
	}

	//--------------------------------------------------------------------------------------------------------

};
