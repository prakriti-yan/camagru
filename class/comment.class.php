<?php

class Comments {

	private $db;
	private $id_pic;
	private $login;
	private $comment;

	public function __construct($id_pic, $login, $comment){
		try{
			require "../config/database.php";
			$this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->id_pic = $id_pic;
			$this->login = $login;
			$this->comment = $comment;
		}catch(PDOException $e){
				die('Error: '.$e->getMessage());
		}
	}

	public function getCmt(){
		try{
			$request = $this->db->prepare("SELECT * FROM `comments` WHERE `id_pic` = ?");
			$response = $request->execute(array($this->id_pic));
			$comments = $request->fetchAll(PDO::FETCH_ASSOC);
			return $comments;

		}catch(PDOException $e){
				die('Error: '.$e->getMessage());
		}
	}

	public function sendMailComment(){
		try{
			$request = $this->db->prepare("SELECT * FROM `images` WHERE `id_pic` = ?");
			$response = $request->execute(array($this->id_pic));
			$img = $request->fetch(PDO::FETCH_ASSOC);
			if ($img['login'] != $this->login){
				$request = $this->db->prepare("SELECT * FROM `users` WHERE `login` = ?");
				$response = $request->execute(array($img['login']));
				$user = $request->fetch(PDO::FETCH_ASSOC);
				require '../srcs/sendEmailFromCmt.php';
			}
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function deleteCmt(){
		try {
			$request = $this->db->prepare("DELETE FROM `comments` WHERE `id_pic` = ?");
			$request->execute(array($this->id_pic));

		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function addCmt(){
		try {
			date_default_timezone_set("Europe/Helsinki");
			$date_creation = date("Y-m-d H:i:s"); 
			$request = $this->db->prepare("INSERT INTO `comments` (`id_pic`, `comment`, `login`, `date_creation`) VALUES (?, ?, ? ,?)");
			$request->execute(array($this->id_pic, $this->comment, $this->login, $date_creation));
			self::sendMailComment();
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

}

?>