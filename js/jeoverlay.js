/**
* Плагин JEOverlay ver. 0.82b
*
* Особенности:
* 	1) Используется фреймворк jQuery 1.4.2 и выше
*
* Параметры:
* siteMinWidth - минимальная ширина сайта
* marginTop - отступ блока от верхнего края;
* minMargin - минимально допустимый отступ от верхнего и нижнего края до блока;
* speed - скорость появления блока;
* bgSettings.bgColor - цвет фона;
* bgSettings.opacity - прозрачность фона фона (от 0 до 1);
*
*/

(function ($)
{
	//Возвращает значение отступа сверху, которое
	//нужно для выравнивания элемента по средине страницы
	function f_getMiddleMarginTop(jQThis, settings)
	{
		fMarginTop = null;

		//Расчитываем отступ сверху, чтобы элемент был по середине экрана
		fMarginTop = ($(window).height() - $(jQThis).outerHeight()) / 2;
		fMarginTop = fMarginTop.toFixed(0);

		return fMarginTop;
	};

	//Возвращает верхний отступ
	function f_getMarginTop(jQThis, settings)
	{
		if(settings.marginTop != null)
		{
			//alert("Margin top (NULL):" + settings.marginTop);
			return settings.marginTop;
		}

		var fMarginTop = f_getMiddleMarginTop(jQThis, settings);

		//Проверяем, текущий отступ и минимально допускаемый
		if(settings.minMargin != null && settings.minMargin > fMarginTop)
		{
			//alert("Margin top (min margin):" + settings.minMargin);
   			return settings.minMargin;
		}

		//alert("Margin top:" + fMarginTop);
		return fMarginTop;
	};

	//Возвращает отступ слева
	function f_getMarginLeft(jQThis, settings)
	{
		var fMarginLeft = null; //Отступ слева
		var windowWidth = $(window).width();

		if(settings.siteMinWidth != null && windowWidth < settings.siteMinWidth)
		{
			windowWidth = settings.siteMinWidth;
		}

		//Расчитываем отступ слева, чтобы элемент был по середине экрана
		fMarginLeft = (windowWidth - $(jQThis).outerWidth()) / 2;
		fMarginLeft = fMarginLeft.toFixed(0);

		return fMarginLeft;
	};

	//Возвращает высоту элемента
	function f_getHeight(jQThis, settings)
	{
		if(settings.marginTop != null)
		{
			return false;
		}

		var fHeight = null;
		//Отступ сверху, который нужен для выравнивания элемента по середине
		var fMiddleMarginTop = f_getMiddleMarginTop(jQThis, settings);
		//Текущий отступ сверху
		var fMarginTop = f_getMarginTop(jQThis, settings);

		if(fMarginTop > fMiddleMarginTop)
		{
			fHeight = ($(window).height() - (fMarginTop * 2));
			fHeight = fHeight.toFixed(0);

			return fHeight;
		}

		return false;
	};

	function f_hideBlock(jQThis, settings)
	{
		$(jQThis).fadeOut(settings.speed);

		if($("#" + settings.containerId).length > 0)
		{
			$("#" + settings.containerId).hide(0, function ()
			{
				//Таким образом, убираем глюк в Opera. Если в ней поставить вызов hide и remove в цепочку, внизу остается участок затенения
				$("#" + settings.containerId).remove();
			});
		}
	};

	$.fn.JEOverlay = function (option)
	{
		var jQThis = this;
		var marginTop = null; //Верхний отступ
		var marginLeft = null;
		var height = null;

		var settings = $.extend(
		{
			bgSettings: {},
			siteMinWidth: null,
			containerId: "JETooltipCarrier_div",
			marginTop: null,
			minMargin: 10,
			position: "fixed",
			closeOnEscape: true,
			zIndex: 10000,
			speed: 0
		}, option || {});

		//Настройки фона
		settings.bgSettings = $.extend(
		{
			bgColor: "#000000",
			opacity: 0.5
		}, settings.bgSettings);

		$.extend(this,
		{
			load: function ()
			{
				//Проверяем есть ли уже объект фона
				if (!$("#" + settings.containerId).length)
				{
					//Создаем фон экрана, так как его нет
	    			$("<div></div>")
	    			.attr("id", settings.containerId)
	    			.css("z-index", settings.zIndex - 1)
	    			.css("position", "fixed")
	    			.css("top", "0px")
	    			.css("left", "0px")
	    			.css("background-color", settings.bgSettings.bgColor)
	    			.css("opacity", settings.bgSettings.opacity)
					.css("width", "auto")
					.css("height", "auto")
					.css("top", "0")
					.css("bottom", "0")
					.css("left", "0")
					.css("right", "0")
					.appendTo("body");
				}

				//Показываем сам элемент
				$(jQThis)
				.css("z-index", settings.zIndex)
				.css("position", "fixed")
				.css("top", function () {
					return f_getMarginTop(jQThis, settings) + "px";
				})
				.css("left", function () {
					return f_getMarginLeft(jQThis, settings) + "px";
				})
				.fadeIn(settings.speed);

				if (settings.position == "absolute")
				{
					var top = $(jQThis).offset().top;
					$(jQThis)
					.css("position", "absolute")
					.css("top", top);
				}

				return jQThis;
			},

			close: function (event)
			{
				f_hideBlock(jQThis, settings);
				return jQThis;
			}
		});

		$(function ()
		{
			$(document).keyup(function(event)
			{
				if(event.keyCode == 27 && settings.closeOnEscape == true)
				{
					f_hideBlock(jQThis, settings);
				}
			});
		});

		return this;
	};
})(jQuery);