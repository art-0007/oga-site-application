$(function()
{
	AdminFancyboxTinymce.init();
});

var AdminFancyboxTinymce =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
	},

	initTinymce: function()
	{
		_option1.selector = ".textareaTinymce";

		tinymce.init(_option1);
	}

	//--------------------------------------------------------------------------------------------------------

};