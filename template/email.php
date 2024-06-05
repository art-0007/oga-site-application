[content]
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>{companyName}</title>

	<style type="text/css">
		* {
			font-size: 14px;
		}

		p {
			color: #666666;
			margin: 0px;
			padding: 0px;
		}

		a {
			color: #FF8A00;
		}
	</style>
</head>

<body>
	{content}
</body>
</html>
[/content]

<!-- ************************************************************************************* -->
<!--
В шаблонах используются переменные:
{name} - Имя пользователя,
{email} - E-mail пользователя,
{question} - Вопрос пользователя,
  -->

<!-- Тема писима "Связаться с нами" -->
[subject_contactUsForm]
[{domain}] - Связаться с нами
[/subject_contactUsForm]

<!-- Контент писима "Связаться с нами"

<p><strong>E-mail</strong>: {email}</p>
 -->
[content_contactUsForm]
<p><strong>Request</strong>: {articleTitle}</p>
<p><strong>Email</strong>: {email}</p>
<br />
<p><strong>IP</strong>: {ip}</p>
<br />
[/content_contactUsForm]

<!-- ************************************************************************************* -->
<!--
В шаблонах используются переменные:
{eventTitle} - Название события,
{name} - Имя пользователя,
{email} - E-mail пользователя,
  -->

<!-- Тема писима "Регистрация на событие" -->
[subject_registerForEventForm]
[{domain}] - Регистрация на событие
[/subject_registerForEventForm]

<!-- Контент писима "Регистрация на событие"

<p><strong>Номер телефона</strong>: {phone}</p>
 -->
[content_registerForEventForm]
<p><strong>Событие</strong>: {eventTitle}</p>
<p><strong>Имя</strong>: {name}</p>
<p><strong>E-mail</strong>: {email}</p>
<br />
<p><strong>IP</strong>: {ip}</p>
<br />
[/content_registerForEventForm]

<!-- ************************************************************************************* -->
<!--
В шаблонах используются переменные:
{getInvolvedTitle} - Название Get involved,
{name} - Имя пользователя,
{phone} - Номер телефона пользователя,
{email} - E-mail пользователя,
  -->

<!-- Тема писима "Get involved" -->
[subject_getInvolvedForm]
[{domain}] - Get involved
[/subject_getInvolvedForm]

<!-- Контент писима "Get involved"

 -->
[content_getInvolvedForm]
<p><strong>Get involved</strong>: {getInvolvedTitle}</p>
<p><strong>Имя</strong>: {name}</p>
<p><strong>Номер телефона</strong>: {phone}</p>
<p><strong>E-mail</strong>: {email}</p>
<br />
<p><strong>IP</strong>: {ip}</p>
<br />
[/content_getInvolvedForm]

<!-- ************************************************************************************* -->
<!--
В шаблонах используются переменные:
{projectVideoTitle} - Название видео,
{email} - E-mail пользователя,
  -->

<!-- Тема писима "Связаться с нами" -->
[subject_projectVideoForm]
[{domain}] - {formTitle}
[/subject_projectVideoForm]

<!-- Контент писима "Связаться с нами"
 -->
[content_projectVideoForm]
<p><strong>Видео</strong>: {projectVideoTitle}</p>
<p><strong>Email</strong>: {email}</p>
<p>{response}</p>
<br />
<p><strong>IP</strong>: {ip}</p>
<br />
[/content_projectVideoForm]

<!-- ************************************************************************************* -->
<!--
В шаблонах используются переменные:
{name} - Имя пользователя,
{email} - E-mail пользователя,
{question} - Вопрос пользователя,
  -->

<!-- Тема писима "Связаться с нами" -->
[subject_projectVideoForm_user]
{subject_projectVideoForm_user}
[/subject_projectVideoForm_user]

<!-- Контент писима "Связаться с нами"

<p><strong>E-mail</strong>: {email}</p>
 -->
[content_projectVideoForm_user]
{content_projectVideoForm_user}
[/content_projectVideoForm_user]




