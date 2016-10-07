<?php
if (!defined('SYSTEM')) die('ACCESS DENIED');
class User{
	private static $set=null;
	public $id;
	private $User;
	public function __construct(){
		self::load();
	}
	public static function set($set=false){
		if(self::$set == null) self::$set = new self($set);
		return self::$set;
	}
	public function getUserInfo(){
		return $this->User;
	}
	public function get($p1){
		return $this->User[$p1];
	}
	private function load(){
		if($_COOKIE['resu'] and !$_SESSION['USER']['id'] and !$_SESSION['USER']['pass']) self::remindMe();
		if($_SESSION['USER']['id'] and $_SESSION['USER']['pass']) {
			$id = $_SESSION['USER']['id'];
			$pass = $_SESSION['USER']['pass'];
			$sql = "SELECT * FROM `com_users` WHERE `id`='$id' AND `password` = '$pass'";
			$result = DB::set()->query($sql)->fetch_assoc();
			$this->User = $result;
			$this->id = $this->User['id'];
		}
		else return false;
	}
	public static function getAuthor($id){
			$sql = "SELECT `id`, `name`, `login` FROM `com_users` WHERE `id`='$id'";
			$result = DB::set()->query($sql)->fetch_assoc();
			return $result;
	}
	public static function jynysy($p1){
		global $_LANG;
		System::loadComponentLanguage("users");
			if ($p1 == 0) return $_LANG['UNKNOWN'];
			else if($p1 == 1) return $_LANG['MALE'];
			else if($p1 == 2) return $_LANG['FEMALE'];
			else return $p1;
	}
	public static function group($id){
		global $_LANG;
		System::loadComponentLanguage("users");
		$sql = "SELECT * FROM `com_users_groups` WHERE `id`='$id'";
		$result = DB::set()->query($sql)->fetch_assoc();
		if($_LANG[$result['name']]) return $_LANG[$result['name']];
		else return $result['name'];
	}
	private static function remindMe(){
		$cook = $_COOKIE['resu'];
		$cookie = substr($cook, 0, 16);
		$kie = substr($cookie, 0, 11);
		$coo = substr($cookie, 11, 16);
		for($i=16; $i<strlen($cook);$i++){
			$result .= $cook[$i];
		}
		$sql = "SELECT `id`, `password` FROM `com_users` WHERE `id`!='-1' AND `id` = '$result' AND `restore` = '$coo$kie'";
		$User = DB::set()->query($sql)->fetch_assoc();
		if(!$User['id']) unset($_COOKIE['resu']);
		$_SESSION['USER']['id'] = $User['id'];
		$_SESSION['USER']['pass'] = $User['password'];
	}
}
?>