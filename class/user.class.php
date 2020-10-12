<?php



class Users {

	private $db;
	private $login;
	private $pwd;
	private $pwdVerif;
	private $email;
	private $token;
	public $msg;

	public function __construct($login, $pwd, $pwdVerif, $email, $token){
		try {
			require 'config/database.php';
			$this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->login=$login;
			$this->pwd=$pwd;
			$this->pwdVerif = $pwdVerif;
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

	private function checkPwd(){
		// if (strlen($this->pwd) < 8)
		// 	return $this->msg =  "Your password needs to have at least 8 characters!";
		if ($this->pwd != $this->pwdVerif)
			return $this->msg =  "The passwords are not the same!";
		if (!preg_match('/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,32}/', $this->pwd))
			return $this->msg = 'Your password has to be of length between 8 and 32, and have at least one digit, one upcase letter and one lowercase letter!';
	}

	private function checkRequire(){
		if (strlen($this->login) > 32)
			return $this->msg = 'Your login name cannot exceed 32 characters!';
		$existingUser = $this->getUser();
		if ($existingUser)
			return $this->msg = 'This login name already exist, please give a new one!';
		$this->checkPwd();
		if ($this->msg != null)
			return;
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
			return $this->msg = 'Your email is not a valid email address!';
	}

	public function verifyUser(){
		try{
			$user = $this->getUser();
			if (!$user)
				return $this->msg = "The login entered does not belong to any registered account!";
			if ($user['confirm'] == 0)
				return $this->msg = "This account has not yet been validated by email!";
			if ($user['password'  != hash('whirlpool', $this->pwd)])
				return $this->msg = "The password is incorrect, please try again!";
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function sendConfirmEmail(){
		$this->checkRequire();
		if ($this->msg)
			return;
		$token = bin2hex(random_bytes(16));
		$url = "localhost:3000/home.php?tken=" . $token;
		// print_r($url);
		date_default_timezone_set('Europe/Helsinki');
		$date_create = date("Y-m-d H:i:s");
		$date_expire = date("Y-m-d H:i:s", strtotime($date_create . ' + 3 days'));
		try{
			$request = $this->db->prepare("INSERT INTO `users` (`login`, `password`, `email`, `date_creation`, `token`, `token_expires`) VALUES (?, ?, ?, ?, ?, ?)");
			$request->execute(array($this->login, hash('whirlpool', $this->pwd), $this->email, $date_create, $token, $date_expire));
			$request = $this->db->prepare("DELETE FROM `users` WHERE `token_expires` < NOW() AND `confirm` = 0");
			$request->execute();
			require 'srcs/sendConfirmEmail.php';

		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}

	public function connectUser(){
		try{
			$request = $this->db->prepare("SELECT * FROM `users` WHERE `token` = ?");
			$response = $request->execute(array($this->token));
			$user = $request->fetch(PDO::FETCH_ASSOC);
			if (!$user)
				return $this->msg = "The token has already expired!";
			$request = $this->db->prepare("UPDATE `users` SET `confirm`=?, `token`=?, `token_expires`=? WHERE `token`=?");
			$request->execute(array(1, NULL, NULL, $this->token )); // HERE NEED SOME INVESTIGATION!
			$this->msg = "Your accound has been validated now," . $user['login']  . " . Please log in!";
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}


	public function sentResetEmail(){
		try{
			$user = $this->getUser();
			if (!$user)
				return $this->msg = "This login name does not exist!";
			$email = $user['email'];
			$token = bin2hex(random_bytes(16));
			$url = "localhost:3000/resetPwd2.php?tken=" . $token;
			date_default_timezone_set('Europe/Helsinki');
			$date_create = date("Y-m-d H:i:s");
			$date_expire = date("Y-m-d H:i:s", strtotime($date_create . ' + 3 days'));
			$request = $this->db->prepare("UPDATE `users` SET `token`=?, `token_expires`=? WHERE `login`=?");
			$request->execute(array($token, $date_expire, $this->login));
			$request = $this->db->prepare("UPDATE `users` SET `token`=?, `token_expires`=? WHERE `token_expires` < NOW() AND `confirm` = 1");
			$request->execute(array(NULL, NULL));
			require 'srcs/sendResetEmail.php';
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}
	
	public function resetPwd(){
		try{
			$request = $this->db->prepare("SELECT * FROM `users` WHERE `token` = ?");
			$response = $request->execute(array($this->token));
			$user = $request->fetch(PDO::FETCH_ASSOC);
			if (!user)
				return $this->msg = "The link has expired!";
			self::checkPwd();
			if ($this->msg != null)
				return ;
			$request = $this->db->prepare("UPDATE `users` SET `password` = ? WHERE `token` = ?");
			$request->execute(array(hash('whirlpool', $this->pwd), $this->token));
			$this->msg = "Your password has been changed!";
		}catch(PDOException $e){
			die('Error: '.$e->getMessage());
		}
	}
}

?>