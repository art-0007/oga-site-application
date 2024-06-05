<!-- Коренной шаблон списка пользователей админпанели (админка) -->
[content]
<div class="pageTitle"><h1>{pageTitle}</h1></div>
<div class="editForm">
	{toolbar}
	<div class="adminUserList">
		<table class="list" cellpadding="0" cellspacing="0" border="0">
		<tr class="trHeader">
			<td><p>Ф.И.О</p></td>
			<td><p>E-mail</p></td>
			<td colspan="2"></td>
		</tr>
		<tr class="trSeparator">
			<td colspan="4"></td>
		</tr>
		{adminUserList}
		</table>
	</div>
</div>
[/content]

<!-- Шаблон toolbara  -->
[toolbar]
<div class="toolbar">
	<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="filled"><p><a class="add" href="/admin/admin-user/add/" title="Добавить"></a></p></td>
		<td class="tdSeparator">&nbsp;</td>
		<td width="*">&nbsp;</td>
	</tr>
	</table>
</div>
[/toolbar]

<!-- Список пользователей админпанели пуст -->
[adminUserList_empty]
<tr>
	<td colspan="4">
		<p>Список пользователей админпанели пуст!</p>
	</td>
</tr>
[/adminUserList_empty]

<!-- Елемент списка пользователей админпанели -->
[adminUserListIteam]
<tr class="line {zebra}">
	<td><p>{name}</p></td>
	<td><p>{email}</p></td>
	<td class="button"><p><a class="edit" href="javascript: void(0);" onclick="window.location.href = '/admin/admin-user/edit/{id}/';" title="Редактировать"></a></p></td>
	<td class="button"><p><a class="delete" href="javascript: void(0);" onclick="AdminAdminUser.deleteConfirm({id});" title="Удалить"></a></p></td>
</tr>
[/adminUserListIteam]

<!-- ************************************************************************************************************ -->
<!-- ************************************************************************************************************ -->

<!-- Шаблон страницы добавления -->
[adminUserAdd]
<div class="pageTitle"><h1>{pageTitle}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminAdminUser.add(this); return false;">

	<div class="title required">Имя</div>
	<div class="content"><input type="text" name="firstName"></div>

	<div class="title required">E-mail</div>
	<div class="content"><input type="text" name="email"></div>

	<div class="title required">Пароль <a href="javascript: void(0)" onclick="AdminAdminUser.generatePassword()">[сгенерировать]</a></div>
	<div class="content"><input type="text" name="password"></div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/admin-user/';">Отменить</a></div>

	</form>
</div>
[/adminUserAdd]

<!-- ************************************************************************************************************ -->
<!-- ************************************************************************************************************ -->

<!-- Шаблон страницы редактированя -->
[adminUserEdit]
<div class="pageTitle"><h1>{pageTitle}</h1></div>
<div class="editForm">
	<form autocomplete="off" enctype="multipart/form-data" onsubmit="AdminAdminUser.edit(this); return false;">
	<input type="hidden" name="adminUserId" value="{id}">

	<div class="title required">Имя</div>
	<div class="content"><input type="text" name="firstName" value="{firstName}"></div>
	<div class="title">Отчество</div>
	<div class="content"><input type="text" name="middleName" value="{middleName}"></div>
	<div class="title">Фамилия</div>
	<div class="content"><input type="text" name="lastName" value="{lastName}"></div>
	<div class="title required">Email</div>
	<div class="content"><input type="text" name="email" value="{email}"></div>
	<div class="title">Пароль <a href="javascript: void(0)" onclick="AdminAdminUser.generatePassword()">[сгенерировать]</a></div>
	<div class="content"><input type="password" name="password"></div>
	<div class="comment">Вводите, только если нужно изменить пароль</div>

	<div class="buttons"><button class="button" type="submit">{submitButtonTitle}</button> или <a href="javascript: void(0);" onclick="window.location.href = '/admin/admin-user/';">Отменить</a></div>

	</form>
</div>
[/adminUserEdit]
