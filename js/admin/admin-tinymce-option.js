_option1 =
{
	selector: "",
	language : 'ru',
	resize: "both",
	width: null,
	height: null,
    menubar : false,
    convert_urls: false,
    fontsize_formats: "0.8rem 0.9rem 1rem 1.1rem 1.2rem 1.3rem 1.4rem 1.5rem 1.6rem 1.7rem 1.8rem 1.9rem 2rem 2.2rem 2.4rem 2.6rem 2.8rem 3rem",
    setup: null,
	body_class: "staticText editor",
	content_css : "/template/css/tiny-mce.css",
	object_resizing : false,
	image_dimensions: false,
	textcolor_map:
	[
		"0151FE", "Blue",
		"1D1D1D", "Dark",
		"EDF3FF", "Light blue",
		"F6F6F6", "Light 2"
	],
	plugins:
	[
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking astrid_image",
         "save table contextmenu directionality emoticons template paste textcolor"
	],
	media_url_resolver: function (data, resolve/*, reject*/)
	{
		if (data.url.indexOf('youtu') !== -1)
		{
			var parser = document.createElement('a');
			parser.href = data.url;

			//parser.protocol; // => "http:"
			//parser.hostname; // => "example.com"
			//parser.port;     // => "3000"
			//parser.pathname; // => "/pathname/"
			//parser.search;   // => "?search=test"
			//parser.hash;     // => "#hash"
			//parser.host; // => "example.com:3000"
			//
			//alert(parser.search);

			var embed = "";

			if (parser.search.indexOf('v=') !== -1)
			{
				var embed = parser.search.replace("?v=", "");
			}
			else
			{
				var embed = parser.pathname;
			}

			var embedHtml = '<div class="videoIframe"><div><iframe src="https://www.youtube.com/embed/' + embed + '" width="100%" height="100%" allowfullscreen="allowfullscreen" frameborder="0" ></iframe></div></div>';
			resolve({html: embedHtml});
		}
		else
		{
			resolve({html: ''});
		}
	},
	templates:
	[
		{title: 'Блок №1', description: 'Блок с двома ячейками 40 / 60', url: '/template/tinymce/typeBlock1.php'},
		{title: 'Блок №2', description: 'Блок с двома ячейками 50 / 50', url: '/template/tinymce/typeBlock1.php'},
		{title: 'Блок №3', description: 'Блок с двома ячейками 60 / 40', url: '/template/tinymce/typeBlock3.php'},
		{title: 'Блок №4', description: 'Блок с тремя елементами в ряд', url: '/template/tinymce/typeBlock4.php'},
	],
	//toolbar: "insertfile undo redo | table | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons"
	toolbar1: "undo redo | styleselect | table | link image astrid_image media | fontsizeselect | template | visualblocks | fullscreen | preview | code",
	toolbar2: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor"
};