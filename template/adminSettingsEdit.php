<!-- Коренной шаблон общих настроек (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitleH1}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminSettings.edit(this); return false;">

		<div class="title required">emailFrom</div>
		<div class="content"><input type="text" name="emailFrom" value="{emailFrom}" /></div>

		<div class="title required">Email для писем</div>
		<div class="content"><input type="text" name="emailTo" value="{emailTo}" /></div>

		<div class="title required">Email шлюзы</div>
		<div class="title checkbox" style="display: inline-block;; margin-right: 50px;">
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><input id="SMTP" type="radio" name="emailGateway" value="1" {eg1_checked} /></td>
				<td><label for="SMTP" style="cursor: pointer;">SMTP</label></td>
			</tr>
			</table>
		</div>
		<div class="title checkbox" style="display: inline-block;; margin-right: 50px;">
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><input id="Mail" type="radio" name="emailGateway" value="2" {eg2_checked} /></td>
				<td><label for="Mail" style="cursor: pointer;">Mail</label></td>
			</tr>
			</table>
		</div>
		<div class="title checkbox" style="display: inline-block;; margin-right: 50px;">
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><input id="Sendmail" type="radio" name="emailGateway" value="3" {eg3_checked} /></td>
				<td><label for="Sendmail" style="cursor: pointer;">Sendmail</label></td>
			</tr>
			</table>
		</div>

		<div class="separator"></div>

		<div class="title required">Количество проэктов на главной</div>
		<div class="content"><input type="text" name="projectAmountOnIndex" value="{projectAmountOnIndex}" /></div>

		<div class="title required">Количество новостей на главной</div>
		<div class="content"><input type="text" name="newsAmountOnIndex" value="{newsAmountOnIndex}" /></div>

		<div class="title required">Количество партнеров на главной</div>
		<div class="content"><input type="text" name="partnerAmountOnIndex" value="{partnerAmountOnIndex}" /></div>

		<div class="title required">Количество событий на главной</div>
		<div class="content"><input type="text" name="eventAmountOnIndex" value="{eventAmountOnIndex}" /></div>

		<div class="title required">Количество команди на главной</div>
		<div class="content"><input type="text" name="teamAmountOnIndex" value="{teamAmountOnIndex}" /></div>

		<div class="separator"></div>

		<div class="title required">Домен</div>
		<div class="content"><input type="text" name="front_domain" value="{front_domain}" /></div>

		<div class="title required">Название компании</div>
		<div class="content"><input type="text" name="front_companyName" value="{front_companyName}" /></div>

		<div class="title required">Телефон компании №1</div>
		<div class="content"><input type="text" name="phone1" value="{phone1}" /></div>

		<div class="title">Телефон компании №2</div>
		<div class="content"><input type="text" name="phone2" value="{phone2}" /></div>

		<div class="title">Email компании №1</div>
		<div class="content"><input type="text" name="email1" value="{email1}" /></div>

		<div class="title">Email компании №2</div>
		<div class="content"><input type="text" name="email2" value="{email2}" /></div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.parent.window.$.fancybox.close();">Отменить</a></div>

	</form>
</div>
[/content]

<!--
<div class="title required">Размеры изображения каталога товаров (ШхВ)</div>
<div class="content"><input class="imgSize" type="text" name="catalogImgWidth_1" value="{catalogImgWidth_1}" /> x <input class="imgSize" type="text" name="catalogImgHeight_1" value="{catalogImgHeight_1}" /></div>
<div class="comment">Если 0 - то изображение будет загружаться без изменений</div>

<div class="title required">Количество новостей на странице списка новостей</div>
<div class="content"><input type="text" name="newsAmountInNewsList" value="{newsAmountInNewsList}" /></div>

<div class="title required">Количество новостей в левом меню</div>
<div class="content"><input type="text" name="newsAmountInLeftMenu" value="{newsAmountInLeftMenu}" /></div>

<div class="title required">Количество товаров в блоке</div>
<div class="content"><input type="text" name="dataAmountInBlock" value="{dataAmountInBlock}" /></div>

<div class="title required">Количество знаков после точки в ценах</div>
<div class="content"><input type="text" name="numAmountAfterPoint" value="{numAmountAfterPoint}" /></div>

<div class="title required">Обрезать последние цифры если это нули? </div>
<div class="title checkbox" style="display: inline-block;; margin-right: 50px;">
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="Yes" type="radio" name="cutLastNumberIfZeros" value="1" {cutLastNumberIfZeros1_checked} /></td>
			<td><label for="Yes" style="cursor: pointer;">Да</label></td>
		</tr>
	</table>
</div>
<div class="title checkbox" style="display: inline-block;; margin-right: 50px;">
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td><input id="No" type="radio" name="cutLastNumberIfZeros" value="0" {cutLastNumberIfZeros0_checked} /></td>
			<td><label for="No" style="cursor: pointer;">Нет</label></td>
		</tr>
	</table>
</div>

<div class="title required">Курс</div>
<div class="content"><input type="text" name="currencyRate" value="{currencyRate}" /></div>
<div class="comment">Целое или дробное (разделитель ".") число больше нуля</div>

<div class="title required">Минимальная сумма заказа</div>
<div class="content"><input type="text" name="minOrderSum" value="{minOrderSum}" /></div>

<div class="title">Телефон компании №2</div>
<div class="content"><input type="text" name="phone2" value="{phone2}" /></div>


-->