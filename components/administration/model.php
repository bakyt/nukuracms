<?php
class com_administration{
	private $Users;
	public $pathway = array();
	public function __construct(){
		$sql = "SELECT * FROM `com_users` WHERE `id`!=0";
		$this->Users = DB::set()->query($sql);
	}
	public function getAllUsers(){
		return $this->Users;
	}
	public function checkExisting($p1, $what){
		while($users = $this->Users->fetch_assoc()){
			if($p1 == $users[$what]) $result += 1;
		}
		return $result;
	}
	public function getUser($id){
		while($users = $this->Users->fetch_assoc()){
			if($id == $users['id']) {$users['password'] = ''; $result = $users;break;}
		}
		return $result;
	}
	public function registration($info){
		global $_LANG;
		$info['password'] = md5($info['password']);
		$query = DB::set()->insert('com_users', "('', '$info[login]', '$info[password]', '$info[name] $info[surname]', '4','$info[jynysy]', '1', '$_LANG[NEW_USERS_STATUS]', NOW(), '$info[email]', 0, 0, NOW(), '$randrestore', '$info[birthdate]')");
		$sql = "SELECT * FROM `com_users` WHERE `login` = '$info[login]'";
		$user = DB::set()->query($sql)->fetch_assoc();
		$_SESSION['REGISTRATION'] = array();
		return $user;
	}
	public function enter($post){
		while($user = $this->Users->fetch_assoc()){
			if($post['login'] == $user['login'] and md5($post['password']) == $user['password']) $result = $user;
		}
		return $result;
	}
	public function checkUser($login){
		$set = new self();
		while($users = $set->Users->fetch_assoc()){
			if($login == $users['login']) {$users['password'] = ''; $result = $users;break;}
		}
		return $result;
	}
	public function printEnterPage(){
		global $_LANG;
		include(HOST.'/components/administration/login.php');
	}
	public function printBody(){
		global $_LANG;
		$Page=Page::set();
		if(!$Page->getUrlPart(1)) echo "";
		else if($Page->getUrlPart(1) == "components"){
			if(!$Page->getUrlPart(2)) self::printComponents();
			else if ($Page->getUrlPart(2) and self::component_exists($Page->getUrlPart(2))){
				if(file_exists(HOST."/components/administration/components/".$Page->getUrlPart(2)."/backend.php")) {
					include(HOST."/components/administration/components/".$Page->getUrlPart(2)."/backend.php");
					$func = $Page->getUrlPart(2);
					$func();
				}
				else echo "Бул компоненттин орнотуулары жок.";
			}
			else $Page->error404();
		}
		else if($Page->getUrlPart(1) == "widgets"){
			if(!$Page->getUrlPart(2)) self::printWidgets();
			else if ($Page->getUrlPart(2) and self::widget_exists($Page->getUrlPart(2))){
				$widget = self::getWidgetInfo($Page->getUrlPart(2));
				if($_GET['display'] == "edit" or !$_GET['display']) $ed = "class=active";
				if($_GET['display'] == "config") $co = "class=active";
				echo '
					<form action="#" method="post">
					<section class="connectedSortable col-lg-8 row">
					<div class="nav-tabs-custom">
					<ul class="nav nav-tabs pull-right">
						<li '.$ed.'><a href="?display=edit">'.$_LANG['EDIT'].'</a></li>
						<li '.$co.'><a href="?display=config">'.$_LANG['SETTINGS'].'</a></li>
						<li class="pull-left header">'.$widget['name'].' v'.$widget['version'].'</li>
					</ul>
					<div class="box-body">
					';
				if($_GET['display'] == 'edit' or !$_GET['display']) echo '
						<div class="">
							<input style="font-size:24px;width:100%;" type="text" name="name" value="'.$widget['title'].'"/>
						</div>
						<div class=""></div>
						<div class=""></div>
				';
				else if($_GET['display'] == 'config') {
					$config = Configuration::setWidgetConfig($widget['config']);
					echo '
						<table class="table no-margin" style="width:100%;display:inline-block;">
							<tbody>
							<tr>
								<td>Title көрсөтүлсүнбү?</td>
								<td><select style="width:100%;" type="text" name="show_title"><option>'.$_LANG['YES'].'</option><option>'.$_LANG['NO'].'</option></select></td>
							</tr>
							<tr>
								<td>Мүмкүнчүлүк</td>
								<td><select style="width:100%;" type="text" name="for_user"><option>'.$_LANG['TO_ALL'].'</option><option>'.$_LANG['TO_GUESTS'].'</option><option>'.$_LANG['TO_USERS'].'</option></select></td>
							</tr>
							</tbody>
						</table>
					';
				}
				echo '
					</div></div>
					</section>
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="box box-widget widget-user-2"><h1>Sidebar</h1></div>
					</div>
					<div class="col-lg-12 col-xs-12 col-md-12 col-sm-12 row" style="margin-top:5px;"><input class="btn btn-default" type="submit" name="save_widget" value="'.$_LANG['SAVE'].'">
					<a href="/'.$Page->getUrlPart(0).'/widgets" class="btn btn-default">'.$_LANG['CANCEL'].'</a>
					</div>
					</form>
				';
				if(file_exists(HOST."/components/administration/widgets/".$Page->getUrlPart(2)."/config.php")) {
					include(HOST."/components/administration/widgets/".$Page->getUrlPart(2)."/config.php");
					$func = $Page->getUrlPart(2);
					$func();
				}
			}
			else $Page->error404();
		}
		else if($Page->getUrlPart(1) == "settings" and !$Page->getUrlPart(2)){
			self::printSettings();
		}
		else $Page->error404();
	}
	public static function widget_exists($id){
		$result = DB::set()->query("SELECT `id` FROM `widgets` WHERE `id`='$id'")->fetch_assoc();
		return $result['id'];
	}
	public static function component_exists($link){
		$result = DB::set()->query("SELECT `id` FROM `components` WHERE `link`='$link'")->fetch_assoc();
		return $result['id'];
	}
	public function printPathway(){
		global $_LANG;
		$Page = Page::set();
		$Page->getUrlParts();
	}
	public function printComponents(){
		global $_LANG;
		echo '
		<div class="box box-info">
		<div class="box-header with-border">
              <h3 class="box-title pull-left">'.$_LANG['COMPONENTS'].'</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">Жүктөө
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove">Жардам</button>
              </div>
            </div>
		<div class="box-body"><div class="table-responsive"><table width="100%" class="table no-margin" ><thead>
		<tr>
		<th class="id">'.$_LANG['ID'].'</th>
		<th class="name">'.$_LANG['NAME'].'</th>
		<th class="version">'.$_LANG['VERSION'].'</th>
		<th class="author">'.$_LANG['AUTHOR'].'</th>
		<th class="turned_on">'.$_LANG['TURNED_ON'].'</th>
		<th class="link">'.$_LANG['LINK'].'</th>
		</tr>
		</thead>
		<tbody>
		';
		$COMPONENTS = DB::set()->query("SELECT * FROM `components`");
		while ($COMPONENTTER = $COMPONENTS->fetch_assoc()){ echo '
		<tr>
		<td class="list">'.$COMPONENTTER['id'].'</td>
		<td class="list"><a href="/'.Page::set()->getUrlPart(0).'/components/'.$COMPONENTTER['link'].'">'.$COMPONENTTER['name'].'</a></td>
		<td class="list">'.$COMPONENTTER['version'].'</td>
		<td class="list">'.$COMPONENTTER['author'].'</td>
		<td class="list">'.System::bool("YESNO", $COMPONENTTER['turned_on']).'</td>
		<td class="list">'.$COMPONENTTER['link'].'</td>
		</tr>';
		}
		echo '</tbody></table></div></div></div>';
	}
	public function printWidgets(){
		global $_LANG;
		echo '
		<div class="box box-info">
		<div class="box-header with-border">
              <h3 class="box-title pull-left">'.$_LANG['WIDGETS'].'</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">Жүктөө
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove">Жардам</button>
              </div>
            </div>
		<div class="box-body">
		<table width="100%" class="table no-margin" ><thead>
		<tr>
		<th class="id">'.$_LANG['ID'].'</th>
		<th class="name">'.$_LANG['NAME'].'</th>
		<th class="version">'.$_LANG['VERSION'].'</th>
		<th class="version">'.$_LANG['DESCRIPTION'].'</th>
		<th class="author">'.$_LANG['AUTHOR'].'</th>
		<th class="turned_on">'.$_LANG['TURNED_ON'].'</th>
		<th class="link">'.$_LANG['POSITION'].'</th>
		</tr>
		</thead>
		<tbody>
		';
		$WIDGETS = DB::set()->query("SELECT * FROM `widgets`");
		while ($WIDGETTER = mysqli_fetch_assoc($WIDGETS)){ 
		echo '
		<tr>
		<td class="list">'.$WIDGETTER['id'].'</td>
		<td class="list"><a href="/'.Page::set()->getUrlPart(0).'/widgets/'.$WIDGETTER['id'].'">'.$WIDGETTER['name'].'</a></td>
		<td class="list">'.$WIDGETTER['version'].'</td>
		<td class="list">'.$WIDGETTER['description'].'</td>
		<td class="list">'.$WIDGETTER['author'].'</td>
		<td class="list">'.System::bool("YESNO", $WIDGETTER['turned_on']).'</td>
		<td class="list">'.$WIDGETTER['position'].'</td>
		</tr>
		';
		}
		echo '</tbody></table></div></div></div>';
	}
	public static function getWidgetInfo($id){
		$db = DB::set();
		$result = $db->query("SELECT * FROM `widgets` WHERE `id` = '$id'")->fetch_assoc();
		return $result;
	}
	public function printSettings(){
		global $_LANG;
		$conf = Configuration::set();
		if($_GET['do']=="change" and $_POST['submit']){
		$conf->configCreatMini($_POST);
		if ($_SESSION['ADMIN_LINK'] != $conf->get('ADMIN_LINK')) System::sendNotice(1,'uspeh', '/'.$conf->get('ADMIN_LINK').'/settings');
		System::sendNotice(1,'uspeh');
		}
		if($conf->get('SITEON') != 0) $siteon = 'checked="checked"';
		else $siteoff = 'checked="checked"';
		if($conf->get('CAN_CHANGE_LANG') != 0) $can_lang = 'checked="checked"';
		else $cant_lang = 'checked="checked"';
		if($conf->get('TITLE_WITH_SITENAME') != 0) $titleon = 'checked="checked"';
		else $titleoff = 'checked="checked"';
		$_SESSION['ADMIN_LINK'] = $conf->get('ADMIN_LINK');
		echo '
			<div class="box box-info">
			<div class="box-header with-border">
			<form action="/'.$conf->get('ADMIN_LINK').'/settings/?do=change" method="post">
			<table width:100%; class="table no-margin">
			<thead>
			<tr><th><strong>'.$_LANG['SETTINGS'].'</strong></th></tr>
			</thead>
			<tbody>
			<tr><td>Сайттын аталышы:<br /><span class="description">Сайттын баштыгында колдонулат</span></td><td><input type="text" value="'.$conf->get('SITE_NAME').'" name="sitename"/></td></tr>
			<tr><td>Сайттын баштыгында сайттын атын көргөзүү:</td><td><label><input '.$titleon.' name="title_with_sitename" value="1" type="radio"/>Ооба</label>&nbsp <label><input '.$titleoff.' value="0" name="title_with_sitename" type="radio"/>Жок</label></td></tr>
			<tr><td>Интерфейстин тили:</td><td><select name="til">'.System::getDirList('/system/languages/', 'option').'</select></td></tr>
			<tr><td>Сайттын калыбы:<br /><span class="description">(Шаблон)</span></td><td><select name="template">'.System::getDirList('/templates/','option') .'</select></td></tr>
			<tr><td>Сайтта интерфейстин тилин өзгөртүү:</td><td><label><input name="can_change_lang" '.$can_lang.' value="1" type="radio"/>Ооба</label>&nbsp <label><input value="0" '.$cant_lang.' name="can_change_lang" type="radio"/>Жок</label></td></tr>
			<tr><td>Сайт иштейби?:</td><td><label><input name="siteon" '.$siteon.' value="1" type="radio"/>Ооба</label>&nbsp <label><input value="0" '.$siteoff.' name="siteon" type="radio"/>Жок</label></td></tr>
			<tr><td>Чечмелөө:</td><td><label><textarea name="description">'.$conf->get('DESCRIPTION').'</textarea></td></tr>
			<tr><td>Ачкыч сөздөр:</td><td><label><textarea name="keywords">'.$conf->get('KEYWORDS').'</textarea></td></tr>
			<tr><td>Админ шилтемеси:<br /><span class="description">Админкага кирүүдө колдонулат</span></td><td><input type="text" value="'.$conf->get('ADMIN_LINK').'" name="admin_link"/></td></tr>
			<tr><td>Админ email:<br /><span class="description">Кат(письмо) жөнөтүүдө колдонулат</span></td><td><input type="text" value="'.$conf->get('EMAIL').'" name="email"/></td></tr>
			<tr><td>noreply-mail:<br /><span class="description">Автоматтык түрдө кат(письмо) жөнөтүүдө колдонулат</span></td><td><input type="text" value="'.$conf->get('NOREPLYMAIL').'" name="noreplymail"/></td></tr>
			<tr><td>Үй бетинин баштыгы:<br /><span class="description">Эгер көрсөтүлгөн эмес болсо сайттын аталышы чыгат</span></td><td><label><input name="title_homepage" value="'.$conf->get('DEFAULT_TITLE').'" type="text"/></td></tr>
			<tr><td></td><td><label><input class="btn btn-default" name="submit" value="'.$_LANG['SAVE'].'" type="submit"/></td></tr>
			</tbody>
			</table>
			</form>
			</div></div>
		';
	}
}
?>