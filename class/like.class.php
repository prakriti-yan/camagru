<?php

class Likes {

	private $db;
	private $id_pic;
	private $login;

	public function __construct($id_pic, $login){
		try {
			require "../config/database.php";
			$this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->id_pic = $id_pic;
			$this->login = $login;

		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function getLike(){
		try {
			$request = $this->db->prepare("SELECT * FROM `likes` WHERE `login` = ? AND `id_pic` = ?");
			$request->execute(array($this->login, $this->id_pic));
			return $request->fetch(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function addLike(){
		try {
			date_default_timezone_set("Europe/Helsinki");
			$date_creation = date("Y-m-d H:i:s");
			$request = $this->db->prepare("INSERT INTO `likes` (`id_pic`, `login`, `date_creation`) VALUES (?,?,?)");
			$request->execute(array($this->id_pic, $this->login, $date_creation));
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function getNB(){
		try {
			$request = $this->db->prepare("SELECT count(*) FROM `likes` WHERE `id_pic` = ?");
			$response = $request->execute(array($this->id_pic));
			$like = $request->fetch(PDO::FETCH_ASSOC);
			return $like['count(*)'];
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function deleteLike(){
		try {
			$request = $this->db->prepare("DELETE FROM `likes` WHERE `id_pic` = ? AND `login` = ?");
			$request->execute(array($this->id_pic, $this->login));
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function deleteLikes(){
		try {
			$request = $this->db->prepare("DELETE FROM `likes` WHERE `id_pic` = ? ");
			$request->execute(array($this->id_pic));
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}
}

?>