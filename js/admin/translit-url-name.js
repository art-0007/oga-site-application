$(function()
{
	TranslitUrlName.init();
});

var TranslitUrlName =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
	},

	//--------------------------------------------------------------------------------------------------------

	setTranslit: function()
	{
  		var _title = $("input[name='title']", ".editForm").val();

		var settings =
		{
			fileName: "/CAAdminTranslitUrlName/",
			parameters: { title: _title },
			messageType: "poupup",
			showOkMessage: false,
			showErrorMessage: true,
			okCallBackFn: "TranslitUrlName.setTranslit_ok"
		};
		AjaxRequest.send(settings);
	},

	setTranslit_ok: function(data)
	{
		$("input[name='urlName']", ".editForm").val(data.urlName);
	}

	//--------------------------------------------------------------------------------------------------------
};
