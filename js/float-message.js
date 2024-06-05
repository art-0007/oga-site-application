$(function(){
	FloatMessage.init();
});

var FloatMessage =
{
	//--------------------------------------------------------------------------------------------------------

	closeTimeoutHandler: null,

	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		//Добавляем html плавающего сообщения в DOM
		FloatMessage.addHtmlToDOM();

		//Вешаем обработчики событий
		FloatMessage.initEvents();
	},

	//--------------------------------------------------------------------------------------------------------

	initAllMessages: function(message, autoCloseKey)
	{
		var textSelector = ".floatMessage .text";

		//Отключаем таймер
		if (FloatMessage.closeTimeoutHandler !== null) clearTimeout(FloatMessage.closeTimeoutHandler);

		$(".floatMessage").hide(0, function(){
			$(textSelector).empty();
			$(textSelector).html(message);

			FloatMessage.show();

			if (true === autoCloseKey)
				FloatMessage.closeTimeoutHandler = setTimeout(FloatMessage.hide, 5000);
		});
	},

	//--------------------------------------------------------------------------------------------------------

	ok: function(message)
	{
		//Удаляем ненужные и ставим нужный класс для сообщения
		$(".floatMessage")
		.removeClass("error")
		.addClass("ok");

		//Запускаем функцию инициализации общих для всех сообщений данных
		FloatMessage.initAllMessages(message, true);
	},

	//--------------------------------------------------------------------------------------------------------

	error: function(message)
	{
		//Удаляем ненужные и ставим нужный класс для сообщения
		$(".floatMessage")
		.removeClass("ok")
		.addClass("error");

		//Запускаем функцию инициализации общих для всех сообщений данных
		FloatMessage.initAllMessages(message, false);
	},

	//--------------------------------------------------------------------------------------------------------

	//Добавляет html всплывающего сообщения в DOM
	addHtmlToDOM: function()
	{
		$("body").append('<div class="floatMessage"><div class="closeButton"><div title="Закрыть" class="sprite sprite-float-message-close"></div></div><div class="text">TEXT</div></div>')
	},

	//--------------------------------------------------------------------------------------------------------

	//Вешаем обработчики событий
	initEvents: function()
	{
		//Вешаем событие закрытия плавающего сообщения
		$(".floatMessage .closeButton > div")
		.unbind("click")
		.bind("click", function(){

			//Отключаем таймер
			if (FloatMessage.closeTimeoutHandler !== null) clearTimeout(FloatMessage.closeTimeoutHandler);

			FloatMessage.hide();
		});
	},

	//--------------------------------------------------------------------------------------------------------

	show: function()
	{
		//Расчет положения сообщения

		var messageWidth = $(".floatMessage").width();
		var windowWidth = $(window).width();
		var left = (windowWidth - messageWidth) / 2;
		$(".floatMessage").css("left", left);

		var top = $(".floatMessage").height();
		$(".floatMessage").css("top", -1*top);

		$(".floatMessage").css("display", "block");

		$(".floatMessage").animate({"top": "+=" + top});
	},

	//--------------------------------------------------------------------------------------------------------

	hide: function()
	{
		$(".floatMessage").hide();
	}

	//--------------------------------------------------------------------------------------------------------
};
