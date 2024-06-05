<!-- Кореной шаблон блока страниц -->
[content]
<div class="paginationCD">
	<ul class="wrapper">
		<li class="previousPage">{previousPage}</li>
		<li class="paginationList">{paginationList}</li>
		<li class="nextPage">{nextPage}</li>
	</ul>
</div>
[/content]

<!-- Элемент previousPage [активный] -->
[previousPage_active]
<span>&larr;</span>
[/previousPage_active]

<!-- Элемент previousPage [пассивный] -->
[previousPage_passive]
<a href="{href}">&larr;</a>
[/previousPage_passive]

<!-- Элемент списка страниц [активный] -->
[paginationListItem_active]
<span>{page}</span>
[/paginationListItem_active]

<!-- Элемент списка страниц [точки] -->
[paginationListItem_point]
<span>...</span>
[/paginationListItem_point]

<!-- Элемент списка страниц [пассивный] -->
[paginationListItem_passive]
<a href="{href}">{page}</a>
[/paginationListItem_passive]

<!-- Элемент nextPage [активный] -->
[nextPage_active]
<span>&rarr;</span>
[/nextPage_active]

<!-- Элемент nextPage [пассивный] -->
[nextPage_passive]
<a href="{href}">&rarr;</a>
[/nextPage_passive]