$(function()
{
	AdminFancyboxPage.init();
});

var AdminFancyboxPage =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
	},

	//--------------------------------------------------------------------------------------------------------

	show: function(url)
	{
		var fancyboxWidth = "90%";
		var fancyboxHeight = $(window).height() - 100;

		//Макс. допустимая ширина 960
		if ($(window).width < 1024)
		{
			fancyboxWidth = "98%";
		}
		/*
				//Расчитываем ширину окна fancybox (16/9=1.78)
				var width = ($(window).height() - 100) * 1.78;

				//Макс. допустимая ширина 960
				if (width > 960)
				{
					width = 960;
				}
				width: width,
				height: $(window).height() - 100,
		*/

		$.fancybox.open(
			[
				{
					src: url,
					type: "iframe",
					iframe :
						{
							css :
								{
									width : fancyboxWidth,
									height : fancyboxHeight
								}
						}
				}
			]);

		return false;
	}

	//--------------------------------------------------------------------------------------------------------
};
