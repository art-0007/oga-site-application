<!-- Коренной шаблон страницы списка -->
[content]
<section class="getInvolvedListCD pt-20">
	<div class="siteWidth container-fluid">
		<ul class="getInvolvedTitleList">{getInvolvedTitleList}</ul>
		<div class="getInvolvedList">{getInvolvedList}</div>
	</div>
</section>
{fileBlock}
[/content]

[getInvolvedList_empty]
<p class="listEmpty">{sh_listEmpty}</p>
[/getInvolvedList_empty]

<!-- ************************************************** -->

[getInvolvedListItem_title]
<li><a href="#gi-{id}" onclick="Main.scrollTo('gi-{id}', event);">{title}</a></li>
[/getInvolvedListItem_title]

<!-- ************************************************** -->

[getInvolvedListItem]
<div id="gi-{id}" class="el_getInvolvedListItem_xs8uVQpL">
	<div class="itemWrapper">
		<p class="title">{title}</p>
		<div class="description staticText">{description}</div>
		{btnBlock}
	</div>
</div>
[/getInvolvedListItem]

[btnBlock]
<p class="btnLine"><a class="btn" href="#" onclick="Form.getInvolvedFormShow(event, {id});">{sh_becomeVolunteerNow}</a></p>
[/btnBlock]

<!-- ************************************************** -->
<!-- ************************************************** -->

[content_view]
<section class="getInvolvedContetView">
	<div class="siteWidth container-fluid">
		<div class="staticText">{text}</div>
	</div>
</section>
[/content_view]