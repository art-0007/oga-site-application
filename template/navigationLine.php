<!-- Коренной шаблон навигационной строки -->
[content]
<div class="navigationLineCD">
	<div class="siteWidth container-fluid">
		<ul class="vocabulary">{content}</ul>
	</div>
</div>
[/content]

<!-- Шаблон елемента навигационной строки (первый ссылка) -->
[navigationLineItem_first_active]
<li><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Ноmе</a></li>
[/navigationLineItem_first_active]

<!-- Шаблон елемента навигационной строки (ссылка) -->
[navigationLineItem_active]
<li><a href="{href}">{title}</a></li>
[/navigationLineItem_active]

<!-- Шаблон елемента навигационной строки (не ссылка) -->
[navigationLineItem_passive]
<li>{title}</li>
[/navigationLineItem_passive]

<!-- Шаблон елемента навигационной строки (разделитель) -->
[navigationLineItem_separator]
<li class="separator">/</li>
[/navigationLineItem_separator]
