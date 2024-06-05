<!-- Коренной шаблон списка файлов хранилища (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
	<div class="toolbar">
		<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			{toolbarButton}
			<td class="filled"><p><a class="addCatalog" {addArticlCatalogHref} title="Создать каталог"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td class="filled"><p><a class="add" {addArticlHref} title="Создать статью"></a></p></td>
			<td class="tdSeparator">&nbsp;</td>
			<td width="*">&nbsp;</td>
		</tr>
		</table>
	</div>

	<div class="articleList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		{tableHeader}
		{articleContent}
		</table>
	</div>
</div>
[/content]

<!-- Дополнительные кнопки тулбара -->
[toolbarButton]
<td class="filled"><p><a class="up" href="/admin/article/{articleCatalogId}/" title="Вверх"></a></p></td>
<td class="tdSeparator widht15px">&nbsp;</td>
[/toolbarButton]

[tableHeader_catalog]
<tr class="trHeader">
	<td><p>Наименование</p></td>
	<td align="center"><p>ID</p></td>
	<td><p>DevName</p></td>
	<td align="center"><p>Позиция</p></td>
	<td align="center"><p>Отображается</p></td>
	<td colspan="2"></td>
</tr>
<tr class="trSeparator">
	<td colspan="7"></td>
</tr>
[/tableHeader_catalog]

[tableHeader_article]
<tr class="trHeader">
	<td width="100"><p>Изображение</p></td>
	<td><p>Наименование</p></td>
	<td align="center"><p>ID</p></td>
	<td align="center"><p>Дата создания</p></td>
	<td align="center"><p>Позиция</p></td>
	<td align="center"><p>Отображается</p></td>
	<td colspan="3"></td>
</tr>
<tr class="trSeparator">
	<td colspan="9"></td>
</tr>
[/tableHeader_article]

<!-- Список каталогов статей -->
[articleCatalogList_empty]
<tr>
	<td colspan="7">
		<p>Список каталогов статей пуст!</p>
	</td>
</tr>
[/articleCatalogList_empty]

<!-- Список статей -->
[articleList_empty]
<tr>
	<td colspan="9">
		<p>Список статей пуст!</p>
	</td>
</tr>
[/articleList_empty]

<!-- Елемент списка каталогов статей (каталог) -->
[articleCatalogListItem]
<tr class="line {zebra}">
	<td class="cursor" onclick="window.location.href = '{href}'"><p style="font-size: 14px; font-weight: bold; color: #000000;">{title}</p></td>
	<td align="center"><p>{id}</p></td>
	<td><p>{devName}</p></td>
	<td align="center"><p>{position}</p></td>
	<td align="center"><p>{show}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/article-catalog/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminArticleCatalog.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/articleCatalogListItem]

<!-- Елемент списка статей -->
[articleListItem]
<tr class="line {zebra}">
	<td><p><img src="{imgSrc}" alt="" height="25" /></p></td>
	<td><p>{title}</p></td>
	<td align="center"><p>{id}</p></td>
	<td align="center"><p>{date}<br />{time}</p></td>
	<td align="center"><p>{position}</p></td>
	<td align="center"><p>{show}</p></td>
	<td class="button"><p><a class="insert_image" href="javascript: void(0);" onclick="window.location.href = '/admin/article-image/{id}/';" title="Изображения статьи"></a></p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/article/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminArticle.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/articleListItem]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления статьи -->
[adminArticleAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.add(this); return false;">
	<input type="hidden" name="articleCatalogId" value="{articleCatalogId}" />

	<div class="title required">Наименование</div>
	<div class="content"><input type="text" name="title" /></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleAdd]

<!-- Шаблон страницы редактирования статьи  -->
[adminArticleEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id статьи - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title"><a href="javascript: void(0)" onclick="$('.articleImgAndVideoBlock').toggle();">Изображения статьи</a></div>
		<div class="content"></div>
		<div class="articleImgAndVideoBlock displayNone">
			<div class="title">
				<img src="{imgSrc1}" style="max-width: 200px;" alt="" />
				<br />
				Изображение статьи №1 (Выводится в списке)
				<a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName1', '{imgSrc1}');" title="Удалить изображение"></a>
			</div>
			<div class="comment">
				Рекомендуемый размер изображение (Указан в настройках каталога): ({articleImgInCatalogWidth_1}X{articleImgInCatalogHeight_1})
				<br />
				Если (0Х0) - Размеры не указаны
				<br />
				Для <strong>"Blog"</strong> Рекомендуемый размер изображение: (412X700)

			</div>
			<div class="content"><input type="file" name="fileName1" /></div>

			<div class="title">
				<img src="{imgSrc2}" style="max-width: 200px;" alt="" />
				<br />
				Изображение статьи №2  (Выводится на странице просмотра)
				<a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName2', '{imgSrc2}');" title="Удалить изображение"></a>
			</div>
			<div class="comment">
				Рекомендуемый размер изображение: ({articleImgInCatalogWidth_2}X{articleImgInCatalogHeight_2})
				<br />
				Если (0Х0) - Размеры не указаны
			</div>
			<div class="content"><input type="file" name="fileName2" /></div>
		</div>

		<div class="title">Отображать статью на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="editFormRow">
			<div>
				<div class="title">Дата создание</div>
				<div class="content"><input class="datepicker" type="text" name="date" value="{date}" /></div>
			</div>
			<div>
				<div class="title">Время создание</div>
				<div class="content"><input class="timepicker" type="text" name="time" value="{time}" /></div>
			</div>
		</div>
		<div class="delimiter"></div>

		<div class="title">Краткое описание</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="title">Текст</div>
		<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>

		{serviceCatalogListBlock}

		{tagLine}

		<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
		<div class="content"></div>
		<div class="seo displayNone">
			<div class="title">Часть ЧПУ адреса статьи. <a href="javascript: void(0)" onclick="TranslitUrlName.setTranslit()">Преобразовать наименование в URL</a></div>
<!--			<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>-->
			<div class="content"><input type="text" name="urlName" value="{urlName}" />-a{id}</div>
			<div class="comment">Если поле будет пустое то ЧПУ будет преобразованно из наменования.<br /> Суфикс "-a{id}" добавляется автоматически</div>

			<div class="title">Текст заголовка страницы</div>
			<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

			<div class="title">metaTitle</div>
			<div class="content"><textarea name="metaTitle">{metaTitle}</textarea></div>

			<div class="title">metaKeywords</div>
			<div class="content"><textarea name="metaKeywords">{metaKeywords}</textarea></div>

			<div class="title">metaDescription</div>
			<div class="content"><textarea name="metaDescription">{metaDescription}</textarea></div>
		</div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit]

<!-- Шаблон страницы редактирования статьи  -->
[adminArticleEdit_project]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">
			<img src="{imgSrc1}" style="max-width: 200px;" alt="" />
			<br />
			Изображение статьи №1 (Выводится в списке)
			<a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName1', '{imgSrc1}');" title="Удалить изображение"></a>
		</div>
		<div class="comment">
			Рекомендуемый размер изображение: (1720 X 600)
			<br />
			Обрезаное изображениебудет: (854 X 600)
		</div>
		<div class="content"><input type="file" name="fileName1" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Отображать на главной</div>
		<div class="content">
			<select name="addField_4">
				<option value="0" {selected_addField_4_0}>Нет</option>
				<option value="1" {selected_addField_4_1}>Да</option>
			</select>
		</div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Показывать кнопку "Donate"</div>
		<div class="content">
			<select name="addField_lang_4">
				<option value="0" {selected_addField_lang_4_0}>Нет</option>
				<option value="1" {selected_addField_lang_4_1}>Да</option>
			</select>
		</div>

		<div class="title">Брать ссылку на из донат</div>
		<div class="content">
			<select name="addField_3">
				{donateSelect}
			</select>
		</div>

		<div class="title">Ссылка (Кнопка "Донат")</div>
		<div class="content"><input type="text" name="addField_lang_5" value="{addField_lang_5}" /></div>

		<div class="title">Самма, $</div>
		<div class="content"><input type="text" name="addField_1" value="{addField_1}" /></div>

		<div class="title">Собранная сумма, $</div>
		<div class="content"><input type="text" name="addField_2" value="{addField_2}" /></div>

		<div class="title">Краткое описание</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="title">Текст</div>
		<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>

		<div class="title">Заголовок блока с видео</div>
		<div class="content"><input type="text" name="addField_lang_1" value="{addField_lang_1}" /></div>

		<div class="title">Краткое описание блока с видео</div>
		<div class="content"><textarea class="textareaTinymce" name="addField_lang_2">{addField_lang_2}</textarea></div>

		<div class="title">Видео</div>
		<div class="content"><textarea name="addField_lang_3">{addField_lang_3}</textarea></div>

		<div class="title">ИД каталога видео (Youtube)</div>
		<div class="content"><input type="text" name="addField_lang_6" value="{addField_lang_6}" /></div>

		<div class="title">ИД каталога Галереи (Вверху страницы)</div>
		<div class="content"><input type="text" name="addField_5" value="{addField_5}" /></div>
		<div class="comment">Можно несколько ИД, через запятую ","</div>

		<div class="title">ИД каталога Галереи (Внизу страницы)</div>
		<div class="content"><input type="text" name="addField_6" value="{addField_6}" /></div>
		<div class="comment">Можно несколько ИД, через запятую ","</div>

		<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
		<div class="content"></div>
		<div class="seo displayNone">
			<div class="title">Часть ЧПУ адреса статьи. <a href="javascript: void(0)" onclick="TranslitUrlName.setTranslit()">Преобразовать наименование в URL</a></div>
			<!--			<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>-->
			<div class="content"><input type="text" name="urlName" value="{urlName}" />-a{id}</div>
			<div class="comment">Если поле будет пустое то ЧПУ будет преобразованно из наменования.<br /> Суфикс "-a{id}" добавляется автоматически</div>

			<div class="title">Текст заголовка страницы</div>
			<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

			<div class="title">metaTitle</div>
			<div class="content"><textarea name="metaTitle">{metaTitle}</textarea></div>

			<div class="title">metaKeywords</div>
			<div class="content"><textarea name="metaKeywords">{metaKeywords}</textarea></div>

			<div class="title">metaDescription</div>
			<div class="content"><textarea name="metaDescription">{metaDescription}</textarea></div>
		</div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_project]

<!-- Шаблон страницы редактирования статьи  -->
[adminArticleEdit_partner]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">
			<img src="{imgSrc1}" style="max-width: 200px;" alt="" />
			<br />
			Изображение статьи №1 (Выводится в списке)
			<a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName1', '{imgSrc1}');" title="Удалить изображение"></a>
		</div>
		<div class="comment">
			Рекомендуемый размер изображение: ({articleImgInCatalogWidth_1}X{articleImgInCatalogHeight_1})
			<br />
			Если (0Х0) - Размеры не указаны

		</div>
		<div class="content"><input type="file" name="fileName1" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_partner]

<!-- Шаблон страницы редактирования статьи  -->
[adminArticleEdit_team]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">
			<img src="{imgSrc1}" style="max-width: 200px;" alt="" />
			<br />
			Изображение статьи №1 (Выводится в списке)
			<a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName1', '{imgSrc1}');" title="Удалить изображение"></a>
		</div>
		<div class="comment">
			Рекомендуемый размер изображение: ({articleImgInCatalogWidth_1}X{articleImgInCatalogHeight_1})
			<br />
			Если (0Х0) - Размеры не указаны

		</div>
		<div class="content"><input type="file" name="fileName1" /></div>

		<div class="title">
			<img src="{imgSrc2}" style="max-width: 200px;" alt="" />
			<br />
			Изображение статьи №2  (Выводится на странице просмотра)
			<a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName2', '{imgSrc2}');" title="Удалить изображение"></a>
		</div>
		<div class="comment">
			Рекомендуемый размер изображение: ({articleImgInCatalogWidth_2}X{articleImgInCatalogHeight_2})
			<br />
			Если (0Х0) - Размеры не указаны
		</div>
		<div class="content"><input type="file" name="fileName2" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Должность</div>
		<div class="content"><input type="text" name="addField_lang_1" value="{addField_lang_1}" /></div>

		<div class="title">Текст</div>
		<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>

		<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
		<div class="content"></div>
		<div class="seo displayNone">
			<div class="title">Часть ЧПУ адреса статьи. <a href="javascript: void(0)" onclick="TranslitUrlName.setTranslit()">Преобразовать наименование в URL</a></div>
			<!--			<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>-->
			<div class="content"><input type="text" name="urlName" value="{urlName}" />-a{id}</div>
			<div class="comment">Если поле будет пустое то ЧПУ будет преобразованно из наменования.<br /> Суфикс "-a{id}" добавляется автоматически</div>

			<div class="title">Текст заголовка страницы</div>
			<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

			<div class="title">metaTitle</div>
			<div class="content"><textarea name="metaTitle">{metaTitle}</textarea></div>

			<div class="title">metaKeywords</div>
			<div class="content"><textarea name="metaKeywords">{metaKeywords}</textarea></div>

			<div class="title">metaDescription</div>
			<div class="content"><textarea name="metaDescription">{metaDescription}</textarea></div>
		</div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_team]

<!-- Шаблон страницы редактирования статьи  -->
[adminArticleEdit_event]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">
			<img src="{imgSrc1}" style="max-width: 200px;" alt="" />
			<br />
			Изображение статьи №1 (Выводится в списке)
			<a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName1', '{imgSrc1}');" title="Удалить изображение"></a>
		</div>
		<div class="comment">
			Указанный размер изображение в каталоге для обрезки: ({articleImgInCatalogWidth_1}X{articleImgInCatalogHeight_1})
			<br />
			Если (0Х0) - Размеры не указаны
			<br />
			Рекомендуемый размер изображение: (845X500)

		</div>
		<div class="content"><input type="file" name="fileName1" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Дата</div>
		<div class="content"><input type="text" name="addField_lang_1" value="{addField_lang_1}" /></div>

		<div class="title">Время</div>
		<div class="content"><input type="text" name="addField_lang_2" value="{addField_lang_2}" /></div>

		<div class="title">Категории событий</div>
		<div class="content"><input type="text" name="addField_lang_3" value="{addField_lang_3}" /></div>

		<div class="title">Website</div>
		<div class="content"><input type="text" name="addField_lang_4" value="{addField_lang_4}" /></div>

		<div class="title">Место проведения</div>
		<div class="content"><textarea name="addField_lang_5">{addField_lang_5}</textarea></div>

		<div class="title">Место проведения (Код карты)</div>
		<div class="content"><textarea name="addField_lang_6">{addField_lang_6}</textarea></div>

		<div class="title">Краткое описание</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="title">Текст</div>
		<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>

		<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
		<div class="content"></div>
		<div class="seo displayNone">
			<div class="title">Часть ЧПУ адреса статьи. <a href="javascript: void(0)" onclick="TranslitUrlName.setTranslit()">Преобразовать наименование в URL</a></div>
			<!--			<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>-->
			<div class="content"><input type="text" name="urlName" value="{urlName}" />-a{id}</div>
			<div class="comment">Если поле будет пустое то ЧПУ будет преобразованно из наменования.<br /> Суфикс "-a{id}" добавляется автоматически</div>

			<div class="title">Текст заголовка страницы</div>
			<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

			<div class="title">metaTitle</div>
			<div class="content"><textarea name="metaTitle">{metaTitle}</textarea></div>

			<div class="title">metaKeywords</div>
			<div class="content"><textarea name="metaKeywords">{metaKeywords}</textarea></div>

			<div class="title">metaDescription</div>
			<div class="content"><textarea name="metaDescription">{metaDescription}</textarea></div>
		</div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_event]

<!-- Шаблон страницы редактирования статьи  -->
[adminArticleEdit_donate]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">
			<img src="{imgSrc1}" style="max-width: 200px;" alt="" />
			<br />
			Изображение статьи №1 (Выводится в блоке)
			<a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName1', '{imgSrc1}');" title="Удалить изображение 1"></a>
		</div>
		<div class="comment">
			Рекомендуемый размер изображение: ({articleImgInCatalogWidth_1}X{articleImgInCatalogHeight_1})
			<br />
			Если (0Х0) - Размеры не указаны

		</div>
		<div class="content"><input type="file" name="fileName1" /></div>

		<div class="title">
			<img src="{imgSrc2}" style="max-width: 200px;" alt="" />
			<br />
			Изображение статьи №2 (Выводится в списке)
			<a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName2', '{imgSrc2}');" title="Удалить изображение 2"></a>
		</div>
		<div class="comment">
			Рекомендуемый размер изображение: ({articleImgInCatalogWidth_2}X{articleImgInCatalogHeight_2})
			<br />
			Если (0Х0) - Размеры не указаны

		</div>
		<div class="content"><input type="file" name="fileName2" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Показывать в блоке "Donate"</div>
		<div class="content">
			<select name="addField_2">
				<option value="0" {selected_addField_2_0}>Нет</option>
				<option value="1" {selected_addField_2_1}>Да</option>
			</select>
		</div>

		<div class="title">Ссылка (Кнопка "Донат")</div>
		<div class="content"><input type="text" name="addField_lang_1" value="{addField_lang_1}" /></div>

		<div class="title">Краткое описание</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_donate]
<!--<div class="title">Система онлайн оплаты</div>-->
<!--<div class="content">-->
<!--	<select name="addField_3">-->
<!--		{orderPaySystemSelect}-->
<!--	</select>-->
<!--</div>-->


<!-- Шаблон страницы редактирования статьи  -->
[adminArticleEdit_donationAmount]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Показывать в инпуте</div>
		<div class="content">
			<select name="addField_2">
				<option value="0" {selected_0}>Нет</option>
				<option value="1" {selected_1}>Да</option>
			</select>
		</div>

		<div class="title">Сумма</div>
		<div class="content"><input type="text" name="addField_1" value="{addField_1}" /></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_donationAmount]

<!-- Шаблон страницы редактирования статьи  -->
[adminArticleEdit_donateInformation]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">Код изображения SVG </div>
		<div class="content"><textarea name="addField_1">{addField_1}</textarea></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Краткое описание</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_donateInformation]

<!-- Шаблон страницы редактирования статьи  -->
[adminArticleEdit_contacts]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Email</div>
		<div class="content"><input type="text" name="addField_1" value="{addField_1}" /></div>

		<div class="title">Телефон</div>
		<div class="content"><input type="text" name="addField_2" value="{addField_2}" /></div>

		<div class="title">Адрес</div>
		<div class="content"><textarea name="addField_lang_1">{addField_lang_1}</textarea></div>

		<div class="title">Краткое описание</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_contacts]

<!-- Шаблон страницы редактирования статьи Соц сетей -->
[adminArticleEdit_socialNetwork]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">
			<img src="{imgSrc1}" style="max-width: 200px;" alt="" />
			<br />
			Изображение статьи №1 (Blue)
			<a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName1', '{imgSrc1}');" title="Удалить изображение 1"></a>
		</div>
		<div class="comment">
			Рекомендуемый размер изображение: ({articleImgInCatalogWidth_1}X{articleImgInCatalogHeight_1})
			<br />
			Если (0Х0) - Размеры не указаны
		</div>
		<div class="content"><input type="file" name="fileName1" /></div>

		<div class="title">
			<img src="{imgSrc2}" style="max-width: 200px;" alt="" />
			<br />
			Изображение статьи №2 (White)
			<a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName2', '{imgSrc2}');" title="Удалить изображение 2"></a>
		</div>
		<div class="comment">
			Рекомендуемый размер изображение: ({articleImgInCatalogWidth_2}X{articleImgInCatalogHeight_2})
			<br />
			Если (0Х0) - Размеры не указаны
		</div>
		<div class="content"><input type="file" name="fileName2" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Ссылка</div>
		<div class="content"><input type="text" name="addField_1" value="{addField_1}" /></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_socialNetwork]

<!-- Шаблон страницы редактирования статьи Соц сетей -->
[adminArticleEdit_ticker]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_ticker]

<!-- Шаблон страницы редактирования статьи -->
[adminArticleEdit_someElement1]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Код изображения SVG </div>
		<div class="content"><textarea name="addField_1">{addField_1}</textarea></div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Краткое описание</div>
		<div class="content"><textarea class="textareaTinymce" name="addField_lang_1">{addField_lang_1}</textarea></div>

		<div class="title">Краткое описание 2</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="title">Текст</div>
		<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>

		<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
		<div class="content"></div>
		<div class="seo displayNone">
			<div class="title">Часть ЧПУ адреса статьи. <a href="javascript: void(0)" onclick="TranslitUrlName.setTranslit()">Преобразовать наименование в URL</a></div>
			<!--			<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>-->
			<div class="content"><input type="text" name="urlName" value="{urlName}" />-a{id}</div>
			<div class="comment">Если поле будет пустое то ЧПУ будет преобразованно из наменования.<br /> Суфикс "-a{id}" добавляется автоматически</div>

			<div class="title">Текст заголовка страницы</div>
			<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

			<div class="title">metaTitle</div>
			<div class="content"><textarea name="metaTitle">{metaTitle}</textarea></div>

			<div class="title">metaKeywords</div>
			<div class="content"><textarea name="metaKeywords">{metaKeywords}</textarea></div>

			<div class="title">metaDescription</div>
			<div class="content"><textarea name="metaDescription">{metaDescription}</textarea></div>
		</div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_someElement1]

<!-- Шаблон страницы редактирования статьи -->
[adminArticleEdit_someElement2]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Код изображения SVG </div>
		<div class="content"><textarea name="addField_1">{addField_1}</textarea></div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Краткое описание</div>
		<div class="content"><textarea class="textareaTinymce" name="addField_lang_1">{addField_lang_1}</textarea></div>

		<div class="title">Краткое описание 2</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="title">Текст</div>
		<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>

		<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
		<div class="content"></div>
		<div class="seo displayNone">
			<div class="title">Часть ЧПУ адреса статьи. <a href="javascript: void(0)" onclick="TranslitUrlName.setTranslit()">Преобразовать наименование в URL</a></div>
			<!--			<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>-->
			<div class="content"><input type="text" name="urlName" value="{urlName}" />-a{id}</div>
			<div class="comment">Если поле будет пустое то ЧПУ будет преобразованно из наменования.<br /> Суфикс "-a{id}" добавляется автоматически</div>

			<div class="title">Текст заголовка страницы</div>
			<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

			<div class="title">metaTitle</div>
			<div class="content"><textarea name="metaTitle">{metaTitle}</textarea></div>

			<div class="title">metaKeywords</div>
			<div class="content"><textarea name="metaKeywords">{metaKeywords}</textarea></div>

			<div class="title">metaDescription</div>
			<div class="content"><textarea name="metaDescription">{metaDescription}</textarea></div>
		</div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_someElement2]

<!-- Шаблон страницы редактирования статьи -->
[adminArticleEdit_selectRequest]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">Отображать на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_selectRequest]

<!-- Шаблон страницы редактирования статьи  -->
[adminArticleEdit_getInvolved]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id статьи - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">Отображать статью на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="editFormRow">
			<div>
				<div class="title">Дата создание</div>
				<div class="content"><input class="datepicker" type="text" name="date" value="{date}" /></div>
			</div>
			<div>
				<div class="title">Время создание</div>
				<div class="content"><input class="timepicker" type="text" name="time" value="{time}" /></div>
			</div>
		</div>
		<div class="delimiter"></div>

		<div class="title">Отображать кнопку формы подачи заявки</div>
		<div class="content">
			<select name="addField_1">
				<option value="0" {selected_0}>Нет</option>
				<option value="1" {selected_1}>Да</option>
			</select>
		</div>

		<div class="title">Краткое описание</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_getInvolved]

<!-- Шаблон страницы редактирования статьи  -->
[adminArticleEdit_projectVideo]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id статьи - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">Отображать статью на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Ссылка на видео в Youtube</div>
		<div class="content"><input type="text" name="addField_lang_1" value="{addField_lang_1}" /></div>

		<div class="title">Показывать кнопку "Donate"</div>
		<div class="content">
			<select name="addField_lang_4">
				<option value="0" {selected_addField_lang_4_0}>Нет</option>
				<option value="1" {selected_addField_lang_4_1}>Да</option>
			</select>
		</div>

		<div class="title">Брать ссылку на из донат</div>
		<div class="content">
			<select name="addField_3">
				{donateSelect}
			</select>
		</div>

		<div class="title">Ссылка (Кнопка "Донат")</div>
		<div class="content"><input type="text" name="addField_lang_5" value="{addField_lang_5}" /></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_projectVideo]

<!-- Шаблон страницы редактирования статьи  -->
[adminArticleEdit_gallery]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticle.edit(this); return false;">
		<input type="hidden" name="id" value="{id}" />

		<div class="title">Id статьи - {id}</div>
		<div class="content"></div>

		<div class="title required">{inputTitleName}</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">
			<img src="{imgSrc1}" style="max-width: 200px;" alt="" />
			<br />
			Изображение статьи №1 (Выводится в списке)
			<a class="deleteButtom" href="javascript: void(0);" onclick="AdminArticleOneImageDelete.deleteConfirm({id}, 'fileName1', '{imgSrc1}');" title="Удалить изображение"></a>
		</div>
		<div class="comment">
			Рекомендуемый размер изображение: ({articleImgInCatalogWidth_1}X{articleImgInCatalogHeight_1})
			<br />
			Если (0Х0) - Размеры не указаны

		</div>
		<div class="content"><input type="file" name="fileName1" /></div>

		<div class="title">Отображать статью на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Ссылка на видео в Youtube</div>
		<div class="content"><input type="text" name="addField_lang_1" value="{addField_lang_1}" /></div>

		<div class="title">Краткое описание</div>
		<div class="content"><textarea name="description">{description}</textarea></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleEdit_gallery]

[articleCatalogListBlock]
<div class="title"><a href="javascript: void(0)" onclick="$('.articleCatalogList').toggle();">Услуги</a></div>
<div class="content"></div>
<div class="articleCatalogList displayNone" style="margin-top: 10px;">{articleCatalogList}</div>
[/articleCatalogListBlock]

[articleCatalogListItem_2]
<div class="subProjectTypeList">
	<p class="articleCatalogTitle">{articleCatalogTitle}</p>
	<div class="checkboxList clearfix">{subArticleCatalogList}</div>
</div>
[/articleCatalogListItem_2]

<!-- Шаблон елимента списка каталога статьи -->
[subArticleCatalogListItem]
<div class="title checkbox item">
	<table cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>
			<td>
				<input id="articleCatalog-{id}" type="checkbox" value="{id}" name="articleCatalogArticle[]" {checked}>
			</td>
			<td>
				<label style="cursor: pointer;" for="articleCatalog-{id}">{title}</label>
			</td>
		</tr>
		</tbody>
	</table>
</div>
[/subArticleCatalogListItem]

<!--  -->
[tagLine]
<div class="title">Теги статьи</div>
<div class="comment width100">В разделе используются такие теги: {tagList}</div>
<div class="content"><textarea class="tagListTextarea" name="tag">{tag}</textarea></div>
<div class="comment width100">Каждый тег добавлять с новой строчки</div>
[/tagLine]

[tagListItem]
<a href="javascript:void(0);" onclick="AdminArticle.setInTextarea('{title}', '.tagListTextarea')">{title}</a>
[/tagListItem]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Шаблон страницы добавления каталога -->
[adminArticleCatalogAdd]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticleCatalog.add(this); return false;">
		<input type="hidden" name="articleCatalogId" value="{articleCatalogId}" />

		<div class="title required">Наименование каталога статей</div>
		<div class="content"><input type="text" name="title" /></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{articleCatalogId}/">Отменить</a></div>
	</form>
</div>
[/adminArticleCatalogAdd]

<!-- Шаблон страницы редактированя каталога -->
[adminArticleCatalogEdit]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticleCatalog.edit(this); return false;">
		<input type="hidden" name="id" value="{articleCatalogId}" />

		<div class="title">ИД каталога - {articleCatalogId}</div>
		<div class="content"></div>
		<div class="title required">Наименование каталога</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title"><a href="javascript: void(0)" onclick="AdminArticleCatalog.showAndHide('catalogImgBlock')">Изображения и размеры изображений каталога</a></div>
		<div id="catalogImgBlock" class="content hide">
			<div class="title"><img src="{imgSrc1}" style="max-width: 200px;" alt="" /><br />Изображение каталога №1</div>
			<div class="content"><input type="file" name="fileName1" /></div>
			<div class="title">Размеры изображения каталога (ШхВ)</div>
			<div class="content"><input class="imgSize" type="text" name="catalogImgWidth_1" value="{catalogImgWidth_1}" /> x <input class="imgSize" type="text" name="catalogImgHeight_1" value="{catalogImgHeight_1}" /></div>
			<div class="comment">Если 0 - то изображение будет загружаться без изменений</div>

			<div class="title"><img src="{imgSrc2}" style="max-width: 200px;" alt="" /><br />Изображение каталога №2</div>
			<div class="content"><input type="file" name="fileName2" /></div>
			<div class="title">Размеры изображения каталога (ШхВ)</div>
			<div class="content"><input class="imgSize" type="text" name="catalogImgWidth_2" value="{catalogImgWidth_2}" /> x <input class="imgSize" type="text" name="catalogImgHeight_2" value="{catalogImgHeight_2}" /></div>
			<div class="comment">Если 0 - то изображение будет загружаться без изменений</div>
		</div>

		<div class="title"><a href="javascript: void(0)" onclick="AdminArticleCatalog.showAndHide('articleImgInCatalogBlock')">Размеры изображения статей в нутри каталога</a></div>
		<div id="articleImgInCatalogBlock" class="content hide">
			<div class="title">Размеры изображения статей в нутри каталога №1 (ШхВ)</div>
			<div class="content"><input class="imgSize" type="text" name="articleImgInCatalogWidth_1" value="{articleImgInCatalogWidth_1}" /> x <input class="imgSize" type="text" name="articleImgInCatalogHeight_1" value="{articleImgInCatalogHeight_1}" /></div>
			<div class="comment">Если 0 - то изображение будет загружаться без изменений</div>
			<div class="title">Размеры изображения статей в нутри каталога №2 (ШхВ)</div>
			<div class="content"><input class="imgSize" type="text" name="articleImgInCatalogWidth_2" value="{articleImgInCatalogWidth_2}" /> x <input class="imgSize" type="text" name="articleImgInCatalogHeight_2" value="{articleImgInCatalogHeight_2}" /></div>
			<div class="comment">Если 0 - то изображение будет загружаться без изменений</div>
		</div>

		<div class="title">Отображать каталог статей на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция каталога</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Позиция данных в нутри каталога</div>
		<div class="content"><select name="orderInCatalog">{orderInCatalogSelect}</select></div>

		<div class="title">Описание</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="title">Текст</div>
		<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>

		{adminFileCatalogField}

		<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
		<div class="content"></div>
		<div class="seo displayNone">
			<div class="title">Часть ЧПУ адреса каталога статей. <a href="javascript: void(0)" onclick="TranslitUrlName.setTranslit()">Преобразовать наименование в URL</a></div>
<!--		<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>-->
			<div class="content"><input type="text" name="urlName" value="{urlName}" />-ac{id}</div>
			<div class="comment">Если поле буднт пустое то ЧПУ будет преобразованно из наменования.<br /> Суфикс "-ac{id}" добавляется автоматически</div>

			<div class="title">Текст заголовка страницы</div>
			<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

			<div class="title">metaTitle</div>
			<div class="content"><textarea name="metaTitle">{metaTitle}</textarea></div>

			<div class="title">metaKeywords</div>
			<div class="content"><textarea name="metaKeywords">{metaKeywords}</textarea></div>

			<div class="title">metaDescription</div>
			<div class="content"><textarea name="metaDescription">{metaDescription}</textarea></div>
		</div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{parentArticleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleCatalogEdit]

<!-- Шаблон страницы редактированя каталога -->
[adminArticleCatalogEdit_sub_project]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticleCatalog.edit(this); return false;">
		<input type="hidden" name="id" value="{articleCatalogId}" />

		<div class="title">ИД каталога - {articleCatalogId}</div>
		<div class="content"></div>
		<div class="title required">Наименование каталога</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">Отображать каталог статей на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Приоритетный</div>
		<div class="content">
			<select name="addField_1">
				<option value="0" {selected_0}>Нет</option>
				<option value="1" {selected_1}>Да</option>
			</select>
		</div>

		<div class="title">Код изображения SVG </div>
		<div class="content"><textarea name="addField_2">{addField_2}</textarea></div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция каталога</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Описание</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
		<div class="content"></div>
		<div class="seo displayNone">
			<div class="title">Часть ЧПУ адреса статьи. <a href="javascript: void(0)" onclick="TranslitUrlName.setTranslit()">Преобразовать наименование в URL</a></div>
			<!--			<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>-->
			<div class="content"><input type="text" name="urlName" value="{urlName}" />-a{id}</div>
			<div class="comment">Если поле будет пустое то ЧПУ будет преобразованно из наменования.<br /> Суфикс "-a{id}" добавляется автоматически</div>

			<div class="title">Текст заголовка страницы</div>
			<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

			<div class="title">metaTitle</div>
			<div class="content"><textarea name="metaTitle">{metaTitle}</textarea></div>

			<div class="title">metaKeywords</div>
			<div class="content"><textarea name="metaKeywords">{metaKeywords}</textarea></div>

			<div class="title">metaDescription</div>
			<div class="content"><textarea name="metaDescription">{metaDescription}</textarea></div>
		</div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{parentArticleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleCatalogEdit_sub_project]


<!-- Шаблон страницы редактирования статьи  -->
[adminArticleCatalogEdit_sub_project_project]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticleCatalog.edit(this); return false;">
		<input type="hidden" name="id" value="{articleCatalogId}" />

		<div class="title">ИД каталога - {articleCatalogId}</div>
		<div class="content"></div>
		<div class="title required">Наименование каталога</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title"><img src="{imgSrc1}" style="max-width: 200px;" alt="" /><br />Изображение каталога №1</div>
		<div class="content"><input type="file" name="fileName1" /></div>
		<div class="title">Размеры изображения каталога (ШхВ)</div>
		<div class="content"><input class="imgSize" type="text" name="catalogImgWidth_1" value="{catalogImgWidth_1}" /> x <input class="imgSize" type="text" name="catalogImgHeight_1" value="{catalogImgHeight_1}" /></div>
		<div class="comment">Если 0 - то изображение будет загружаться без изменений</div>

		<div class="title">Отображать каталог статей на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Отображать на главной</div>
		<div class="content">
			<select name="addField_4">
				<option value="0" {selected_addField_4_0}>Нет</option>
				<option value="1" {selected_addField_4_1}>Да</option>
			</select>
		</div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция данных в нутри каталога</div>
		<div class="content"><select name="orderInCatalog">{orderInCatalogSelect}</select></div>

		<div class="title">Позиция каталога</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Показывать кнопку "Donate"</div>
		<div class="content">
			<select name="addField_lang_4">
				<option value="0" {selected_addField_lang_4_0}>Нет</option>
				<option value="1" {selected_addField_lang_4_1}>Да</option>
			</select>
		</div>

		<div class="title">Брать ссылку на из донат</div>
		<div class="content">
			<select name="addField_3">
				{donateSelect}
			</select>
		</div>

		<div class="title">Ссылка (Кнопка "Донат")</div>
		<div class="content"><input type="text" name="addField_lang_5" value="{addField_lang_5}" /></div>

		<div class="title">Самма, $</div>
		<div class="content"><input type="text" name="addField_1" value="{addField_1}" /></div>

		<div class="title">Собранная сумма, $</div>
		<div class="content"><input type="text" name="addField_2" value="{addField_2}" /></div>

		<div class="title">Краткое описание</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="title">Текст</div>
		<div class="content"><textarea class="textareaTinymce" name="text">{text}</textarea></div>

		<div class="title">Заголовок блока с видео</div>
		<div class="content"><input type="text" name="addField_lang_1" value="{addField_lang_1}" /></div>

		<div class="title">Краткое описание блока с видео</div>
		<div class="content"><textarea class="textareaTinymce" name="addField_lang_2">{addField_lang_2}</textarea></div>

		<div class="title">Видео</div>
		<div class="content"><textarea name="addField_lang_3">{addField_lang_3}</textarea></div>

		<div class="title">ИД каталога видео (Youtube)</div>
		<div class="content"><input type="text" name="addField_lang_6" value="{addField_lang_6}" /></div>

		<div class="title">ИД каталога Галереи (Вверху страницы)</div>
		<div class="content"><input type="text" name="addField_5" value="{addField_5}" /></div>
		<div class="comment">Можно несколько ИД, через запятую ","</div>

		<div class="title">ИД каталога Галереи (Внизу страницы)</div>
		<div class="content"><input type="text" name="addField_6" value="{addField_6}" /></div>
		<div class="comment">Можно несколько ИД, через запятую ","</div>

		<div class="title"><a href="javascript: void(0)" onclick="$('.seo').toggle();">SEO данные</a></div>
		<div class="content"></div>
		<div class="seo displayNone">
			<div class="title">Часть ЧПУ адреса статьи. <a href="javascript: void(0)" onclick="TranslitUrlName.setTranslit()">Преобразовать наименование в URL</a></div>
			<!--			<div class="content"><input type="text" name="urlName" value="{urlName}" /></div>-->
			<div class="content"><input type="text" name="urlName" value="{urlName}" />-a{id}</div>
			<div class="comment">Если поле будет пустое то ЧПУ будет преобразованно из наменования.<br /> Суфикс "-a{id}" добавляется автоматически</div>

			<div class="title">Текст заголовка страницы</div>
			<div class="content"><input type="text" name="pageTitle" value="{pageTitle}" /></div>

			<div class="title">metaTitle</div>
			<div class="content"><textarea name="metaTitle">{metaTitle}</textarea></div>

			<div class="title">metaKeywords</div>
			<div class="content"><textarea name="metaKeywords">{metaKeywords}</textarea></div>

			<div class="title">metaDescription</div>
			<div class="content"><textarea name="metaDescription">{metaDescription}</textarea></div>
		</div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{parentArticleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleCatalogEdit_sub_project_project]


<!-- Шаблон страницы редактированя каталога -->
[adminArticleCatalogEdit_video]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminArticleCatalog.edit(this); return false;">
		<input type="hidden" name="id" value="{articleCatalogId}" />

		<div class="title">ИД каталога - {articleCatalogId}</div>
		<div class="content"></div>
		<div class="title required">Наименование каталога</div>
		<div class="content"><input type="text" name="title" value="{title}" /></div>

		<div class="title">Отображать каталог статей на сайте</div>
		<div class="title checkbox">
			<table cellspacing="0" cellpadding="0" border="0">
				<tbody>
				<tr>
					<td><input id="showKey" type="checkbox" value="yes" name="showKey" {showKey_checked}></td>
					<td><label style="cursor: pointer;" for="showKey">Отображать</label></td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="title">Имя для разработчика</div>
		<div class="content"><input type="text" name="devName" value="{devName}" /></div>

		<div class="title">Позиция каталога</div>
		<div class="content"><input type="text" name="position" value="{position}" /></div>

		<div class="title">Описание</div>
		<div class="content"><textarea class="textareaTinymce" name="description">{description}</textarea></div>

		<div class="title">Видео</div>
		<div class="content"><textarea name="addField_2">{addField_2}</textarea></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="/admin/article/{parentArticleCatalogId}/">Отменить</a></div>

	</form>
</div>
[/adminArticleCatalogEdit_video]

<!-- ************************************************************************************* -->
<!-- ************************************************************************************* -->

[adminFileCatalogField]
<div class="title">ИД каталога хранилища (Через ,)</div>
<div class="content"><input type="text" name="addField_3" value="{addField_3}" /></div>
[/adminFileCatalogField]

<!-- Шаблон кода для YouTube -->
[youtubeObjectCode]
<iframe width="{width}" height="{height}" src="{src}" frameborder="0" allowfullscreen></iframe>
[/youtubeObjectCode]

<!-- Шаблон кода для Twitch -->
[twitchObjectCode]
<iframe src="{src}" frameborder="0" scrolling="no" height="{height}" width="{width}"></iframe>
[/twitchObjectCode]

<!-- Шаблон кода для CyberGame.tv -->
[cybergameObjectCode]
<iframe src="{src}" width="{width}" height="{height}"></iframe>
[/cybergameObjectCode]

