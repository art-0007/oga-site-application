$(function ()
{
	Rotator.init();
});

var Rotator =
{
	//-------------------------------------------------------------------

	init: function ()
	{
	},

	//-------------------------------------------------------------------

	//инициализация баннеров
	initSlider: function(selector)
	{
		if (0 === $(".initBanner", selector).length)
		{
			return;
		}

		$(".initBanner", selector).slick(
		{
			infinite: true,
			dots: false,
			arrows: false,
			autoplay: true,
			autoplaySpeed: 8000,
			speed: 500,
			adaptiveHeight: true,
			useTransform: false,
			fade: true,
			cssEase: 'linear',
			responsive:
			[
				{
					breakpoint: 768,
					settings:
					{
						arrows: false
					}
				}
			]
		});
	},

	//-------------------------------------------------------------------

	//Партнеры
	initPartnerSlider: function (selector)
	{
		if (0 === $(selector).length)
		{
			return;
		}

		$('.sliderBlock', selector).slick(
		{
			infinite: true,
			dots: false,
			arrows: true,
			prevArrow: $(".slick-prev", selector),
			nextArrow: $(".slick-next", selector),
			autoplay: true,
			autoplaySpeed: 5000,
			slidesToShow: 6,
			slidesToScroll: 1,
			speed: 500,
			fade: false,
			useTransform: false,
			cssEase: 'linear',
			responsive:
			[
				{
					breakpoint: 1201,
					settings:
					{
						slidesToShow: 4
					}
				},
				{
					breakpoint: 992,
					settings:
					{
						slidesToShow: 3
					}
				},
				{
					breakpoint: 768,
					settings:
					{
						slidesToShow: 2
					}
				}
			]
		});
	},

	//-------------------------------------------------------------------

	//Команда
	initTeamSlider: function (selector)
	{
		if (0 === $(selector).length)
		{
			return;
		}

		$('.sliderBlock', selector).slick(
		{
			infinite: true,
			dots: false,
			arrows: true,
			prevArrow: $(".slick-prev", selector),
			nextArrow: $(".slick-next", selector),
			autoplay: true,
			autoplaySpeed: 5000,
			slidesToShow: 4,
			slidesToScroll: 1,
			speed: 500,
			fade: false,
			useTransform: false,
			cssEase: 'linear',
			responsive:
			[
				{
					breakpoint: 1367,
					settings:
						{
							slidesToShow: 3
						}
				},
				{
					breakpoint: 768,
					settings:
						{
							slidesToShow: 2
						}
				},
				{
					breakpoint: 481,
					settings:
						{
							slidesToShow: 1
						}
				}
			]
		});
	},

	//-------------------------------------------------------------------

	//Команда
	initTeamTabsSlider: function (selector)
	{
		if (0 === $(selector).length)
		{
			return;
		}

		$('.sliderBlock', selector).each(function()
		{
			let id = $(this).attr("data-team-id");

			$(this).slick(
			{
				infinite: true,
				dots: false,
				arrows: true,
				prevArrow: $("#tabSliderBtn-team-" + id + " .slick-prev", selector),
				nextArrow: $("#tabSliderBtn-team-" + id + " .slick-next", selector),
				autoplay: true,
				autoplaySpeed: 5000,
				slidesToShow: 4,
				slidesToScroll: 1,
				speed: 500,
				fade: false,
				useTransform: false,
				cssEase: 'linear',
				responsive:
					[
						{
							breakpoint: 1201,
							settings:
								{
									slidesToShow: 4
								}
						},
						{
							breakpoint: 992,
							settings:
								{
									slidesToShow: 3
								}
						},
						{
							breakpoint: 768,
							settings:
								{
									slidesToShow: 2
								}
						}
					]
			});
		});
	},

	//-------------------------------------------------------------------

	//инициализация баннеров
	initIVSlider: function(selector)
	{
		if (0 === $(".sliderBlock", selector).length)
		{
			return;
		}
		$('.sliderBlock', selector).each(function()
		{
			let parent = $(this).closest(".innerWrapper");

			$(this).slick(
			{
				infinite: true,
				dots: false,
				arrows: true,
				autoplay: false,
				autoplaySpeed: 8000,
				slidesToShow: 5,
				slidesToScroll: 1,
				prevArrow: $(".slick-prev", parent),
				nextArrow: $(".slick-next", parent),
				speed: 500,
				fade: false,
				useTransform: false,
				cssEase: 'linear',
				responsive:
				[
					{
						breakpoint: 1367,
						settings:
						{
							slidesToShow: 4
						}
					},
					{
						breakpoint: 1201,
						settings:
						{
							slidesToShow: 1
						}
					},
					{
						breakpoint: 768,
						settings:
						{
							slidesToShow: 2
						}
					},
					{
						breakpoint: 481,
						settings:
						{
							slidesToShow: 1
						}
					}
				]
			});
		});
	},

	//-------------------------------------------------------------------

	//инициализация баннеров
	initArticleImageSlider: function(selector)
	{
		if (0 === $(".sliderBlock", selector).length)
		{
			return;
		}

		let articleImageSlider = $(".sliderBlock", selector);

		$(articleImageSlider).on('init', function(event, slick)
		{
			let prevSlide = slick.currentSlide - 1;
			let nextSlide = slick.currentSlide + 1;

			$(".sliderBlock .item", selector).removeClass("slick-active-prev");
			$(".sliderBlock .item[data-slick-index='" + prevSlide + "']", selector).addClass("slick-active-prev");

			$(".sliderBlock .item", selector).removeClass("slick-active-next");
			$(".sliderBlock .item[data-slick-index='" + nextSlide + "']", selector).addClass("slick-active-next");
		});

		$(articleImageSlider).slick(
		{
			infinite: true,
			dots: false,
			arrows: true,
			autoplay: false,
			autoplaySpeed: 8000,
			slidesToShow: 5,
			slidesToScroll: 1,
			prevArrow: $(".slick-prev", selector),
			nextArrow: $(".slick-next", selector),
			centerMode: true,
			centerPadding: '0px',
			variableWidth: true,
			speed: 100,
			fade: false,
			useTransform: false,
			cssEase: 'linear',
			responsive:
			[
				{
					breakpoint: 1367,
					settings:
					{
						slidesToShow: 3,
					}
				}
			]
		});

		$(articleImageSlider).on('afterChange', function(event, slick, currentSlide)
		{
			let prevSlide = currentSlide - 1;
			let nextSlide = currentSlide + 1;

			$(".sliderBlock .item", selector).removeClass("slick-active-prev");
			$(".sliderBlock .item[data-slick-index='" + prevSlide + "']", selector).addClass("slick-active-prev");

			$(".sliderBlock .item", selector).removeClass("slick-active-next");
			$(".sliderBlock .item[data-slick-index='" + nextSlide + "']", selector).addClass("slick-active-next");
		});
	},

	//-------------------------------------------------------------------

	//инициализация баннеров
	initArticleImageSlider2: function(selector)
	{
		if (0 === $(".sliderBlock", selector).length)
		{
			return;
		}

		$(".sliderBlock", selector).slick(
		{
			infinite: true,
			dots: false,
			arrows: true,
			autoplay: false,
			autoplaySpeed: 8000,
			slidesToShow: 2,
			slidesToScroll: 1,
			prevArrow: $(".slick-prev", selector),
			nextArrow: $(".slick-next", selector),
			centerMode: true,
			centerPadding: '33.333333%',
			speed: 500,
			useTransform: false,
			cssEase: 'linear'
		});
	}

	//-------------------------------------------------------------------

};
