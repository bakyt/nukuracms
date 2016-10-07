<?php
if (!defined('SYSTEM')) die('ACCESS DENIED');
class Page{
	private static $set=null;
	private $conf, $REQUEST_URI;
	public $componenttitle;
	private $page = array();
	public function __construct(){
		self::setUrlParts();
		self::checkPage();
	}
	public static function set($set=false){
		if(self::$set == null) self::$set = new self($set);
		return self::$set;
	}
	//Калыптагы (Шаблон) css файлдарын кошуу үчүн колдонулат
	//css Файлдарын templates/Шаблон/сss коюу керек
	//setCss(Файлдын аты гана жазылышы керек);
	public static function setCss($p1){
		global $_LANG;
		$Conf = Configuration::set();
		if (file_exists(HOST.'/templates/'.TEMPLATE.'/css/'.$p1.'.css')) $b = '<link href="/templates/'.TEMPLATE.'/css/'.$p1.'.css" rel="stylesheet" type="text/css">';
		else die($p1.'.css '.$_LANG['NAMED'].' '.$_LANG['FILE'].' '.$_LANG['NOT_FOUND']);
		echo $b;
	}
	//Калыптагы (Шаблон) javascript файлдарын кошуу үчүн колдонулат
	//javascript Файлдарын templates/Шаблон/js коюу керек
	//setJs(Файлдын аты гана жазылышы талап кылынат);
	public static function setJs($p1){
		global $_LANG;
		$Conf = Configuration::set();
		if (file_exists(HOST.'/templates/'.TEMPLATE.'/js/'.$p1.'.js')) $b = '<script src="/templates/'.TEMPLATE.'/js/'.$p1.'.js" type="text/javascript" ></script>';
		else die($p1.'.js '.$_LANG['NAMED'].' '.$_LANG['FILE'].' '.$_LANG['NOT_FOUND']);
		echo $b;
	}
	public static function getResource($p1){
		global $_LANG;
		$p1 = trim($p1);
		$Conf = Configuration::set();
		if (file_exists(HOST.'/system/resources/'.$p1)) return '/system/resources/'.$p1;
		else die("Көрсөтүлгөн ресурс табылган жок!");
	}
	//URL
	private function changeUrl($url){
		$this->page[0] = $url;
	}
	private function setUrlParts(){
			$URL_Path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			$URL_Path = System::urlCoder(System::checkForm($URL_Path));
			$URL_Parts = explode('/', trim($URL_Path, ' /'));
			$this->REQUEST_URI = $URL_Path;
			if($URL_Parts[0]=="index.php") {
				$link = substr($_SERVER['REQUEST_URI'], 10, strlen($_SERVER['REQUEST_URI']));
				System::redirect($link);
			}

			$this->page = $URL_Parts;
	}
	public function getFromLastUrlPart($index){
		$page = $this->page;
		$last = count($page);
		return $page[$last - $index];
	}
	public function getUrlPart($number){
		if($number !=(int)$number) die('getUrlPart($number) - Сан гана кабыл кылат!');
		return $this->page[$number];
	}
	public function getUrlParts(){
		return $this->page;
	}
	public function printPage(){
		$component = self::getUrlPart(0);
		$Conf = Configuration::set();
		if($Conf->get("ADMIN_LINK") == $component) $component = "administration";
		if ($component == '' and $Conf->get("INDEX") == '') return false;
		else if($component == '' and $Conf->get("INDEX")) $component = $Conf->get("INDEX");
		$sql = "SELECT `config` FROM `components` WHERE `link` = '$component'";
		$config = DB::set()->query($sql)->fetch_assoc();
		System::loadComponent($component);
		self::setFrontend($component);
		$component = 'com_'.$component;
		$component($config);
	}
	public function getRequestUri(){
		return trim($this->REQUEST_URI, "/");
	}
	private static function setFrontend($component){
		include(HOST.'/components/'.$component.'/frontend.php');
	}
	// Хакерлерден корголуу
	// Көрсөтүлгөн бетти (url) текшерет
	private function checkPage(){
		$component = self::getUrlPart(0);
		$Conf = Configuration::set();
		if($Conf->get("ADMIN_LINK") == $component) $component = "administration";
		$sql = "SELECT * FROM `components` WHERE `link` = '$component'";
		$DB = DB::set()->query($sql)->fetch_assoc();
		if (!$DB and self::getUrlPart(0) != '') {
			self::error404();
			exit();
		}
		
	}
	// 404, беттин жок экендигин көрсөтүү үчүн
	public function error404(){
		global $_LANG;
		if(ob_get_length()) { ob_end_clean(); }
		header("HTTP/1.0 404 Not Found");
		include(HOST.'/templates/'.TEMPLATE.'/pages/error404.php');
		exit();
	}
	public function forbiddenForGuests(){
		global $_LANG;
		if(ob_get_length()) { ob_end_clean(); }
		header("HTTP/1.0 404 Not Found");
		include(HOST.'/templates/'.TEMPLATE.'/pages/forbiddenForGuests.php');
		exit();
	}
	public function forbiddenForUsers(){
		global $_LANG;
		if(ob_get_length()) { ob_end_clean(); }
		header("HTTP/1.0 404 Not Found");
		include(HOST.'/templates/'.TEMPLATE.'/pages/forbiddenForUsers.php');
		exit();
	}
	public function checkLink($link){
		$link = explode(',', $link);
		for($i = 0; $i < count($link); $i++){
			if(trim($link[$i], "/") != trim($this->REQUEST_URI, "/") and $link[$i] != 'all') continue;
			else if(trim($link[$i], "/") == trim($this->REQUEST_URI, "/") or $link[$i] == 'all') return true;
			else continue;
		}
		return false;
	}
	public function getPositions(){
		$db = DB::set();
		$widgets = $db->query("SELECT * FROM `widgets` WHERE `visibility` !='0'  ORDER By `order`");
		while($widget = $widgets->fetch_assoc()){
			$widget['config'] = Configuration::set()->setWidgetConfig($widget['config']);
			if($widget['config']['access']){
				if($widget['config']['access']==1 and User::set()->id) continue;
				else if($widget['config']['access']==2 and !User::set()->id) continue;
			}
			$check = self::checkLink($widget['show_on_page']);
			if($check == false) continue;
		$position[$widget['position']] = 1;
		}
		return $position;
	}
	public function position($position){
		$db = DB::set();
		$widgets = $db->query("SELECT * FROM `widgets` WHERE `visibility` !='0'  ORDER By `order`");
		while($widget = $widgets->fetch_assoc()){
			$widget['config'] = Configuration::set()->setWidgetConfig($widget['config']);
			if($widget['config']['access']){
			if($widget['config']['access'] == 1 and User::set()->id) continue;
			else if($widget['config']['access'] == 2 and !User::set()->id) continue;
		}
			$check = self::checkLink($widget['show_on_page']);
			if($check == false) continue;
			if($position == $widget['position']) self::printWidget($widget);
		}
	}
	public function printWidget($widget){
		global $_LANG;
		echo '<div class="widget">';
		if($widget['external'] == 0) {
			if ($widget['config']['show_title']) echo '<div class ="title">'.$widget['title'].'</div>';
			System::set()->initTemplate('widget')->assign($widget, 'widget')->display('wid_templates/'.$widget['config']['template']);
		}
		else {
			$widg = 'wid_'.$widget['body'];
			if (!function_exists($widg)) include(HOST.'/widgets/'.$widget['body'].'/widget.php');
			if ($widget['config']['show_title']) echo '<div class="title">'.$widget['title'].'</div>';
			$widg($widget['config']);
		}
		echo '</div>';
	}
	public static function printTitle(){
		$title = $_SESSION['SYSTEM']['TITLE'];
		$_SESSION['SYSTEM']['TITLE'] = array();
		if ($title) return ' - '.$title;
		else return false;
	}
}
?>