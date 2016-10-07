<?php
if (!defined('SYSTEM')) die('ACCESS DENIED');
	$System = System::set();
	$Page = Page::set();
	$Position = $Page->getPositions();
	$Conf = Configuration::set();
	$notice = $System->printNotices();
	$DB = DB::set();
	if($Position['left']) $class = '8';
	else $class = '12';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $Page->setCss('styles');?>
<?php $Page->setJs('template');?>
<script src="<?php echo $Page->getResource('js/jquery.js');?>" type="text/javascript" ></script>
<link href="<?php echo $Page->getResource('css/bootstrap.css');?>" rel="stylesheet" type="text/css">
<script src="<?php echo $Page->getResource('js/bootstrap.js');?>" type="text/javascript" ></script>
<meta name="keywords" content="" />
<meta name="description" content="" />
</head>
<body>
	<div class="wrapper">
	<div class="header_a"><div class="container">
		<div class="row header_b">
			<a href="/"><div class="logo col-md-3 col-xs-9"><img src="/templates/<?php echo TEMPLATE?>/images/logo.png"></div></a>
			<div class="visible-md visible-sm visible-lg col-md-9"><?php $Page->position('usermenu')?></div>
		</div>
	</div></div>
	<div class="menu_a"><div class="container">
		<div class="menu_b">
			<?php $Page->position('menu')?>
		</div>
	</div></div>
	<div class="top_a">
		<div class="top_b container">
		<?php if ($Page->getUrlPart(0) == '') $Page->position('top');?>
		</div>
	</div>
	<div class="content_a"><div class="container">
		<div class="content_b row">
			<div class="col-md-4 col-sm-4 ">
				<?php $Page->position('left');?>
			</div> 
			<div class="page col-xs-12 col-md-<?php echo $class?> col-sm-<?php echo $class?>">
				<div id="notice" class="<?php echo $notice['TYPE'];?>">
					<div id = "close" onClick="close_notice()">X</div>
						<?php echo $notice['MESSAGE'];?>
				</div>
				<div class="component window">
				<?php $Page->printPage();?>
			</div>
			<?php $Page->position('up_bottom');?>
			</div>
		</div></div>
	</div>
	<div class="bottom_shadow"></div>
	<div class="bottom_a">
		<div class="bottom_b container">
			<?php $Page->position('bottom');?>
			<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12"><?php $Page->position('bottom_1');?></div>
			<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12"><?php $Page->position('bottom_2');?></div>
			<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12"><?php $Page->position('bottom_3');?></div>
			<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12"><?php $Page->position('bottom_4');?></div>
		</div>
	</div>
	<div class="footer_a">
		<div class="footer_b container">
			<div class="col-md-3 row"><?php echo SITENAME.' © '.date('Y')?></div>
			<div class="col-md-4"></div>
			<div class="col-md-5 row" align="right">Сайттын эрежелери</div>
		</div>
	</div>
	</div>
	<script>
	var a = "<?php echo $notice['MESSAGE']?>";
	if(a) $("#notice").toggle(1000);
	</script>
</body>
<title><?php echo SITENAME.$Page->printTitle();?></title>
</html>