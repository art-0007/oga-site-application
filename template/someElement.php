<!-- Коренной шаблон страницы списка -->
[content]
<section class="someElementListCD pt-20">
	<div class="siteWidth container-fluid">
		<div class="someElementList row typeContentBlock1 inRow5">{someElementList}</div>
	</div>
</section>
[/content]

[someElementList_empty]
<p class="listEmpty">{sh_listEmpty}</p>
[/someElementList_empty]

<!-- ************************************************** -->

[someElementBlock]
<section class="el_someElementBlock_xs8uVQpL bgBlue">
	<div class="siteWidth container-fluid">
		<div class="blockTitle white">
			<p class="title">{articleCatalogTitle}</p>
			<p class="btnLine"><a class="btn type4" href="/page/about/#{articleCatalogDevName}">{sh_more}</a></p>
		</div>

		<div class="someElementList row">{someElementList}</div>
	</div>
</section>
[/someElementBlock]

<!-- ************************************************** -->

[someElementBlock_2]
<section id="{articleCatalogDevName}" class="el_someElementBlock2_xs8uVQpL {addClass}">
	<div class="siteWidth container-fluid">
		<div class="someElementList">{someElementList}</div>
	</div>
</section>
[/someElementBlock_2]

<!-- ************************************************** -->

[someElementBlock_3]
<section id="{articleCatalogDevName}" class="el_someElementBlock2_xs8uVQpL line {addBlockClass}">
	<div class="siteWidth container-fluid">
		<div class="blockTitle {textColorClass}">
			<p class="title">{articleCatalogTitle}</p>
		</div>

		<div class="someElementList">{someElementList}</div>
	</div>
</section>
[/someElementBlock_3]

<!-- ************************************************** -->

[someElementListItem]
<div class="el_someElementListItem_xs8uVQpL col">
	<div class="itemWrapper">
		<div class="imageBlock">{icoCode}</div>
		<p class="title"><a href="{href}">{title}</a></p>
		<div class="description staticText white">{description}</div>
	</div>
</div>
<div class="el_someElementListItem_xs8uVQpL lineCol col"><div class="itemWrapper"></div></div>
[/someElementListItem]

<!-- ***** -->

[someElementListItem_2]
<div class="el_someElementListItem2_xs8uVQpL">
	<div class="itemWrapper">
		<div class="titleBlock">
			<div class="imageBlock">{icoCode}</div>
			<p class="title"><a href="{href}">{title}</a></p>
		</div>
		<p class="btnLine"><a class="btn {addBtnClass}" href="{href}">{sh_more}</a></p>
		<div class="description staticText {textColorClass}">{description}</div>
	</div>
</div>
[/someElementListItem_2]

<!-- ***** -->

[someElementListItem_3]
<div class="el_someElementListItem3_xs8uVQpL">
	<div class="itemWrapper">
		<div class="titleBlock">
			<div class="imageBlock">{icoCode}</div>
			<p class="title"><a href="{href}">{title}</a></p>
		</div>
		<p class="btnLine"><a class="btn {addBtnClass}" href="{href}">{sh_more}</a></p>
		<div class="description staticText {textColorClass}">{description}</div>
	</div>
</div>
[/someElementListItem_3]

<!--<div class="el_someElementListItem2_xs8uVQpL lineCol col"><div class="itemWrapper"></div></div>-->

<!-- ************************************************** -->
<!-- ************************************************** -->

[content_view]
<section class="someElementContetView pt-20">
	<div class="siteWidth container-fluid">
		<div class="staticText">{text}</div>
	</div>
</section>

{articleImageSlider}

[/content_view]