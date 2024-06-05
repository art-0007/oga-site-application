<!-- Коренной шаблон страницы списка статей -->
[content]
<div class="saitWidth articleListBlock">{articleListBlock}</div>
<div class="delimiter"></div>
{linkBlock}
[/content]

<!-- Шаблон пустого списка статей -->
[articleList_empty]
<p>{sh_articleList_empty}</p>
[/articleList_empty]

<!-- ************************************************** -->

[articleCatalogListBlockItem]
<section class="articleCatalogListBlock">
	<div class="siteWidth container-fluid">
		<div class="blockTitle">
			<p class="title">{articleCatalogTitle}</p>
		</div>

		<div class="articleList row typeContentBlock1 inRow3">{articleList}</div>
	</div>
</section>
[/articleCatalogListBlockItem]

<!-- ************************************************** -->

<!-- Шаблон елемента списка статей -->
[articleListItem]
<div class="articleListItem col">
	<div class="innerWrapper">
		<div class="imageBlock">
			<div class="img_wrap">
				<span class="el"><img src="{imgSrc1}" alt="{altTitle}" /></span>
			</div>
		</div>
		<div class="infoBlock">
			<p class="title"><a href="{href}" title="{altTitle}">{title}</a></p>
			<p class="date">{date}</p>
		</div>
	</div>
</div>
[/articleListItem]

<!-- *------------------------------------------------------------* -->
<!-- *------------------------------------------------------------* -->

<!-- Коренной шаблон страницы просмотра статьи -->
[content_view]
<div class="saitWidth">
	<table class="width100">
	<tr>
		<td><p><img src="{imgSrc}" alt="" /></p></td>
		<td>
			{pageTitle}
			<div class="saitWidth actionText" data-admin-val="{id}-tinymce-text-4">{text}</div>
			<div class="delimiter"></div>
			{socBlock}
			<div class="delimiter"></div>
		</td>
	</tr>
	</table>
</div>
<div class="delimiter"></div>
[/content_view]
