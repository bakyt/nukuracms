<?php
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="ru"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="ru"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="ru"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="ru"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php echo SITENAME?> - Тыюу салынган!</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php Page::setCss('e404')?>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	    <!--[if lt IE 9]>
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
</head>
<body>
<div class="comingcontainer">
    <div class="checkbacksoon">
		<p>
			<span class="go3d text"><a href="/users/do/logout">Чыгуу</a></span>
		</p>
        
        <p class="error"><br/>Бул бетке өтүү үчүн сайттагы профилиңизден чыгуу талап кылынат.
		</p>
		<form action="" method="post" class="search">
  <input type="search" name="" placeholder="поиск" class="input" />
  <input type="submit" name="" value="" class="submit" />
</form>
        <nav>
            <ul>
                <li><a href="/"><?php echo $_LANG['HOME']?></a></li>
                <li><a href="#">Сайт жөнүндө</a></li>
            </ul>	
        </nav>
    
	</div>
</div>

</body>
</html>