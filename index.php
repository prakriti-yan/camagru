<?PHP 

	session_start();

	if (!isset($_SESSION['loggedInUser'])){
		require 'config/setup.php';
		header("Location: pages/home.php");
	}else{
		header("Location: pages/main.php");
	}

?>
