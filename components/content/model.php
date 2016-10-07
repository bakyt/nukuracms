<?php
class com_content{
	private $Content, $Cat;
	function __construct(){
		$sql = "SELECT * FROM `com_content_item`";
		$this->Content = DB::set()->query($sql);
		$sql = "SELECT * FROM `com_content_cat`";
		$this->Cat = DB::set()->query($sql);
		//print_r($items);
	}
	public function getAllItems(){
		return DB::itemParser($this->Content);
	}
	public function getItem($short){
		while($item = $this->Content->fetch_assoc()){
			if($short == $item['shortcut']){
				$item['link'] = self::getLink($item['cat_id']).'/'.$short;
				return $item;
			}
		}
		return false;
	}
	public function getCatInfoName($name){
		$sql = "SELECT * FROM `com_content_cat` WHERE `shortcut` = '$name'";
		$Cat = DB::set()->query($sql)->fetch_assoc();
		$Cat['link'] = self::getLink($Cat['id']);
		return $Cat;
	}
	public function getCatInfoId($id){
		$sql = "SELECT * FROM `com_content_cat` WHERE `id` = '$id'";
		$Cat = DB::set()->query($sql)->fetch_assoc();
		return $Cat;
	}
	public function getCatItems($name){
		$cats = self::getCatInfoName($name);
		$i=0;
		while($cat = $this->Cat->fetch_assoc()){
			if($cats['id'] != $cat['parent_id']) continue;
			else {
				$cat['link'] = self::getLink($cat['id']);
				$result[$i] = $cat;
			}
			$i++;
		}
		while($item = $this->Content->fetch_assoc()){
			if($cats['id'] != $item['cat_id']) continue;
			else {
				$item['link'] = self::getLink($item['cat_id'])."/".$item['shortcut'];
				$result[$i] = $item;
			}
			$i++;
		}
		return $result;
	}
	public function getLink($id){
		$link = '';
		while(true){
			if($id < 2) break;
			$cat = self::getCatInfoId($id);
			$link = '/'.$cat['shortcut'].$link;
			$id = $cat['parent_id'];
		}
		return trim($link, "/");
	}
}
?>