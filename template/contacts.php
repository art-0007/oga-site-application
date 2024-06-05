<!-- ************************************************** -->

[contactsBlock]
<section class="el_contactsBlock_xs8uVQpL pb-40">
	<div class="siteWidth container-fluid">
		<div class="blockTitle">
			<p class="title">{sh_ourBranches}</p>
		</div>

		<div class="contactsList">{contactsList}</div>
	</div>
</section>
[/contactsBlock]

<!-- ************************************************** -->

[contactsListItem]
<div class="contactsListItem">
	<div class="row">
		<div class="col item">
			<p class="title">{title}</p>
		</div>
		<div class="col item">
			<p class="itemTitle">{sh_contacts_email}</p>
			<div class="itemContent">
				<ul>
					<li><a href="mailto:{email}">{email}</a></li>
				</ul>
			</div>
		</div>
		<div class="col item">
			<p class="itemTitle">{sh_contacts_telephone}</p>
			<div class="itemContent">
				<ul>
					<li><a href="tel:+{phoneA}">{phone}</a></li>
				</ul>
			</div>
		</div>
		<div class="col item">
			<p class="itemTitle">{sh_contacts_adress}</p>
			<div class="itemContent">
				<div class="companyAddress">{address}</div>
			</div>
		</div>
	</div>
</div>
[/contactsListItem]
