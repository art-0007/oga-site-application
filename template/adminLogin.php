[content]
<div class="loginCarrier">
	<div>
		<div class="loginLogo"><p>Авторизация</p></div>
		<div class="editForm">
			<form autocomplete="off" id="id_loginForm" enctype="multipart/form-data" onsubmit="AdminLogin.login(this); return false;">

			<div class="title">Email</div>
			<div class="content"><input class="short" id="id_email" type="text" name="email"></div>
			<div class="title">Пароль</div>
			<div class="content"><input class="short" id="id_password" type="password" name="password"></div>

			<div style="margin-top: 25px;">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>&nbsp;</td>
					<td align="right">
						<div><button class="button" type="submit">Войти</button></div>
					</td>
				</tr>
				</table>
			</div>

			</form>
		</div>
	</div>
</div>
[/content]