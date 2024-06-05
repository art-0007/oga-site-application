<!-- Коренной шаблон страницы списка -->
[content]
<section class="teamListCD pt-20">
	<div class="siteWidth container-fluid">
		{teamCatalogList}
		<div class="teamList row typeContentBlock1 inRow5">{teamList}</div>
	</div>
</section>

{textBlock}
{donateBlock}
[/content]

[teamList_empty]
<p class="listEmpty">{sh_listEmpty}</p>
[/teamList_empty]

[textBlock]
<section class="teamListTextBlock">
	<div class="siteWidth container-fluid">
		<div class="text staticText">{text}</div>
	</div>
</section>
[/textBlock]

<!-- ************************************************** -->

[teamCatalogListBlock]
<div class="el_teamCatalogListBlock_xs8uVQpL">
	<ul class="teamCatalogList">
		<li>
			<a class="{activeClass}" href="/team/">{sh_all}</a>
		</li>
		{teamCatalogList}
	</ul>
</div>
[/teamCatalogListBlock]

[teamCatalogListItem]
<li><a class="{activeClass}" href="{href}">{title}</a></li>
[/teamCatalogListItem]

<!-- ************************************************** -->

[teamBlock]
<section id="teamSlider" class="el_teamBlock_xs8uVQpL">
	<div class="siteWidth container-fluid">
		<div class="innerWrapper">
			<div class="ttBlock">
				<div class="blockTitle">
					<p class="title">{articleCatalogTitle}</p>
				</div>

				<ul class="teamCatalogList">{teamCatalogList}</ul>

				<div class="sliderBtnBlock top">
					<div class="btnWrapper">
						<button class="slick-prev slick-arrow">
							<svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M14.2642 0.190191C14.9766 0.532721 15.3105 1.29313 15.0359 1.96449C14.9246 2.24537 14.3162 2.84137 10.6358 6.24611L6.36186 10.2057L15.7482 10.2194L25.142 10.24L25.4982 10.4455C25.9954 10.7332 26.166 11.0552 26.166 11.7129C26.166 12.3705 25.9954 12.6925 25.4982 12.9802L25.142 13.1857L15.7482 13.2063L6.36186 13.22L10.6358 17.1796C14.3162 20.5844 14.9246 21.1804 15.0359 21.4613C15.2808 22.071 15.0137 22.7971 14.4052 23.1876C14.0416 23.4205 13.4035 23.4959 12.9509 23.3589C12.5428 23.2356 1.28653 12.8775 1.01199 12.3705C0.781965 11.9526 0.774546 11.5211 0.982307 11.0963C1.19749 10.651 12.2757 0.41626 12.8025 0.16964C13.307 -0.0632801 13.7522 -0.0564308 14.2642 0.190191Z" fill="#1D1D1D"/>
							</svg>
						</button>
						<button class="slick-next slick-arrow">
							<svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12.2358 0.190191C11.5234 0.532721 11.1895 1.29313 11.4641 1.96449C11.5754 2.24537 12.1838 2.84137 15.8642 6.24611L20.1381 10.2057L10.7518 10.2194L1.35795 10.24L1.00179 10.4455C0.504646 10.7332 0.333984 11.0552 0.333984 11.7129C0.333984 12.3705 0.504646 12.6925 1.00179 12.9802L1.35795 13.1857L10.7518 13.2063L20.1381 13.22L15.8642 17.1796C12.1838 20.5844 11.5754 21.1804 11.4641 21.4613C11.2192 22.071 11.4863 22.7971 12.0948 23.1876C12.4584 23.4205 13.0965 23.4959 13.5491 23.3589C13.9572 23.2356 25.2135 12.8775 25.488 12.3705C25.718 11.9526 25.7255 11.5211 25.5177 11.0963C25.3025 10.651 14.2243 0.41626 13.6975 0.16964C13.193 -0.0632801 12.7478 -0.0564308 12.2358 0.190191Z" fill="#1D1D1D"/>
							</svg>
						</button>
					</div>
				</div>
			</div>

			<div class="teamList sliderBlock row typeContentBlock4 inRow4">{teamList}</div>
			<div class="sliderBtnBlock bottom">
				<div class="btnWrapper">
					<button class="slick-prev slick-arrow">
						<svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M14.2642 0.190191C14.9766 0.532721 15.3105 1.29313 15.0359 1.96449C14.9246 2.24537 14.3162 2.84137 10.6358 6.24611L6.36186 10.2057L15.7482 10.2194L25.142 10.24L25.4982 10.4455C25.9954 10.7332 26.166 11.0552 26.166 11.7129C26.166 12.3705 25.9954 12.6925 25.4982 12.9802L25.142 13.1857L15.7482 13.2063L6.36186 13.22L10.6358 17.1796C14.3162 20.5844 14.9246 21.1804 15.0359 21.4613C15.2808 22.071 15.0137 22.7971 14.4052 23.1876C14.0416 23.4205 13.4035 23.4959 12.9509 23.3589C12.5428 23.2356 1.28653 12.8775 1.01199 12.3705C0.781965 11.9526 0.774546 11.5211 0.982307 11.0963C1.19749 10.651 12.2757 0.41626 12.8025 0.16964C13.307 -0.0632801 13.7522 -0.0564308 14.2642 0.190191Z" fill="#1D1D1D"/>
						</svg>
					</button>
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
[/teamBlock]

[teamBlock_teamCatalogListItem]
<li><a class="btn" href="{href}">{title}</a></li>
[/teamBlock_teamCatalogListItem]

<!-- ************************************************** -->

[teamTabBlock]
<section id="teamTabSlider" class="el_teamTabBlock_xs8uVQpL tabsBlock">
	<div class="siteWidth container-fluid">
		<div class="innerWrapper">
			<div class="ttBlock">
				<div class="blockTitle">
					<p class="title">{articleCatalogTitle}</p>
				</div>

				<ul class="tabs">{tabTitleList}</ul>

				<div class="sliderBtnBlock">
					{sliderArrowList}
				</div>
			</div>

			<div class="tabsContentBlock">{tabContentList}</div>
		</div>
	</div>
</section>
[/teamTabBlock]

[tabTitleListItem]
<li id="tab-team-{id}" class="tab btn {activeClass}" data-tab-id="team-{id}">{title}</li>
[/tabTitleListItem]

[sliderArrowList]
<div id="tabSliderBtn-team-{id}" class="btnWrapper {activeClass}">
	<button class="slick-prev slick-arrow">
		<svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M14.2642 0.190191C14.9766 0.532721 15.3105 1.29313 15.0359 1.96449C14.9246 2.24537 14.3162 2.84137 10.6358 6.24611L6.36186 10.2057L15.7482 10.2194L25.142 10.24L25.4982 10.4455C25.9954 10.7332 26.166 11.0552 26.166 11.7129C26.166 12.3705 25.9954 12.6925 25.4982 12.9802L25.142 13.1857L15.7482 13.2063L6.36186 13.22L10.6358 17.1796C14.3162 20.5844 14.9246 21.1804 15.0359 21.4613C15.2808 22.071 15.0137 22.7971 14.4052 23.1876C14.0416 23.4205 13.4035 23.4959 12.9509 23.3589C12.5428 23.2356 1.28653 12.8775 1.01199 12.3705C0.781965 11.9526 0.774546 11.5211 0.982307 11.0963C1.19749 10.651 12.2757 0.41626 12.8025 0.16964C13.307 -0.0632801 13.7522 -0.0564308 14.2642 0.190191Z" fill="#1D1D1D"/>
		</svg>
	</button>
	<button class="slick-next slick-arrow">
		<svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M12.2358 0.190191C11.5234 0.532721 11.1895 1.29313 11.4641 1.96449C11.5754 2.24537 12.1838 2.84137 15.8642 6.24611L20.1381 10.2057L10.7518 10.2194L1.35795 10.24L1.00179 10.4455C0.504646 10.7332 0.333984 11.0552 0.333984 11.7129C0.333984 12.3705 0.504646 12.6925 1.00179 12.9802L1.35795 13.1857L10.7518 13.2063L20.1381 13.22L15.8642 17.1796C12.1838 20.5844 11.5754 21.1804 11.4641 21.4613C11.2192 22.071 11.4863 22.7971 12.0948 23.1876C12.4584 23.4205 13.0965 23.4959 13.5491 23.3589C13.9572 23.2356 25.2135 12.8775 25.488 12.3705C25.718 11.9526 25.7255 11.5211 25.5177 11.0963C25.3025 10.651 14.2243 0.41626 13.6975 0.16964C13.193 -0.0632801 12.7478 -0.0564308 12.2358 0.190191Z" fill="#1D1D1D"/>
		</svg>
	</button>
</div>
[/sliderArrowList]

[tabContentListItem]
<div id="tabContent-team-{id}" class="tabContent {activeClass}">
	<div class="teamList sliderBlock row typeContentBlock4 inRow4" data-team-id="team-{id}">{teamList}</div>
</div>
[/tabContentListItem]

<!-- ************************************************** -->

[teamListItem]
<div class="el_teamListItem_xs8uVQpL col">
	<a class="innerWrapper" href="{href}">
		<span class="imageBlock">
			<span class="img_wrap">
				<span class="el"><img src="{imgSrc1}" alt="{altTitle}" /></span>
			</span>
		</span>
		<div class="infoBlock">
			<span class="title">{title}</span>
			<span class="post">{post}</span>
			<span class="btn type3 h40">{sh_more}</span>
		</div>
	</a>
</div>
[/teamListItem]

[teamListItem2]
<div class="el_teamListItem2_xs8uVQpL col">
	<a class="innerWrapper" href="{href}">
		<span class="title">{title}</span>
		<span class="post">{post}</span>
		<span class="arrow">
			<svg width="9" height="8" viewBox="0 0 9 8" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.19117 0.691168C4.09088 0.900773 4.18169 1.1635 4.38737 1.25888C4.44085 1.28368 4.82205 1.32699 5.4999 1.38527C6.06702 1.43403 6.53546 1.47921 6.54089 1.48568C6.5463 1.49213 5.2187 2.61513 3.59065 3.98123L0.630574 6.46503L0.592389 6.55874C0.533669 6.70286 0.553809 6.83715 0.654061 6.96985C0.753112 7.10097 0.867517 7.15789 1.02378 7.15383L1.12345 7.15124L4.11123 4.65103C5.7545 3.2759 7.1034 2.15605 7.10876 2.16244C7.11412 2.16884 7.07732 2.64384 7.02696 3.21803C6.92814 4.34487 6.92888 4.37269 7.06149 4.49883C7.14987 4.58291 7.30857 4.63645 7.4287 4.62275C7.56384 4.60735 7.71595 4.497 7.76491 4.37883C7.80846 4.27373 8.08036 1.13649 8.05515 1.0301C8.0295 0.921845 7.9155 0.790946 7.80845 0.746838C7.68456 0.695767 4.55645 0.428519 4.45576 0.460403C4.35192 0.493264 4.23855 0.592154 4.19117 0.691168Z" fill="#5F7ABA"/>
			</svg>
		</span>
	</a>
</div>
[/teamListItem2]

<!-- ************************************************** -->
<!-- ************************************************** -->

[content_view]
<section class="teamContetView">
	<div class="siteWidth container-fluid">
		<div class="innerWrapper">
			<div class="imageBlock">
				<div class="img_wrap">
					<span class="el"><img src="{imgSrc}" alt=""></span>
				</div>
			</div>
			<div class="infoBlock">
				<div class="pageTitle teamView">
					<h1>{pageTitle}</h1>
				</div>
				<p class="post">{post}</p>
				<div class="text staticText">{text}</div>
			</div>
		</div>
	</div>
</section>
[/content_view]