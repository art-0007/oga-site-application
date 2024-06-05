<!-- Шаблон статической страницы -->
[content]
<section class="staticPageCD pt-20">
	<div class="siteWidth container-fluid">
		<div class="staticText">{text}</div>
	</div>
</section>
{donateBlock}
[/content]

<!-- ************************************************** -->

[content_about]
{videoBlock}
<section class="staticPageCD about">
	<div class="siteWidth container-fluid">
		<div class="staticText">{text}</div>
	</div>
</section>

{someElement1Block}
{someElement2Block}
{teamBlock}
{partnerBlock}
{contactUsForm}

[/content_about]

<!-- ************************************************** -->
<!-- ************************************************** -->

[content_contacts]
<section class="staticPageCD contacts pt-50 pb-50">
	<div class="siteWidth container-fluid">
		<div class="infoBlock">
			<div class="imageBlock"><img src="{imgSrc}"></div>
			<div class="pageTitle contacts">
				<h1>{pageTitle}</h1>
			</div>
		</div>

		<div class="text staticText">{text}</div>

		<div class="contactsBlock">
			<div class="row">
				<div class="col item">
					<p class="title">USA</p>
				</div>
				<div class="col item">
					<p class="itemTitle">{sh_contacts_email}</p>
					<div class="itemContent">
						<ul>
							<li><a href="mailto:{email1A}">{email1}</a></li>
						</ul>
					</div>
				</div>
				<div class="col item">
					<p class="itemTitle">{sh_contacts_telephone}</p>
					<div class="itemContent">
						<ul>
							<li><a href="tel:+{phone1A}">{phone1}</a></li>
							<li><a href="tel:+{phone2A}">{phone2}</a></li>
						</ul>
					</div>
				</div>
				<div class="col item">
					{sh_usa_adresses}
				</div>
			</div>
		</div>
	</div>
</section>
<div class="el_contactsMap_xs8uVQpL">
	<div>{map}</div>
</div>
{contactUsForm}
{contactsBlock}
[/content_contacts]

[socialNetworkListItem]
<li><a href="{href}"><img src="{imgSrc1}" alt="{title}"></a></li>
[/socialNetworkListItem]

<!-- ************************************************** -->
<!-- ************************************************** -->

<!-- Шаблон статической страницы -->
[content_onlinePaySuccess]
<section class="staticPageCD pt-20">
	<div class="siteWidth container-fluid">
		<div class="staticText">{text}</div>
	</div>
</section>
[/content_onlinePaySuccess]

<!-- ************************************************** -->
<!-- ************************************************** -->

<!-- Шаблон статической страницы -->
[content_onlinePayError]
<section class="staticPageCD pt-20">
	<div class="siteWidth container-fluid">
		<div class="staticText">{text}</div>
	</div>
</section>
[/content_onlinePayError]

