[content]
<div class="adminPanel">
	<div class="topMenu">
		<table class="width100">
		<tr>
			{additionalButtons}
			<td width="*">&nbsp;</td>
			<td class="separator">&nbsp;</td>

			<td class="filled"><p><a class="article" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/article/0/');" title="Управление новостями / статьями"></a></p></td>
			<td class="separator">&nbsp;</td>
			<td class="filled"><p><a class="lang" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/donate/list/');" title="Просмотр списка донат"><i class="fa fa-money" aria-hidden="true"></i></a></p></td>
			<td class="separator"><p>&nbsp;</p></td>
			<td class="filled"><p><a class="sliderImage" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/slider-image/0/');" title="Управление слайдером"></a></p></td>
			<td class="separatorColor"><p>&nbsp;</p></td>

			<td class="filled"><p><a class="email" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/email/');" title="Список E-mail"></a></p></td>
			<td class="separatorColor"><p>&nbsp;</p></td>

			<td class="filled"><p><a class="file" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/file/{fileCatalogId}/');" title="Хранилище файлов"></a></p></td>
			<td class="separator">&nbsp;</td>
			<td class="filled"><p><a class="staticHtml" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/static-html/');" title="Статический html (тексты)"></a></p></td>
			<td class="separator">&nbsp;</td>
			<td class="filled"><p><a class="staticPage" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/page/');" title="Статические страницы"></a></p></td>
			<td class="separator">&nbsp;</td>
			<td class="filled"><p><a class="dataImageSettings" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/data-image-settings/');" title="Управление изображениями товара"></a></p></td>
			<td class="separatorColor"><p>&nbsp;</p></td>

			<td class="filled"><p><a class="adminUser" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/admin-user/');" title="Управление пользователями админпанели"></a></p></td>
			<td class="separator">&nbsp;</td>
			<td class="filled"><p><a class="lang" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/lang/list/');" title="Управление языками"><i class="fa fa-language" aria-hidden="true"></i></a></p></td>
			<td class="separator">&nbsp;</td>
			<td class="filled"><p><a class="lang" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/online-pay-system/list/');" title="Управление системами онлайн оплаты"><i class="fa fa-usd" aria-hidden="true"></i></a></p></td>
			<td class="separator">&nbsp;</td>
			<td class="filled"><p><a class="allSettings" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/settings-edit/');" title="Общие настройки"></a></p></td>
			<td class="separatorColor"><p>&nbsp;</p></td>
			<td class="filled"><p><a class="exit" href="javascript: void(0);" onclick="AdminPanel.logout();" title="Выход"></a></p></td>
		</tr>
		</table>
	</div>
</div>
[/content]

<!-- ******************************************************************************************************** -->
<!-- ******************************************************************************************************** -->

<!-- Главная страница -->
[adminPanel_index]
<td class="filled"><p><a class="edit" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/page/edit/1/');" title='Редактировать "{title}"'></a></p></td>
<td class="separator">&nbsp;</td>
[/adminPanel_index]

<!-- Статические страницы -->
[adminPanel_page]
<td class="filled"><p><a class="edit" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/page/edit/{id}/');" title='Редактировать "{title}"'></a></p></td>
<td class="separator">&nbsp;</td>
[/adminPanel_page]

<!-- Статические страницы -->
[adminPanel_brands]
<td class="filled_p"><p class="admin_title">Бренд:</p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="add catalog" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/brand/add//');" title='Добавить новый бренд'></a></p></td>
<td class="separatorColor"><p>&nbsp;</p></td>
<td class="filled_p" style="min-width: 170px;"><p class="admin_title">Статическая страница "{title}":</p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="edit" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/page/edit/{id}/');" title='Редактировать "{title}"'></a></p></td>
<td class="separator">&nbsp;</td>
[/adminPanel_brands]

<!-- Страница каталога -->
[adminPanel_catalog]
<td class="filled_p"><p class="admin_title">Каталог:</p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="add catalog" href="javascript: void(0);" onclick="{catalogAddOnclick}" title='{catalogAddTitle}'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="edit catalog" href="javascript: void(0);" onclick="{catalogEditOnclick}" title='Редактировать каталог "{catalogTitle}"'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="delete catalog" href="javascript: void(0);" onclick="{catalogDeleteOnclick}" title='Удалить каталог "{catalogTitle}"'></a></p></td>
<td class="separatorColor"><p>&nbsp;</p></td>

<td class="filled_p"><p class="admin_title">Товар:</p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="add data" href="javascript: void(0);" onclick="{dataAddOnclick}" title='Добавить товар в каталог "{catalogTitle}"'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="delete" href="javascript: void(0);" onclick="AdminData.deleteConfirm();" title='Удалить выбранные товары'></a></p></td>
<td class="separator">&nbsp;</td>
[/adminPanel_catalog]

<!-- Страница просмотра товара -->
[adminPanel_data]
<td class="filled_p"><p class="admin_title">Товар:</p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="edit" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/data/edit/{dataId}/');" title='Редактировать "{dataTitle}"'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="delete" href="javascript: void(0);" onclick="AdminData.deleteConfirm({dataId});" title='Удалить "{dataTitle}"'></a></p></td>
<td class="separatorColor"><p>&nbsp;</p></td>

<td class="filled_p"><p class="admin_title">Изображения товара:</p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="insert_image" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/data-image/{dataId}/');" title='Изображения товара "{dataTitle}"'></a></p></td>
[/adminPanel_data]

<!-- Страница списка статей -->
[adminPanel_articleCatalog]
<td class="filled_p"><p class="admin_title">Каталог:</p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="add catalog" href="javascript: void(0);" onclick="{catalogAddOnclick}" title='Добавить новый каталог в каталог "{catalogTitle}"'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="edit catalog" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/article-catalog/edit/{catalogId}/');" title='Редактировать каталог "{catalogTitle}"'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="delete catalog" href="javascript: void(0);" onclick="AdminArticleCatalog.deleteConfirm({catalogId});" title='Удалить каталог "{catalogTitle}"'></a></p></td>
<td class="separatorColor"><p>&nbsp;</p></td>

<td class="filled_p"><p class="admin_title">Статья:</p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="add data" href="javascript: void(0);" onclick="{articleAddOnclick}" title='Добавить статью в каталог "{catalogTitle}"'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="delete" href="javascript: void(0);" onclick="AdminArticle.deleteConfirm();" title='Удалить выбранные статьи'></a></p></td>
<td class="separator">&nbsp;</td>
[/adminPanel_articleCatalog]

<!-- Страница списка статей + статья + изображение статьи -->
[adminPanel_articleCatalog_article_articleImage]
<td class="filled_p"><p class="admin_title">Каталог:</p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="add catalog" href="javascript: void(0);" onclick="{catalogAddOnclick}" title='Добавить новый каталог в каталог "{catalogTitle}"'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="edit catalog" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/article-catalog/edit/{catalogId}/');" title='Редактировать каталог "{catalogTitle}"'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="delete catalog" href="javascript: void(0);" onclick="AdminArticleCatalog.deleteConfirm({catalogId});" title='Удалить каталог "{catalogTitle}"'></a></p></td>
<td class="separatorColor"><p>&nbsp;</p></td>

<td class="filled_p"><p class="admin_title">Статья:</p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="add data" href="javascript: void(0);" onclick="{articleAddOnclick}" title='Добавить статью в каталог "{catalogTitle}"'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="delete" href="javascript: void(0);" onclick="AdminArticle.deleteConfirm();" title='Удалить выбранные статьи'></a></p></td>
<td class="separatorColor"><p>&nbsp;</p></td>

<td class="filled"><p><a class="edit" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/article/edit/{id}/');" title='Редактировать "{title}"'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="delete" href="javascript: void(0);" onclick="AdminArticle.deleteConfirm({id});" title='Удалить "{title}"'></a></p></td>
<td class="separatorColor"><p>&nbsp;</p></td>
<td class="filled"><p><a class="sliderImage" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/article-image/add/{id}/');" title='Добавить изображение в "{title}"'></a></p></td>
<td class="separator">&nbsp;</td>
[/adminPanel_articleCatalog_article_articleImage]

<!-- Страница просмотра статьи -->
[adminPanel_article]
<td class="filled"><p><a class="edit" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/article/edit/{id}/');" title='Редактировать "{title}"'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="delete" href="javascript: void(0);" onclick="AdminArticle.deleteConfirm({id});" title='Удалить "{title}"'></a></p></td>
<td class="separator">&nbsp;</td>
[/adminPanel_article]

[adminPanel_article_image]
<td class="filled"><p><a class="edit" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/article/edit/{id}/');" title='Редактировать "{title}"'></a></p></td>
<td class="separator">&nbsp;</td>
<td class="filled"><p><a class="delete" href="javascript: void(0);" onclick="AdminArticle.deleteConfirm({id});" title='Удалить "{title}"'></a></p></td>
<td class="separatorColor"><p>&nbsp;</p></td>
<td class="filled"><p><a class="sliderImage" href="javascript: void(0);" onclick="AdminFancyboxPage.show('/admin/article-image/add/{id}/');" title='Добавить изображение в "{title}"'></a></p></td>
<td class="separator">&nbsp;</td>
[/adminPanel_article_image]
