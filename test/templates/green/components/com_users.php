<div id = "users">
<?php
$i=0;
for($i=0;$i<count($users);$i++){?>
	<div class="user_list col-sm-12 col-xs-12 col-md-12 col-lg-12">
		<img class="img" src="/templates/<?php echo TEMPLATE?>/images/profile/no_avatar_<?php echo $users[$i]['jynysy']?>.png">
	
	<div class="text">
		<a href="/users/<?php echo $users[$i]['id']?>"><?php echo $users[$i]['login']?></a>
		<p><?php echo $users[$i]['status']?></p>
	</div>
	</div>
<?php } ?>
</div>