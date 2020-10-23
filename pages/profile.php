<?php
	session_start();
	require '../class/user.class.php';
	require '../class/image.class.php';
	require '../class/like.class.php';
	require '../class/comment.class.php';

	if (!isset($_SESSION['loggedInUser']))
		header("Location: home.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../static/img/android-chrome-192x192.png" type="image/png" sizes="64x64">
	<link rel="stylesheet" href="../static/css/header.css">
	<link rel="stylesheet" href="../static/css/connect.css">
	<title>Camagru - setting</title>
</head>
<body>
	<div id="container">
	<?php require 'header.php'?>
	<div class="section">
		<h2>Edit profile</h2>
		<form method="POST" action="">
			<table border="0" align="center" cellpadding="5">
			<tr>
				<td align="right">Login: </td>
				<td align="left"><input type="TEXT" name="new_login" id="login" required /></td>
			</tr>
			<tr>
				<td align="right">Email: </td>
				<td align="left"><input type="TEXT" name="new_email" id="email" required /></td>
			</tr>
			<tr>
				<td align="right">New password: </td>
				<td align="left"><input type="PASSWORD" name="new_pwd" ></td>
			</tr>
			<tr>
				<td align="right">Repeat new password: </td>
				<td align="left"><input type="PASSWORD" name="new_pwdVerif" ></td>
			</tr>
			<tr>
				<td align="right">Notification setting: </td>
				<td align="left"><input type="checkbox" name="notification" value="yes" /><label for="notification">Receive emails upon comment to your posts</label></td>
			</tr>
			<tr>
				<td align="right">Confirm with old password: </td>
				<td align="left"><input type="PASSWORD" name="old_pwd" required/></td>
			</tr>
			<tr>
				<td align="right"> </td>
				<td colspan="2" align="left"><input type="SUBMIT" name="new_submit" value="OK" required/></td>
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
	if (!empty(htmlentities($_POST['new_login'])) && !empty($_POST['new_pwd']) && !empty($_POST['new_pwdVerif']) &&!empty($_POST['old_pwd'])
    && !empty(htmlentities($_POST['new_email'])) && $_POST['new_submit'] == "OK"){
		$new_login = trim($_POST['new_login']);
		$new_email = trim(htmlentities($_POST['new_email']));
		if (!isset($_POST['notification']))
			$db = new Users($new_login, $_POST['new_pwd'], $_POST['new_pwdVerif'],$_POST['old_pwd'], $new_email, "", "no");
		else
			$db = new Users($new_login, $_POST['new_pwd'], $_POST['new_pwdVerif'],$_POST['old_pwd'], $new_email, "", "yes");
		// print_r($_POST);
		// print_r($db);
		$db->updateProfile();
		if (($db->msg) !== null){
			echo '<div style="color:red;">' . $db->msg . '</div>';
			return;
		}else{
			$old_login= $_SESSION['loggedInUser'];
			$imgs = new Images("", "", $old_login);
			$imgs->changeLogin($new_login);
			$likes = new Likes("", $old_login);
			$likes->changeLogin($new_login);
			$cmts = new Comments("",  $old_login, "");
			$cmts->changeLogin($new_login);
			$db->resetSession();
			echo '<div style="color:red;">Your account has been successfully modified!</div>';
		}
		
	}else if ($_POST['new_submit'] == "OK")
		echo '<div style="color:red;">Fill in all the fields!</div>';
	?>
	<script type="application/javascript">
		document.getElementById("login").value='<?php echo $_SESSION['loggedInUser'] ; ?>'; 
		document.getElementById("email").value='<?php echo $_SESSION['email'] ; ?>'; 
		document.getElementById("name").innerHTML='<?php echo $_SESSION['loggedInUser'] ; ?>'; 
	</script>
</body>
</html>