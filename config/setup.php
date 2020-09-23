<?php

// include 'database.php';
$DB_DSN = 'mysql:dbname=camagru;host=127.0.0.1';
// $DB_DSN = 'mysql:host=127.0.0.1';
$DB_USER = 'root';
$DB_PD = 'password';

try{
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// $sql = "USE camagru";
	// $conn->exec($sql);
	// $sql = 'CREATE TABLE IF NOT EXISTS product (
	// 	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	// 	name VARCHAR(50) NOT NULL,
	// 	information TEXT NOT NULL,
	// 	price INT NOT NULL,
	// 	category VARCHAR(100) NOT NULL,
	// 	origin VARCHAR(100) NOT NULL,
	// 	img VARCHAR(300) NOT NULL);';
	// $conn->query($sql);
}catch(PDOException $e){
	die('Error: '.$e->getMessage());
}


?>