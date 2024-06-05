$(function()
{
	GalleryView.init();
});

var GalleryView =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		//Вешаем плагин просмотра изображений (загруженных через tinymce) в fancybox
		this.initFancybox();
	},

	//--------------------------------------------------------------------------------------------------------

	initFancybox: function ()
	{
		//Вешаем плагин просмотра изображений
		$(".popupImage")
		.attr("rel", "thumbnail")
		.fancybox(
		{
			autoSize: true,
			autoCenter: true,
			nextEffect: "fade",
			prevEffect: "fade",
			helpers:
			{
				title: null
			}
		});
	}

	//--------------------------------------------------------------------------------------------------------
};
