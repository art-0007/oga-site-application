[content]
<!DOCTYPE html>

<html>

<head>
	<title>{metaTitle}</title>
	<meta name="keywords" content="{metaKeywords}" />
	<meta name="description" content="{metaDescription}" />

	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
	<meta name="viewport" content="width=device-width" />

	{mainCSS}
	{css}

	<link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />
	<link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-11396553032"></script>;
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'AW-11396553032');
	</script>

</head>

<body class="{pageClass}">
	<!-- Админ панель -->
	<div class="adminPanelCarrier_div">{adminPanel}</div>
	<!-- Админ панель //-->

	<div class="mainWrapper">
		<!-- Header -->
		{header}
		<!-- Header //-->

		<main class="mainCD">
			<!-- NavigationLine -->
			{navigationLine}
			<!-- NavigationLine //-->

			<!-- PageTitle -->
			{pageTitle}
			<!-- Content //-->

			<div class="siteWidth container-fluid">
				<div class="row">
					<div id="content" class="col contentCD">
						{content}
					</div>
				</div>
			</div>
		</main>

		<!-- Footer -->
		{footer}
		<!-- Footer //-->
	</div>

	{javascript}

</body>

</html>
[/content]

[schemaOrganization]
<!-- Start: Google Structured Data Markup -->
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "Organization",
		"url": "{url}",
		"address":
		{
			"@type": "PostalAddress",
			"addressLocality": "{sh_schemaOrg_addressLocality}",
			"postalCode": "{sh_schemaOrg_postalCode}",
			"streetAddress": "{sh_schemaOrg_streetAddress}"
		},
		"email": "{email}",
		"faxNumber": "{faxNumber}",
		"name": "{sh_schemaOrg_name}",
		"telephone": "{telephone}",
		"logo": "{logo}",
		"sameAs" :
		[
			{sameAs}
		]
	}
</script>
[/schemaOrganization]
