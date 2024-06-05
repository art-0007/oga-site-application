$(function(){
	Console.init();
});

var Console =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
	},

	//--------------------------------------------------------------------------------------------------------

 	log: function(message)
 	{
 		Console.printMessage(message, "log");
 	},

	//--------------------------------------------------------------------------------------------------------

	info: function(message)
	{
		Console.printMessage(message, "info");
	},

	//--------------------------------------------------------------------------------------------------------

	warn: function(message)
	{
		Console.printMessage(message, "warn");
	},

	//--------------------------------------------------------------------------------------------------------

	error: function(message)
	{
		Console.printMessage(message, "error");
	},

	//--------------------------------------------------------------------------------------------------------

	printMessage: function(message, type)
	{
		if (false === _debugJavaScript) return;
		if ("undefined" == typeof(console)) return;

		//Р•СЃР»Рё СЃРѕРѕР±С‰РµРЅРёРµ СЏРІР»СЏРµС‚СЃСЏ РѕР±СЉРµРєС‚РѕРј, С‚Рѕ РїСЂРµРѕР±СЂР°Р·РѕРІС‹РІР°РµРј РµРіРѕ РІ СЃС‚СЂРѕРєСѓ JSON С„РѕСЂРјР°С‚Р°
		if ("object" == typeof(message))
		{
			message = JSON.stringify(message);
		}

		if ("undefined" == typeof(type))
		{
			type = "log";
		}

		switch(type)
		{
			case "info":
			{
				if (!console.info) return;
				window.console.info(message);
				break;
			}
			case "warn":
			{
				if (!console.warn) return;
				window.console.warn(message);
				break;
			}
			case "error":
			{
				if (!console.error) return;
				window.console.error(message);
				break;
			}
			case "log":
			default:
			{
				if (!console.log) return;
				window.console.log(message);
			}
		}
	}

	//--------------------------------------------------------------------------------------------------------
};
