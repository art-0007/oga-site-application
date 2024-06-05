<!-- Коренной шаблон страницы списка -->
[content]
<section class="projectListCD pt-20  pb-20 ">
	<div class="siteWidth container-fluid">
		{projectCatalogList}
		<div class="projectList row typeContentBlock1 inRow2">{projectList}</div>
		<div class="text staticText">{text}</div>
	</div>
</section>

{someElement2Block}
[/content]

[projectList_empty]
<p class="listEmpty">{sh_listEmpty}</p>
[/projectList_empty]

<!-- ************************************************** -->
<!-- ************************************************** -->




<!-- ************************************************** -->
<!-- ************************************************** -->

[projectCatalogListBlock]
<div class="el_projectCatalogListBlock_xs8uVQpL">
	<ul class="projectCatalogList">
		<li>
			<a class="{activeClass}" href="/project/">
				<span class="title">
					<span class="ico">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M0.834766 15.4784C1.04102 17.0983 2.0293 18.3659 3.51602 18.9245C5.60859 19.7108 7.99336 18.6495 8.81406 16.5698C9.07188 15.9081 9.07617 15.8608 9.07617 13.8026V11.912L8.95586 11.6671C8.80977 11.3663 8.52188 11.1042 8.2125 10.9881C7.98906 10.9065 7.88164 10.9022 6.2875 10.9022C4.41836 10.9022 4.14766 10.928 3.49883 11.16C2.5707 11.4995 1.71133 12.2643 1.26445 13.1581C0.91211 13.8671 0.744532 14.7737 0.834766 15.4784ZM2.75977 14.5159C2.94453 13.7338 3.5418 13.1194 4.37109 12.8573C4.56875 12.7928 4.83086 12.7799 5.93516 12.7628L7.25859 12.7413L7.24141 14.0647C7.22422 15.1733 7.20703 15.4311 7.14258 15.6288C7.00938 16.0456 6.81602 16.3721 6.54531 16.6385C5.55703 17.6053 4.00586 17.5022 3.17227 16.4108C2.74258 15.8522 2.60078 15.1991 2.75977 14.5159Z" fill="white"/>
							<path d="M0.847488 5.53125C1.09241 7.29297 2.476 8.72813 4.22913 9.0332C4.51272 9.08477 4.98108 9.09766 6.28733 9.09766C7.88147 9.09766 7.98889 9.09336 8.21233 9.01172C8.52171 8.8957 8.8096 8.63359 8.95569 8.33281L9.076 8.08789L9.08889 6.35625C9.09749 4.95547 9.08889 4.55156 9.03733 4.24219C8.63342 1.92188 6.39905 0.422265 4.07444 0.912109C2.50178 1.24297 1.2428 2.50195 0.907644 4.0875C0.826004 4.46992 0.795926 5.16602 0.847488 5.53125ZM2.74241 4.49141C2.90569 3.74375 3.49007 3.07773 4.22053 2.81992C4.58147 2.69102 5.13147 2.66523 5.48811 2.75977C6.28733 2.96602 6.8803 3.5418 7.14241 4.37109C7.20686 4.56875 7.22405 4.82656 7.24124 5.93516L7.25843 7.25859L5.93499 7.23711C4.48694 7.21562 4.4053 7.20273 3.87678 6.94062C3.38694 6.69141 2.91428 6.09844 2.76389 5.52695C2.68655 5.24336 2.67796 4.79648 2.74241 4.49141Z" fill="white"/>
							<path d="M10.9836 15.8866C11.1641 16.7116 11.5766 17.4678 12.1567 18.0178C12.5606 18.4002 12.784 18.5549 13.2824 18.7913C14.8594 19.5346 16.7371 19.2081 17.9703 17.9706C20.0715 15.8737 19.3367 12.2987 16.5738 11.1901C15.9207 10.928 15.6629 10.9022 13.7508 10.9022C12.118 10.9022 12.0106 10.9065 11.7871 10.9881C11.4777 11.1041 11.1899 11.3663 11.0438 11.667L10.9234 11.912L10.9149 13.7166C10.9063 15.3237 10.9149 15.56 10.9836 15.8866ZM14.0688 12.7627C15.1688 12.7799 15.4309 12.7928 15.6285 12.8573C16.4578 13.1194 17.0336 13.7124 17.2399 14.5116C17.3301 14.851 17.3086 15.4053 17.1926 15.7577C17.1496 15.8866 17.0164 16.1401 16.8961 16.3163C16.2516 17.2659 15.0012 17.5709 13.9742 17.0338C13.4371 16.7502 12.9602 16.1229 12.8399 15.5428C12.7668 15.1776 12.7625 15.1217 12.7539 13.8928L12.7496 12.7413L14.0688 12.7627Z" fill="white"/>
						</svg>
					</span>
					{sh_all}
				</span>
			</a>
		</li>
		{projectCatalogList}
	</ul>
</div>
[/projectCatalogListBlock]

[projectCatalogListItem]
<li><a class="{activeClass}" href="{href}"><span class="title"> <span class="ico">{img}</span> {title}</span> {priority}</a></li>
[/projectCatalogListItem]

[priority]
<span class="priority">{sh_ourPriorities}</span>
[/priority]

<!-- ************************************************** -->

[projectBlock]
<section id="projectSlider" class="el_projectBlock_xs8uVQpL">
	<div class="siteWidth container-fluid">
		<div class="blockTitle">
			<p class="title">{articleCatalogTitle}</p>
		</div>

		<div class="projectList row typeContentBlock1 inRow2">{projectList}</div>

		<p class="btnLine text-right">
			<a class="btn" href="/project/">{sh_moreProjects}</a>
		</p>
	</div>
</section>
[/projectBlock]

[projectBlock2]
<section id="projectSlider" class="el_projectBlock_xs8uVQpL">
	<div class="siteWidth container-fluid">
		<div class="projectList row typeContentBlock1 inRow2">{projectList}</div>
	</div>
</section>
[/projectBlock2]

<!-- ************************************************** -->

[projectListItem1]
<div class="el_entityListItem_xs8uVQpL i1 col {addClass}">
	<div class="innerWrapper" style="background-image: url({imgSrc1})">
		<div class="catalogInfo">
			{articleCatalogImg}
			<p class="catalogTitle">{articleCatalogTitle}</p>
		</div>

		<div class="infoBlock">
			<p class="title"><a href="{href}"><span>{title}</span></a></p>
			<div class="description staticText white">{description}</div>

			<div class="bottomBlock">
				<div>
					<p class="btnLine">
						<a class="btn type2 more" href="{href}">{sh_more}</a>
					</p>

				</div>
			</div>
		</div>
	</div>
</div>
[/projectListItem1]

<!--{donatedBlock}-->

[donatedBlock]
<div class="donatedBlock">
	<div class="donated">
		<div style="width: {donatedWidth}%;"></div>
		<span>{donated}$</span> <span>{cost}$</span>
	</div>
</div>
[/donatedBlock]


[projectListItem2]
<div class="el_entityListItem_xs8uVQpL i2 col {addClass}">
	<div class="innerWrapper" style="background-image: url({imgSrc1})">
		<div class="catalogInfo">
			{articleCatalogImg}
			<p class="catalogTitle">{articleCatalogTitle}</p>
		</div>

		<div class="infoBlock">
			<p class="title"><a href="{href}"><span>{title}</span></a></p>

			<div class="bottomBlock">
				<div>
					<p class="btnLine">
						<a class="btn type2 more" href="{href}">{sh_more}</a>
						{donateBtn}
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
[/projectListItem2]

[donateBtn_1]
<a class="btn donate" href="#" onclick="Form.projectDonateFormShow(event, {id});">{sh_donate}</a>
[/donateBtn_1]

[donateBtn_2]
<a class="btn donate" href="{href}" target="_blank">{sh_donate}</a>
[/donateBtn_2]

<!-- ************************************************** -->
<!-- ************************************************** -->

[content_view]
{topSliderBlock}
<section class="projectContetView pt-50">
	<div class="siteWidth container-fluid">
		<div class="text staticText">{text}</div>
	</div>
</section>
{projectBlock}
{videoBlock}
{projectVideoBlock}
{bottomSliderBlock}
[/content_view]
