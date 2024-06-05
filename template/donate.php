<!-- Коренной шаблон страницы списка -->
[content]
<section class="donateListCD pt-100">
	<div class="siteWidth container-fluid">
		<div class="donateList">{donateList}</div>
	</div>
</section>

{donateInformationBlock}

[/content]

[donateList_empty]
<p class="listEmpty">{sh_listEmpty}</p>
[/donateList_empty]

<!-- ************************************************** -->

[donateBlock]
<section class="el_donateBlock_xs8uVQpL pt-20 pb-20">
	<div class="bgBlue blockWrapper">
		<div class="siteWidth container-fluid">
			<div class="blockTitle white"><p class="title">{articleCatalogTitle}</p></div>
			<div class="donateList row">{donateList}</div>
		</div>
	</div>
</section>
[/donateBlock]

[donateBlock2]
<section class="el_donateBlock2_xs8uVQpL pt-20 pb-20">
	<div class="siteWidth container-fluid">
		<div class="donateList">{donateList}</div>
	</div>
</section>
[/donateBlock2]

<!-- ************************************************** -->

[donateListItem]
<div class="el_donateListItem_xs8uVQpL col">
	<a class="itemWrapper" href="{href}" target="_blank">
		<div class="imageBlock">
			<span class="img_wrap">
				<span class="el"><img src="{imgSrc1}" alt="{altTitle}" /></span>
			</span>
		</div>
		<p class="title">{title}</p>
		<p class="ico">
			<svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M9.99121 1L20.4329 8.91358C20.7192 9.13056 20.723 9.55961 20.4407 9.78168L9.99121 18" stroke="#0151FE" stroke-width="1.64516"/>
				<path d="M1 1L11.4417 8.91358C11.728 9.13056 11.7318 9.55961 11.4495 9.78168L1 18" stroke="#0151FE" stroke-width="1.64516"/>
			</svg>
		</p>
	</a>
</div>
[/donateListItem]
<!--<a class="itemWrapper" href="#" onclick="Form.donateFormShow(event, 0, {id});">-->

[donateListItem2]
<div class="el_donateListItem2_xs8uVQpL">
	<a class="itemWrapper" href="{href}" target="_blank">
		<div class="imageBlock">
			<span class="img_wrap">
				<span class="el"><img src="{imgSrc1}" alt="{altTitle}" /></span>
			</span>
		</div>
		<p class="title">{title}</p>
		<p class="ico">
			<svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M9.99121 1L20.4329 8.91358C20.7192 9.13056 20.723 9.55961 20.4407 9.78168L9.99121 18" stroke="#0151FE" stroke-width="1.64516"/>
				<path d="M1 1L11.4417 8.91358C11.728 9.13056 11.7318 9.55961 11.4495 9.78168L1 18" stroke="#0151FE" stroke-width="1.64516"/>
			</svg>
		</p>
	</a>
</div>
[/donateListItem2]
<!--<a class="itemWrapper" href="#" onclick="Form.donateFormShow(event, 0, {id});">-->

[donateListItem3]
<div class="el_donateListItem3_xs8uVQpL">
	<div class="itemWrapper">
		<div class="imtBlock">
			<div class="imageBlock">
				<div class="img_wrap">
					<div class="el"><img src="{imgSrc2}" alt="{altTitle}" /></div>
				</div>
			</div>
			<p class="title">{title}</p>
		</div>
		<div class="dbBlock">
			<div class="description staticText">{description}</div>
			{donateBtn}
		</div>
	</div>
</div>
[/donateListItem3]

[donateBtn]
<p class="btnBlock"><a class="btn h65" href="#" onclick="Form.donateFormShow(event, 0, {id});">{sh_donate}</a></p>
[/donateBtn]

[donateBtn_a]
<p class="btnBlock"><a class="btn h65" href="{href}" target="_blank">{sh_donate}</a></p>
[/donateBtn_a]

<!-- ************************************************** -->
<!-- ************************************************** -->

[content_view]
<section class="donateContetView">
	<div class="siteWidth container-fluid">
		<div class="staticText">{text}</div>
	</div>
</section>
[/content_view]