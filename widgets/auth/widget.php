<?php
	function wid_auth($config=''){
		global $_LANG;
		System::initTemplate('widget')->
		assign($_LANG, '_LANG')->
		assign($config, 'config')->
		display('wid_auth');
	}
?>