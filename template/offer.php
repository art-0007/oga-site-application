<!-- Коренной шаблон страницы списка товаров -->
[content]
<section class="offerPageCD">
	<div class="row">
		<div id="productImageBlock" class="col imageCol">
			<div class="mainImageBlock">
				<div class="img_wrap">
					{imageList}
				</div>
				{wobblerImgList}
			</div>
			{previewImageBlock}
		</div>
		<div class="col infoCol">
			{pageTitle}
			{availableBlock}
			<div class="priceBlock">
				<form method="POST" enctype="multipart/form-data" onsubmit="CartOfferAction.add(this); return false;">
					<input type="hidden" name="offerId" value="{id}">

					<p class="priceTitle">{sh_price}</p>
					{priceOld}
					<p class="price"><span class="value">{price}</span> <span class="currency">₴</span></p>

					<div class="row">
						<div class="col amountCol">
							<div class="wrapper">
								<button class="minus" type="button" onclick="CartOfferAction.plusAndMinusButton(this, 'minus');"></button>
								<input class="offerAmount" type="text" name="offerAmount" value="1">
								<button class="plus" type="button" onclick="CartOfferAction.plusAndMinusButton(this, 'plus');"></button>
							</div>
						</div>
						<div class="col btnCol">
							<p class="formButton"><button class="addToCartBtn" {buyBtnDisable}><span>{sh_buy}</span></button></p>
						</div>
					</div>
				</form>
			</div>

			{tabBlock}
		</div>
	</div>
</section>
{otherOfferBlock}
[/content]

[imageListItem]
<a href="javascript:void(0);" class="mainImage fancyBoxImg el {viewedClass}"
   data-fancybox="offerImage" rel="thumbnail"
   data-offer-img-id="{id}"
   data-big-offer-img-src="{bigImgSrc}"
>
	<img src="{imgSrc}" alt="">
</a>
[/imageListItem]

[previewImageBlock]
<div class="previewImageBlock">
	<div class="row previewImageSlider type2">
		{previewImageList}
	</div>
</div>
[/previewImageBlock]

<!-- Шаблон  одного изображения -->
[previewImageListItem]
<div class="item col">
	<div class="img_wrap">
		<a href="javascript:void(0);" class="imageA el" data-offer-img-id="{id}">
			<img src="{imgSrc}" alt="">
		</a>
	</div>
</div>
[/previewImageListItem]

[tabBlock]
<div id="tabBlock" class="tabBlock">
	<ul class="tabs">
		<li class="tab-item"><a id="tab-1" class="tab" href="#tab=1" data-tab-id="1">{sh_description}</a></li>
	</ul>
	<div class="tabContents">
		<div id="tabContent-1" class="tabContent staticText">{description}</div>
	</div>
</div>
[/tabBlock]

<!-- ************************************************** -->
<!-- ************************************************** -->

<!-- Шаблон пустой страницы товаров -->
[offerList_empty]
<p class="listEmpty">{sh_listEmpty}</p>
[/offerList_empty]

<!--  -->
[wobblerListItem]
<img class="dataMark id{id}" src="{imgSrc}" title="{title}" alt="{title}" border="0" />
[/wobblerListItem]

<!-- Шаблон блока (Старая цена) -->
[priceOld]
<p class="priceOld"><span class="value">{priceOld}</span> <span class="currency">₴</span></p>
[/priceOld]

<!-- Шаблон блока (в наличии) -->
[available]
<p class="available yes"><i class="fa fa-check-circle-o" aria-hidden="true"></i> {sh_available}</p>
[/available]

<!-- Шаблон блока (нет в наличии) -->
[notAvailable]
<p class="available not"><i class="fa fa-times-circle-o" aria-hidden="true"></i> {sh_notAvailable}</p>
[/notAvailable]

<!-- ************************************************** -->
<!-- ************************************************** -->

<!-- Шаблон элемента списка товаров (шаблон товара)  -->
[offerListItem_1]
<div class="offerShortView_1 col">
	<div class="innerWrapper">
		<div class="imageBlock">
			<div class="img_wrap">
				<a class="el" href="{href}"><img class="offerImg" src="{imgSrc}" alt="{altTitle}" /></a>
				{wobblerImgList}
			</div>
		</div>
		<div class="infoBlock">
			<p class="catalogTitle"><span>{catalogTitle}</span></p>
			<p class="title"><a href="{href}" title="{altTitle}">{title}</a></p>
			{availableBlock}
			<div class="priceBlock">
				<form method="POST" enctype="multipart/form-data" onsubmit="CartOfferAction.add(this); return false;">
					<input type="hidden" name="offerId" value="{offerId}">

					<div class="row-5">
						<div class="col-5 priceCol">
							{priceOld}
							<p class="price"><span class="value">{price}</span> <span class="currency">₴</span></p>
						</div>
						<div class="col-5 amountCol">
							<div class="wrapper">
								<button class="minus" type="button" onclick="CartOfferAction.plusAndMinusButton(this, 'minus');"></button>
								<input class="offerAmount" type="text" name="offerAmount" value="1">
								<button class="plus" type="button" onclick="CartOfferAction.plusAndMinusButton(this, 'plus');"></button>
							</div>
						</div>
					</div>
					<p class="formButton"><button class="addToCartBtn" {buyBtnDisable}><span>{sh_buy}</span></button></p>
				</form>
			</div>
		</div>
	</div>
</div>
[/offerListItem_1]

<!-- Шаблон элемента списка товаров (шаблон товара)  -->
[offerListItem_2]
<div class="offerShortView_2 col">
	<a class="innerWrapper" href="{href}">
		<span class="imageBlock">
			<span class="img_wrap">
				<span class="el"><img src="{imgSrc}" alt="{altTitle}" /></span>
				{wobblerImgList}
			</span>
		</span>
		<span class="infoBlock">
			<span class="title">{title}</span>
		</span>
	</a>
</div>
[/offerListItem_2]

<!-- ************************************************** -->
<!-- ************************************************** -->

[offerListBlock]
<section id="offerListBlock" class="offerListBlock">
	<div class="blockTitle">
		<p class="title">{blockTitle}</p>
	</div>
	<div class="offerList row typeContentBlock1 inRow5 sliderBlock type2">{offerList}</div>
</section>
[/offerListBlock]
