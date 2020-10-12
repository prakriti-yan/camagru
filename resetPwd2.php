<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camagru - reset password</title>
</head>
<body>
	<?php require "header.php"; ?>
    <h2>Reset your password:</h2>
	<form class="" action="#" method="POST">
		New password: <input type="password" name="new_pwd" value=""><br/>
		Confirm new password: <input type="password" name="new_pwdVerif" value=""><br/>
		<input class="button" type = "submit" name= "submit" value="OK">
	</form>
	<?php
	require 'class/user.class.php';
	if (htmlentities($_GET['tken']) != "" && !empty($_POST['new_pwd']) && !empty($_POST['new_pwdVerif']) && $_POST['submit'] == "OK"){
		$token = htmlentities($_GET['tken']);
		$new_pwd = $_POST['new_pwd'];
		$new_pwdVerif = $_POST['new_pwdVerif'];
		$db = new Users("", $new_pwd, $new_pwdVerif, "", $token);
		$db->resetPwd();
		if ($db->msg)
			echo '<p style="color:red;">' . $db->msg . '</p>';
	}
	?>
</body>
</html>