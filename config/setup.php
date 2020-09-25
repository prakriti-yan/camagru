<?php

require 'database.php';

try{
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = 'CREATE DATABASE IF NOT EXISTS camagru';
	$conn->exec($sql);
}catch(PDOException $e){
	die('Error: '.$e->getMessage());
}

try{
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = 'CREATE TABLE IF NOT EXISTS `users` (
		`id_user` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		`login` VARCHAR(30) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
		`password` VARCHAR(255) NOT NULL,
		`email` VARCHAR(255) NOT NULL,
		`date_creation` DATETIME NOT NULL,
		`confirm` BOOLEAN DEFAULT 0 NOT NULL,
		`token` VARCHAR(255),
		`token_expires` DATETIME)';
	$conn->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `images` (
		`id_pic` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		`login` VARCHAR(30) NOT NULL,
		`date_creation` DATETIME NOT NULL,
		`image` LONGBLOB NOT NULL)";
	$conn->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `likes` (
		`id_like` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		`id_pic` INT UNSIGNED NOT NULL,
		`login` VARCHAR(30) NOT NULL,
		`date_creation` DATETIME NOT NULL)";
	$conn->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `comments` (
		`id_comment` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		`id_pic` INT UNSIGNED NOT NULL,
		`comment` VARCHAR(255) NOT NULL,
		`login` VARCHAR(30) NOT NULL,
		`date_creation` DATETIME NOT NULL)";
	$conn->exec($sql);


}catch(PDOException $e){
	die('Error: '.$e->getMessage());
}

$conn = null;

?>