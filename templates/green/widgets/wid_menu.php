<ul class="nav navbar-nav row">
<?php for($i = 0; $i<count($list); $i++){
	if($config['using_active'] == 0) $list[$i]['active'] = '';
	echo '<li '.$list[$i]['active'].'><a href="'.$list[$i]['link'].'">'.System::translate($list[$i]['value'], '', 'users').'</a></li>'; 
	} ?>
</ul>