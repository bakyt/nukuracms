<?php
if (!defined('SYSTEM')) die('ACCESS DENIED');
class System{
	const CMS = "BAGYTCMS";
	const VERSION = "1.0";
	private static $set=null;
	private $temp;
	function __construct(){
		//Класстарды кошобуз
		self::setClasses();
		//Константаларды ыйгаруу
		$Conf = Configuration::set();
		define('TEMPLATE', $Conf->get('TEMPLATE'));
		define('SITENAME', $Conf->get('SITE_NAME'));
		define('ADMIN_LINK', $Conf->get('ADMIN_LINK'));
		define('LANGUAGE', $Conf->get('LANGUAGE'));
		//Сайттын тилин иштетүү
		self::loadSystemLanguages();
	}
	public static function translate($p1, $select='', $component=''){
		global $_LANG;
		if ($component) $_LANG += self::parse('/system/languages/'.LANGUAGE.'/components/'.$component.'.lang');
		if ($select!="false"){
			$a = scandir(HOST.'/system/languages/'.LANGUAGE.'/translate/');
			if ($select) $_LANG += self::parse('/system/languages/'.LANGUAGE.'/translate/'.$select.'.lang');
			else for ($i=2; $i < count($a); $i++){
				$_LANG += self::parse('/system/languages/'.LANGUAGE.'/translate/'.$a[$i]);
			}
		}
		$p1=strtr($p1, $_LANG);
		return $p1;
	}
	public static function set($set=false){
		if(self::$set == null) self::$set = new self($set);
		return self::$set;
	}
	public static function parse($link, $char=":", $isFile=true){
		if ($isFile) {
			$link = trim($link, '/');
			$file = file_get_contents(HOST . '/' . $link);
		}
		else $file=$link;
			$conf = explode("\n", $file);
			for ($i = 0; $i < count($conf); $i++){
				if(trim($conf[$i]) == '' or !trim($conf[$i])) continue;
				$conf[$i] = explode($char, $conf[$i]);
				$c0 = trim($conf[$i][0]);
				$c1 = trim($conf[$i][1]);
				if(trim($c0) == '') continue;
				if($c1 == 'null') $c1 = null;
				$result[$c0] = $c1;
			}
		return $result;
	}
	//Калыпты (Шаблон) кошуу
	public static function printTemplate(){
		global $_LANG;
		ob_start();
		$Conf = Configuration::set();
		if($Conf->get("ADMIN_LINK") == Page::set()->getUrlPart(0)) include(HOST.'/components/administration/administration.php');
		else include(HOST.'/templates/'.TEMPLATE.'/temp_index.php');
	}
	//Билдирүү жөнөтүү
	public static function sendNotice($type, $message, $redirect=''){
		$_SESSION['SYSTEM']['NOTICE']['MESSAGE'] = $message;
		if ($type == 3) $_SESSION['SYSTEM']['NOTICE']['TYPE'] = "wrong";
		else if ($type == 2) $_SESSION['SYSTEM']['NOTICE']['TYPE'] = "warning";
		else $_SESSION['SYSTEM']['NOTICE']['TYPE'] = "true";
		self::redirect($redirect);
	}
	//Билдирүүлөрдү чыгаруу
	public static function printNotices(){
		$notice = $_SESSION['SYSTEM']['NOTICE'];
		$_SESSION['SYSTEM']['NOTICE'] = array();
		return $notice;
	}
	public static function warning($info){
		echo $info;
	}
	//Башка бетке кайтаруу
	public static function redirect($link=''){
		if($link != '/' and $link != '') $_SERVER['HTTP_REFERER'] = trim($link);
		else if($link != '') $_SERVER['HTTP_REFERER'] = $link;
		$i = $_SERVER['HTTP_REFERER'];
		$l = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		if ($l == $i or !$i) $_SERVER['HTTP_REFERER'] = '/';
		exit(header('Location: '.$_SERVER['HTTP_REFERER']));  
	}
	// classes папкасындагы класстар кошуу үчүн колддонулат
	private static function setClasses(){
		$a = scandir(HOST.'/system/classes/');
		for ($i=2; $i < count($a); $i++){
			$exp = explode(".",$a[$i]);
			if(!class_exists($exp[0])) include(HOST.'/system/classes/'.$a[$i]);
		}
	}
	//Системанын тилин иштетүү үчүн
	private static function loadSystemLanguages(){
		global $_LANG;
		$_LANG = self::parse('/system/languages/'.LANGUAGE.'/lang.lang');
	}
	//Виджеттин тилин иштетүү үчүн
	public static function loadWidgetLanguage($widget){
		global $_LANG;
		$_LANG += self::parse('/system/languages/'.LANGUAGE.'/widgets/'.$widget.'.lang');
	}
	//Компоненттин тилин иштетүү үчүн
	public static function loadComponentLanguage($component){
		global $_LANG;
		$_LANG += self::parse('/system/languages/'.LANGUAGE.'/components/'.$component.'.lang');
	}
	//форма текшерүүүсү
	public static function checkForm($p1){
		$result="";
		for($i=0; $i<strlen($p1); $i++){
			if($p1[$i - 1] == '/' and $p1[$i] == '/') continue;
			if($p1[$i] == "'") {$result .= "''"; continue;}
			$result .= $p1[$i];
		}
		return $result;
	}
	public function initTemplate($type){
		$Template = new Template($type);
		return $Template;
	}
	public function RandomString($p1){
		$Char = '0123456789abcdefghijklmnopqrstuvwxyz';
		for ($i = 0; $i < $p1; $i++) $String .= $Char[rand(0, strlen($Char) - 1)];
		return $String;
	}
	public static function loadComponent($name, $construct=''){
		if (!class_exists("com_$name")) include(HOST.'/components/'.$name.'/model.php');
		$comp = "com_$name";
		$component = new $comp();
		return $component;
	}
	public static function getDirList($dir, $p1=''){
		$a = scandir(HOST.$dir);
		if($p1 == 'option') {
			$p2 = '</'.$p1.'>';
			$p1 = '<'.$p1.'>';
		}
		for($i = 2; $i<count($a); $i++){
			$lang .= $p1.$a[$i].$p2;
		}
		return $lang;
	}
	public static function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
	}
	public static function trim_to_dot($string) {
		$pos = strrpos($string, '.');
		if ($pos) return substr($string, $pos, strlen($string));
		else return false;
	}
	public static function siteDate($p1, $p2=''){
	global $_LANG;
		$year = substr($p1, 0, 4);
		$month = substr($p1, 5, 2);
		$month_num = substr($p1, 5, 2);
		$day = substr($p1, 8, 2);
		if ($day < 10) $day = substr($p1, 9, 1);
		$hour = substr($p1, 11, 2);
		$minute = substr($p1, 14, 2);
		$seconds = substr($p1, 17, 2);
		if ($hour < 19)  $hour += 6;
		else {
			$hour = (24 - $hour)-1;
			$day += 1;
		}
		if ($month == '01') $month = $_LANG['JANUARY'];
		if ($month == '02') $month = $_LANG['FEBRUARY'];
		if ($month == '03') $month = $_LANG['MARCH'];
		if ($month == '04') $month = $_LANG['APRIL'];
		if ($month == '05') $month = $_LANG['MAY'];
		if ($month == '06') $month = $_LANG['JUNE'];
		if ($month == '07') $month = $_LANG['JULY'];
		if ($month == '08') $month = $_LANG['AUGUST'];
		if ($month == '09') $month = $_LANG['SEPTEMBER'];
		if ($month == '10') $month = $_LANG['OCTOBER'];
		if ($month == '11') $month = $_LANG['NOVEMBER'];
		if ($month == '12') $month = $_LANG['DECEBER'];
		if ($p2 == 'seconds') {
			$seconds = (($minute * 60)+($hour * 60 * 60)+ $seconds);
			return $seconds;
			}
		else if ($p1 and $p2 == 'hour/minute') return $hour.':'.$minute;
		else if ($p1 and $p2 == 'ymd') return $year.$month_num.$day;
		else if ($p1 and $p2 == 'month/day/year') return $day.'-'.$month.' '.$year;
		else if ($p1 and $p2 == 'minute') return $minute;
		else if ($p1 and $p2 == 'hour') return $hour;
		else if ($p1 and $p2 == 'day') return $day;
		else if ($p1 and $p2 == 'month') return $month;
		else if ($p1 and $p2 == 'year') return $year.'-'.$_LANG['YEAR'];
		else if ($p1 and $p2 == 'year/month') return $year.'-'.$_LANG['YEAR'].' '.$day.'-'.$month;
		else if ($p1 and $p2 == 'year/month/time') return $year.'-'.$_LANG['YEAR'].' '.$day.'-'.$month.' '.$hour.':'.$minute;
		else return $year.'-'.$_LANG['YEAR'].' '.$day.'-'.$month.' '.$hour.':'.$minute.':'.$seconds;
	}
	public static function urlCoder($url){
		return mb_convert_encoding(urldecode($url), "utf-8", "auto");
	}
	public static function bool($p1,$p2){
		global $_LANG;
		if($p1=="YESNO") {
			if ($p2 == 0) return $_LANG['NO'];
			else return	$_LANG['YES'];
		}
		else if($p1=="HASNO") {
			if ($p2 == 0) return $_LANG['NO'];
			else return	$_LANG['HAS'];
		}
		else return $p2;
	}
}
?>