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

			<div id="content" class="contentCD">
				{content}
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
