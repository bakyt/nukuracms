<?php
function com_users($config=''){
	global $_LANG;
	System::loadComponentLanguage('users');
	$Users = new com_users();
	$logUser = User::set();
	$System = System::set();
	if(Page::set()->getUrlPart(1) == ''){
		$System->initTemplate('component')->
		setTitle($_LANG['USERS'])->
		assign($Users->getAllUsers(), "users")->
		assign($_LANG, "_LANG")->
		display('com_users');
	}
	//Каттоо
	else if(Page::set()->getUrlPart(1) == 'registration' and !$logUser->id){
		$System->initTemplate('component')->
		setTitle($_LANG['REGISTRATION'])->
		assign($_LANG, "_LANG")->
		display('com_users_registration');
	}
	//Кирүү
	else if(Page::set()->getUrlPart(1) == 'login' and !$logUser->id){
		$System->initTemplate('component')->
		setTitle($_LANG['LOGIN'])->
		assign($_LANG, "_LANG")->
		display('com_users_login');
	}
	//Чыгуу
	else if(Page::set()->getUrlPart(1) == 'logout' and $logUser->id or Page::set()->getUrlPart(1) == 'do' and Page::set()->getUrlPart(2) == 'logout' and $logUser->id){
		if ($_COOKIE['resu']){
			setcookie('resu', '', strtotime('-30 days'), '/');
			unset($_COOKIE['resu']);
		}
		$_SESSION['USER'] = array();
		System::sendNotice(1, $_LANG['SEE_YOU'], '/users/login');
	}
	//Профиль
	else if(Page::set()->getUrlPart(1) == (int)Page::set()->getUrlPart(1) and !Page::set()->getUrlPart(2)){
		$user = $Users->getUser(Page::set()->getUrlPart(1));
		if(!$user) Page::error404();
		$System->initTemplate('component')->
		setTitle($user['name'])->
		assign($_LANG, "_LANG")->
		assign($user, "user")->
		assign($logUser, "logUser")->
		display('com_users_profile');
	}
	/*-------------------------------------------- Аткарылуучу жумуштар ------------------------------------------------*/
	else if(Page::set()->getUrlPart(1) == 'do'){
		//Каттоо
		if(Page::set()->getUrlPart(2) == 'registration' and isset($_POST['registration'])) {
			$_POST['name'] = System::checkForm(htmlspecialchars($_POST['name']));
			$_POST['surname'] = System::checkForm(htmlspecialchars($_POST['surname']));
			$_POST['login'] = System::checkForm(htmlspecialchars($_POST['login']));
			$_POST['email'] = System::checkForm(htmlspecialchars($_POST['email']));
			$_SESSION['REGISTRATION'] = $_POST;
			if(!$_POST['name']) $notice .= $_LANG['WRITE_YOUR_NAME'].'<br />';
			if(!$_POST['email']) $notice .= $_LANG['WRITE_YOUR_EMAIL'].'<br />';
			if(!$_POST['login']) $notice .= $_LANG['WRITE_A_LOGIN'].'<br />';
			else if($Users->checkExisting($_POST['login'], "login")) $notice .= $_LANG['ALREADY_USED_LOGIN'].'<br />';
			if(!$_POST['password']) $notice .= $_LANG['WRITE_A_PASSWORD'].'<br />';
			else if(strlen($_POST['password']) < 6) $notice .= $_LANG['PASSWORD_CANT_BE_LESS_THAN_SIX'].'<br />';
			if($_POST['password'] != $_POST['repassword']) $notice .= $_LANG['PASS_NOT_MATCH'].'<br />';
			if(md5($_POST['captcha']) != $_SESSION['captcha']) $notice .= $_LANG['WRONG_CODE'].'<br />';
			if($notice) System::sendNotice(3, $notice);
			else {
				$reg = $Users->registration($_POST);
				if(!$reg) System::sendNotice(2, $_LANG['REGISTRATION_PROBLEMS']);
				else {
					$_SESSION['USER']['id'] = $reg['id'];
					System::sendNotice(3, $_LANG['REGISTRATION_SUCCESS'], '/users/'.$reg['id']);
				}
			}
		}
		//Кирүү
		else if(Page::set()->getUrlPart(2) == 'login' and isset($_POST['enter'])) {
			$_POST['login'] = System::checkForm(htmlspecialchars($_POST['login']));
			//if(md5($_POST['captcha']) != $_SESSION['captcha']) $notice .= $_LANG['WRONG_CODE'].'<br />';
			if(!$_POST['login']) $notice .= $_LANG['WRONG_PASS_OR_LOGIN'].'<br />';
			else {$log = $Users->enter($_POST);
					if(!$log) System::sendNotice(2, $_LANG['WRONG_PASS_OR_LOGIN']);
					else {
						$ie = substr($log['restore'], 0, 5);
						$cook = substr($log['restore'], 5, 16);
						if ($_POST['remind']) setcookie('resu', $cook.$ie.$log['id'], strtotime('+30 days'), '/');
						$_SESSION['USER']['id'] = $log['id'];
						$_SESSION['USER']['pass'] = md5($_POST['password']);
						if (!$_POST['EnterAdmin']) System::redirect('/users/'.$log['id']);
						else System::redirect($_SERVER['HTTP_REFERRER']);
					}
				}
			if($notice) System::sendNotice(3, $notice);
		}
		else Page::error404();
	}
	else Page::error404();
}
?>