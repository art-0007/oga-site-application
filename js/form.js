$(function()
{
	Form.init();
});

var Form =
{
	//--------------------------------------------------------------------------------------------------------

	formSelector: "",
	pageClass: "",

	init: function()
	{
	},

	//--------------------------------------------------------------------------------------------------------

	projectDonateFormShow: function(event, projectId)
	{
		event.preventDefault();
		event.stopPropagation();

		$.fancybox.close(true);
		$("#myModal").remove();

		var settings =
		{
			fileName: "/CAProjectDonateFormShow/",
			parameters: { projectId: projectId },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "Form.projectDonateFormShow_ok",
			errorCallBackFn: "Form.projectDonateFormShow_error",
		};
		AjaxRequest.send(settings);
	},

	projectDonateFormShow_ok: function(data)
	{
		$.fancybox.close(true);
		$("#myModal").remove();

		$("body").append(data.modalHtml);

		$.fancybox.open(
		{
			src: '#myModal',
			type: 'inline',
			smallBtn: false,
			opts: {}
		});
	},

	projectDonateFormShow_error: function(data)
	{
		Form.showError(data);
	},

	//--------------------------------------------------------------------------------------------------------

	donateFormShow: function(event, projectId, donateId)
	{
		event.preventDefault();
		event.stopPropagation();

		$.fancybox.close(true);
		$("#myModal").remove();

		var settings =
		{
			fileName: "/CADonateFormShow/",
			parameters: { projectId: projectId, donateId: donateId },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "Form.donateFormShow_ok",
			errorCallBackFn: "Form.donateFormShow_error",
		};
		AjaxRequest.send(settings);
	},

	donateFormShow_ok: function(data)
	{
		$.fancybox.close(true);
		$("#myModal").remove();

		$("body").append(data.modalHtml);

		$.fancybox.open(
		{
			src: '#myModal',
			type: 'inline',
			smallBtn: false,
			opts: {}
		});
	},

	donateFormShow_error: function(data)
	{
		Form.showError(data);
	},

	//--------------------------------------------------------------------------------------------------------

	donateFormSend: function(fThis, selector)
	{
		selector = selector || "";

		Form.formSelector = selector;
		Form.hideError();

		var settings =
		{
			fileName: "/CADonateFormSend/",
			parameters: { q: fThis },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: false,
			okCallBackFn: "Form.donateFormSend_ok",
			errorCallBackFn: "Form.donateFormSend_error",
		};
		AjaxRequest.send(settings);
	},

	donateFormSend_ok: function(data)
	{
		//перенаправляем на страницу оплаты
		window.location.replace("/online-pay/start/?donateCode=" + data.donateCode);
	},

	donateFormSend_error: function(data)
	{
		Form.showError(data);
	},

	//--------------------------------------------------------------------------------------------------------

	subscribeFormShow: function(event)
	{
		event.preventDefault();
		event.stopPropagation();

		$.fancybox.close(true);
		$("#myModal").remove();

		var settings =
		{
			fileName: "/CASubscribeFormShow/",
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "Form.subscribeFormShow_ok",
			errorCallBackFn: "Form.subscribeFormShow_error",
		};
		AjaxRequest.send(settings);
	},

	subscribeFormShow_ok: function(data)
	{
		$.fancybox.close(true);
		$("#myModal").remove();

		$("body").append(data.modalHtml);

		$.fancybox.open(
		{
			src: '#myModal',
			type: 'inline',
			smallBtn: false,
			opts: {}
		});
	},

	subscribeFormShow_error: function(data)
	{
		Form.showError(data);
	},

	//--------------------------------------------------------------------------------------------------------

	subscribeFormSend: function(fThis, selector)
	{
		selector = selector || "";

		Form.formSelector = selector;
		Form.hideError();

		var settings =
		{
			fileName: "/CASubscribeFormSend/",
			parameters: { q: fThis },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: false,
			okCallBackFn: "Form.subscribeFormSend_ok",
			errorCallBackFn: "Form.subscribeFormSend_error",
		};
		AjaxRequest.send(settings);
	},

	subscribeFormSend_ok: function(data)
	{
		//Отображаем ответ
		$(Form.formSelector)[0].reset();

		$.fancybox.close(true);
		$("#myModal").remove();

		//Вставляем форму отвeта в тело сайта
		$("body").append(data.modalHtml);

		$.fancybox.open(
		{
			src: '#myModal',
			type: 'inline',
			opts: {}
		});
	},

	subscribeFormSend_error: function(data)
	{
		Form.showError(data);
	},

	//--------------------------------------------------------------------------------------------------------

	registerForEventFormShow: function(articleId)
	{
		$.fancybox.close(true);
		$("#myModal").remove();

		var settings =
		{
			fileName: "/CARegisterForEventFormShow/",
			parameters: { articleId: articleId },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "Form.registerForEventFormShow_ok",
			errorCallBackFn: "Form.registerForEventFormShow_error",
		};
		AjaxRequest.send(settings);
	},

	registerForEventFormShow_ok: function(data)
	{
		$.fancybox.close(true);
		$("#myModal").remove();

		$("body").append(data.modalHtml);

		$.fancybox.open(
		{
			src: '#myModal',
			type: 'inline',
			smallBtn: false,
			opts: {}
		});
	},

	registerForEventFormShow_error: function(data)
	{
		Form.showError(data);
	},

	//--------------------------------------------------------------------------------------------------------

	registerForEventFormSend: function(fThis, selector)
	{
		selector = selector || "";

		Form.formSelector = selector;
		Form.hideError();

		var settings =
		{
			fileName: "/CARegisterForEventFormSend/",
			parameters: { q: fThis },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: false,
			okCallBackFn: "Form.registerForEventFormSend_ok",
			errorCallBackFn: "Form.registerForEventFormSend_error",
		};
		AjaxRequest.send(settings);
	},

	registerForEventFormSend_ok: function(data)
	{
		//Отображаем ответ
		$(Form.formSelector)[0].reset();

		$.fancybox.close();
		$("#myModal").remove();

		//Вставляем форму отвeта в тело сайта
		$("body").append(data.modalHtml);

		$.fancybox.open(
		{
			src: '#myModal',
			type: 'inline',
			opts: {}
		});
	},

	registerForEventFormSend_error: function(data)
	{
		Form.showError(data);
	},

	//--------------------------------------------------------------------------------------------------------

	getInvolvedFormShow: function(event, articleId)
	{
		event.preventDefault();
		event.stopPropagation();

		$.fancybox.close(true);
		$("#myModal").remove();

		var settings =
		{
			fileName: "/CAGetInvolvedFormShow/",
			parameters: { articleId: articleId },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: false,
			okCallBackFn: "Form.getInvolvedFormShow_ok",
			errorCallBackFn: "Form.getInvolvedFormShow_error",
		};
		AjaxRequest.send(settings);
	},

	getInvolvedFormShow_ok: function(data)
	{
		$.fancybox.close(true);
		$("#myModal").remove();

		$("body").append(data.modalHtml);

		$.fancybox.open(
		{
			src: '#myModal',
			type: 'inline',
			smallBtn: false,
			opts: {}
		});
	},

	getInvolvedFormShow_error: function(data)
	{
		Form.showError(data);
	},

	//--------------------------------------------------------------------------------------------------------

	getInvolvedFormSend: function(fThis, selector)
	{
		selector = selector || "";

		Form.formSelector = selector;
		Form.hideError();

		var settings =
		{
			fileName: "/CAGetInvolvedFormSend/",
			parameters: { q: fThis },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: false,
			okCallBackFn: "Form.getInvolvedFormSend_ok",
			errorCallBackFn: "Form.getInvolvedFormSend_error",
		};
		AjaxRequest.send(settings);
	},

	getInvolvedFormSend_ok: function(data)
	{
		//Отображаем ответ
		$(Form.formSelector)[0].reset();

		$.fancybox.close();
		$("#myModal").remove();

		//Вставляем форму отвeта в тело сайта
		$("body").append(data.modalHtml);

		$.fancybox.open(
		{
			src: '#myModal',
			type: 'inline',
			opts: {}
		});
	},

	getInvolvedFormSend_error: function(data)
	{
		Form.showError(data);
	},

	//--------------------------------------------------------------------------------------------------------

	contactUsFormSend: function(fThis, selector)
	{
		selector = selector || "";

		Form.formSelector = selector;
		Form.hideError();

		var settings =
		{
			fileName: "/CAContactUsFormSend/",
			parameters: { q: fThis },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: false,
			okCallBackFn: "Form.contactUsFormSend_ok",
			errorCallBackFn: "Form.contactUsFormSend_error",
		};
		AjaxRequest.send(settings);
	},

	contactUsFormSend_ok: function(data)
	{
		//Отображаем ответ
		$(Form.formSelector)[0].reset();

		$.fancybox.close();
		$("#myModal").remove();

		//Вставляем форму отвeта в тело сайта
		$("body").append(data.modalHtml);

		$.fancybox.open(
		{
			src: '#myModal',
			type: 'inline',
			opts: {}
		});
	},

	contactUsFormSend_error: function(data)
	{
		Form.showError(data);
	},

	//--------------------------------------------------------------------------------------------------------

	projectVideoFormShow: function(event, projectVideoId)
	{
		event.preventDefault();
		event.stopPropagation();

		$.fancybox.close(true);
		$("#myModal").remove();

		var settings =
			{
				fileName: "/CAProjectVideoFormShow/",
				parameters: { projectVideoId: projectVideoId },
				messageType: "alert",
				showOkMessage: false,
				showErrorMessage: true,
				okCallBackFn: "Form.projectVideoFormShow_ok",
				errorCallBackFn: "Form.projectVideoFormShow_error",
			};
		AjaxRequest.send(settings);
	},

	projectVideoFormShow_ok: function(data)
	{
		$.fancybox.close(true);
		$("#myModal").remove();

		$("body").append(data.modalHtml);

		$.fancybox.open(
		{
			src: '#myModal',
			type: 'inline',
			smallBtn: false,
			opts: {}
		});
	},

	projectVideoFormShow_error: function(data)
	{
		Form.showError(data);
	},

	//--------------------------------------------------------------------------------------------------------

	projectVideoFormSend: function(fThis, selector)
	{
		selector = selector || "";

		Form.formSelector = selector;
		Form.hideError();

		var settings =
			{
				fileName: "/CAProjectVideoFormSend/",
				parameters: { q: fThis },
				messageType: "alert",
				showOkMessage: false,
				showErrorMessage: false,
				okCallBackFn: "Form.projectVideoFormSend_ok",
				errorCallBackFn: "Form.projectVideoFormSend_error",
			};
		AjaxRequest.send(settings);
	},

	projectVideoFormSend_ok: function(data)
	{
		if ("" !== data.href)
		{
			window.location.href = data.href;
		}

		//Отображаем ответ
		$(Form.formSelector)[0].reset();

		$.fancybox.close();
		$("#myModal").remove();

		//Вставляем форму ответа в тело сайта
		$("body").append(data.modalHtml);

		$.fancybox.open(
		{
			src: '#myModal',
			type: 'inline',
			opts: {}
		});
	},

	projectVideoFormSend_error: function(data)
	{
		Form.showError(data);
	},

	//--------------------------------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------------------------------

	getModal: function(modalTitle, modalBody)
	{
		var modalTitle = modalTitle || null;
		var modalBody = modalBody || null;

		var settings =
		{
			fileName: "/CAGetModal/",
			parameters: { modalTitle: modalTitle, modalBody: modalBody },
			messageType: "alert",
			showOkMessage: false,
			showErrorMessage: false,
			okCallBackFn: "Form.getModal_ok",
			errorCallBackFn: "Form.getModal_error",
		};
		AjaxRequest.send(settings);
	},

	getModal_ok: function(data)
	{
		//Отображаем ответ
		$(Form.formSelector)[0].reset();

		$.fancybox.close();

		if ($("#myModal").length > 0)
		{
			$("#myModal").remove();
		}
		//Вставляем форму отвeта в тело сайта
		$("body").append(data.modalHtml);

		$.fancybox.open(
		{
			src: '#myModal',
			type: 'inline',
			opts: {}
		});
	},

	getModal_error: function(data)
	{
	},

	//--------------------------------------------------------------------------------------------------------

	setValueToField: function(pThis, fieldName, fieldValue)
	{
		var form = $(pThis).closest("form");

		$("[name='"+fieldName+"']", form).val(fieldValue);
	},

	//--------------------------------------------------------------------------------------------------------

	//Отображает все ошибки на всех формах
	showOk: function(data)
	{
		$(Form.formSelector)[0].reset();

		//Выводим текст ошибки над формой
		if(typeof(data["okText"]) !== "undefined" && data["okText"] != "")
		{
			$("[id='form_message']", Form.formSelector)
			.html(data["okText"])
			.addClass("alert-success")
			.show("slow");

			setTimeout(function()
			{
				$(".alert.alert-success").empty().removeClass("alert-success").hide();
			}, 50000);
		}
	},

	//Отображает все ошибки на всех формах
	showError: function(data)
	{
		//Выводим текст ошибки над формой
		if(typeof(data["errorText"]) !== "undefined" && data["errorText"] != "")
		{
			$("[id='form_message']", Form.formSelector)
			.html(data["errorText"])
			.addClass("alert-danger")
			.show("slow");
		}

		if(typeof(data["error"]) !== "undefined")
		{
			//Обходим все ошибки и выводим их
			$.each(data["error"], function(key, val)
			{
				//Выводим текст ошибки
				$("[id='form_message-" + val["inputName"] + "']", Form.formSelector)
				.html(val["errorText"])
				.addClass("alert-danger")
				.show("slow");

				var backgroundColor = $("input[name='" + val["inputName"] + "']", Form.formSelector).css("background-color");

				$("input[name='" + val["inputName"] + "']", Form.formSelector)
				.focus()
				.css({ "background-color": "#FFD6D6" })
				.delay(2000)
				.animate({ "background-color": backgroundColor }, 800);
			});
		}
	},

	//Скрывает все поля с ошибками на всех формах
	hideError: function()
	{
		//Скрываем текст ошибки над формой
		$("#form_message", Form.formSelector).empty().hide();

		//Скрываем текст ошибки на input-ами
		$("[id^='form_message-']", Form.formSelector).empty().hide();

		$(".alert", Form.formSelector).removeClass("alert-danger");
	}

	//--------------------------------------------------------------------------------------------------------

};
