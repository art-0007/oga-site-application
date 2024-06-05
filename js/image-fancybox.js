$(function ()
{
	ImageFancybox.init();
});

var ImageFancybox =
{
	init: function ()
	{
		//Вешаем плагин просмотра изображений (загруженных через tinymce) в fancybox
		this.initFancybox();
	},

	initFancybox: function ()
	{
		//Обходим все изображения для fancybox
		$(".fancyBoxImg")
		.each(function()
		{
			//Добавляем ссылку на большое изображение в атрибут href ссылки
			$(this).attr("href", $(this).attr("data-big-img-src"));
		});

		//Вешаем плагин просмотра изображений на все мини изображения товара
		$(".fancyBoxImg").fancybox(
		{
            autoSize: true,
			autoCenter: true,
			nextEffect: "fade",
			prevEffect: "fade",
			overlayShow: true, 
			overlayOpacity: 0.8,	
			hideOnContentClick:false,
			centerOnScroll: false,
			helpers:
			{
				title: null
			}
		});
	}
};