$(function ()
{
});

var UrlHash =
{
	//Ключ указывающий на изменение хеша
	manualChangeKey: false,

	init: function ()
	{
	},

	//Ф-ция слушатель изминения хеша
	bindChangeHashFn: function(fFunction)
	{
		$(window).bind("hashchange", function ()
		{
			if(UrlHash.isChangeManualChangeKey())
			{
				//Сбрасываем ключ ручной уставнки хеша в дефолтное значение
    			UrlHash.setManualChangeKeyToDefault();

				return;
			}

			//Вызываем пользовательскую ф-цию
			fFunction();
		});
	},

	//Возвращает хеш
	get: function()
	{
		//Текущий адрес тсраницы
		var url = window.location.href;

		//Проверяем, есть ли хеша в адресе
		if(url.indexOf("#") !== -1)
		{
			//Хеш есть, возвращаем его
			return url.substr(url.indexOf("#") + 1);
		}
		else
		{
			return "";
		}
	},

	//Возвращает хеш в виде массива
	serializeArray: function()
	{
		var varsArray = [];
		var hash = this.get();

		//Если хеш пустой, то возвращаем пустой массив
		if("" == hash)
		{
			return [];
		}

		//Разбиваем хеш по &
		var hashVarsArray = hash.split("&");

		for (var i = 0; i < hashVarsArray.length; i++)
		{
			var varInfo = hashVarsArray[i].split("=", 2);
			//Добавляем переменную в массив
			varsArray.push({ name: varInfo[0], value: varInfo[1] });
		}

		return varsArray;
	},

	//Устанавливаем хеш
	set: function(urlHash)
	{
		//Устанавливаем ключ ручной установки хеша
		this.setManualChangeKeyToProcess();
		//Устанавливаем хеш
		window.location.hash = urlHash;
	},

	//Опредиляем изменяем ли мы хеш сами
	isChangeManualChangeKey: function()
	{
		if (this.manualChangeKey)
		{
			return true;
		}
		else
		{
			return false;
		}
	},

	//Устанавливаем ключ изменения хеша в занчение true
	setManualChangeKeyToProcess: function ()
	{
		this.manualChangeKey = true;
	},

	//Устанавливаем ключ изменения хеша в дефолтное значение
	setManualChangeKeyToDefault: function ()
	{
		this.manualChangeKey = false;
	}
};