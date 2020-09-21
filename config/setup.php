<?php

require 'database.php';

try{
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = 'CREATE TABLE users
	(
		ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY
	)
	';
	$conn->query($sql);
}catch(PDOException $e){
	die('Error: '.$e->getMessage());
}


?>