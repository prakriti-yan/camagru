<?PHP 

	session_start();

	if (!isset($_SESSION['loggedInUser'])){
		require './config/setup.php';
		header("Location: home.php");
	}else{
		header("Location: main.php");
	}

?>
