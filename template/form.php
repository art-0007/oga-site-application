[contactUsForm]
<section class="formBlockType1 el_contactUsFormBlock_xs8uVQpL pt-200 pb-0" style="background-image: url('{TEMPLATE}/img/contact-us-form-bg.jpg');">
	<div class="siteWidth container-fluid">
		<div class="innerWrapper">
			<div class="contentBlock">
				<div class="blockTitle mb-10">{sh_contactUsForm_title}</div>
				<div class="note">{sh_contactUsForm_note}</div>

				<form id="contactUsForm" class="contactUsForm" method="POST" enctype="multipart/form-data" onsubmit="Form.contactUsFormSend(this, '#contactUsForm'); return false;">

					<p id="form_message" class="alert"></p>

					<div class="input_wrapper">
						<select name="requestId">
							<option value="">Select the topic of the request</option>
							{selectRequestList}
							<option value="0">{sh_other}</option>
						</select>
						<p id="form_message-requestId" class="alert"></p>
					</div>

					<div class="input_wrapper">
						<input id="email" type="text" name="email" placeholder="E-mail" />
						<p id="form_message-email" class="alert"></p>
					</div>

					<div class="btn_wrap">
						<button class="btn h65">{sh_send}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
[/contactUsForm]

<!-- ************************************************************************************************************ -->
<!-- ************************************************************************************************************ -->

[registerForEventForm]
<section class="formBlockType1 el_registerForEventFormBlock_xs8uVQpL pt-200 pb-0" style="background-image: url('{TEMPLATE}/img/register-for-event-form-bg.jpg');">
	<div class="siteWidth container-fluid">
		<div class="innerWrapper">
			<div class="contentBlock">
				<div class="blockTitle mb-10">
					<p class="title">{sh_registerForEventForm_title}</p>
				</div>
				<div class="note">{sh_registerForEventForm_note}</div>

				<form id="registerForEventForm" class="registerForEventForm" method="POST" enctype="multipart/form-data" onsubmit="Form.registerForEventFormSend(this, '#registerForEventForm'); return false;">
					<input type="hidden" name="articleId" value="{articleId}">

					<p id="form_message" class="alert"></p>

					<div class="input_wrapper">
						<input id="name" type="text" name="name" placeholder="{sh_name}" />
						<p id="form_message-name" class="alert"></p>
					</div>

					<div class="input_wrapper">
						<input id="email" type="text" name="email" placeholder="E-mail" />
						<p id="form_message-email" class="alert"></p>
					</div>

					<div class="btn_wrap">
						<button class="btn h65">{sh_register}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
[/registerForEventForm]

[registerForEventForm_model]
<div id="myModal" class="registerForEventFormCD modal">
	<div>
		<div class="blockTitle2 text-center"><span>{sh_registerForEventForm_title}</span></div>
		<p class="note eventTitle">{eventTitle}</p>

		<div class="modalСontent text-center">
			<form id="registerForEventForm" method="POST" enctype="multipart/form-data" onsubmit="Form.registerForEventFormSend(this, '#registerForEventForm'); return false;">
				<input type="hidden" name="articleId" value="{articleId}">

				<p id="form_message" class="alert"></p>

				<div class="input_wrapper">
					<label for="name">{sh_name} <sup>*</sup>:</label>
					<input id="name" type="text" name="name" />
					<p id="form_message-name" class="alert"></p>
				</div>

				<div class="input_wrapper">
					<label for="phone">{sh_phone} <sup>*</sup>:</label>
					<input id="phone" type="text" name="phone" placeholder="+XX XXX XXX XX XX" />
					<p id="form_message-phone" class="alert"></p>
				</div>

				<div class="btn_wrap">
					<button class="btn">{sh_register}</button>
				</div>
			</form>
		</div>
	</div>
</div>
[/registerForEventForm_model]

<!-- ************************************************************************************************************ -->
<!-- ************************************************************************************************************ -->

[projectDonateForm]
<div id="myModal" class="projectDonateFormCD modal">
	<div>
		<div class="blockTitle2 text-center">
			<p class="title">{sh_donate}</p>
		</div>
		<p class="note donateTitle">{projectTitle}</p>

		<div class="modalСontent text-center">
			<ul class="projectDonateList">
				{projectDonateList}
			</ul>
		</div>
	</div>
</div>
[/projectDonateForm]

[projectDonateListItem]
<li><a class="donateItem" href="{href}" target="_blank">{title} <i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
[/projectDonateListItem]

<!-- ************************************************************************************************************ -->
<!-- ************************************************************************************************************ -->

[donateForm]
<div id="myModal" class="donateFormCD modal">
	<div>
		<div class="blockTitle2 text-center">
			<p class="title">{sh_donateForm_title}</p>
		</div>
		<p class="note donateTitle">{sh_donateForm_note}</p>

		<div class="modalСontent text-center">
			<form id="donateForm" method="POST" enctype="multipart/form-data" onsubmit="Form.donateFormSend(this, '#donateForm'); return false;">
				<input type="hidden" name="articleId" value="{articleId}">

				<p id="form_message" class="alert"></p>

				<div class="input_wrapper">
					<label for="projectId">Project <sup>*</sup>:</label>
					<select class="" name="projectId">
						{projectOptionSelect}
					</select>
					<p id="form_message-projectId" class="alert"></p>
				</div>

				<div class="input_wrapper">
					<label for="articleDonateId">Donate <sup>*</sup>:</label>
					<select class="" name="articleDonateId">
						{donateOptionSelect}
					</select>
					<p id="form_message-articleDonateId" class="alert"></p>
				</div>

				<div class="input_wrapper">
					<label for="donationAmount">{sh_donationAmount} <sup>*</sup>:</label>
					<p class="donationAmountList">{donationAmountList}</p>
					<input id="donationAmount" type="text" name="donationAmount" value="{donationAmountValue}" />
					<p id="form_message-donationAmount" class="alert"></p>
				</div>

				<div class="btn_wrap">
					<button class="btn h65">{sh_donateForm_btn}</button>
				</div>
			</form>
		</div>
	</div>
</div>
[/donateForm]

[donationAmountListItem]
<span class="daItem" onclick="Form.setValueToField(this, 'donationAmount', '{sum}')">{title}</span>
[/donationAmountListItem]

<!-- ************************************************************************************************************ -->
<!-- ************************************************************************************************************ -->

[getInvolvedForm]
<div id="myModal" class="getInvolvedFormCD modal">
	<div>
		<div class="blockTitle2 text-center"><p class="title">{sh_getInvolvedForm_title}</p></div>
		<p class="note getInvolvedTitle">{getInvolvedTitle}</p>

		<div class="modalСontent text-center">
			<form id="getInvolvedForm" method="POST" enctype="multipart/form-data" onsubmit="Form.getInvolvedFormSend(this, '#getInvolvedForm'); return false;">
				<input type="hidden" name="articleId" value="{articleId}">

				<p id="form_message" class="alert"></p>

				<div class="input_wrapper">
					<label for="name">{sh_name} <sup>*</sup>:</label>
					<input id="name" type="text" name="name" />
					<p id="form_message-name" class="alert"></p>
				</div>

				<div class="input_wrapper">
					<label for="phone">{sh_phone} <sup>*</sup>:</label>
					<input id="phone" type="text" name="phone" placeholder="+XX XXX XXX XX XX" />
					<p id="form_message-phone" class="alert"></p>
				</div>

				<div class="input_wrapper">
					<label for="email">E-mail <sup>*</sup>:</label>
					<input id="email" type="text" name="email" placeholder="E-mail" />
					<p id="form_message-email" class="alert"></p>
				</div>

				<div class="btn_wrap">
					<button class="btn">{sh_getInvolvedForm_btnTitle}</button>
				</div>
			</form>
		</div>
	</div>
</div>
[/getInvolvedForm]

<!-- ************************************************************************************************************ -->
<!-- ************************************************************************************************************ -->

[subscribeForm]
<div id="myModal" class="subscribeFormCD modal">
	<div>
		<div class="blockTitle2 text-center">
			<p class="title">{sh_subscribeForm_title}</p>
		</div>
		<p class="note text-center">{sh_subscribeForm_note}</p>

		<div class="modalСontent text-center">
			<form id="subscribeForm" class="subscribeForm" method="POST" enctype="multipart/form-data" onsubmit="Form.subscribeFormSend(this, '#subscribeForm'); return false;">

				<p id="form_message" class="alert"></p>

				<div class="input_wrapper">
					<input id="email" type="text" name="email" placeholder="E-mail" />
					<p id="form_message-email" class="alert"></p>
				</div>

				<div class="btn_wrap">
					<button class="btn">{sh_subscribeForm_btn}</button>
				</div>
			</form>
		</div>
	</div>
</div>
[/subscribeForm]

<!-- ************************************************************************************************************ -->
<!-- ************************************************************************************************************ -->

[projectVideoForm]
<div id="myModal" class="projectVideoFormCD modal">
	<div>
		<div class="blockTitle2 text-center">
			<p class="title">{sh_projectVideoForm_title}</p>
		</div>
		<p class="note projectVideoTitle">{sh_projectVideoForm_note}</p>

		<div class="modalСontent text-center">
			<form id="projectVideoForm" method="POST" enctype="multipart/form-data" onsubmit="Form.projectVideoFormSend(this, '#projectVideoForm'); return false;">
				<input type="hidden" name="projectVideoId" value="{projectVideoId}">

				<p id="form_message" class="alert"></p>

				<div class="input_wrapper">
					<input id="email" type="text" name="email" placeholder="E-mail" />
					<p id="form_message-email" class="alert"></p>
				</div>

				<div class="input_wrapper checkbox">
					<input id="recordVideoResponseKey" type="checkbox" name="recordVideoResponseKey" value="true">
					<label for="recordVideoResponseKey">{sh_text_3}</label>
				</div>

				<div class="btn_wrap">
					<button class="btn h65">{sh_projectVideoForm_btn}</button>
				</div>
			</form>
		</div>
	</div>
</div>
[/projectVideoForm]

<!-- ************************************************************************************************************ -->
<!-- ************************************************************************************************************ -->
