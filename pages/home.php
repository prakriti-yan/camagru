<?php
	session_start();
	require '../class/user.class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../static/img/android-chrome-192x192.png" type="image/png" sizes="64x64">
	<link rel="stylesheet" href="../static/css/header.css">
	<link rel="stylesheet" href="../static/css/connect.css">
	<title>Camagru - login</title>
</head>
<body>
	<div id="container">
	<?php require 'header.php'?>
	<div class="section">
		<h2>Log in</h2>
		<form method="POST" action="" >
			<table border="0" align="center" cellpadding="5">
			<tr>
				<td align="right">Login: </td>
				<td><input type="TEXT" name="login" required/></td>
			</tr>
			<tr>
				<td align="right">Password: </td>
				<td><input type="PASSWORD" name="pwd" required/></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="SUBMIT" name="submit" value="OK" required/></td>
			</tr>
			</table>
		</form>
		<a href="resetPwd.php" align="center">Forget your password?</a>
	</div>
	<?php
	if (!empty(htmlentities($_POST['login'])) && !empty(htmlentities($_POST['pwd'])) && $_POST['submit'] == "OK"){
		$login = trim(htmlentities($_POST['login']));
		$pwd = htmlentities($_POST['pwd']);
		$db = new Users($login, $pwd, "", "", "");
		$db->verifyUser();
		if ($db->msg != null)
			echo '<div style="color:red;">' . $db->msg . '</div>';
		else{
			$_SESSION['loggedInUser'] = $login;
			echo '<script> location.replace("../index.php"); </script>';
		}
	}

	?>
	<div class="section">
		<h2>Register</h2>
		<form method="POST" action="">
			<table border="0" align="center" cellpadding="5">
			<tr>
				<td align="right">Login: </td>
				<td><input type="TEXT" name="new_login" required/></td>
			</tr>
			<tr>
				<td align="right">Password: </td>
				<td><input type="PASSWORD" name="new_pwd" required/></td>
			</tr>
			<tr>
				<td align="right">Repeat password: </td>
				<td><input type="PASSWORD" name="new_pwdVerif" required/></td>
			</tr>
			<tr>
				<td align="right">Email: </td>
				<td><input type="TEXT" name="new_email" required/></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="SUBMIT" name="new_submit" value="OK" required/></td>
			</tr>
			</table>
		</form>
	</div>
	<div id="footer">
		<hr>
		<a href='https://github.com/prakriti-yan' class="left bottom"  target="_blank"><strong>Yan Yan 2020</strong></a>
	</div>
	</div>
	<?php
	if (!empty(htmlentities($_POST['new_login'])) && !empty($_POST['new_pwd']) && !empty($_POST['new_pwdVerif'])
    && !empty(htmlentities($_POST['new_email'])) && $_POST['new_submit'] == "OK"){
		$new_login = trim(htmlentities($_POST['new_login']));
		$new_email = trim(htmlentities($_POST['new_email']));
		$db = new Users($new_login, $_POST['new_pwd'], $_POST['new_pwdVerif'], $new_email, "");
		$db->sendConfirmEmail();
		if ($db->msg)
			echo '<div style="color:red;">' . $db->msg . '</div>';
	}else if ($_POST['new_submit'] == "OK")
		echo '<div style="color:red;">Fill in all the fields!</div>';
	else if ($_GET['tken'] != ""){
		$token = $_GET['tken'];
		$db = new Users("", "", "", "", $token);
		$db->connectUser();
		print_r($db->msg);
		if ($db->msg)
        	echo '<div style="color:red;">' . $db->message . '</div>';
	}
	?>
	
</body>
</html>