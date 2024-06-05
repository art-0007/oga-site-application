<!-- Коренной шаблон страницы списка новостей -->
[content_catalog]
<div class="catalogCatalogContent">
	<div class="catalogList row typeContentBlock2 inRow4">{catalogList}</div>
</div>
[/content_catalog]

[content_offer]
<div class="catalogOfferContent">
	<div class="offerList row typeContentBlock2 inRow3">{offerList}</div>
</div>
[/content_offer]

<!-- Шаблон пустой страницы товаров -->
[catalogList_empty]
<p class="listEmpty">{sh_listEmpty}</p>
[/catalogList_empty]

<!-- ************************************************** -->
<!-- ************************************************** -->

[catalogListBlockItem]
<section class="catalogListBlock">
	<div class="siteWidth container-fluid">
		<div class="blockTitle">
			<p class="title">{catalogTitle}</p>
		</div>

		<div class="offerList row typeContentBlock1 inRow3">{offerList}</div>
	</div>
</section>
[/catalogListBlockItem]

[catalogListItem]
<div class="catalogItem {addClass} col">
	<div class="innerWrapper">
		<div class="imageBlock">
			<div class="img_wrap">
				<a class="el" href="{href}">
					<img src="{imgSrc}" alt="{altTitle}" />
				</a>
			</div>
		</div>
		<a class="title" href="{href}">{title}</a>
	</div>
</div>
[/catalogListItem]

[catalogListItem2]
<div class="catalogItem {addClass} col">
	<div class="innerWrapper">
		<div class="imageBlock">
			<div class="img_wrap">
				<a class="el" href="{href}">
					<img src="{imgSrc}" alt="{altTitle}" />
				</a>
			</div>
		</div>
		<a class="title" href="{href}">{title}</a>
	</div>
</div>
[/catalogListItem2]

[catalogListItem_showMore]
<p class="showMore"><a href="javascript: void(0);" onclick="Main.showMoreCatalog();"><img src="/template/img/showmore.png" /></a></p>
[/catalogListItem_showMore]

<!-- ************************************************** -->
