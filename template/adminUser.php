<!-- Коренной шаблон списка пользователей админпанели (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitle}</h1></div>
<div class="editForm">
	{toolbar}
	<div class="userList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>Ф.И.О</p></td>
			<td><p>E-mail / Телефон</p></td>
			<td colspan="2"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="4"></td>
		</tr>
		{userList}
		</table>
	</div>
</div>
[/content]

<!-- Шаблон toolbara  -->
[toolbar]
<div class="toolbar">
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="filled"><p><a class="add" href="/admin/user/add/" title="Добавить"></a></p></td>
		<td class="tdSeparator">&nbsp;</td>
		<td width="*">&nbsp;</td>
	</tr>
	</table>
</div>
[/toolbar]

<!-- Список пользователей админпанели пуст -->
[userList_empty]
<tr>
	<td colspan="4">
		<p>Список покупателей пуст!</p>
	</td>
</tr>
[/userList_empty]

<!-- Елемент списка пользователей админпанели -->
[userListItem]
<tr class="line {zebra}">
	<td><p>{lastName} {firstName} {middleName}</p></td>
	<td>
		<p>{email}</p>
		<p>{phone}</p>
	</td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/user/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminUser.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/userListItem]

<!-- ************************************************************************************************************ -->
<!-- ************************************************************************************************************ -->

<!-- Шаблон страницы добавления -->
[userAdd]
<div class="pageTitle"><h1>{pageTitle}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminUser.add(this); return false;">

	<div class="title required">Имя</div>
	<div class="content"><input type="text" name="firstName"></div>

	<div class="title required">E-mail</div>
	<div class="content"><input type="text" name="email"></div>

	<div class="title required">Пароль <a href="javascript: void(0)" onclick="AdminUser.generatePassword()">[сгенерировать]</a></div>
	<div class="content"><input type="text" name="password"></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/user/';">Отменить</a></div>

	</form>
</div>
[/userAdd]

<!-- ************************************************************************************************************ -->
<!-- ************************************************************************************************************ -->

<!-- Шаблон страницы редактированя -->
[userEdit]
<div class="pageTitle"><h1>{pageTitle}</h1></div>
<p style="text-align: right;"><a href="javascript:void(0);" onclick="window.location.reload(true);">Обновить страницу</a></p>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminUser.edit(this); return false;">
		<input type="hidden" name="userId" value="{id}">

		<div class="title">Id покупателя - {id}</div>
		<div class="content"></div>

		<div class="row mt-30">
			<div class="col">
				<div class="title required">Имя</div>
				<div class="content"><input type="text" name="firstName" value="{firstName}"></div>

				<div class="title">Фамилия</div>
				<div class="content"><input type="text" name="lastName" value="{lastName}"></div>

				<div class="title">Отчество</div>
				<div class="content"><input type="text" name="middleName" value="{middleName}"></div>

				<div class="title">Пол</div>
				<div class="content"><select name="sex">{sexSelect}</select></div>

			</div>
			<div class="col">
				<div class="title required">Email</div>
				<div class="content"><input type="text" name="email" value="{email}"></div>

				<div class="title">Телефон</div>
				<div class="content"><input type="text" name="phone" value="{phone}"></div>

				<div class="title">Город</div>
				<div class="content"><input type="text" name="city" value="{city}"></div>

				<div class="title">Скидка</div>
				<div class="content"><input type="text" name="discount" value="{discount}"></div>

			</div>
		</div>

		<div class="row mt-30">
			<div class="col">
				<div class="title">Активирована ли запись</div>
				<div class="title checkbox">
					<table cellspacing="0" cellpadding="0" border="0">
						<tbody>
						<tr>
							<td><input id="activeKey" type="checkbox" value="yes" name="activeKey" {activeKey_checked}></td>
							<td><label style="cursor: pointer;" for="activeKey">Да</label></td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col">
				<div class="title">Пароль <a href="javascript: void(0)" onclick="AdminUser.generatePassword()">[сгенерировать]</a></div>
				<div class="content"><input type="password" name="password"></div>
				<div class="comment">Вводите, только если нужно изменить пароль</div>
			</div>
		</div>

		<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/user/';">Отменить</a></div>
	</form>
</div>
[/userEdit]
