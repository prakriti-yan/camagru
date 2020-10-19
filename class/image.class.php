<?php

class Images {

	private $db;
	private $id_pic;
	private $login;
	private $img;

	public function __construct($id_pic, $img, $login){
		try{
			require "../config/database.php";
			$this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->id_pic = $id_pic;
			$this->img = $img;
			$this->login = $login;

		}catch(PDOException $e){
				die('Error: '.$e->getMessage());
		}
	}

	public function getImgByLogin(){
		try{
			$request = $this->db->prepare("SELECT * FROM `images` WHERE `login` = ? ORDER BY `date_creation` DESC LIMIT 20");
			$response = $request->execute(array($this->login));
			$img = $request->fetchAll(PDO::FETCH_ASSOC);
			return $img;
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	
	

	public function addImg(){
		try{
			date_default_timezone_set('Europe/Helsinki');
			$date_creation = date('Y-m-d H:i:s');
			$request = $this->db->prepare("INSERT INTO `images` (`login`, `image`, `date_creation`) VALUES (?, ?, ?)");
			$request->execute(array($this->login, $this->img, $date_creation));
			$request = $this->db->query("SELECT `id_pic` FROM `images` WHERE `login` = '" . $this->login . "' AND `date_creation` = '" . $date_creation . "'");
			$id_pic = $request->fetch(PDO::FETCH_ASSOC);
			return $id_pic;
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}
	
	public function getImgByNB($start, $end){
		try{
			$request = $this->db->prepare("SELECT * FROM `images` ORDER BY `date_creation` DESC LIMIT" . $start . ", " . $end);
			$response = $request->execute();
			$imgs = $request->fetchAll(PDO::FETCH_ASSOC);
			return $imgs;
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function getImgByNBByLogin($start, $end){
		try{
			$request = $this->db->prepare("SELECT * FROM `images` WHERE `login`= ? ORDER BY `date_creation` DESC LIMIT " . $start . ", " . $end);
			$response = $request->execute(array($this->login));
			$imgs = $request->fetchAll(PDO::FETCH_ASSOC);
			return $imgs;
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function countNB(){
		try{
			$request = $this->db->query("SELECT count(*) FROM `images`");
			$nb = $request->fetch(PDO::FETCH_ASSOC);
			return $nb['count(*)'];
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function countNBByLogin(){
		try{
			$request = $this->db->query("SELECT count(*) FROM `images` WHERE `login` = '" . $this->login . "'");
			$nb = $request->fetch(PDO::FETCH_ASSOC);
			return $nb['count(*)'];
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function deleteImg(){
		try{
			print_r("we are here");
			$request = $this->db->prepare("DELETE FROM `images` WHERE `id_pic` = ? AND `login` = ?");
			$request->execute(array($this->id_pic, $this->login));
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}
}


?>