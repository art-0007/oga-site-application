/**
* Плагин JEAutocomplete версия 1.2b
*
* Особенности:
* 	1) Используется фреймворк jQuery 1.4.2 и выше
* 	2) Используется библиотека JsHttpRequest 5
* 	3) Вариантиы автодополнения должны возвращатся в виде двухмерного массива
*	4) Имя переменной в которой передается текст в обработчик "text"
*	5) Имя переменной в которой возвращается результат в виде двухмерного массива "resultArray"
*
*
* Описание параметров:
* objectName - Имя глобальной переменной объекта ссылающего на инициализированый плагин. Необходим для вызова функции колбека для AjaxRequest.send. Параметр обязателен, так как без него плагин не покажет результаты
* carrierDivClass - css класс div-а который является подложкой для вариантов автодополнения
* carrierDivId - html атрибут id div-а который является подложкой для вариантов автодополнения
* lineClass - css класс div-а в пассивном состоянии, в который обертывается каждый вариант автодополнения
* selectedLineClass - css класс div-а в активном состоянии, в которой обертывается каждый вариант автодополнения
* onSelectFunction - имя ф-ции которая вызывается при выборе одного из вариантов автодополнения
* showArrayIndex - index элемента, значение которого, нужно отображать в вариантах автодополнения
* insertArrayIndex - index элемента, значение которого, нужно подставлять в input после нажатия Enter или клика мышкой
* onselectCodeArrayIndex - index элемента, значение которого нужно выполнить как JS код при выборе его строки (как по клику так и при нажании энтера). Проверяется его существование в массиве, и только после этого производится выпополнение данного кода
* minChars - Минимальное кол-во введенных символов, которое нужно ввести, прежде чем ображатся к обработчику за вариантами автодополнения
* parameter - Дополнительные параметры передаваемые обработчику
* ajaxFileName - имя ajax обработчика
* delay - задержка, после воода символа, после которой инициируется ajax запрос
* closeOnEsc - вкл./выкл. закрытие div-а с вариантами автодополнения при нажатии клавиши Esc
* disableEnterSubmit - вкл./откл. автосабмит формы по Enter-у когда в форме один input
*
*/

(function ($)
{
	var delayInterval; //Обект интервала вызова ф-ции запроса
	var	indexAmount = 0; //Кол-во подсказок
	var currentIndex = 0; //Номер выбранноой подсказки
	var inputText = ""; //Текст в input-е
	var resultArray = new Array;
	var settings; //Настройки
	var jQThis;
	var jQCurrierDiv;
	var request; //Обьект запроса

	function f_initPlagin()
	{
		$("#autocompleteStatus_span").text("enable");

		f_addAutocompleteDiv();
		f_disableFormAutocomplete();
		jQCurrierDiv = $("#" + settings.carrierDivId);
	}

	//Див для подсказок
	function f_addAutocompleteDiv()
	{
		$("div[id='" + settings.carrierDivId + "']").remove(); //Удаляем подложку если такая уже есть
		var inputOffset = jQThis.offset();

		var element = $("<div></div>")
		.attr("id", settings.carrierDivId)
		.attr("class", settings.carrierDivClass)
		.css("display", "none")
		.css("position", "absolute")
		.css("top", inputOffset.top + jQThis.outerHeight())
		.css("left", inputOffset.left)
		.css("width", jQThis.outerWidth())
		//.css("margin", "0px")
		//.css("padding", "0px")
		.appendTo("body");

		//Переопределяем ширину элемента отняв его бордеры
		element.css("width", jQThis.outerWidth() - parseInt(element.css("border-left-width")) - parseInt(element.css("border-right-width")));
	}

	function f_disableFormAutocomplete()
	{
		$("form")
		.has(jQThis)
		.attr("autocomplete", "off");
	}

	//Событие когда кнопка отпущена
	function f_keyUp(e)
	{
		clearInterval(delayInterval); //Останавливаем вызов

		//Отменяем обработку Enter, Esc, стрелки влево, стрелки вверх, стрелки вправо, стрелки вниз
		if(e.keyCode == 13 || e.keyCode == 27 || e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40)
		{
			return;
		}

		//Проверяем минимальное кол-во символов
		if(jQThis.val().length >= settings.minChars)
		{
			delayInterval = setInterval(f_ajax, settings.delay);
		}
		else
		{
			f_hideAutocompleteDiv();
		}
	}

	//Событие когда кнопка нажата
	function f_keyDown(e)
	{
		clearInterval(delayInterval); //Останавливаем вызов

		//Кнопка Enter
		if(e.keyCode == 13)
		{
			if(jQCurrierDiv.is(":visible"))
			{
				f_excecuteOnselectCode();
				f_setInputValue();
			}

			return;
		}

		//Кнопка Esc
		if(e.keyCode == 27)
		{
			if(settings.closeOnEsc)
			{
				f_hideAutocompleteDiv();
			}

			return;
		}

		//Стрелка вверх
		if(e.keyCode == 38)
		{
			if(jQCurrierDiv.is(":visible"))
			{
				f_selectedUp();
			}

			return;
		}

		//Стрелка вниз
		if(e.keyCode == 40)
		{
			if(jQCurrierDiv.is(":visible"))
			{
				f_selectedDown();
			}

			return;
		}
	}

	//Событие, когда кнопка нажата
	function f_keyPress(e)
	{
  		//alert("f_keyPress");
	}

	//Обрабатываем нажатие Enter
	function f_setInputValue()
	{
		//ВНИМАНИЕ! Добавлена проверка на существование элемента с таким индексом только для того чтобы ВРЕМЕННО исправить глюк
		//с необработкой ситуации нажатия энтера тогда когда див с результатами показан но ниодин из этих результатов не выделен пользователем

		if ("undefined" != typeof(resultArray[currentIndex - 1]) && "undefined" != typeof(resultArray[currentIndex - 1][settings.insertArrayIndex]))
		{
			jQThis
			.val(resultArray[currentIndex - 1][settings.insertArrayIndex])
			.focus();

			f_hideAutocompleteDiv();

			if(settings.onSelectFunction != "")
			{
				setTimeout(settings.onSelectFunction + "()", 0); //Вызов внешней ф-ции
			}
		}
	}

	//Обрабатываем вызов кода по выбору элемента, если такой есть
	function f_excecuteOnselectCode()
	{
		//Если передается параметр по счоту "onselectCodeArrayIndex" в массиве результатов, то запускаем код, который там передается
		//ВНИМАНИЕ! В указанном параметре должен передаватся именно код, а не имя функции, так как он запускается без всякого добавления скобок в конце
		if ("undefined" != typeof(resultArray[currentIndex - 1]) && "undefined" != typeof(resultArray[currentIndex - 1][settings.onselectCodeArrayIndex]))
		{
			setTimeout(resultArray[currentIndex - 1][settings.onselectCodeArrayIndex], 0);
		}
	}

	//AJAX запрос к обработчику
	function f_ajax()
	{
		clearInterval(delayInterval); //Останавливаем вызов

		settings.parameter = $.extend(settings.parameter,
		{
			text: jQThis.val()
		});

		//Не производим никаких операций, если текст оказался пустым
		if (settings.parameter.text == "") return;

		var settingsAjax =
		{
			fileName: settings.ajaxFileName,
			parameters: settings.parameter,
			messageType: "float",
			showOkMessage: false,
			okCallBackFn: settings.objectName + ".okCallbackFn"
		};
		AjaxRequest.send(settingsAjax);
	}

	//Обработка результата
	function f_ajaxResult(data)
	{
		resultArray = data.resultArray;

		jQCurrierDiv.empty(); //Удаляем содержимое div

		if(resultArray.length > 0)
		{
			jQCurrierDiv.show(); //Отображаем div

			for(var i = 0; i < resultArray.length; i++)
			{
				$("<div></div>")
				.attr("class", settings.lineClass)
				.attr("index", i + 1)
				//.css("margin", "0px")
				//.css("padding", "0px")
				.mouseover(function ()
				{
					$("div[index]", jQCurrierDiv).attr("class", settings.lineClass);
					$(this)
					.attr("class", settings.selectedLineClass)
					.css("cursor", "default");
					currentIndex = $(this).attr("index");
				})
				.click(function ()
				{
         			f_excecuteOnselectCode();
         			f_setInputValue();
				})
				.html(resultArray[i][settings.showArrayIndex])
				.appendTo(jQCurrierDiv);
			}

			indexAmount = resultArray.length;
			currentIndex = 0;
		}
		else
		{
			resultArray = new Array;
			f_hideAutocompleteDiv();
		}
	}

	//Сдвиг выделителя вверх
	function f_selectedUp()
	{
		if(indexAmount == 0)
		{
			return;
		}

		currentIndex--; //Смещаем указатель
		$("div[index]", jQCurrierDiv).attr("class", settings.lineClass); //Устанавливаем элементам фон по умолчанию

		if(currentIndex < 0)
		{
			currentIndex = indexAmount;
		}

		if(currentIndex == 0)
		{
   			jQThis.val(inputText);
		}

		if(currentIndex != 0)
		{
			if(inputText == "")
			{
				inputText = jQThis.val();
			}

			$("div[index='" + currentIndex + "']", jQCurrierDiv).attr("class", settings.selectedLineClass);
			jQThis.val(resultArray[currentIndex - 1][settings.insertArrayIndex]);
		}
	}

	//Сдвиг выделителя вниз
	function f_selectedDown()
	{
		if(indexAmount == 0)
		{
			return;
		}

		currentIndex++; //Смещаем указатель
		$("div[index]", jQCurrierDiv).attr("class", settings.lineClass); //Устанавливаем элементам фон по умолчанию

		if(currentIndex > indexAmount)
		{
			currentIndex = 0;
		}

		if(currentIndex == 0)
		{
   			jQThis.val(inputText);
		}

		if(currentIndex != 0)
		{
			if(inputText == "")
			{
				inputText = jQThis.val();
			}

			$("div[index='" + currentIndex + "']", jQCurrierDiv).attr("class", settings.selectedLineClass);
			jQThis.val(resultArray[currentIndex - 1][settings.insertArrayIndex]);
		}
	}

	//Скрывает див с вариантами автодополнения
	function f_hideAutocompleteDiv()
	{
		jQCurrierDiv.empty().hide();
		//indexAmount = 0;
		//currentIndex = 0;
		inputText = "";
	}

	//Отключает submit формы по Enter-у
	function f_disableFormSubmit()
	{
		if(settings.disableEnterSubmit)
		{
			$("form")
			.has(jQThis)
			.submit(function ()
			{
				return false;
			});
		}
	}

	//Возвращает возможность submit-а формы по Enter-у и кнопке submit
	function f_cleanDisableSubmit()
	{
		if(settings.disableEnterSubmit)
		{
			$("form")
			.has(jQThis)
			.unbind("submit");
		}
	}

	function f_plTest()
	{
  		formId = $("form").has(jQThis);
  		alert(formId.attr("id"));
	}

	$.fn.JEAutocomplete = function (option)
	{
		jQThis = this;

		//Настройки
		settings = $.extend(
		{
			objectName: "",
			carrierDivClass: "acCarrierDiv",
			carrierDivId: "acCarrierDiv",
			lineClass: "acLine",
			selectedLineClass: "acSelectedLine",
			onSelectFunction: "",
			showArrayIndex: 0,
			insertArrayIndex: 1,
			onselectCodeArrayIndex: 2,
			minChars: 2,
			parameter: {},
			ajaxFileName: "acajax.php",
			delay: 500,
			closeOnEsc: true,
			disableEnterSubmit: false
		}, option || {});

		$.extend(this,
		{
			setSettings: function (option)
			{
				settings = $.extend(settings, option || {});
				f_initPlagin();
			},
   			getValue: function (arrayIndex)
   			{
				return resultArray[currentIndex - 1][arrayIndex];
   			},
			okCallbackFn: function(data)
			{
				f_ajaxResult(data);
			},
			setParameter: function(parameter)
			{
				settings.parameter = parameter;
			}
		});

		f_initPlagin();

		this
		.bind(
		{
			keyup: function (event)
			{
				f_keyUp(event);
			},
			keydown: function (event)
			{
				f_keyDown(event);
			},
			focus: function (event)
			{
				f_disableFormSubmit();
			},
			blur: function (event)
			{
				f_cleanDisableSubmit();
			}
		});

		$(document).bind(
		{
			click: function ()
			{
				f_hideAutocompleteDiv();
			}
		});

		return this;
	}

})(jQuery);