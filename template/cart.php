<!-- Коренной шаблон полной корзины -->
[content]
<div class="cartContent">
	<div class="innerWrapper">
		<!-- Список акций -->
		<div id="ajaxActionInfoBlock" class="actionInfoBlock"></div>
		<!-- //Список акций -->

		<!-- Список товаров в корзине -->
		<div id="ajaxOfferInfoBlock" class="offerInfoBlock"></div>
		<!-- Список товаров в корзине //-->

		<div id="cartOfferList" class="cartOfferList"></div>

		<div class="formBlock">
			<form id="cartOrderForm" method="POST" enctype="multipart/form-data" onsubmit="Cart.addNewOrder(this); return false;">
				<div class="orderData">
					<div class="top row">
						<div class="left-side col">
							<div class="titleBlock"><p><span>{sh_personalData}</span></p></div>

							<div class="input_wrapper">
								<label for="phone">{sh_contactPhone} <sup>*</sup>:</label>
								<input id="phone" type="text" name="phone" placeholder="+XX XXX XXX XX XX" />
							</div>

							<div class="input_wrapper">
								<label for="email">Email:</label>
								<input id="email" type="text" name="email" value="{userEmail}" />
							</div>

							<div class="input_wrapper">
								<label for="firstName">{sh_firstName}:</label>
								<input id="firstName" type="text" name="firstName" />
							</div>
						</div>
						<div class="right-side col">
							<div class="titleBlock"><p><span>{sh_deliveryData}</span></p></div>

							<div class="input_wrapper">
								<label for="orderDeliveryTypeId">{sh_deliveryMethod}:</label>
								<select id="orderDeliveryTypeId" name="orderDeliveryTypeId">
									<option value="0" selected="selected">{sh_delivery}</option>
									{orderDeliveryTypeSelect}
								</select>
							</div>

							<div class="inputBlock_city">
								<div class="input_wrapper">
									<label for="city">{sh_city}:</label>
									<input id="city" type="text" name="city">
								</div>
							</div>

							<div class="inputBlock_street">
								<div class="input_wrapper">
									<label for="street">{sh_addressStreet}:</label>
									<input id="street" type="text" name="street">
								</div>
							</div>

							<div class="inputBlock_storeAddress">
								<div class="input_wrapper">
									<label for="storeAddress">{sh_storeAddress}:</label>
									<input id="storeAddress" type="text" name="storeAddress">
								</div>
							</div>

							<div class="input_wrapper">
								<label for="orderPayTypeId">{sh_paymentMethod}:</label>
								<select id="orderPayTypeId" name="orderPayTypeId">
									<option value="0" selected="selected">{sh_payment}</option>
									{orderPayTypeSelect}
								</select>
							</div>
						</div>
					</div>
					<div class="bottom row">
						<div class="bottom-side col">
							<div class="input_wrapper">
								<label for="userComment">{sh_note}:</label>
								<textarea id="userComment" name="userComment"></textarea>
							</div>
						</div>
					</div>

					<div class="btn_wrap">
						<button id="checkoutBtn" class="btn checkoutBtn">{sh_checkout}<span class="preloader"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></span></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
[/content]

<!-- Коренной шаблон пустой корзины -->
[cartEmpty_content]
<section class="cartEmptyContent">
	<div class="innerWrapper row">
		<div class="bag col"><i class="fa fa-shopping-basket" aria-hidden="true"></i></div>
		<div class="text staticText col">
			<p>{sh_cartEmpty_text_1}</p>
			<p>{sh_cartEmpty_text_2}</p>
			<p><a class="btn" href="/"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> {sh_goToShopping}</a></p>
		</div>
	</div>
</section>
[/cartEmpty_content]

<!-- Коренной шаблон успешного оформления заказа -->
[сartComplete_content]
<section class="сartCompleteContent">
	<div class="staticText">
		<p class="thanks">{sh_cartSuccess_text_1}</p>
		<p class="manager">{sh_cartSuccess_text_2}</p>
		<p class="goToHome"><a class="btn" href="/"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> {sh_goToMainPage}</a></p>
	</div>
</section>
[/сartComplete_content]

<!-- **************************************************************** -->
<!-- **************************************************************** -->

<!-- Шаблон блока списка товаров в корзине -->
[offerListBlock]
<!-- Список товаров -->
<div class="offerListBlock">
	<div class="tableHeader row">
		<div class="col delete" title="{sh_delete}"><p></p></div>
		<div class="col product"><p>{sh_product}</p></div>
		<div class="col price"><p>{sh_price}</p></div>
		<div class="col qty"><p>{sh_quantity}</p></div>
		<div class="col sum"><p>{sh_cost}</p></div>
	</div>

	{offerList}

	<div class="tableFooter row">
		<div class="col summary">
			<div class="row">
				<div class="col text">{sh_discount} <span>{userDiscountPercent}%</span>:</div>
				<div class="col count">- {discountPrice} <span class="currency">₴</span></div>
			</div>
			<div class="row result">
				<div class="col text">{sh_totalForPayment}:</div>
				<div class="col count"><span id="orderPaySum">{orderPaySum}</span> <span class="currency">₴</span></div>
			</div>
		</div>
	</div>
</div>

<div class="minOrderSumTextBlock">{minOrderSumText}</div>
<!-- Список товаров //-->
[/offerListBlock]

<!--<div class="row">-->
<!--	<div class="col text">{sh_costOfDelivery}:</div>-->
<!--	<div class="col count"><span id="orderDeliveryPrice">{{ 0|number_format(settings.moneyNumAmountAfterPoint, '.', '') }}</span> <span class="currency">₴</span></div>-->
<!--</div>-->

<!-- Шаблон елемента списка товаров в корзине -->
[offerListItem]
<div class="itemRow row">
	<div class="delete col">
		<form id="offerDeleteForm-{offerId}" method="POST" enctype="multipart/form-data" onsubmit="CartOfferAction.del(this, event); return false;" autocomplete="off">
			<input type="hidden" name="offerId" value="{offerId}">
			<input type="hidden" name="offerAmount" value="{offerAmount}">
			<button class="btn3" title="{sh_delete}"><i class="fa fa-trash" aria-hidden="true"></i></button>
		</form>
	</div>
	<div class="col product">
		<div class="container-fluid">
			<div class="row">
				<div class="itemImg col">
					<div class="img_wrap">
						<a href="{offerUrl}" class="el"><img src="{offerImgSrc}" alt=""></a>
					</div>
				</div>
				<div class="col description">
					<p class="title"><a href="{offerUrl}">{offerTitle}</a></p>
				</div>
			</div>
		</div>
	</div>
	<div class="col price">
		<p><span>{offerPrice}</span> <span class="currency">₴</span></p>
	</div>
	<div class="col qty">
		<form id="offerForm-{offerId}" method="POST" enctype="multipart/form-data" onsubmit="CartOfferAction.change(this, event); return false;" autocomplete="off">
			<input type="hidden" name="offerId" value="{offerId}">
			<div class="wrapper">
				<button type="button" class="minus" onclick="CartOfferAction.plusAndMinusButton(this, 'minus');"></button>
				<input class="qtyinput" type="text" name="offerAmount" value="{offerAmount}" onchange="Cart.changeOfferAmount({offerId}, {offerAmount})" />
				<button type="button" class="plus" onclick="CartOfferAction.plusAndMinusButton(this, 'plus');"></button>
				<p class="calc"><a type="sumbit" href="javascript: void(0);">{sh_recalculate}</a></p>
			</div>
		</form>
	</div>
	<div class="col sum">
		<p><span>{offerCost}</span> <span class="currency">₴</span></p>
	</div>
</div>
[/offerListItem]

[minOrderSumText]
<p class="text alert alert-warning">{minOrderSumText}</p>
[/minOrderSumText]

