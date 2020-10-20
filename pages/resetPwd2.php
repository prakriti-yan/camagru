<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../static/img/android-chrome-192x192.png" type="image/png" sizes="64x64">
	<link rel="stylesheet" href="/static/css/header.css">
	<link rel="stylesheet" href="/static/css/connect.css">
	<title>Camagru - reset password</title>
</head>
<body>
	<div id="container">
	<?php require "header.php"; ?>
	<div class="section height">
    <h2>Reset your password:</h2>
	<form class="" action="#" method="POST">
		New password: <input type="password" name="new_pwd" value="" required><br/>
		Confirm new password: <input type="password" name="new_pwdVerif" value="" required><br/>
		<input class="button" type = "submit" name= "submit" value="OK">
	</form>
	<?php
	require '../class/user.class.php';
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
	</div>
	<div id="footer">
			<hr>
			<a href='https://github.com/prakriti-yan' class="left bottom"  target="_blank"><strong>Yan Yan 2020</strong></a>
	</div>
	</div>
</body>
</html>