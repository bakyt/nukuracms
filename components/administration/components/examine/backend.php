<?php
function examine(){
	global $_LANG;
	$db = DB::set();
	System::loadComponentLanguage('examine');
	echo '
		<div id="menu">
		<ul class="menu-1 nav navbar-nav navbar-default">
		<li><a href="/'.ADMIN_LINK.'/components/examine/?display=cats">Категориялар</a></li>
		<li><a href="/'.ADMIN_LINK.'/components/examine/?display=new_cat">Категория кошуу</a></li>
		<li><a href="/'.ADMIN_LINK.'/components/examine/?display=help">Жардам</a></li>
		</ul>
		</div>
	';
	if($_GET['display'] == 'cats' or !$_GET['display']){
		$cats = $db->query("SELECT * FROM `com_examine_cat`");
			echo '
				<table width:100%; class="simple-little-table">
				<thead>
				<tr><th>id</th><th>'.$_LANG['NAME'].'</th><th>'.$_LANG['DESCRIPTION'].'</th><th>'.$_LANG['WILL_SHOWN'].'</th></tr>
				</thead>
				<tbody>
			';
		while($cat = $cats->fetch_assoc()){
			echo '
				<tr><td>'.$cat['id'].'</td><td><a href="/'.ADMIN_LINK.'/components/examine/?display='.$cat['id'].'">'.$cat['name'].'</a></td><td>'.$cat['description'].'</td><td>'.$cat['display'].'</td></tr>
			';
		}
		echo '</tbody></table>';
	}
	else if(is_int($_GET['display'])){
		$cats = $db->query("SELECT * FROM `com_examine_cat` WHERE `id`='$_GET[cat]'");
		$items = $db->query("SELECT * FROM `com_examine` WHERE `category`='$_GET[cat]'");
		if (!$items->num_rows and !$cats->num_rows) Page::error404();
		else if ($items->num_rows and !$cats->num_rows)	Page::warning("Бул категориядагы суроолорду башка категорияга жылдырууну сунуштайбыз!");
		while($item = $items->fetch_assoc()){
			
		}
		
	}
	else if($_GET['display'] == (int)$_GET['display']){echo 'bul jerde items turmakchy';}
	else Page::error404();
}
?>