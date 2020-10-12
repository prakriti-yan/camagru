<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camagru - reset password</title>
</head>
<body>
    <h2>Forgot your password?</h2>
    <form method="POST">
        Login name: <br />
        <input type="TEXT" name="login" required/> <br />
        <input type="SUBMIT" name="submit" value="OK" required/>
    </form>
    <?php
        require 'class/user.class.php';
    ?>
</body>
</html>