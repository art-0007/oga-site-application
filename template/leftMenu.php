<!-- Шаблон левого меню -->
[content]
<div id="left_side" class="col leftMenuCD asideBlockCD">
	<div id="leftMenuCatalogBlock" class="asideWidget">
		<h3 class="asideWidgetHeader">{sh_categories}</h3>
		<div class="asideWidgetContent">
			<ul class="list">
				{catalogList}
			</ul>
		</div>
	</div>
</div>
[/content]

<!-- Шаблон элемента левого меню (каталоги) -->
[catalogListItem]
<li><a href="{href}" class="{activeClass}">{title}</a></li>
[/catalogListItem]

[catalogListSubItem]
<li>
	<a class="{activeClass}" href="{href}">{title}</a>
	<button class="toggleBtn {openClass}" onclick="Main.toggleClassBlock(event, this, '#leftMenuCatalogBlock #scBlock-{id}');"></button>
	<ul id="scBlock-{id}" class="{openClass}">{subCatalogList}</ul>
</li>
[/catalogListSubItem]

<!-- Шаблон элемента левого меню (новости) -->
[newsListItem]
<li class="{addClass}"><a href="{href}" class="{addClass}">{title}</a></li>
[/newsListItem]

<!-- Список каталогов товаров -->
[catalogList_empty]
<p>Список каталогов товаров пуст!</p>
[/catalogList_empty]

<!-- Список каталогов товаров -->
[newsList_empty]
<p>Список новостей товаров пуст!</p>
[/newsList_empty]

