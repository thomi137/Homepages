<?php if(!isset($_SESSION['username'])):
	if(!isset($_POST['username']) && !isset($_POST['password'])):?>
		<div id="login">
			<form name="loginform" class="loginform" action="login" method="post">
				<input type="text" name="username" value="Benutzername" onBlur="if(this.value=='')this.value='Benutzername'" onFocus="if(this.value=='Benutzername')this.value='' ">
				<input type="password" name="password" value="Passwort" onBlur="if(this.value=='')this.value='Passwort'" onFocus="if(this.value=='Passwort')this.value='' ">
				<input type="submit" value="Login">
		</form>
	</div>
	<?php else:
		include('./modules/db_connection.php');
		$username = DbUtils::sanitize($_POST['username']);
		$password = DbUtils::sanitize($_POST['password']);	
		if(DbUtils::get_login($username, $password)){
		$_SESSION['username'] = $username;
	}
	include('./content/admin.php');
	?>
	<?php endif;?>
<?php else:
	include('./content/admin.php');
 endif; ?>
