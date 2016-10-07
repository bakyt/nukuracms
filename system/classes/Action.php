<?php
if (!defined('SYSTEM')) die('ACCESS DENIED');

class Action{
	private static $set=null;
	public static function set($set=false){
		if(self::$set == null) self::$set = new self($set);
		return self::$set;
	}
	public function addAction(){}
	public function deleteAction(){}
}
?>