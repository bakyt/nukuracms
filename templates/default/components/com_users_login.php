<?php

?>
<table class="reg">
	<form  action="/users/do/login" method="POST">
		<tr><td><?php echo $_LANG['USERNAME'];?>:</td><td><input class="form-control"  type="text" name="login" maxlength="32" pattern="[A-Za-z-0-9.-_]{3,32}" title="<?php echo $_LANG['ONLY_LATYN'].', '.$_LANG['NUMBERS'].$_LANG['AND'].'._- 3-32'?>" placeholder="<?php echo $_LANG['ONLY_LATYN'].', '.$_LANG['NUMBERS'].$_LANG['AND'].' ._- 3-32'?>"> </td></tr>
		<tr><td><?php echo $_LANG['PASSWORD'];?>:</td><td><input class="form-control" type="password" name="password" maxlength="32" pattern="[A-Za-z-0-9.-_]<?php echo '{6,32}';?>" placeholder="6-32"> </td></tr>
		<tr><td><?php echo $_LANG['REMIND_ME'];?>:</td><td><input type="checkbox" name="remind"> </td></tr>
		<?php if($_SESSION['USER']['captcha']==1) echo '<tr><td>'.$_LANG['CAPTCHA'].':</td><td><img src="/system/resources/captcha.php" alt="captcha"><input class="form-control" style="float:left;width:100px;" type="text" name="captcha" placeholder="'.$_LANG['CODE'].'"/> </td></tr>'?>
		<tr><td></td><td><input class="btn btn-default" style="float:right;" type="submit" name="enter" style="float:right;" value="<?php echo $_LANG['LOGIN'];?>"> </td></tr>
</form></table>