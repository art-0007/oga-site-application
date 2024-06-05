<!-- Шаблон шапки сайта -->
[content]
<header id="headerCD" class="headerCD {pageClass}">
	<div id="fixedHeader" class="fixedHeader" data-top="0px">
		<div class="siteWidth container-fluid">
			<div class="row">
				<div class="col logoCol">
					<div class="logo">
						<a href="/"><img src="/template/img/logo.png" alt=""></a>
					</div>
				</div>
				<nav class="col navCol">
					<ul>
						<li><a class="{aboutActive}" href="/page/about/">{sh_menu_aboutUs}</a></li>
						<li><a class="{eventActive}" href="/event/">{sh_menu_events}</a></li>
						<li><a class="{projectActive}" href="/project/">{sh_menu_projects}</a></li>
						<li><a class="{donateActive}" href="/donate/">{sh_menu_donate}</a></li>
						<li><a class="{getInvolvedActive}" href="/get-involved/">{sh_menu_getInvolved}</a></li>
						<li><a class="{contactsActive}" href="/page/contacts/">{sh_menu_contacts}</a></li>
					</ul>
				</nav>
				<div class="col rightCol">
					<div class="bgWrapper">
						{socialBlock}

						{langBlock}

						<div class="menuButtonCol">
							<button id="showMenuButton" class="showMenuButton burgerBtn" onclick="Main.toggleClassBlock(event, $('#showMenuButton ,#closeMenuButton'), '#mobileMenuBlock', 'open', true);">
								<div class="burger"><span></span></div>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
[/content]

[subMenuListBlock]
<div class="subBlock">
	<ul>{subMenuList}</ul>
</div>
[/subMenuListBlock]

[subMenuListItem]
<li>
	<a class="{activeClass}" href="{href}">
		<span class="ico">
			<span class="img_wrap">
				<span class="el"><img src="{imgSrc1}"></span>
			</span>
		</span>
		<span class="title">{title}</span>
	</a>
</li>
[/subMenuListItem]

<!-- Шаблон кабинета в шапке -->
[profileBlock]
<div class="col profileCol">
	<div class="toggleWrapper">
		<p class="toggleTitle">
			<a href="#" onclick="Main.toggleClassBlock(event, this, '#profileLinkBlock')">
				<svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M7.54585 0.0121109C6.43616 0.152871 5.54316 0.571905 4.77404 1.31276C3.07399 2.95034 2.89202 5.60342 4.3512 7.47744C5.75483 9.28013 8.31836 9.78839 10.2882 8.65449C12.0285 7.65278 12.927 5.7073 12.5546 3.74695C12.2112 1.93896 10.7501 0.464538 8.93317 0.0925052C8.58749 0.0217066 7.82051 -0.0227126 7.54585 0.0121109ZM4.26201 9.65663C2.7157 9.92782 1.29726 10.8867 0.412646 12.2587C0.225747 12.5486 0 13.0398 0 13.1565C0 13.3859 0.664419 14.3193 1.29258 14.9724C2.82732 16.568 4.71934 17.5189 6.89956 17.7905C7.3535 17.8471 8.61907 17.8465 9.0655 17.7895C10.8323 17.5638 12.4043 16.9047 13.7642 15.8193C14.1854 15.4831 15.016 14.6263 15.3419 14.1919C15.71 13.7013 16 13.2306 16 13.1238C16 13.0202 15.8026 12.5908 15.6329 12.3251C15.0364 11.3917 14.2051 10.6328 13.2717 10.1697C12.5906 9.83179 11.7418 9.59707 11.3131 9.62802C11.1634 9.63883 11.0677 9.67153 10.9281 9.7595C10.4229 10.0779 10.2645 10.1667 9.98313 10.2889C9.28992 10.5899 8.58145 10.7224 7.82533 10.6924C6.85984 10.6541 6.05146 10.3954 5.24493 9.86637C5.06945 9.75126 4.88262 9.64749 4.82976 9.63573C4.77687 9.624 4.71004 9.60942 4.68122 9.60335C4.6524 9.59724 4.46376 9.62125 4.26201 9.65663Z" fill="#2F2A27"/>
				</svg>
			</a>
		</p>
		<div id="profileLinkBlock" class="toggleBlock profileLinkBlock">
			<ul>
				{linkList}
			</ul>
		</div>
	</div>
</div>
[/profileBlock]

<!-- Шаблон для авторизованного пользователя -->
[authorizationUser]
<li><a class="{userProfileActive}" href="/user/profile/" title="{sh_myProfile}"><span>{sh_myProfile}</span></a></li>
<li><a href="javascript:void(0);" onclick="Authorization.logoutButton()" title="{sh_exit}"><i class="fa fa-sign-out" aria-hidden="true"></i> <span>{sh_exit}</span></a></li>
[/authorizationUser]

<!-- Шаблон для не авторизованного пользователя -->
[notAuthorizationUser]
<li><a id="authorizationLink" class="authorizationLink" href="javascript:void(0);"><span>{sh_signIn}</span></a></li>
<li><a id="registrationLink" class="registrationLink" href="javascript:void(0);"><span>{sh_registration}</span></a></li>
[/notAuthorizationUser]

[langBlock]
<div class="langCol">
	<div class="toggleWrapper">
		<p class="toggleTitle"><a href="#" onclick="Main.toggleClassBlock(event, this, '#langToggleBlock')">{activeLangCode} <span class="toggleBtn"></span></a></p>
		<div id="langToggleBlock" class="toggleBlock langToggleBlock">
			<ul>
				{langList}
			</ul>
		</div>
	</div>
</div>
[/langBlock]

<!-- Шаблон елемента списка языков -->
[langListItem]
<li><a href="#" onclick="Main.setLang({langId}, event);">{name}</a></li>
[/langListItem]

[langListItem_active]
<li class="active"><span>{name}</span></li>
[/langListItem_active]

<!-- socialBlock -->

[socialBlock]
<div class="socialCol">
	<ul>{socialNetworkList}</ul>
</div>
[/socialBlock]

[socialNetworkListItem]
<li><a href="{href}"><img src="{imgSrc2}" alt="{title}"></a></li>
[/socialNetworkListItem]

<!-- mobileMenuBlock -->

[mobileMenuBlock]
<div id="mobileMenuBlock" class="mobileMenuBlock">
	<div class="closeBG" onclick="Main.toggleClassBlock(event, $('#showMenuButton ,#closeMenuButton'), '#mobileMenuBlock', 'open', true);"></div>
	<div class="mobileContent">
		<div class="logoBlock">
			<div class="row">
				<div class="col mobLogoCol">
					<a class="logo" href="/"><img src="/template/img/logo.png" alt=""></a>
				</div>
				<div class="col menuButtonCol">
					<button id="closeMenuButton" class="closeMenuButton burgerBtn" onclick="Main.toggleClassBlock(event, $('#showMenuButton ,#closeMenuButton'), '#mobileMenuBlock', 'open', true)">
						<div class="burger"><span></span></div>
					</button>
				</div>
			</div>
		</div>

		<ul class="mainUL">
			<li><a class="{aboutActive}" href="/page/about/">{sh_menu_aboutUs}</a></li>
			<li><a class="{projectActive}" href="/project/">{sh_menu_projects}</a></li>
			<li><a class="{eventActive}" href="/event/">{sh_menu_events}</a></li>
			<li><a class="{getInvolvedActive}" href="/get-involved/">{sh_menu_getInvolved}</a></li>
			<li><a class="{donateActive}" href="/donate/">{sh_menu_donate}</a></li>
			<li><a class="{newsActive}" href="/news/">{sh_menu_news}</a></li>
<!--			<li><a class="{teamActive}" href="/team/">{sh_menu_team}</a></li>-->
			<li><a class="{contactsActive}" href="/page/contacts/">{sh_menu_contacts}</a></li>
		</ul>

		<div class="contactsBlock">
			<p class="phone"><a href="tel:+{phone1A}">{phone1}</a></p>
			<p class="email"><a href="mailto:{email1A}">{email1}</a></p>
		</div>
		<div class="socialNetworkList">
			<ul>{socialNetworkList}</ul>
		</div>
	</div>
</div>
[/mobileMenuBlock]

<!--
<li>
	<a href="#" onclick="Main.toggleClassBlock(event, this, '#mobileMenuBlock #scBlock-0');">{sh_catalog}</a>
	<button class="toggleBtn" onclick="Main.toggleClassBlock(event, this, '#mobileMenuBlock #scBlock-0');"></button>
	<ul id="scBlock-0">{catalogBlock}</ul>
</li>
-->

[catalogListItem]
<li><a class="" href="{href}">{title}</a></li>
[/catalogListItem]

[catalogListSubItem]
<li>
	<a class="{activeClass}" href="javascript:void(0);" onclick="Main.toggleClassBlock(event, this, '#mobileMenuBlock #scBlock-{id}');">{title}</a>
	<button class="toggleBtn" onclick="Main.toggleClassBlock(event, this, '#mobileMenuBlock #scBlock-{id}');"></button>
	<ul id="scBlock-{id}">{subCatalogList}</ul>
</li>
[/catalogListSubItem]
