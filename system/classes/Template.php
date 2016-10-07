<?php
if (!defined('SYSTEM')) die('ACCESS DENIED');
class Template{
	private static $set=null;
	private $temp;
	private $assignfunction;
	private $info = array();
	public function __construct($temp){
		$this->temp = $temp;
	}
	public function assign($value, $name){
		$this->info[$name] = $value;
		return $this;
	}
	public function setHtmlTitle($title){
		$_SESSION['SYSTEM']['TITLE'] = $title;
	}
	public function setTitle($title){
		$this->componenttitle = $title;
		$_SESSION['SYSTEM']['TITLE'] = $title;
		return $this;
	}
	public function display($p1){
		if ($this->componenttitle) echo '<div class="title">'.$this->componenttitle.'</div>';
		foreach($this->info as $key=>$value){
			$$key = $value;
		}
		if($this->temp == "widget") {
			if (file_exists(HOST.'/templates/'.TEMPLATE.'/widgets/'.$p1.'.php')) include(HOST.'/templates/'.TEMPLATE.'/widgets/'.$p1.'.php');
			else echo 'Widget: '.$p1.' аталышындагы файл табылган жок!';
			
		}
		else if($this->temp == "component") {
			if (file_exists(HOST.'/templates/'.TEMPLATE.'/components/'.$p1.'.php')) include(HOST.'/templates/'.TEMPLATE.'/components/'.$p1.'.php');
			else echo 'Component: '.$p1.' аталышындагы файл табылган жок!';
			
		}
		else echo "initTemplate функциясында ката чыкты. Функция колдонулган жерди текшериңиз!";		
	}
	public static function getPositions(){
		$sql="SELECT `positions` FROM `templates` WHERE `folder`='".TEMPLATE."'";
		$positions = DB::set()->query($sql)->fetch_assoc();
		return explode("\n", $positions['positions']);
	}
}
?>