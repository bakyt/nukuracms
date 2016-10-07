<form action="/users/do/login" method="post">
<div class="body">
	<label for="login"> <?php echo $_LANG['USERNAME']?>:</label><input type="text" id="login" class="input-custom" name="login" style="width:100%;"/>
	<label for="password"> <?php echo $_LANG['PASSWORD']?>:</label><input type="password" id="password" class="input-custom" name="password" style="width:100%;"/>
	<input type="checkbox" id="check1"><label for="check1"> <?php echo $_LANG['REMIND_ME']?></label><br />
	<?php if($_SESSION['USER']['captcha']==1) echo '<img src="/system/resources/captcha.php" alt="captcha"><input class="form-control" style="float:left;width:100px;" type="text" name="captcha" placeholder="'.$_LANG['CODE'].'"/>'?>
	<input type="submit" style="float:right;" class="btn btn-default" name="enter" value="<?php echo $_LANG['LOGIN']?>"/>
</div>
</form>