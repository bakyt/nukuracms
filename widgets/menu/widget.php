<?php
	function wid_menu($config=''){
		global $_LANG;
		$User = User::set();
		$Menu = System::loadComponent("menu");
		$list = $Menu->getMenu($config['type']);
		System::initTemplate('widget')->
		assign($_LANG, '_LANG')->
		assign($list, 'list')->
		assign($User, 'User')->
		assign($config, 'config')->
		display('wid_menu');
	}
?>