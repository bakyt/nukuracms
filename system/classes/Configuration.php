<?php
if (!defined('SYSTEM')) die('ACCESS DENIED');

class Configuration{
	private static $set=null;
	private $conf;
	public function __construct(){
		self::loadSystemConfigurations();
	}
	public static function set($set=false){
		if(self::$set == null) self::$set = new self($set);
		return self::$set;
	}
	private function loadSystemConfigurations(){
		$this->conf = System::parse('/system/configurations/sys_configs.conf');;
	}
	//Конфигурация файлындагы орнотууларды алып берет
	public function get($setting){
		return $this->conf[$setting];
	}
	public static function setComponentConfig($componentconf){
		$componentconf = explode(';', $componentconf);
		for ($i = 0; $i < count($componentconf)-1; $i++){
			$componentconf[$i] = explode(':', $componentconf[$i]);
			$c0 = trim($componentconf[$i][0]);
			$c1 = trim($componentconf[$i][1]);
			$component[$c0] = $c1;
		}
		return $component;
	}
	public static function setWidgetConfig($widgetconf){
		$widgetconf = explode(';', $widgetconf);
		for ($i = 0; $i < count($widgetconf)-1; $i++){
			$widgetconf[$i] = explode(':', $widgetconf[$i]);
			$c0 = trim($widgetconf[$i][0]);
			$c1 = trim($widgetconf[$i][1]);
			$widget[$c0] = $c1;
			if ($widget['name_'.TIL]) $widget['name'] = $widget['name_'.TIL];
		}
		return $widget;
	}
	public static function configCreatMini($STG){
		foreach($STG as $key=>$value) if(!$STG[$key]) $STG[$key] = 'null';
		$STG['DB_HOST'] = Configuration::set()->get('DB_HOST');
		$STG['DB_NAME'] = Configuration::set()->get('DB_NAME');
		$STG['DB_USER'] = Configuration::set()->get('DB_USER');
		$STG['DB_PASS'] = Configuration::set()->get('DB_PASS');
		$CONFIG = HOST.'/system/configurations/sys_configs.conf';
		$data = "
	DB_HOST: $STG[DB_HOST]
	DB_NAME: $STG[DB_NAME]
	DB_USER: $STG[DB_USER]
	DB_PASS: $STG[DB_PASS]
	SITE_NAME: $STG[sitename]
	ADMIN_LINK: $STG[admin_link]
	INDEX: $STG[index]
	LANGUAGE: $STG[til]
	EMAIL: $STG[email]
	NOREPLYMAIL: $STG[noreplymail]
	SITEON: $STG[siteon]
	CAN_CHANGE_LANG: $STG[can_change_lang]
	WATERMARK: bagyt.png
	TEMPLATE: default
	PATH_HOME: 1
	TITLE_HOMEPAGE: 1
	TITLE_WITH_SITENAME: $STG[title_with_sitename]
	DESCRIPTION: $STG[description]
	KEYWORDS: $STG[keywords]
	";
		if($STG['admin_link'] == 'null'){
			$result['link'] = "";
			$result['notice'] = "Админ шилтемеси бош боло албайт!";
			$result['type'] = "3";
		}
        else {
			$hd = fopen($CONFIG, "w");
			$e = fwrite($hd, $data);
			if ($e == -1) {
				$result['link'] = "";
				$result['notice'] = "Сактоодо ката чыкты!";
				$result['type'] = "3";
			} else {
				if (Configuration::set()->get('ADMIN_LINK') == $STG['admin_link']) {
					$result['link'] = "";
					$result['notice'] = "Өзгөртүү ийгиликтүү аяктады";
					$result['type'] = "1";
				} else {
					$result['link'] = "/" . $STG['admin_link'] . "/" . Page::set()->getUrlPart(1);
					$result['notice'] = "Өзгөртүү ийгиликтүү аяктады";
					$result['type'] = "1";
				}
			}
		}
		return $result;
	}
	public function changeConfig($key, $value){
		$data = "";
		$config = $this->conf;
		$config[$key] = $value;
		foreach($config as $item=>$val) {
			if(!$config[$key]) $config[$key] = 'null';
			$data .= $item.": ".$val."\n";
		}
		$path = HOST.'/system/configurations/sys_configs.conf';
		if($config['ADMIN_LINK'] == 'null'){
			$result['link'] = "";
			$result['notice'] = "Админ шилтемеси бош боло албайт!";
			$result['type'] = "3";
		}
        else {
			$hd = fopen($path, "w");
			$e = fwrite($hd, $data);
			if ($e == -1) {
				$result['link'] = "";
				$result['notice'] = "Сактоодо ката чыкты!";
				$result['type'] = "3";
			} else {
				if (Configuration::set()->get('ADMIN_LINK') == $config['ADMIN_LINK']) {
					$result['link'] = "";
					$result['notice'] = "Өзгөртүү ийгиликтүү аяктады";
					$result['type'] = "1";
				} else {
					$result['link'] = "/" . $config['ADMIN_LINK'] . "/" . Page::set()->getUrlPart(1);
					$result['notice'] = "Өзгөртүү ийгиликтүү аяктады";
					$result['type'] = "1";
				}
			}
		}
		return $result;
	}
}
?>