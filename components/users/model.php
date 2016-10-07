<?php
class com_users{
	private $Users;
	public function __construct(){
		$sql = "SELECT * FROM `com_users` WHERE `id`!=-1";
		$this->Users = DB::set()->query($sql);
	}
	public function getAllUsers(){
		$a = $this->Users;
		return DB::itemParser($a);
	}
	public function checkExisting($p1, $what){
		while($users = $this->Users->fetch_assoc()){
			if($p1 == $users[$what]) $result += 1;
		}
		return $result;
	}
	public function getUser($id){
		while($users = $this->Users->fetch_assoc()){
			if($id == $users['id']) {$users['password'] = ''; $result = $users;break;}
		}
		return $result;
	}
	public function registration($info){
		global $_LANG;
		$info['password'] = md5($info['password']);
		$query = DB::set()->insert('com_users', "('', '$info[login]', '$info[password]', '$info[name] $info[surname]', '4','$info[jynysy]', '1', '$_LANG[NEW_USERS_STATUS]', NOW(), '$info[email]', 0, 0, NOW(), '$randrestore', '$info[birthdate]')");
		$sql = "SELECT * FROM `com_users` WHERE `login` = '$info[login]'";
		$user = DB::set()->query($sql)->fetch_assoc();
		$_SESSION['REGISTRATION'] = array();
		return $user;
	}
	public function enter($post){
		while($user = $this->Users->fetch_assoc()){
			if($post['login'] == $user['login'] and md5($post['password']) == $user['password']) $result = $user;
		}
		return $result;
	}
	public function checkUser($login){
		$set = new self();
		while($users = $set->Users->fetch_assoc()){
			if($login == $users['login']) {$users['password'] = ''; $result = $users;break;}
		}
		return $result;
	}
}
?>