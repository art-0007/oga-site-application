$(function()
{
	Index.init();
});

var Index =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		Rotator.initSlider("#indexSlider");
		Index.initSliderBtnDown();
	},

	//--------------------------------------------------------------------------------------------------------

	initSliderBtnDown: function()
	{
		var indexBottonSliderOffset = $("#indexBottonSlider").offset();

		indexBottonSliderOffset = indexBottonSliderOffset.top * 0.3;

		$(window).scroll(function()
		{
			var scrollTop = $(window).scrollTop();

			if (scrollTop > indexBottonSliderOffset)
			{
				$("#indexSlider .btnDown").hide();
			}
			else
			{
				$("#indexSlider .btnDown").show();
			}
		});
	}

	//--------------------------------------------------------------------------------------------------------

};
