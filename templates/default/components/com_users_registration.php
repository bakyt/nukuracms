<?php

?>
<table class="reg">
	<form  action="/users/do/registration" method="POST">
	
				 <tr><td><?php echo $_LANG['NAME'];?>:</td><td><input class="form-control" value="<?php echo $_SESSION['REGISTRATION']['name'];?>" type="text" name="name" maxlength="15"></td></tr>  
				 <tr><td><?php echo $_LANG['SURNAME'];?>:</td><td><input class="form-control" value="<?php echo $_SESSION['REGISTRATION']['surname'];?>" type="text" name="surname" maxlength="15">  </td></tr>
				 <tr><td><?php echo $_LANG['EMAIL'];?>:</td><td><input class="form-control" value="<?php echo $_SESSION['REGISTRATION']['email'];?>" type="email" name="email"> </td></tr>
				 <tr><td><?php echo $_LANG['USERNAME'];?>:</td><td><input class="form-control" value="<?php echo $_SESSION['REGISTRATION']['login'];?>" type="text" name="login" maxlength="32" pattern="[A-Za-z-0-9.-_]{3,32}" title="<?php echo $_LANG['ONLY_LATYN'].', '.$_LANG['NUMBERS'].$_LANG['AND'].'._- 3-32'?>" placeholder="<?php echo $_LANG['ONLY_LATYN'].', '.$_LANG['NUMBERS'].$_LANG['AND'].' ._- 3-32'?>"> </td></tr>
				 <tr><td><?php echo $_LANG['PASSWORD'];?>:</td><td><input class="form-control" type="password" name="password" maxlength="32" pattern="[A-Za-z-0-9.-_]<?php echo '{6,32}';?>" placeholder="6-32"> </td></tr>
				 <tr><td><?php echo $_LANG['RE_PASSWORD'];?>:</td><td><input class="form-control" type="password" name="repassword" maxlength="32" pattern="[A-Za-z-0-9.-_]<?php echo '{6,32}';?>" placeholder="6-32"> </td></tr>
				 <tr><td><?php echo $_LANG['AVATAR'];?>:</td><td><input class="form-control" value="<?php echo $_SESSION['REGISTRATION']['file'];?>" type="file" name="avatar"> </td></tr>
				 <tr><td><?php echo $_LANG['JYNYSY'];?>:</td><td><select class="form-control" selected="<?php echo $_SESSION['REGISTRATION']['jynysy'];?>" name="jynysy" placeholder="{$_LANG.JYNYSY}"><option value="0"><?php echo $_LANG['NO_CHOSEN']?></option><option value="1"><?php echo $_LANG['MALE']?></option><option value="2"><?php echo $_LANG['FEMALE']?></option></select></td></tr> 
				 <tr><td><?php echo $_LANG['CAPTCHA'];?>:</td><td><img src="/system/resources/captcha.php" alt="captcha"><input class="form-control" style="float:left;width:100px;" type="text" name="captcha" placeholder="<?php echo $_LANG['CODE'];?>"/> </td></tr>
				 <tr><td></td><td><input class="btn btn-default" style="float:right;" type="submit" name="registration" style="float:right;" value="<?php echo $_LANG['REGISTRATION'];?>"> </td></tr>
	</form></table>