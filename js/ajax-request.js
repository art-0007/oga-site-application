/*
ОПИСАНИЕ ФУНКЦИИ AjaxRequest.send()

//Объект настроек для функции, который передается в нее как параметр
//Ниже приведен список всех возможных параметров объекта настроек с их значениями ПОУМОЛЧАНИЮ
var options =
{
	fileName: "",									string - Имя файла запроса
	parameters:										object - Параметры передаваемые в запросе
	{
		param1: "value1",
		param2: "value2",
		paramN: "valueN"
	},
	showErrorMessage: true,							bool - Указывает выводит ли error сообщение
	showOkMessage: true,							bool - Указывает выводит ли ok сообщение
	messageType: {ok: "float", error: "float"},		string - {"popup", "float", "alert"} Тип ok и error сообщения. alert - это стандартный JavaScript alert. popup - PopupMessage. float - FloatMessage
	okCallBackFn: null,								mixed - string - имя функции; function - функция в синтаксисте JavaScript. Данная функция вызывается в случае успеха, после вывода сообщения
	errorCallBackFn: null,							mixed - string - имя функции; function - функция в синтаксисте JavaScript. Данная функция вызывается в случае ошибки, после вывода сообщения
	nonBlockingCall: false,							bool - Указывает запускать ли функцию в небокирующем режиме или нет (блокирующий режим это когда функция будет не будет запускатся пака не завершится предыдущий блокирующий вызов. ВНИМАНИЕ! При это мне будет никакйо постановкив очередь, просто вызов этой функции отбросится)
	usePreloader: true								bool - Указывает использовать ли прелоадер или нет
}
*/

$(function()
{
	AjaxRequest.init();
});

var AjaxRequest =
{
	//Ключ указывающий запущен ли уже блокирующий вызов или нет
	ajaxRequestProcessKey: false,

	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		AjaxRequest.initPreloader();
	},

	//--------------------------------------------------------------------------------------------------------

	send: function(options)
	{

		var settings = $.extend(
		{
			fileName: "",
			parameters:{},
			showErrorMessage: true,
			showOkMessage: true,
			messageType: {ok: "float", error: "float"},
			okCallBackFn: null,
			errorCallBackFn: null,
			nonBlockingCall: false,
			usePreloader: true
		}, options || {});

		//-----------------------------------------------------
		//Проверяем передачу обязательного параметра
		if (settings.fileName == "")
		{
			alert("AjaxRequest.send: fileName not set in input data");
			return false;
		}

		//-----------------------------------------------------
		//Проверяем формат параметра settings.messageType
		//Если переменая строка, то переопределяем ее в объект
		var type = typeof(settings.messageType);
		type = type.toLowerCase();
		if ("string" == type)
		{
			settings.messageType = {ok: settings.messageType, error: settings.messageType};
		}
		else
		{
			if ("undefined" == typeof(settings.messageType.ok))
				settings.messageType.ok = "popup";

			if ("undefined" == typeof(settings.messageType.error))
				settings.messageType.error = "popup";
		}

		//-----------------------------------------------------
		//Проверяем нужно ли выполнять проверки по блокировке двух подряд блокирующих запросов
		if (settings.nonBlockingCall === false)
		{
			if (AjaxRequest.ajaxRequestProcessKey === true)
			{
				//Блокирующий вызов еще не завершен, значит выводим сообщение, в котром написано, что мыл подождите завершения предыдущего и выходим с данной функции
				if(settings.usePreloader === true) AjaxRequest.showPreloaderMessage();
				return;
			}
			else
			{
				//Устанавливаем флаг блокирующего вызова
				AjaxRequest.ajaxRequestProcessKey = true;

				//Показываем прелоадер
				if(settings.usePreloader === true) AjaxRequest.showPreloader();
			}
		}

		//-----------------------------------------------------
		var request = new JsHttpRequest();
		request.onreadystatechange = function ()
		{
			if(request.readyState == 4)
			{
				if(request.status == 200)
				{
					//Проверяем есть ли чтото в потоке вывода (в данном случае там только мусор всякий, такой как ошибки и т.д.)
					if (request.responseText != "")
					{
						//Поток вывода содержит ошибки

						if (settings.nonBlockingCall === false) AjaxRequest.ajaxRequestProcessKey = false;
						if(settings.usePreloader === true) AjaxRequest.hidePreloader();

						switch(settings.messageType.error)
			      		{
			      			case "alert":
			      			{
								alert("Произошла ошибка! Возможно у Вас открыта устаревшая версия страницы.\nОбновите страницу воспользовавшись комбинацией клавиш 'Ctrl+R'.\nЕсли ошибка не устраниться, свяжитесь с системным администратором сайта.\n\nТекст ошибки: Буфер вывода не обработан." + ((_debugJavaScript == true) ? "\n\nСодержимое буфера вывода:\n" + request.responseText : "" ));
								break;
			      			}
			      			case "float":
			      			{
								FloatMessage.error("Произошла ошибка! Возможно у Вас открыта устаревшая версия страницы.<br>Обновите страницу воспользовавшись комбинацией клавиш 'Ctrl+R'.<br>Если ошибка не устраниться, свяжитесь с системным администратором сайта.<br><br><strong>Текст ошибки:</strong> Буфер вывода не обработан." + ((_debugJavaScript == true) ? "<br><br><strong>Содержимое буфера вывода:</strong><br>" + request.responseText : "" ));
			      				break;
			      			}
			      			case "popup":
			      			default:
			      			{
			      				PopupMessage.error("Произошла ошибка! Возможно у Вас открыта устаревшая версия страницы.<br>Обновите страницу воспользовавшись комбинацией клавиш 'Ctrl+R'.<br>Если ошибка не устраниться, свяжитесь с системным администратором сайта.<br><br><strong>Текст ошибки:</strong> Буфер вывода не обработан." + ((_debugJavaScript == true) ? "<br><br><strong>Содержимое буфера вывода:</strong><br>" + request.responseText : "" ));
			      			}
			      		}

			      		return;
					}

					if(request.responseJS.status == "error")
					{
						/*error*/
						if (settings.nonBlockingCall === false) AjaxRequest.ajaxRequestProcessKey = false;
						if(settings.usePreloader === true) AjaxRequest.hidePreloader();

						//Нужно выводить сообщение?
						if (settings.showErrorMessage === false)
						{
							//Проверяем передавалось ли имя функции settings.errorCallBackFn, если да, то запускаем ее
							if (settings.errorCallBackFn !== null)
							{
								//Проверяем передавался ли массив выходных данных
								if ("undefined" != typeof(request.responseJS.data))
								{
									window.setTimeout(settings.errorCallBackFn + "(" + Func.toJSON(request.responseJS.data) + ")", 0);
								}
								else
								{
									setTimeout(settings.errorCallBackFn + "()", 0);
								}
							}
						}
						else
						{
							switch(settings.messageType.error)
				      		{
				      			case "alert":
				      			{
				      				//Выводим сообщение
									alert(request.responseJS.message);

									//Проверяем передавалось ли имя функции settings.errorCallBackFn, если да, то после закрытия сообщения, данная функция запустится
									if (settings.errorCallBackFn !== null)
									{
										//Проверяем передавался ли массив выходных данных
										if ("undefined" != typeof(request.responseJS.data))
											setTimeout(settings.errorCallBackFn + "(" + Func.toJSON(request.responseJS.data) + ")", 0);
										else
											setTimeout(settings.errorCallBackFn + "()", 0);
									}
				      				break;
				      			}
				      			case "float":
				      			{
									//Проверяем передавалось ли имя функции settings.errorCallBackFn, если да, то запускаем ее до вывода сообщения
									if (settings.errorCallBackFn !== null)
									{
										//Проверяем передавался ли массив выходных данных
										if ("undefined" != typeof(request.responseJS.data))
											setTimeout(settings.errorCallBackFn + "(" + Func.toJSON(request.responseJS.data) + ")", 0);
										else
											setTimeout(settings.errorCallBackFn + "()", 0);
									}

									FloatMessage.error(request.responseJS.message);
				      				break;
				      			}
				      			case "popup":
				      			default:
				      			{
									//Проверяем передавалось ли имя функции settings.errorCallBackFn, если да, то передаем ее как параметр для запуска вывода сообщения
									//После закрытия сообщения, данная функция запустится
									if (settings.errorCallBackFn !== null)
									{
										//Проверяем передавался ли массив выходных данных
										if ("undefined" != typeof(request.responseJS.data))
											PopupMessage.error(request.responseJS.message, settings.errorCallBackFn, request.responseJS.data);
										else
											PopupMessage.error(request.responseJS.message, settings.errorCallBackFn);
									}
									else
									{
										PopupMessage.error(request.responseJS.message);
									}
				      			}
				      		}
						}
					}
					else
					{
						if(request.responseJS.status == "ok")
						{
							/*ok*/
							if (settings.nonBlockingCall === false) AjaxRequest.ajaxRequestProcessKey = false;
							if(settings.usePreloader === true) AjaxRequest.hidePreloader();

							//Нужно выводить сообщение?
							if (false === settings.showOkMessage)
							{
								//Проверяем передавалось ли имя функции settings.okCallBackFn, если да, то запускаем ее и выходим из функции
								if (settings.okCallBackFn !== null)
								{
									//Проверяем является ли строкой функция колбека
									if ("string" == typeof(settings.okCallBackFn))
									{
										//Проверяем передавался ли массив выходных данных
										if ("undefined" != typeof(request.responseJS.data))
										{
											window.setTimeout(settings.okCallBackFn + "(" + Func.toJSON(request.responseJS.data) + ")", 0);
										}
										else
										{
											setTimeout(settings.okCallBackFn + "()", 0);
										}
									}
									else if ("function" == typeof(settings.okCallBackFn))
									{
										//Проверяем передавался ли массив выходных данных
										if ("undefined" != typeof(request.responseJS.data))
										{
											settings.okCallBackFn(request.responseJS.data);
										}
										else
										{
											settings.okCallBackFn();
										}
									}
								}
							}
							else
							{
								switch(settings.messageType.ok)
					      		{
					      			case "alert":
					      			{
					      				//Выводим сообщение
										alert(request.responseJS.message);

										//Проверяем передавалось ли имя функции settings.okCallBackFn, если да, то после закрытия сообщения, данная функция запустится
										if (settings.okCallBackFn !== null)
										{
											//Проверяем является ли строкой функция колбека
											if ("string" == typeof(settings.okCallBackFn))
											{
												//Проверяем передавался ли массив выходных данных
												if ("undefined" != typeof(request.responseJS.data))
													window.setTimeout(settings.okCallBackFn + "(" + Func.toJSON(request.responseJS.data) + ")", 0);
												else
													window.setTimeout(settings.okCallBackFn + "()", 0);
											}
											else if ("function" == typeof(settings.okCallBackFn))
											{
												//Проверяем передавался ли массив выходных данных
												if ("undefined" != typeof(request.responseJS.data))
												{
													settings.okCallBackFn(request.responseJS.data);
												}
												else
												{
													settings.okCallBackFn();
												}
											}
										}
					      				break;
					      			}
					      			case "float":
					      			{
										//Проверяем передавалось ли имя функции settings.okCallBackFn, если да, то запускаем ее до вывода сообщения
										if (settings.okCallBackFn !== null)
										{
											//Проверяем является ли строкой функция колбека
											if ("string" == typeof(settings.okCallBackFn))
											{
												//Проверяем передавался ли массив выходных данных
												if ("undefined" != typeof(request.responseJS.data))
													window.setTimeout(settings.okCallBackFn + "(" + Func.toJSON(request.responseJS.data) + ")", 0);
												else
													window.setTimeout(settings.okCallBackFn + "()", 0);
											}
											else if ("function" == typeof(settings.okCallBackFn))
											{
												//Проверяем передавался ли массив выходных данных
												if ("undefined" != typeof(request.responseJS.data))
												{
													settings.okCallBackFn(request.responseJS.data);
												}
												else
												{
													settings.okCallBackFn();
												}
											}
										}

										FloatMessage.ok(request.responseJS.message);
					      				break;
					      			}
					      			case "popup":
					      			default:
					      			{
										//Проверяем передавалось ли имя функции settings.okCallBackFn, если да, то запускаем ее до вывода сообщения
										if (settings.okCallBackFn !== null)
										{
											//Проверяем является ли строкой функция колбека
											if ("string" == typeof(settings.okCallBackFn))
											{
												//Проверяем передавался ли массив выходных данных
												if ("undefined" != typeof(request.responseJS.data))
													PopupMessage.ok(request.responseJS.message, settings.okCallBackFn, request.responseJS.data);
												else
													PopupMessage.ok(request.responseJS.message, settings.okCallBackFn);
											}
											else if ("function" == typeof(settings.okCallBackFn))
											{
												//Проверяем передавался ли массив выходных данных
												if ("undefined" != typeof(request.responseJS.data))
												{
													PopupMessage.ok(request.responseJS.message, settings.okCallBackFn, request.responseJS.data);
												}
												else
												{
													PopupMessage.ok(request.responseJS.message, settings.okCallBackFn);
												}
											}
										}
										else
										{
											//Так как settings.okCallBackFn не передавалось, то просто выводим сообщение
											PopupMessage.ok(request.responseJS.message);
										}
					      			}
					      		}
							}
						}
						else
						{
							if (settings.nonBlockingCall === false) AjaxRequest.ajaxRequestProcessKey = false;
							if(settings.usePreloader === true) AjaxRequest.hidePreloader();

							PopupMessage.error("Произошла ошибка! Возможно у Вас открыта устаревшая версия страницы.<br>Обновите страницу воспользовавшись комбинацией клавиш 'Ctrl+R'.<br>Если ошибка не устраниться, свяжитесь с системным администратором сайта.<br><br>(<strong>Текст ошибки:</strong> Сервер вернул некорректный статуст сообщения [" + request.responseJS.status + "])");
						}
					}
				}
				else
				{
					if (settings.nonBlockingCall === false) AjaxRequest.ajaxRequestProcessKey = false;
					if(settings.usePreloader === true) AjaxRequest.hidePreloader();

					switch(settings.messageType.error)
		      		{
		      			case "alert":
		      			{
		      				//Выводим сообщение
							alert("Произошла ошибка! Возможно у Вас открыта устаревшая версия страницы.\nОбновите страницу воспользовавшись комбинацией клавиш 'Ctrl+R'.\nЕсли ошибка не устраниться, свяжитесь с системным администратором сайта.\n\nТекст ошибки: Буфер вывода не обработан." + ((_debugJavaScript == true) ? "\n\nСодержимое буфера вывода:\n" + request.responseText : "" ));

							//Проверяем передавалось ли имя функции settings.errorCallBackFn, если да, то после закрытия сообщения, данная функция запустится
							if (settings.errorCallBackFn !== null)
							{
								setTimeout(settings.errorCallBackFn + "()", 0);
							}
		      				break;
		      			}
		      			case "float":
		      			{
							//Проверяем передавалось ли имя функции settings.errorCallBackFn, если да, то запускаем ее до вывода сообщения
							if (settings.errorCallBackFn !== null)
							{
								setTimeout(settings.errorCallBackFn + "()", 0);
							}

							FloatMessage.error("Произошла ошибка! Возможно у Вас открыта устаревшая версия страницы.<br>Обновите страницу воспользовавшись комбинацией клавиш 'Ctrl+R'.<br>Если ошибка не устраниться, свяжитесь с системным администратором сайта.<br><br><strong>Текст ошибки:</strong> Буфер вывода не обработан." + ((_debugJavaScript == true) ? "<br><br><strong>Содержимое буфера вывода:</strong><br>" + request.responseText : "" ));
		      				break;
		      			}
		      			case "popup":
		      			default:
		      			{
		      				var message = "Произошла ошибка! Возможно у Вас открыта устаревшая версия страницы.<br>Обновите страницу воспользовавшись комбинацией клавиш 'Ctrl+R'.<br>Если ошибка не устраниться, свяжитесь с системным администратором сайта.<br><br><strong>Текст ошибки:</strong> Буфер вывода не обработан." + ((_debugJavaScript == true) ? "<br><br><strong>Содержимое буфера вывода:</strong><br>" + request.responseText : "" );

							//Проверяем передавалось ли имя функции settings.errorCallBackFn, если да, то передаем ее как параметр для запуска вывода сообщения
							//После закрытия сообщения, данная функция запустится
							if (settings.errorCallBackFn !== null)
							{
								PopupMessage.error(message, settings.errorCallBackFn);
							}
							else
							{
								PopupMessage.error(message);
							}
		      			}
	   				}
				}
			}
		}
		request.open('POST', "/ajax" + settings.fileName, true);
		request.send( settings.parameters );
	},

	//--------------------------------------------------------------------------------------------------------

	initPreloader: function()
	{
		var html = '<div id="id_ajaxRequestPreloader"></div><div id="id_ajaxRequestPreloaderMessage">Дождитесь завершения предыдущей операции...</div><div id="id_ajaxRequestPreloaderCover"></div>';

		//Создаем элемент прелоадера
		$("body").append(html);

		//Проставляем правильное позиционирование элементам прелоадера
		$("#id_ajaxRequestPreloader").css("left", $(window).width()/2 - $("#id_ajaxRequestPreloader").width()/2);
		$("#id_ajaxRequestPreloaderMessage").css("left", $(window).width()/2 - $("#id_ajaxRequestPreloaderMessage").width()/2);
		$("#id_ajaxRequestPreloaderMessage").css("top", $("#id_ajaxRequestPreloader").height());
	},

	//--------------------------------------------------------------------------------------------------------

	//Показывает прелоадер выполнения запроса
	showPreloader: function ()
	{
		FloatMessage.hide();
		AjaxRequest.showPreloaderCover();
		$("#id_ajaxRequestPreloader").show();
	},

	//--------------------------------------------------------------------------------------------------------

	//Скрывает прелоадер выполнения запроса
	hidePreloader: function()
	{
		AjaxRequest.hidePreloaderCover();
		$("#id_ajaxRequestPreloader").hide();
		AjaxRequest.hidePreloaderMessage();
	},

	//--------------------------------------------------------------------------------------------------------

	showPreloaderCover: function()
	{
		//Расчитываем размеры элемента покрывающего документ
		$("#id_ajaxRequestPreloaderCover")
		.width($(document).width())
		.height($(document).height())
		.css("position", "absolute")
		.css("z-index", "10002")
		.css("top", "0")
		.css("left", "0")
		.css("background-color", "transparent")
		.css("cursor", "wait")
		.show();
	},

	//--------------------------------------------------------------------------------------------------------

	hidePreloaderCover: function()
	{
		$("#id_ajaxRequestPreloaderCover").hide();
	},

	//--------------------------------------------------------------------------------------------------------

	//Показывает сообщение прелоадера выполнения запроса
	showPreloaderMessage: function()
	{
		$("#id_ajaxRequestPreloaderMessage").show();
	},

	//--------------------------------------------------------------------------------------------------------

	//Скрывает сообщение прелоадера выполнения запроса
	hidePreloaderMessage: function()
	{
		$("#id_ajaxRequestPreloaderMessage").hide();
	}

	//--------------------------------------------------------------------------------------------------------
};
