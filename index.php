<?PHP 

	session_start();

	if (!isset($_SESSION['loggedInUser'])){
		require './config/setup.php';
		header("Location: home.php");
	}else{
		header("Location: main.php");
	}

?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Camagru</title>
</head>
<body>

<p>Camgagu</p>
	
</body>
</html> -->
