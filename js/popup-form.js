$(function(){
	PopupForm.init();
});

var PopupForm =
{
	//--------------------------------------------------------------------------------------------------------

	jeOverlay: null,
	popupFormOpenedKey: false,
	popupFormContentHtml: null,
	popupFormContainerId: null,

	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		//Добавляем html всплывающей формы в DOM
		PopupForm.addHtmlToDOM();

		//Инициализируем плагин JEOverlay
		PopupForm.initJEOverlay();
	},

	//--------------------------------------------------------------------------------------------------------

	//отображает всплывающую форму
	//formTitle string Заголовок всплывающей формы
	//formContainerId string ИД тега контейнера содержимого всплывающей формы
	//callbackFn midex string - Имя функции, которая запускается после отображения; function - Функция, которая запускается после отображения
	show: function(formTitle, formContainerId, callbackFn)
	{
		//Проверяем закрыта ли предыдущая открытая форма
		if (PopupForm.popupFormOpenedKey)
		{
			//ВНИМАНИЕ! Если форма не была закрыта, то ТОЛЬКО ТОГДА, НО ОБЯЗАТЕЛЬНО необходимо вызвать эту функцию, так как в тей производится восстановление html кода старого контейнера
			PopupForm.hide();
		}

		if ("undefined" == typeof(formContainerId))
		{
			Func.fatalMessage("Ошибка инициализации формы (formContainerId not send)");
			return;
		}

		if (!$("#" + formContainerId).length)
		{
			Func.fatalMessage("Ошибка инициализации формы (Элемент с таким id контейнера не найден)");
			return;
		}

		//Заносим html формы в временную переменную и стираем содержимое контейнера этой формы (ЭТО НЕОБХОДИМО ДЛЯ ИЗБЕЖАНИЯ ДУБЛИРОВАНИЯ ДАННЫХ)
		//Содержимое контейнера будет восстановлено полсле закрытия формы
		PopupForm.popupFormContentHtml = $("#" + formContainerId).html();
		$("#" + formContainerId).empty();

		//Устанавливаем заголовок формы
		$(".popupForm .popupFormTitle").text(formTitle);

		//Устанавливаем содержимое формы и выполнияем дополнительные действия (см. код)
		$(".popupFormContent")
		.empty()
		.html(PopupForm.popupFormContentHtml)
		//Конструкция each() прописана только для того, чтобы вызвать функцию PopupForm.jeOverlay.load(), непосредственно после установки html выше
		.each(function(){
			PopupForm.jeOverlay
			.load()
			//Конструкция each() прописана только для того, чтобы вызвать функцию callbackFn, непосредственно после load выше
			.each(function(){

				PopupForm.popupFormOpenedKey = true;

				//Переводим фокус на первый элемент формы
				$("select, textarea, input[type!=hidden]", this).eq(0).focus();

				//Запускаем callbackFn, если она передавалась
				if ("undefined" != typeof(callbackFn) && callbackFn !== null)
				{
					if ("string" == typeof(callbackFn))
					{
						setTimeout(callbackFn + "()", 0);
					}
					else
					{
						if ("function" == typeof(callbackFn))
						{
							callbackFn();
						}
					}
				}

				//ЗАКОМОРТИРОВАНО, так как исправление этой проблемы было решено средствами плагина JEOverlay (там сначало объект отображается как fixed, а потом переводится в absolut с предварительным расчетом параметра top)
				////Перематываем экран к верхней границе документа, так как форма отображается с позицией absolute т.е. ее отступ сверху, это отступ от границы документа, а не от границы окна
				////$(window).scrollTop(0);

				if ("undefined" != typeof(ContextHelp))
				{
					ContextHelp.load_forPopupForm();
				}
			});
		});

		PopupForm.popupFormContainerId = formContainerId;
	},

	//--------------------------------------------------------------------------------------------------------

	//Скрывает всплывающую форму
	hide: function()
	{
		////ВНИМАНИЕ! Выполняем спецоперацию удаления объекта tinymce
		//Func.removeTinyMCE(".popupForm .content.tinymce textarea");

		//Закрываем форму
		PopupForm.jeOverlay.close();

		//Очищаем содержимое контейнера всплывающей формы
		//ВНИМАНИЕ! Очистить содержимое контейнера всплывающей формы обязательно, так как иначе возникают ошибки работы tinyMCE, который инициализировался на содержимое этой формы
		$(".popupFormContent").empty();

		//Восстанавливаем html формы, который был занесен во временную переменную
		$("#" + PopupForm.popupFormContainerId).html(PopupForm.popupFormContentHtml);

		PopupForm.popupFormOpenedKey = false;
	},

	//--------------------------------------------------------------------------------------------------------

	//Добавляет html всплывающей формы в DOM
	addHtmlToDOM: function()
	{
		$("body").append('<div class="popupForm"><div class="closeButton"><div class="sprite sprite-popup-form-close" title="Закрыть" onclick="PopupForm.hide()"></div></div><div class="popupFormTitle">Заголовок всплывающей фомы</div><div class="popupFormContent editForm"></div></div>');
	},

	//--------------------------------------------------------------------------------------------------------

	//Инициализирует плагины для окна формы
	initJEOverlay: function()
	{
		//Инициализация плагина всплывающей формы
		PopupForm.jeOverlay = $(".popupForm").JEOverlay({
			containerId: "id_popupFormContainer",
			minMargin: 20,
			speed: 0,
			position: "absolute",//Задаем абсолютную позиции, что даст нам возможность прокручивая скрол увидеть залезшие за границы экрана области формы
			closeOnEscape: true,
			zIndex: 9998,//Должен быть на две единицы меньше чем при инициализации плагина для сообщений, чтобы сообщения выводились поверх всплывающей формы
			bgSettings:
			{
				bgColor: '#002b55',
				opacity: 0.98
			}
		});

		//ЗАКОМЕНТИРОВАНО, так как это вызывает глюки (объяснимые).
		//Позиция формы absolute, так как это нужно для возможности проматывания экрана с целью увидеть часть
		//формы в него не помещающуюся, но в таком случае плагин jqiery-ui-draggable расчитывает отступ от верхней границе,
		//который уже интерпретируется неверно, так как позиция не fixed, а absolute, что приводит к прыгании элемента вниз,
		//если страница промотана ниже верхней границы документа
		////Инициализация плагина таскания обьекта
		////ВНИМАНИЕ! Ни в коем случае не делать драг всей формы!!! В крайнем случае сделать тягание за какие-то элементы типа ".popupForm.editForm .header"
		//$(".popupForm").draggable(
		//{
		//	handle: ".popupFormTitle"
		//});
	}

	//--------------------------------------------------------------------------------------------------------
};



