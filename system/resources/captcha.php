<?php
	session_start();
	$Char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	for ($i = 0; $i < 5; $i++) $Random .= $Char[rand(0, strlen($Char) - 1)];
	//$Random = rand(10001, 99999);
	$_SESSION['captcha'] = md5($Random);
	$im = imagecreatetruecolor(100, 40);
	imagefilledrectangle($im, -20, -10, 100, 40, imagecolorallocate($im,255, 255, 255));
	imagettftext($im, 25, 0, 5, 35, imagecolorallocate($im, 82, 82, 82), 'fonts/6.TTF', $Random);
	header('Expires; Wed, 1 Jan 1997 00:00:00 GMT');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check = 0', false);
	header('Pragma: no-cache');
	header('Content-type: image/gif');
	imagegif($im);
	imagedestroy($im);
?>