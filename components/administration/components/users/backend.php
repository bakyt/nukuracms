<?php
function users(){
	global $_LANG;
	unset($_LANG['NAME']);
	System::loadComponentLanguage('users');
	$db = DB::set();
	$sql = "SELECT * FROM `com_users`";
	$users = $db->query($sql);
	if($_GET['display']=='users' or !$_GET['display'] ){
		echo '<table width="100%" class="simple-little-table">
			<thead>
			<tr><th>id</th><th>'.$_LANG['NAME'].'</th><th>'.$_LANG['USERNAME'].'</th><th>'.$_LANG['EMAIL'].'</th><th>'.$_LANG['ACTIVATE'].'</th><th>'.$_LANG['REGDATE'].'</th><th>'.$_LANG['LASTVISIT'].'</th><th>'.$_LANG['GROUP'].'</th><th>'.$_LANG['JYNYSY'].'</th><th>'.$_LANG['BIRTHDATE'].'</th></tr>
			</thead>';
		while($user = $users->fetch_assoc()){
			echo '
				<tr><td>'.$user['id'].'</td><td><a href="/'.ADMIN_LINK.'/components/users/?display='.$user['id'].'">'.$user['name'].'</a></td><td>'.$user['login'].'</td><td>'.$user['email'].'</td><td>'.System::bool("YESNO", $user['activate']).'</td><td>'.System::siteDate($user['regdate'], 'year/month').'</td><td>'.System::siteDate($user['lastvisit'], 'year/month').'</td><td>'.User::group($user['group']).'</td><td>'.User::jynysy($user['jynysy']).'</td><td>'.System::siteDate($user['birthdate'], 'year/month').'</td></tr>
			';
		}
		echo '';
	}
}
?>