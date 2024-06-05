<!-- Шаблон футера сайта -->
[content]
<footer id="footerCD" class="footerCD">
	<div class="topFooterBlock">
		<div class="siteWidth container-fluid">
			<div class="row">
				<div class="col logoCol">
					<div class="logoBlock">
						<a class="logo" href="/">
							<img src="{TEMPLATE}/img/logo_footer.png" alt="">
						</a>
					</div>

					<ul class="contactsBlock">
						<li class="link"><a href="tel:+{phone1A}">{phone1}</a></li>
						<li class="link email"><a href="mailto:{email1A}">{email1}</a></li>
					</ul>

					<p class="btnLine"><a class="btn type5 h50 {contactsActive}" href="/page/contacts/">{sh_menu_contacts}</a></p>
				</div>
				<div class="col itemCol menu">
					<p class="itemTitle">{sh_footerItemTitle_1}</p>
					<div class="itemContent">
						<ul>
							<li><a class="{aboutActive}" href="/page/about/">{sh_menu_aboutUs}</a></li>
							<li><a class="{projectActive}" href="/project/">{sh_menu_projects}</a></li>
							<li><a class="{eventActive}" href="/event/">{sh_menu_events}</a></li>
							<li><a class="{getInvolvedActive}" href="/get-involved/">{sh_menu_getInvolved}</a></li>
						</ul>
						<ul>
							<li><a class="{donateActive}" href="/donate/">{sh_menu_donate}</a></li>
							<li><a class="{partnerActive}" href="/partner/">{sh_menu_partners}</a></li>
							<li><a class="{newsActive}" href="/news/">{sh_menu_news}</a></li>
							<li><a class="{contactsActive}" href="/page/contacts/">{sh_menu_contacts}</a></li>
						</ul>
					</div>
				</div>
				<div class="col itemCol socialNetwork">
					<p class="itemTitle">{sh_footerItemTitle_2}</p>
					<div class="itemContent socialNetworkBlock">
						<ul class="socialNetworkList bottom">
							{socialNetworkList}
						</ul>
					</div>
				</div>
				<div class="col itemCol subscribeCol">
					<p class="itemTitle">{sh_footerItemTitle_4}</p>
					<div class="itemContent">
						<p class="btnLine"><a class="btn h50" href="#" onclick="Form.subscribeFormShow(event);">{sh_subscribeButton}</a></p>

						{contactsAddTaxtBlock}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="bottomFooterBlock">
		<div class="siteWidth container-fluid">
			<div class="row">
				<div class="col copyrightCol">
					<div class="copyright">&copy; Copyright {companyName} {curentYear}. All Rights Reserved.</div>
				</div>
				<div class="col menuCol">
					<ul>
						<li><a href="/page/privacy-policy/">{sh_menu_privacyPolicy}</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>
[/content]

<!--******************************************-->

[socialNetworkListItem]
<li><a href="{href}" target="_blank"><img src="{imgSrc1}" alt="{altTitle}"></a></li>
[/socialNetworkListItem]

<!--******************************************-->

[contactsAddTaxtBlock]
<div class="additionalInformation staticText">{description}</div>
[/contactsAddTaxtBlock]