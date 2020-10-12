<?php

session_start();
if (!isset($_SESSION['loggedInUser'])){
	header("Location: home.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Camagru - web camera</title>
</head>
<body>
	<?php include 'header.php'; ?>
	
</body>

</html>