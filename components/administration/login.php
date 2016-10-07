<?php
System::loadComponentLanguage('users');
$Page = Page::set();
$notice = System::set()->printNotices();
?>
<html>
<head>
<meta charset="utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="/components/administration/css/styles.css" rel="stylesheet" type="text/css">
<script src="<?php echo $Page->getResource('js/jquery.js');?>" type="text/javascript" ></script>
<link href="<?php echo $Page->getResource('css/bootstrap.css');?>" rel="stylesheet" type="text/css">
<script src="<?php echo $Page->getResource('js/bootstrap.js');?>" type="text/javascript" ></script>
</head>
<body><div id="login">
<form  action="/users/do/login" method="POST">
				<div class="admin_login container">
				<div class="header_login"><?php echo $_LANG['LOGIN'];?></div><br /><br /><br/>
				<input type="hidden" name="EnterAdmin" value="true">
				<input placeholder="<?php echo $_LANG['USERNAME'];?>" type="text" name="login" maxlength="32" pattern="[A-Za-z-0-9.-_]{3,32}" title="<?php echo $_LANG['ONLY_LATYN'];?>, <?php echo $_LANG['NUMBERS'];?> <?php echo $_LANG['AND'];?> '._-' 3-32" placeholder="<?php echo $_LANG['ONLY_LATYN'];?>, <?php echo $_LANG['NUMBERS'];?> <?php echo $_LANG['AND'];?> '._-' 3-32"><br />
				<input placeholder="<?php echo $_LANG['PASSWORD'];?>" type="password" name="password" maxlength="32" pattern="[A-Za-z-0-9.-_]{6,32}" placeholder="6-32"> <br />
				<br/><input type="checkbox" align="middle" name="remind" id="remember"><label align="middle" for="remember"> <?php echo $_LANG['REMIND_ME'];?></label><br /><br />
				<input style="width:100px; margin-bottom:30px;" type="text" name="captcha" placeholder="<?php echo $_LANG['CODE'];?>"><img src ="../../system/resources/captcha.php" alt="captcha" style="margin:0px;"> <input style="float:right; margin-top:3px;" class="btn btn-default" type="submit" name="enter" value="<?php echo $_LANG['LOGIN'];?>">
				<div id="notice" class="page col-xs-page col-md-page col-sm-page <?php echo $notice['TYPE'];?>">
				<div id = "close" onClick="close_notice()">X</div>
				<?php echo $notice['MESSAGE'];?>
		</div>
</div></div>
</form>
</div>
<script>
	var a = "<?php echo $notice['MESSAGE']?>";
	if(a) $("#notice").toggle(1000);
	function close_notice(){
		$("#notice").toggle(1000);
}
	</script>
</body>
</html>