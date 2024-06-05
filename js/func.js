
$(function()
{
	Func.init();
});

var Func =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
	},

	//--------------------------------------------------------------------------------------------------------

	getRandomString: function(length)
	{
		var result = "";
		var words = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
		var max_position = words.length - 1;
		for( i = 0; i < length; ++i )
		{
			var position = Math.floor (Math.random() * max_position);
			result = result + words.substring(position, position + 1);
		}

		return result;
	},

	//--------------------------------------------------------------------------------------------------------

	getRandomNum: function(length)
	{
		var result = "";
		var words = "0123456789";
		var max_position = words.length - 1;
		for( i = 0; i < length; ++i )
		{
			var position = Math.floor (Math.random() * max_position);
			result = result + words.substring(position, position + 1);
		}

		return result;
	},

	//--------------------------------------------------------------------------------------------------------

	toJSON: function(data)
	{
		return JSON.stringify(data);
	},

	//--------------------------------------------------------------------------------------------------------

	fromJSON: function(str)
	{
		return JSON.parse(str);
	},

	//--------------------------------------------------------------------------------------------------------

	//Функция организована специально для тех случаев, когда ее используют в колбеках, в которых можно вписать только имя функции без других символов
	reloadPage: function(timeout)
	{
		if ("undefined" == typeof(timeout))
		{
			window.location.reload(true);
		}
		else
		{
			setTimeout("window.location.reload(true);", timeout);
		}
	}

	//--------------------------------------------------------------------------------------------------------
};
