<!-- Коренной шаблон страницы списка -->
[content]
<section class="newsListCD pt-20">
	<div class="siteWidth container-fluid">
		<div class="newsList row typeContentBlock1 inRow4">{newsList}</div>
	</div>
</section>
{donateBlock}
[/content]

[newsList_empty]
<p class="listEmpty">{sh_listEmpty}</p>
[/newsList_empty]

<!-- ************************************************** -->

[newsBlock]
<section class="el_newsBlock_xs8uVQpL bgBlue">
	<div class="siteWidth container-fluid">
		<div class="blockTitle white">
			<p class="title">{articleCatalogTitle}</p>
			<p class="btnLine"><a class="btn type4" href="/news/">{sh_allNews}</a></p>
		</div>

		<div class="newsList row typeContentBlock1 inRow4">{newsList}</div>
	</div>
</section>
[/newsBlock]

<!-- ************************************************** -->

[newsListItem]
<div class="el_entityListItem3_xs8uVQpL col {addClass}">
	<a class="itemWrapper" href="{href}">
		<span class="imageBlock">
			<span style="background-image: url({imgSrc1});"></span>
		</span>
		<div class="infoBlock">
			<p class="title">{title}</p>
			<div class="description staticText">{description}</div>
			<span class="date">{date}</span>
			<span class="btn h40 type3 more">{sh_more}</span>
		</div>
	</a>
</div>
[/newsListItem]

<!-- ************************************************** -->
<!-- ************************************************** -->

[content_view]
<section class="newsContetView pt-20">
	<div class="siteWidth container-fluid">
		<div class="staticText">{text}</div>
	</div>
</section>
{donateBlock}
[/content_view]