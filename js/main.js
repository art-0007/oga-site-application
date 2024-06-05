$(function()
{
	Main.init();
});

var Main =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		Main.siteLoad();
		Main.fixScroll();
		Main.initTicker();

		Rotator.initTeamSlider(".el_teamBlock_xs8uVQpL");
		Rotator.initPartnerSlider("#partnerSlider");

		//Main.initTab();

		//Инициализация кнопки вверх
		Main.bottonUpInit();
	},

	//--------------------------------------------------------------------------------------------------------

	showMoreCatalog: function()
	{
  		$(".catalogListBlock .catalogItem").removeClass("hidden");
  		$(".catalogListBlock .od").removeClass("hidden");
  		$(".catalogListBlock .showMore").hide();
	},

	//--------------------------------------------------------------------------------------------------------

	setLang: function(langId, event)
	{
		event.stopPropagation();
		event.preventDefault();

		$.cookies.set("langId", langId, { path: "/", domain: "." + _domain, hoursToLive: 0 });
		window.location.reload(true);
	},

	//--------------------------------------------------------------------------------------------------------

	logout: function()
	{
		var settings =
		{
			fileName: "/CALogout/",
			showOkMessage: false,
			okCallBackFn: function(){window.location.reload(true);}
		};
		AjaxRequest.send(settings);
	},

	//--------------------------------------------------------------------------------------------------------

	menuClick: function(anchor)
	{
		window.location.hash = anchor;
		Main.siteLoad();
	},

	//--------------------------------------------------------------------------------------------------------

	//Фикс
	fixScroll: function()
	{
		//Получаем текущий отступ сверху
		var scrollTop = $(window).scrollTop();
		//Скрулим окно на 1px вниз и вверх
		$(window).scrollTop(scrollTop + 1).scrollTop(scrollTop - 1).scrollTop(scrollTop);
	},

	//--------------------------------------------------------------------------------------------------------

	siteLoad: function()
	{
		//Проверяем, есть ли хеш в адресе
		if(window.location.hash !== "")
		{
			//Достаем текущий URL страницы
			var currentUrl = document.location.href;
			//Достаем хэш без решетки
			var urlHash = currentUrl.substring(currentUrl.indexOf("#") + 1);
			//Разбиваем urlHash по знаку "-"
			var urlHashArray = urlHash.split("-");

			switch(urlHashArray[0])
			{
				//Продукты
				case "products":
				{
					//Проматываем к product
					Main.scrollTo("products");
					break;
				}
				//Продукты
				case "advantages":
				{
					//Проматываем к advantages
					Main.scrollTo("advantages");
					break;
				}
				//Контакты
				case "contacts":
				{
					//Проматываем к contacts
					Main.scrollTo("contacts");
					break;
				}
				default:
				{
					break;
				}
			}
		}
	},

	//--------------------------------------------------------------------------------------------------------

	scrollTo: function(anchor, event)
	{
		var event = event || null;

		if (null !== event)
		{
			event.preventDefault();
			event.stopPropagation();
		}

		var heightAdminPanel = $(".adminPanelCarrier_div").outerHeight();
		var heightHeader = $("#headerCD").outerHeight();
		var offTop = heightAdminPanel + heightHeader;

		$.scrollTo("#" + anchor, 1250,
		{
			offset: { top: -offTop, left: 0 }
		});
	},

	//--------------------------------------------------------------------------------------------------------

	showAndHideBlock: function(fThis, selector)
	{
		if ($(selector).is(":hidden"))
		{
			$(fThis)
			.removeClass("rolled")
			.addClass("deployed");
			$(selector).slideDown("slow");
		}
		else
		{
			$(fThis)
			.removeClass("deployed")
			.addClass("rolled");
			$(selector).slideUp("slow");
		}
	},

	//---------------------------------------------------------------

	pdsp: function(event)
	{
		event.preventDefault();
		event.stopPropagation();
	},

	//---------------------------------------------------------------

	toggleClassBlock: function(e, fThis, selector, toggleClass, setBodyToggleClassKey)
	{
		e.preventDefault();
		e.stopPropagation();

		var selector = selector || null;
		var toggleClass = toggleClass || "open";
		var setBodyToggleClassKey = setBodyToggleClassKey || false;

		$(fThis).toggleClass(toggleClass);

		if (null !== selector)
		{
			$(selector).toggleClass(toggleClass);
		}

		if (setBodyToggleClassKey)
		{
			$("body").toggleClass(toggleClass);
		}
	},

	//---------------------------------------------------------------

	slideToggleBlock: function(fThis, selector, toggleClass)
	{
		var selector = selector || null;
		var toggleClass = toggleClass || "open";

		$(fThis).toggleClass(toggleClass);

		if (null !== selector)
		{
			$(selector).slideToggle();
		}
	},

	//--------------------------------------------------------------------------------------------------------

	initTicker: function()
	{
		$(".marqueeBlock").each(function()
		{
			var pThis = this;

			var tickerListItemHtml = $(pThis).html();

			for (var i = 0; i < 10; i++)
			{
				$(pThis).append(tickerListItemHtml);
			}

			$(pThis).marquee(
				{
					duration: 5000,
					startVisible: true,
					duplicated: true,
					delayBeforeStart: 0,
					speed: 30,
					gap: 0,
					pauseOnHover: false
				});
		});
	},

	//--------------------------------------------------------------------------------------------------------

	initTab: function ()
	{
		$(".tabsBlock").each(function()
		{
			var tabsBlockSelector = $(this);
			var setHashKey = $(this).attr("data-set-hash-key");
			var fTabId = $(".tabs .tab:first-child", tabsBlockSelector).attr("data-tab-id");

			$(".tabs .tab[id^='tab-']", tabsBlockSelector).on("click", function()
			{
				Main.showTab(tabsBlockSelector, $(this).attr("data-tab-id"), setHashKey);
			});

			//Достаем информацию о вкладке (ИД вкладки)
			let hashArray = UrlHash.serializeArray();
			let hashTabId = null;

			//Достаем информацию о вкладке (ИД вкладки)
			hashArray.forEach(function(item, i, hashArray)
			{
				if ("tab" === item.name)
				{
					hashTabId = item.value;
				}
			});

			//Если существует ИД вкладки то отображаем ее
			if (null !== hashTabId)
			{
				Main.showTab(tabsBlockSelector, hashTabId, setHashKey);
			}
			else
			{
				//Активируем вкладку по умолчанию
				Main.showTab(tabsBlockSelector, fTabId, setHashKey);
			}
		});
	},

	//---------------------------------------------------------------

	showTab: function(tabsBlockSelector, fTabId, setHashKey)
	{
		$(".tabs .tab[id^='tab-']", tabsBlockSelector).removeClass("active");
		$(".tabs .tab[id='tab-" + fTabId + "']", tabsBlockSelector).addClass("active");

		$(".sliderBtnBlock .btnWrapper[id^='tabSliderBtn-']", tabsBlockSelector).removeClass("active");
		$(".sliderBtnBlock .btnWrapper[id='tabSliderBtn-" + fTabId + "']", tabsBlockSelector).addClass("active");

		$(".tabsContentBlock div[id^='tabContent-']", tabsBlockSelector).removeClass("active");
		$(".tabsContentBlock div[id='tabContent-" + fTabId + "']", tabsBlockSelector).addClass("active");

		//Проверяем, нужно ли устанавливать хеш страницы
		if (1 === parseInt(setHashKey, 10))
		{
			//Добавляем хеш вкладки в адрес страницы
			UrlHash.set("tab=" + fTabId);
		}
	},

	//--------------------------------------------------------------------------------------------------------

	bottonUpInit: function()
	{
		$("<div><i class=\"fa fa-angle-double-up\"></i></div>")
		.attr("id", "bottonUp")
		.click(function()
		{
			$(window).scrollTo("#headerCD", 300);
		})
		.appendTo("body");

		$(window).scroll(function()
		{
			//Высота окна
			var windowHeight = $(window).height();

			if ($(window).scrollTop() >= windowHeight * 0.7)
			{
				$("#bottonUp").fadeIn(300);
			}
			else
			{
				$("#bottonUp").fadeOut(300);
			}
		});
	}

	//--------------------------------------------------------------------------------------------------------

};
