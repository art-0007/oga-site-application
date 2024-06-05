<!-- Коренной шаблон страницы списка -->
[content]
<section class="partnerListCD pt-20">
	<div class="siteWidth container-fluid">
		<div class="partnerList row typeContentBlock1 inRow7">{partnerList}</div>
	</div>
</section>

{textBlock}
{donateBlock}

[/content]

[partnerList_empty]
<p class="listEmpty">{sh_listEmpty}</p>
[/partnerList_empty]

<!-- ************************************************** -->

[partnerBlock]
<section id="partnerSlider" class="el_partnerBlock_xs8uVQpL">
	<div class="siteWidth container-fluid">
		<div class="blockTitle">
			<p class="title">{articleCatalogTitle}</p>
			<p class="btnLine"><a class="btn" href="/partner/">{sh_allPartners}</a></p>
		</div>

		<div class="innerWrapper">
			<div class="sliderBtnBlock leftCol">
				<div class="btnWrapper">
					<button class="slick-prev slick-arrow">
						<svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M14.2642 0.190191C14.9766 0.532721 15.3105 1.29313 15.0359 1.96449C14.9246 2.24537 14.3162 2.84137 10.6358 6.24611L6.36186 10.2057L15.7482 10.2194L25.142 10.24L25.4982 10.4455C25.9954 10.7332 26.166 11.0552 26.166 11.7129C26.166 12.3705 25.9954 12.6925 25.4982 12.9802L25.142 13.1857L15.7482 13.2063L6.36186 13.22L10.6358 17.1796C14.3162 20.5844 14.9246 21.1804 15.0359 21.4613C15.2808 22.071 15.0137 22.7971 14.4052 23.1876C14.0416 23.4205 13.4035 23.4959 12.9509 23.3589C12.5428 23.2356 1.28653 12.8775 1.01199 12.3705C0.781965 11.9526 0.774546 11.5211 0.982307 11.0963C1.19749 10.651 12.2757 0.41626 12.8025 0.16964C13.307 -0.0632801 13.7522 -0.0564308 14.2642 0.190191Z" fill="#1D1D1D"/>
						</svg>
					</button>
				</div>
			</div>

			<div class="partnerListCol">
				<div class="partnerList sliderBlock row typeContentBlock1 inRow6">{partnerList}</div>
			</div>

			<div class="sliderBtnBlock rightCol">
				<div class="btnWrapper">
					<button class="slick-next slick-arrow">
						<svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12.2358 0.190191C11.5234 0.532721 11.1895 1.29313 11.4641 1.96449C11.5754 2.24537 12.1838 2.84137 15.8642 6.24611L20.1381 10.2057L10.7518 10.2194L1.35795 10.24L1.00179 10.4455C0.504646 10.7332 0.333984 11.0552 0.333984 11.7129C0.333984 12.3705 0.504646 12.6925 1.00179 12.9802L1.35795 13.1857L10.7518 13.2063L20.1381 13.22L15.8642 17.1796C12.1838 20.5844 11.5754 21.1804 11.4641 21.4613C11.2192 22.071 11.4863 22.7971 12.0948 23.1876C12.4584 23.4205 13.0965 23.4959 13.5491 23.3589C13.9572 23.2356 25.2135 12.8775 25.488 12.3705C25.718 11.9526 25.7255 11.5211 25.5177 11.0963C25.3025 10.651 14.2243 0.41626 13.6975 0.16964C13.193 -0.0632801 12.7478 -0.0564308 12.2358 0.190191Z" fill="#1D1D1D"/>
						</svg>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
[/partnerBlock]

<!-- ************************************************** -->

[partnerListItem]
<div class="el_partnerListItem_xs8uVQpL col">
	<div class="innerWrapper">
		<div class="img_wrap">
			<div class="el"><img src="{imgSrc1}" alt="{altTitle}" /></div>
		</div>
	</div>
</div>
[/partnerListItem]

<!-- ************************************************** -->
<!-- ************************************************** -->

[content_view]
<section class="partnerContetView">
	<div class="siteWidth container-fluid">
		<div class="staticText">{text}</div>
	</div>
</section>
[/content_view]