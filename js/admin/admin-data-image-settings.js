$(function()
{
	AdminDataImageSettingsEdit.init();
});

var AdminDataImageSettingsEdit =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
	   this.initEvents();
	},

	//--------------------------------------------------------------------------------------------------------

	initEvents: function()
	{
		//--------------------------------------------------------------------------------------------------------

		$("[id^='id_changeTypeToJPG_radio_']").bind("click", function(){
			var id = $(this).attr("id");
			id = id.replace("id_changeTypeToJPG_radio_", "");
			$("#id_changeTypeToPNG_div_" + id).slideUp(200, function(){
				$("#id_changeTypeToJPG_div_" + id).slideDown(200);
			});
		});

		//--------------------------------------------------------------------------------------------------------

		$("[id^='id_changeTypeToPNG_radio_']").bind("click", function(){
			var id = $(this).attr("id");
			id = id.replace("id_changeTypeToPNG_radio_", "");
			$("#id_changeTypeToJPG_div_" + id).slideUp(200, function(){
				$("#id_changeTypeToPNG_div_" + id).slideDown(200);
			});
		});

		//--------------------------------------------------------------------------------------------------------

		$("[id^='id_changeTypeToGIF_radio_']").bind("click", function(){
			var id = $(this).attr("id");
			id = id.replace("id_changeTypeToGIF_radio_", "");
			$("#id_changeTypeToJPG_div_" + id).slideUp(200);
			$("#id_changeTypeToPNG_div_" + id).slideUp(200);
		});

		//--------------------------------------------------------------------------------------------------------

		$("[id^='id_cropPositionFixedTrue_radio_']").bind("click", function(){
			var id = $(this).attr("id");
			id = id.replace("id_cropPositionFixedTrue_radio_", "");
			if ($("#id_cropPositionFixedTrue_radio_" + id).prop("checked"))
			{
				$("#id_cropPositionFixedFalse_div_" + id).slideUp(500, function(){
					$("#id_cropPositionFixedTrue_div_" + id).slideDown(500);
				});
			}
		});

		$("[id^='id_cropPositionFixedFalse_radio_']").bind("click", function(){
			var id = $(this).attr("id");
			id = id.replace("id_cropPositionFixedFalse_radio_", "");
			if ($("#id_cropPositionFixedFalse_radio_" + id).prop("checked"))
			{
				$("#id_cropPositionFixedTrue_div_" + id).slideUp(500, function(){
					$("#id_cropPositionFixedFalse_div_" + id).slideDown(500);
				});
			}
		});

		//--------------------------------------------------------------------------------------------------------

		$("[id^='id_watermarkPositionFixedTrue_radio_']").bind("click", function(){
			var id = $(this).attr("id");
			id = id.replace("id_watermarkPositionFixedTrue_radio_", "");
			if ($("#id_watermarkPositionFixedTrue_radio_" + id).prop("checked"))
			{
				$("#id_watermarkPositionFixedFalse_div_" + id).slideUp(500, function(){
					$("#id_watermarkPositionFixedTrue_div_" + id).slideDown(500);
				});
			}
		});

		$("[id^='id_watermarkPositionFixedFalse_radio_']").bind("click", function(){
			var id = $(this).attr("id");
			id = id.replace("id_watermarkPositionFixedFalse_radio_", "");
			if ($("#id_watermarkPositionFixedFalse_radio_" + id).prop("checked"))
			{
				$("#id_watermarkPositionFixedTrue_div_" + id).slideUp(500, function(){
					$("#id_watermarkPositionFixedFalse_div_" + id).slideDown(500);
				});
			}
		});

		//--------------------------------------------------------------------------------------------------------

		$("input[name^='watermarkPosition_']").bind("click", function(){
			var id = $(this).attr("name");
			id = id.replace("watermarkPosition_", "");
			AdminDataImageSettingsEdit.selectWatermarkPosition($(this).val(), id);
		});

		//--------------------------------------------------------------------------------------------------------

		$("input[name^='cropPosition_']").bind("click", function(){
			var id = $(this).attr("name");
			id = id.replace("cropPosition_", "");
			AdminDataImageSettingsEdit.selectCropPosition($(this).val(), id);
		});

		//--------------------------------------------------------------------------------------------------------
	},

	//--------------------------------------------------------------------------------------------------------

	deselectAllWatermarkPosition: function(id)
	{
		$("input[name='watermarkPosition_" + id + "']").each(function(){
			//$(this).parent().css("background-color", "inherit");
			$(this).parent().removeClass("imageProcessTemplatePostion_selected");
		});
	},

	//--------------------------------------------------------------------------------------------------------

	selectWatermarkPosition: function(position, id)
	{
		AdminDataImageSettingsEdit.deselectAllWatermarkPosition(id);
		$("input[name='watermarkPosition_" + id + "'][value='" + position + "']").prop("checked", true).parent().addClass("imageProcessTemplatePostion_selected");
	},

	//--------------------------------------------------------------------------------------------------------

	edit: function(fThis)
	{
		var settings =
		{
			fileName: "/CAAdminDataImageSettingsEdit/",
			parameters: { q: fThis },
			messageType: "poupup",
			showOkMessage: true,
			showErrorMessage: true,
			okCallBackFn: "AdminDataImageSettingsEdit.edit_ok",
		};
		AjaxRequest.send(settings);
	},

	edit_ok: function()
	{
		window.location.reload(true);
	}

	//--------------------------------------------------------------------------------------------------------
};
