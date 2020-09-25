<? php

class Users{

	private $db;
	private $login;
	private $pwd;
	private $pwdVerif;
	private $email;
	private $token;
	public $msg;

	public function __construct($login, $pwd, $pwdVerif, $email, $token){
		try {
			require '../config/database.php';
			$this->db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->login=$login;
			$this->pwd=$pwd;
			$this->pwdVerify = $pwdVerif;
			$this->email = $email;
			$this->token = $token;
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}



	private function getUser(){
		try{
			$request = $this->db->prepare("SELECT * FROM `users` WHERE `login` = ?");
			$response = $request->execute(array($this->login));
			$user = $request->fetch(PDO::FETCH_ASSOC);
			return $user;
		}catch(PDOException $e){
			die('Error! Cannot find the user! '.$e->getMessage());
		}
	}

}

?>