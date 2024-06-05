$(function(){
	PopupMessage.init();
});

var PopupMessage =
{
	//--------------------------------------------------------------------------------------------------------

	jeOverlay: null,
	lastMessageType: null,

	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		//Добавляем html всплывающего сообщения в DOM
		PopupMessage.addHtmlToDOM();

		//Инициализируем плагин JEOverlay
		PopupMessage.initJEOverlay();
	},

	//--------------------------------------------------------------------------------------------------------

	initAllMessages: function(message, okCallBackFn, okCallBackFnArgument)
	{
		var buttonOkSelector = ".popupMessage #id_buttonOk";
		var textSelector = ".popupMessage .text";

		$(textSelector).empty();
		$(textSelector).html(message);

		$(buttonOkSelector).unbind("click");

		if ("undefined" == typeof(okCallBackFn))
		{
			//Вешаем обработчик события клика на кнопе ОК
			$(buttonOkSelector).bind("click", function(){PopupMessage.hide();});
		}
		else
		{
			//Если okCallBackFn это строка, то работаем через функцию setTimeout
			if ("string" == typeof(okCallBackFn))
			{
				//Вешаем обработчик события клика на кнопе ОК
				$(buttonOkSelector).bind("click", function()
				{
					PopupMessage.hide();

					//Проверяем есть ли аргумент, который мы передадим в запускаемую функцию
					if ("undefined" == typeof(okCallBackFnArgument))
					{
						setTimeout(okCallBackFn + "()", 0);
					}
					else
					{
						setTimeout(okCallBackFn + "(" + Func.toJSON(okCallBackFnArgument) + ")", 0);
					}
				});
			}
			else
			{
				//Если okCallBackFn это строка, то работаем через обычный синтаксис работы с JS функциями
				if ("function" == typeof(okCallBackFn))
				{
					//Вешаем обработчик события клика на кнопе ОК
					$(buttonOkSelector).bind("click", function()
					{
						PopupMessage.hide();

						//Проверяем есть ли аргумент, который мы передадим в запускаемую функцию
						if ("undefined" == typeof(okCallBackFnArgument))
						{
							okCallBackFn();
						}
						else
						{
							okCallBackFn(okCallBackFnArgument);
						}
					});
				}
				else
				{
					Func.fatalMessage("Аргумент okCallBackFn должен иметь тип string или function [" + typeof(okCallBackFn) + "]");
					return;
				}
			}
		}

		PopupMessage.show();
	},

	//--------------------------------------------------------------------------------------------------------

	ok: function(message, okCallBackFn, okCallBackFnArgument)
	{
		PopupMessage.lastMessageType = "ok";

		//Инициализируем панель кнопок характерную для Ok
		$(".popupMessage .buttons").html('<button class="button" id="id_buttonOk">OK</button>');

		//Удаляем ненужные и ставим нужный класс для сообщения
		$(".popupMessage .image")
		.removeClass("sprite-popup-message-error")
		.removeClass("sprite-popup-message-confirm")
		.addClass("sprite-popup-message-ok");

		//Запускаем функцию инициализации общих для всех сообщений данных
		PopupMessage.initAllMessages(message, okCallBackFn, okCallBackFnArgument);
	},

	//--------------------------------------------------------------------------------------------------------

	error: function(message, okCallBackFn, okCallBackFnArgument)
	{
		PopupMessage.lastMessageType = "error";

		//Инициализируем панель кнопок характерную для Error
		$(".popupMessage .buttons").html('<button class="button" id="id_buttonOk">OK</button>');

		//Удаляем ненужные и ставим нужный класс для сообщения
		$(".popupMessage .image")
		.removeClass("sprite-popup-message-ok")
		.removeClass("sprite-popup-message-confirm")
		.addClass("sprite-popup-message-error");

		//Запускаем функцию инициализации общих для всех сообщений данных
		PopupMessage.initAllMessages(message, okCallBackFn, okCallBackFnArgument);
	},

	//--------------------------------------------------------------------------------------------------------

	confirm: function(message, okCallBackFn, okCallBackFnArgument)
	{
		PopupMessage.lastMessageType = "confirm";

		//Инициализируем панель кнопок характерную для Confirm
		$(".popupMessage .buttons").html('<button class="button" id="id_buttonOk">Да</button><button class="button2" style="margin-left: 10px;" onclick="PopupMessage.hide();">Отмена</button>');

		//Удаляем ненужные и ставим нужный класс для сообщения
		$(".popupMessage .image")
		.removeClass("sprite-popup-message-ok")
		.removeClass("sprite-popup-message-error")
		.addClass("sprite-popup-message-confirm");

		//Запускаем функцию инициализации общих для всех сообщений данных
		PopupMessage.initAllMessages(message, okCallBackFn, okCallBackFnArgument);
	},

	//--------------------------------------------------------------------------------------------------------

	custom: function(message, type, buttonsArray)
	{
		PopupMessage.lastMessageType = type;

		//[1] Формируем html кнопок

		var buttonsHtml = "";

		for (var index in buttonsArray)
		{
			var b = buttonsArray[index];

			//Если указан параметр html, то игрнорируем все остальные параметры
			if ("string" == typeof(b.html))
			{
				buttonsHtml = buttonsHtml + b.html;
			}
			else
			{
				buttonsHtml = buttonsHtml + "<button id='popupMessage_customButton_" + index + "' class='" + b.className + "'>" + b.text + "</button>";
			}
		}

		//Инициализируем панель кнопок характерную для Ok
		$(".popupMessage .buttons").html(buttonsHtml);

		//[2] Удаляем ненужные и ставим нужный класс для сообщения
		$(".popupMessage .image")
		.removeClass("sprite-popup-message-error")
		.removeClass("sprite-popup-message-confirm")
		.removeClass("sprite-popup-message-ok")
		.addClass("sprite-popup-message-" + type);

		//[3] Устанавливаем текст сообщения

		var textSelector = ".popupMessage .text";
		$(textSelector).empty();
		$(textSelector).html(message);

		//[4] Вешаем события на кнопках

		//Удаляем обработчики событий на все custom кнопки
		$("[id^='popupMessage_customButton_']").unbind("click");

		//Вешаем новые события на каждой из custom кнопок, если необходимо
		for (var index in buttonsArray)
		{
			var b = buttonsArray[index];

			if ("function" == typeof(b.onclickFn))
			{
				$("#popupMessage_customButton_" + index).bind("click", b.onclickFn);
			}

			$("#popupMessage_customButton_" + index).css("margin-left", "10px");
		}

		PopupMessage.show();
	},

	//--------------------------------------------------------------------------------------------------------

	//Добавляет html всплывающего сообщения в DOM
	addHtmlToDOM: function()
	{
		$("body").append('<div class="popupMessage"><div class="image"></div><div class="header">Сообщение</div><div class="popupMessageContent"><div class="text">TEXT</div><div class="buttons"></div></div></div>');
	},

	//--------------------------------------------------------------------------------------------------------

	//Инициализирует плагины для окна сообщения
	initJEOverlay: function()
	{
		//Инициализация плагина всплывающего сообщения
		PopupMessage.jeOverlay = $(".popupMessage").JEOverlay({
			containerId: "id_popupMessageContainer",
			minMargin: 20,
			speed: 0,
			closeOnEscape: false,
			zIndex: 10000,//Должен быть на две единицы больше чем при инициализации плагина для всплывающей формы, чтобы сообщения выводились поверх всплывающей формы
			bgSettings:
			{
				bgColor: '#333333',
				opacity: 0.5
			}
		});

		//Инициализация плагина таскания обьекта
		$(".popupMessage").draggable(
		{
			handle: ".header"
		});
	},

	//--------------------------------------------------------------------------------------------------------

	show: function()
	{
		PopupMessage.jeOverlay.load();

		//Устанавливаем фокус на кнопке OK, только в том случае, если это не сообщение confirm (с целью избежания случайного нажатия на подтверждении сообщения)
		if ("confirm" != PopupMessage.lastMessageType)
		{
			$("#id_buttonOk").focus();
		}
	},

	//--------------------------------------------------------------------------------------------------------

	hide: function()
	{
		PopupMessage.jeOverlay.close();
	}

	//--------------------------------------------------------------------------------------------------------
};
