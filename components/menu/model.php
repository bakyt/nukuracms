<?php
class com_menu{
	private $Menu;
	public function __construct(){
		$sql = "SELECT * FROM `com_menu` ORDER By `order`";
		$this->Menu = DB::set()->query($sql);
	}
	public function getAllItems(){
		return $this->Menu;
	}
	public function getMenu($cat){
		$i=0;
		$User = User::set();
		while($item = $this->Menu->fetch_assoc()){
			if($item['cat_id'] == $cat and $item['visibility'] == 1) {
				$item['link_exploded'] = explode('/', $item['link']);
				$item['link'] = '/'.trim($item['link'], '/');
				if ($item['value'] == 'ADMINISTRATION') $item['link'] = '/'.Configuration::set()->get('ADMIN_LINK');
				if ($item['value'] == 'USER_LOGIN'){ $item['value'] = $User->get('name');$item['link'] = '/users/'.$User->id;}
				if($item['link_exploded'][0] == 'content') {
					if ($item['link_exploded'][1] == Page::set()->getUrlPart(1)) $item['active'] = 'class="active"';
				}
				else if ($item['link_exploded'][0] == Page::set()->getUrlPart(0)) $item['active'] = 'class="active"';
				else $item['active']='';
				$menu[$i] = $item;
				$i++;
			}
			else {continue;}
		}
		return $menu;
	}
}
?>