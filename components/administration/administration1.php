<?php
if (!defined('SYSTEM')) die('ACCESS DENIED');
	$User = User::set();
	include(HOST."/components/administration/model.php");
	$Admin = new com_administration;
	$System = System::set();
	$Page = Page::set();
	$Conf = Configuration::set();
	$notice = $System->printNotices();
	$DB = DB::set();
	System::loadComponentLanguage("administration");
	if(!$User->id or $User->id and $User->get('group') != 1) die($Admin->printEnterPage());
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo SITENAME;?></title>
<link href="/components/administration/css/styles.css" rel="stylesheet" type="text/css">
<script src="<?php echo $Page->getResource('js/jquery.js');?>" type="text/javascript" ></script>
<link href="<?php echo $Page->getResource('css/bootstrap.css');?>" rel="stylesheet" type="text/css">
<script src="<?php echo $Page->getResource('js/bootstrap.js');?>" type="text/javascript" ></script>
<meta name="keywords" content="" />
<meta name="description" content="" />
</head>
<body>
	<div class="wrapper">
	<div class="header_menu">
		<p>menu</p>
	</div>
	<div class="header">
		<div class="logo col-md-3 col-xs-9 row"><a href="/"><img src="/templates/<?php echo TEMPLATE?>/images/logo.png"></a></div>
		<div class="menu col-md-9 col-xs-9">
		<ul>
			<li><a href="/<?php echo $Conf->get("ADMIN_LINK");?>/filemanager"><img style="height:48px;" src="/components/administration/images/fm.png"></a></li>
			<li><a href="/<?php echo $Conf->get("ADMIN_LINK");?>/components"><img style="height:48px;" src="/components/administration/images/components.png"></a></li>
			<li><a href="/<?php echo $Conf->get("ADMIN_LINK");?>/widgets"><img style="height:48px;" src="/components/administration/images/widgets.png"></a></li>
			<li><a href="/<?php echo $Conf->get("ADMIN_LINK");?>/settings"><img style="height:48px;" src="/components/administration/images/settings.png"></a></li>
			<li><a href="/<?php echo $Conf->get("ADMIN_LINK");?>/templates"><img style="height:48px;" src="/components/administration/images/templates.png"></a></li>
			<li><a href="/<?php echo $Conf->get("ADMIN_LINK");?>/upload"><img style="height:48px;" src="/components/administration/images/upload.png"></a></li>
		</ul>
		</div>
	</div>
	<div class="top">
		<div id="pathway">
			<?php
				$path=array();
				$path[1]['title'] = "title";
				$path[1]['link'] = "link";
				
				$path[2]['title'] = "123";
				$path[2]['link'] = "123";
				$path[3]['title'] = "123";
				$path[3]['link'] = "123";
				$Admin->setPathway($path)?>
			<?php $Admin->printPathway()?>
		</div>
		<div id="notice" class="col-xs-12 col-md-12 col-sm-12 <?php echo $notice['TYPE'];?>">
		<div id = "close" onClick="close_notice()">X</div>
				<?php echo $notice['MESSAGE'];?>
		</div>
			<!-- component settings -->
	</div>
	<div class="content">
		<?php $Admin->printBody()?>
	</div>
	<div class="footer">
		<div class=""><?php echo SITENAME.' © '.date('Y')?></div>
	</div>
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