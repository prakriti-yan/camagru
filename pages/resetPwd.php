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
    <h2>Forgot your password?</h2>
    <form method="POST" action="">
        Login name: <br />
        <input type="TEXT" name="login" required/> <br />
        <input type="SUBMIT" name="submit" value="OK" required/>
    </form>
    <?php
        require '../class/user.class.php';
        if (!empty(htmlentities($_POST['login'])) && $_POST['submit'] == "OK"){
            $login = trim(htmlentities($_POST['login']));
            $db = new Users($login, "", "","", "", "","");
            $db->sentResetEmail();
            if ($db->msg){
                echo '<div style="color:red;">' . $db->msg . '</div>';
            }
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