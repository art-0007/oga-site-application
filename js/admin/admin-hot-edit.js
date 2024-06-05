$(function()
{
	AdminHotEdit.init();
});

var AdminHotEdit =
{
	//--------------------------------------------------------------------------------------------------------

	init: function()
	{
		this.initClick();
		this.initToolsForEditingListItem();
	},

	//--------------------------------------------------------------------------------------------------------

	//Вешаем клики на елементах с дата атрибутом data-admin-val
	initClick: function()
	{
		$("[data-admin-val]").each(function()
		{
			$(this).click(function()
			{
				if ($(this).attr("data-admin-editKey"))
				{
					return;
				}

				var type = AdminHotEdit.getDataAdminAttributeVal(this, "type");

				switch(type)
				{
					case "input":
					{
						AdminHotEdit.initInput(this);
						break;
					}

					case "textarea":
					{
						AdminHotEdit.initTextarea(this);
						break;
					}

					case "tinymce":
					{
						AdminHotEdit.initTinymce(this);
						break;
					}

					case "image":
					{
						AdminHotEdit.initImage(this);
						break;
					}

					default:
					{
						break;
					}
				}
			});
		});
	},

	//--------------------------------------------------------------------------------------------------------

	//Инпут
	initInput: function(fThis)
	{
		var width = $(fThis).width();
		var content = $(fThis).html();

		//Очищаем содержимое
		$(fThis)
		.attr("data-admin-editKey", "true")
		.empty();

		$("<p class=\"adminHotEditComment\">Enter - сохранить; Esc - отмена.</p>")
		.appendTo(fThis);

		$("<input>")
		.attr("class", "adminHotEditInput")
		.val(content)
		.keyup(function(e)
		{
			if (27 == e.keyCode)
			{
				AdminHotEdit.cancelEdit(fThis);
			}

			if (13 == e.keyCode)
			{
				AdminHotEdit.saveChange(fThis, this);
			}
		})
		.appendTo(fThis)
		.focus();

		$("<div>")
		.attr("class", "adminHideContent")
		.hide()
		.html(content)
		.appendTo(fThis);
	},

	//--------------------------------------------------------------------------------------------------------

	//Textarea
	initTextarea: function(fThis)
	{
		var width = $(fThis).width();
		var height = $(fThis).height();
		var content = $(fThis).html();

		//Очищаем содержимое
		$(fThis)
		.attr("data-admin-editKey", "true")
		.empty();

		$("<p class=\"adminHotEditComment\">Ctrl+Enter - сохранить; Esc - отмена.</p>")
		.appendTo(fThis);

		$("<textarea>")
		.attr("class", "adminHotEditTextarea")
		.css(
			{
				"width": (width - 15) + "px",
				"height": function()
				{
					//Росщитаваем высоту tinymce
					if (height > 400)
					{
						return "400px";
					}
					else
					{
						return (height + 100) + "px";
					}
				}
			})
		.val(content)
		.keyup(function(e)
		{
			if (27 == e.keyCode)
			{
				AdminHotEdit.cancelEdit(fThis);
			}

			if (e.ctrlKey && 13 == e.keyCode)
			{
				AdminHotEdit.saveChange(fThis, this);
			}
		})
		.appendTo(fThis)
		.focus();

		$("<div>")
		.attr("class", "adminHideContent")
		.hide()
		.html(content)
		.appendTo(fThis);
	},

	//--------------------------------------------------------------------------------------------------------

	//Tinymce
	initTinymce: function(fThis)
	{
		var width = $(fThis).width();
		var height = $(fThis).height();
		var tinymceHeight = height;
		var content = $(fThis).html();

		//Очищаем содержимое
		$(fThis)
		.attr("data-admin-editKey", "true")
		.empty();

		$("<textarea>")
		.attr("class", "adminHotEditTextarea")
		.val(content)
		.appendTo(fThis);

		$("<p class=\"adminHotEditButton\"></p>")
		.appendTo(fThis);

		//Кнопка сохранить
		$("<a>")
		.addClass("save")
		.attr("href", "javascript: void(0);")
		.click(function()
		{
			AdminHotEdit.saveChange(fThis, $("textarea", fThis), tinymceEd);
		})
		.appendTo($("p.adminHotEditButton", fThis));

		//Кнопка отмены
		$("<a>")
		.addClass("cancel")
		.attr("href", "javascript: void(0);")
		.click(function()
		{
			AdminHotEdit.cancelEdit(fThis, tinymceEd);
		})
		.appendTo($("p.adminHotEditButton", fThis));

		//Росщитаваем высоту tinymce
		if (tinymceHeight > 500)
		{
			tinymceHeight = 500;
		}
		else
		{
			if (tinymceHeight < 200)
			{
				tinymceHeight = 200;
			}
			else
			{
				tinymceHeight = tinymceHeight + 50;
			}
		}

		var tinymceInitOption = {};
		$.extend(tinymceInitOption, _option1);

		tinymceInitOption.width = width;
		tinymceInitOption.height = tinymceHeight;

		tinymceInitOption.setup = function(editor)
		{
			editor.on('keyup', function(e)
			{
				if(27 == e.keyCode)
				{
					AdminHotEdit.cancelEdit(fThis, tinymceEd);
				}

				if (e.ctrlKey && 83 == e.keyCode)
				{
					AdminHotEdit.saveChange(fThis, $("textarea", fThis), tinymceEd);
				}
			});
		};

		var tinymceEd = $("textarea", fThis).tinymce(tinymceInitOption);

		$("<div>")
		.attr("class", "adminHideContent")
		.hide()
		.html(content)
		.appendTo(fThis);
	},

	//--------------------------------------------------------------------------------------------------------

	//Изображение
	initImage: function(fThis)
	{
		var content = $(fThis).attr("src");

		//Очищаем содержимое
		$(fThis).parent().find("form[data-admin-form-image]").remove();

		$("<input type=\"file\">")
		.attr("class", "adminHotEditInputFile")
		.attr("name", "fileName")
		.change(function()
		{
			AdminHotEdit.saveImageChange(fThis, this);
		})
		.wrap("<form method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"return false\" data-admin-form-image=\"true\">")
		.parent()
		.insertAfter(fThis);

		$(fThis).parent().find("input", "form[data-admin-form-image]")
		.focus()
		.click();
	},

	//--------------------------------------------------------------------------------------------------------

	//Сохраняет редактирование
	saveChange: function(pThis, eThis, tinymceEd)
	{
		var parameters =
			{
				"id": AdminHotEdit.getDataAdminAttributeVal(pThis, "id"),
				"hotEditName": AdminHotEdit.getDataAdminAttributeVal(pThis, "name"),
				"hotEditValue": $(eThis).val(),
				"hotEdit": true
			};

		var settings =
			{
				fileName: "/" + AdminHotEdit.getControllerName(AdminHotEdit.getDataAdminAttributeVal(pThis, "controllerId")) + "/",
				parameters: parameters,
				messageType: "alert",
				showOkMessage: false,
				showErrorMessage: true,
				okCallBackFn: function(data)
				{
					if (typeof(tinymceEd) != "undefined")
					{
						//Удаляем tinymce
						tinymceEd.remove();
					}

					//Очищаем содержимое
					$(pThis)
					.empty()
					.html(data.html);

					setTimeout(function()
					{
						$(pThis).removeAttr("data-admin-editKey");
					}, 1000);
				}
			};
		AjaxRequest.send(settings);
	},

	//--------------------------------------------------------------------------------------------------------

	//Сохраняет редактирование
	saveImageChange: function(pThis, eThis)
	{
		var parameters =
			{
				"id": AdminHotEdit.getDataAdminAttributeVal(pThis, "id"),
				"hotEditName": AdminHotEdit.getDataAdminAttributeVal(pThis, "name"),
				"hotEditValue": eThis,
				"hotEdit": true
			};

		var settings =
			{
				fileName: "/" + AdminHotEdit.getControllerName(AdminHotEdit.getDataAdminAttributeVal(pThis, "controllerId")) + "/",
				parameters: parameters,
				messageType: "alert",
				showOkMessage: false,
				showErrorMessage: true,
				okCallBackFn: function(data)
				{
					//Очищаем содержимое
					$(pThis)
					.attr("src", data.html)
					.parent()
					.find("form[data-admin-form-image]")
					.remove();
				}
			};
		AjaxRequest.send(settings);
	},

	//--------------------------------------------------------------------------------------------------------

	//Отменяет редактирование
	cancelEdit: function(pThis, tinymceEd)
	{
		if (typeof(tinymceEd) != "undefined")
		{
			//Удаляем tinymce
			tinymceEd.remove();
		}

		var content = $("div.adminHideContent", pThis).html();

		//Очищаем содержимое
		$(pThis)
		.empty()
		.html(content);

		setTimeout(function()
		{
			$(pThis).removeAttr("data-admin-editKey");
		}, 1000);
	},

	//--------------------------------------------------------------------------------------------------------

	getDataAdminAttributeVal: function(fThis, name)
	{
		var array = $(fThis).attr("data-admin-val").split("-");

		switch(name)
		{
			case "id":
			{
				return array[0];
			}

			case "type":
			{
				return array[1];
			}

			case "name":
			{
				return array[2];
			}

			case "controllerId":
			{
				return array[3];
			}
		}

		return false;
	},

	//--------------------------------------------------------------------------------------------------------

	//Достает имя обработчика
	getControllerName: function(controllerId)
	{
		var controllerName =
			{
				1: "CAAdminDataEdit",
				2: "CAAdminCatalogEdit",
				3: "CAAdminPageEdit",
				4: "CAAdminArticleEdit",
				5: "CAAdminArticleCatalogEdit"
			}

		return controllerName[controllerId];
	},

	//--------------------------------------------------------------------------------------------------------

	//инструменты редактирования элемента списка
	initToolsForEditingListItem: function()
	{
		var div = "<div id=\"toolsForEditingListItem\"><p><input type=\"checkbox\"><a class=\"edit\" href=\"javascript: void(0)\" title=\"Редактировать\"></a><a class=\"delete\" href=\"javascript: void(0)\" title=\"Удалить\"></a></p></div>";

		$("*[data-admin-parent]").each(function()
		{
			switch($(this).attr("data-admin-parent"))
			{
				case "data":
				{
					var dataId = AdminHotEdit.getDataAdminAttributeVal($("*[data-admin-val]", this), "id");

					//Добавляем
					$(this).prepend(div);

					$("#toolsForEditingListItem input", this)
					.attr("value", dataId);

					$("#toolsForEditingListItem a.edit", this)
					.attr("onclick", "AdminFancyboxPage.show('/admin/data/edit/" + dataId + "/');");

					$("#toolsForEditingListItem a.delete", this)
					.attr("onclick", "AdminData.deleteConfirm(" + dataId + ");");

					break;
				}

				case "article":
				{
					var articleId = AdminHotEdit.getDataAdminAttributeVal($("*[data-admin-val]", this), "id");

					//Добавляем
					$(this).prepend(div);

					$("#toolsForEditingListItem input", this)
					.attr("value", articleId);

					$("#toolsForEditingListItem a.edit", this)
					.attr("onclick", "AdminFancyboxPage.show('/admin/article/edit/" + articleId + "/');");

					$("#toolsForEditingListItem a.delete", this)
					.attr("onclick", "AdminArticle.deleteConfirm(" + articleId + ");");

					break;
				}

				case "article-catalog":
				{
					var articleCatalogId = AdminHotEdit.getDataAdminAttributeVal($("*[data-admin-val]", this), "id");

					//Добавляем
					$(this).prepend(div);

					$("#toolsForEditingListItem input", this)
					.attr("value", articleCatalogId);

					$("#toolsForEditingListItem a.edit", this)
					.attr("onclick", "AdminFancyboxPage.show('/admin/article-catalog/edit/" + articleCatalogId + "/');");

					$("#toolsForEditingListItem a.delete", this)
					.attr("onclick", "AdminArticleCatalog.deleteConfirm(" + articleCatalogId + ");");

					break;
				}

				default:
				{
					break;
				}
			}
		});
	},

	//--------------------------------------------------------------------------------------------------------

	getSelectedRowsIdArray: function (objectName)
	{
		var idArray = [];

		switch(objectName)
		{
			case "data":
			{
				$("*[data-admin-parent=\"data\"]").each(function()
				{
					if ($("#toolsForEditingListItem input", this).prop("checked"))
					{
						idArray.push(AdminHotEdit.getDataAdminAttributeVal($("*[data-admin-val]", this), "id"));
					}
				});

				break;
			}

			case "article":
			{
				$("*[data-admin-parent=\"article\"]").each(function()
				{
					if ($("#toolsForEditingListItem input", this).prop("checked"))
					{
						idArray.push(AdminHotEdit.getDataAdminAttributeVal($("*[data-admin-val]", this), "id"));
					}
				});

				break;
			}

			default:
			{
				break;
			}
		}

		return idArray;
	}

	//--------------------------------------------------------------------------------------------------------
};
