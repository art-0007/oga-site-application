<!-- Слайдер на главной -->
[sliderBlock_index]
<section id="indexSlider" class="indexSlider pt-0 pb-0">
	<div class="initBanner type1">{sliderList}</div>
	<div class="btnDown">
		<button class="" onclick="Main.scrollTo('indexBottonSlider');">
			<svg width="26" height="49" viewBox="0 0 26 49" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M5.9955 32.9977C2.41125 30.9158 0 27.0266 0 22.5723V12.0386C0 5.39027 5.37225 0 12 0C18.627 0 24 5.39027 24 12.0386V22.5723C24 27.0281 21.5872 30.9181 18.0007 33" transform="translate(1 1)" stroke="white" stroke-width="2" stroke-linecap="round"></path>
				<path d="M0 0V5" transform="translate(13 9)" stroke="white" stroke-width="2" stroke-linecap="round"></path>
				<path d="M1 0V19" transform="translate(12 27)" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
				<path d="M12 0L6 6L0 0" transform="translate(7 42)" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
			</svg>
		</button>
	</div>
</section>
<div id="indexBottonSlider"></div>
[/sliderBlock_index]

<!-- Шаблон елемента списка слайдера "Главная" -->
[sliderListItem_index]
<div class="item" style="background-image: url({imgSrc});">
	<div class="siteWidth container-fluid">
		<div class="sliderWrapper">
			<div class="titleCol"><p class="title">{title}</p></div>
			<div class="textCol">
				<div class="text staticText white">{text}</div>
			</div>
		</div>

	</div>
</div>
[/sliderListItem_index]

<!-- ************************************************** -->
<!-- ************************************************** -->

[articleImageSliderBlock]
<section id="articleImageSlider-{id}" class="el_articleImageSlider_xs8uVQpL pt-100 pb-50">
	<div class="siteWidth container-fluid">
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

			<div class="articleImageSliderCol">
				<div class="articleImageSlider sliderBlock row align_items_center">{articleImageSliderList}</div>
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
[/articleImageSliderBlock]

[articleImageSliderListItem]
<div class="item col">
	<a href="{imgSrc}" data-fancybox="" data-imageid="{id}" style="background-image: url({imgSrc})"></a>
</div>
[/articleImageSliderListItem]

<!-- ************************************************** -->
<!-- ************************************************** -->

[articleImageSliderBlock_2]
<section id="articleImageSlider-{id}" class="el_articleImageSlider2_xs8uVQpL pt-20">
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

		<div class="articleImageSliderCol">
			<div class="articleImageSlider sliderBlock">{articleImageSliderList}</div>
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
</section>
[/articleImageSliderBlock_2]

[articleImageSliderListItem_2]
<div class="item">
	<a href="{imgSrc}" data-fancybox="" data-imageid="{id}" style="background-image: url({imgSrc})"></a>
</div>
[/articleImageSliderListItem_2]


<!-- ************************************************** -->
<!-- ************************************************** -->

[ivSliderBlock]
<section id="ivSlider-{articleCatalogId}" class="el_ivSlider_xs8uVQpL pt-100 pb-50" data-id="{articleCatalogId}">
	<div class="siteWidth container-fluid">
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

			<div class="ivSliderCol">
				<div class="ivSlider sliderBlock row">{ivSliderList}</div>
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
[/ivSliderBlock]

[ivSliderBlock2]
<div id="ivSlider-{articleCatalogId}" class="el_ivSlider_xs8uVQpL type2" data-id="{articleCatalogId}">
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

		<div class="ivSliderCol">
			<div class="ivSlider sliderBlock row">{ivSliderList}</div>
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
[/ivSliderBlock2]

[ivSliderListItem]
<div class="item col">
	<div class="img_wrap">
		<a class="el"
		   rel="thumbnail"
		   href="{imgSrc1}"
		   data-fancybox="iv-gallery-{articleCatalogId}"
		   data-caption="{description}"
		>
			<img src="{imgSrc1}" alt="">
		</a>
	</div>
</div>
[/ivSliderListItem]

[ivSliderListItem2]
<div class="item col">
	<div class="img_wrap">
		<a class="videoBtn el"
		   rel="thumbnail"
		   href="{href}"
		   data-fancybox="iv-gallery-{articleCatalogId}"
		   data-caption="{description}"
		>
			<img src="http://img.youtube.com/vi/{code}/mqdefault.jpg" alt="">
			<svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg>
		</a>
	</div>
</div>
[/ivSliderListItem2]

<!-- ************************************************** -->
<!-- ************************************************** -->

[fileCatalogSliderBlock]
<div id="imageSlider-{id}">
	<div class="sliderContainer imageSlider">{imageSliderList}</div>
</div>
[/fileCatalogSliderBlock]

[imageSliderListItem]
<div class="item">
	<div class="img_wrap"><span class="el"><img src="{imgSrc}" alt="{nameOriginal}"></span></div>
</div>
[/imageSliderListItem]

<!-- ************************************************** -->
<!-- ************************************************** -->

[sliderBlock_advantage]
<section class="advantages-slider">
	<div class="advantages-slider-wrap">
		<div class="advantages-slider-block advantages-slider-block--js">
			{sliderList}
		</div>
		<div class="advantages-slider-arrow">
			<div class="advantages-slider-arrow-wrap site-width">
				<div class="advantages-slider-arrow-btns">
					<button class="slick-prev slick-arrow advantages-slider-prev" aria-label="Previous" type="button">Previous</button>
					<button class="slick-next slick-arrow advantages-slider-next" aria-label="Next" type="button">Next</button>
				</div>
			</div>
		</div>
	</div>
</section>
[/sliderBlock_advantage]

[sliderListItem_advantage]
<div class="advantages-slider-slide">
	<div class="advantages-slider-img"><img class="img" src="{imgSrc}" alt=""></div>
	<div class="advantages-slider-text">
		<div class="advantages-slider-wrap site-width">
			<div class="item">
				<div class="item-title">
					<h2 class="item-title--title">{title}</h2>
				</div>
				<div class="item-desc">
					<div class="item-desc--desc">{text}</div>
				</div>
			</div>
		</div>
	</div>
</div>
[/sliderListItem_advantage]

<!-- ************************************************** -->
<!-- ************************************************** -->

[sliderBlock_about]
<section class="about-gallery">
	<div class="about-gallery-wrap site-width">
		<div class="title-block">
			<h2 class="title">{sliderImageCatalogTitle}:</h2>
		</div>
		<div class="about-gallery-block">
			<div class="carousel-slider carousel-slider--js">
				{sliderList}
			</div>
		</div>
	</div>
</section>
[/sliderBlock_about]

[sliderListItem_about]
<div class="carousel-slide col">
	<div class="item-block">
		<div class="item-block-img"><img class="img" src="{imgSrc}" alt=""></div>
	</div>
</div>
[/sliderListItem_about]
