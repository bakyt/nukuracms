<?php
	$Gist = BagytCMS::set();
	if (!$Gist->Page[1]) $ERROR = $Gist->Page[0];
	else if (!$Gist->Page[2]) $ERROR = $Gist->Page[1];
	else if (!$Gist->Page[3]) $ERROR = $Gist->Page[2];
	else if (!$Gist->Page[4]) $ERROR = $Gist->Page[3];
	else if (!$Gist->Page[5]) $ERROR = $Gist->Page[4];
	else if (!$Gist->Page[6]) $ERROR = $Gist->Page[5];
	else if (!$Gist->Page[7]) $ERROR = $Gist->Page[6];
	else if (!$Gist->Page[8]) $ERROR = $Gist->Page[7];
	else if (!$Gist->Page[9]) $ERROR = $Gist->Page[8];
	else $ERROR = $Gist->Page[10];
?>
<head><title>404 -- <?php echo SITENAME?></title></head>
<table id="error404" border="0" cellpadding="auto" cellspacing="auto">
            <tbody><tr>
                <td align="center">
                    <table style="text-align:center;padding:10px" border="0" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                            <td width="140">
                                <img src="/templates/default/images/error404.png">
                            </td>
                            <td>
								<p style="text-align:center"><b><?php echo SITENAME?></b></p>
                                <h2>Сиз издеген "<?php echo $ERROR;?>" бети табылган жок!</h2>
                                <p>Ал бет өчүрүлгөн же башка жерге көчүрүлгөн болушу мүмкүн.</p>
								<p style="text-align:center;"><a href="<?php echo $_GET['redirecturl']?>"><?php echo $_LANG['BACK'];?></a></p>
                                                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
        </tbody></table>