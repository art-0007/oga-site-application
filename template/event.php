<!-- Коренной шаблон страницы списка -->
[content]
<section class="eventListCD pt-20">
	<div class="siteWidth container-fluid">
		<div class="eventList row typeContentBlock1 inRow2">{eventList}</div>

		{textBlock}
	</div>
</section>
{donateBlock}
[/content]

[textBlock]
<div class="text staticText">{text}</div>
[/textBlock]

[eventList_empty]
<p class="listEmpty">{sh_listEmpty}</p>
[/eventList_empty]

<!-- ************************************************** -->

[eventBlock]
<section class="el_eventBlock_xs8uVQpL">
	<div class="siteWidth container-fluid">
		<div class="blockTitle">
			<p class="title">{articleCatalogTitle}</p>
		</div>

		<div class="eventList row typeContentBlock1 inRow2">{eventList}</div>

		<p class="btnLine text-right"><a class="btn" href="/event/">{sh_allEvents}</a></p>
	</div>
</section>
[/eventBlock]

<!-- ************************************************** -->

[eventListItem]
<div class="el_entityListItem2_xs8uVQpL col">
	<a class="innerWrapper" href="{href}" style="background-image: url({imgSrc1});">
		<div class="infoBlock">
			<span class="title">{title}</span>
			<div class="description staticText white">{description}</div>
			<span class="btn type2 more">{sh_more}</span>
		</div>
	</a>
</div>
[/eventListItem]

[eventListItem2]
<div class="el_entityListItem2_xs8uVQpL col">
	<a class="innerWrapper" href="{href}">
		<span class="imageBlock">
			<span class="img_wrap">
				<span class="el"><img src="{imgSrc1}" alt="{altTitle}" /></span>
			</span>
		</span>
		<div class="infoBlock">
			<div class="p1">
				<span class="date">{date}</span>
				<span class="arrow">
					<svg width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M6.28675 1.03675C6.13632 1.35116 6.27254 1.74524 6.58106 1.88833C6.66128 1.92552 7.23307 1.99048 8.24985 2.0779C9.10053 2.15105 9.80319 2.21882 9.81133 2.22852C9.81945 2.2382 7.82806 3.9227 5.38597 5.97185L0.945861 9.69755L0.888583 9.83811C0.800504 10.0543 0.830714 10.2557 0.981092 10.4548C1.12967 10.6515 1.30128 10.7368 1.53568 10.7307L1.68518 10.7269L6.16685 6.97655C8.63175 4.91386 10.6551 3.23408 10.6631 3.24367C10.6712 3.25325 10.616 3.96577 10.5404 4.82705C10.3922 6.5173 10.3933 6.55903 10.5922 6.74825C10.7248 6.87436 10.9628 6.95467 11.1431 6.93412C11.3458 6.91103 11.5739 6.74549 11.6474 6.56824C11.7127 6.41059 12.1205 1.70473 12.0827 1.54515C12.0443 1.38277 11.8733 1.18642 11.7127 1.12026C11.5268 1.04365 6.83467 0.642779 6.68364 0.690605C6.52788 0.739897 6.35783 0.888232 6.28675 1.03675Z" fill="#5F7ABA"/>
					</svg>
				</span>
			</div>
			<div class="p2">
				<span class="title">{title}</span>
				<div class="description staticText">{description}</div>
			</div>
		</div>
	</a>
</div>
[/eventListItem2]

<!-- ************************************************** -->
<!-- ************************************************** -->

[content_view]
{projectImageSlider}
<section class="eventContetView pt-20">
	<div class="siteWidth container-fluid">

		<p class="descriptionBlockLine">{sh_text_2}</p>

		<div class="text staticText">{text}</div>


		<div class="detailsAndVenueBlock">
			<div class="detailsBlock bgBlue">
				<div>
					<div class="item">
						<p class="title">{sh_date}:</p>
						<div class="text">{date}</div>
					</div>

					<div class="item">
						<p class="title">{sh_time}:</p>
						<div class="text">{time}</div>
					</div>

					<div class="item">
						<p class="title">{sh_venue}:</p>
						<div class="text">{venue}</div>
					</div>
				</div>

				<div>
					<div class="item">
						<p class="title">{sh_eventCategories}:</p>
						<div class="text">{eventCategories}</div>
					</div>

					<div class="item">
						<p class="title">{sh_website}:</p>
						<div class="text">{website}</div>
					</div>
				</div>
			</div>
			<div class="venueBlock">
				<div class="map"><div>{venueMap}</div></div>
			</div>
		</div>

	</div>
</section>

{registerForEventForm}
[/content_view]