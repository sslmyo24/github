<?php
	header('Content-Type: image/jpeg');
	$captcha_num = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM9784651320';
	$captcha_num = substr(str_shuffle($captcha_num), 0, 6);
	$_SESSION['code'] = $captcha_num;
	$img_width = 150;
	$img_width = 40;
	$font_size = 30;
	$image = imagecreate($img_width, $img_height);
	imagecolorallocate($image, 255, 255, 255);
	$text_color = imagecolorallocate($image, 0, 0, 0);
	imagettftext($image, $font_size, 0, 14, 30, $text_color, _PUBLIC."/font/arial.ttf", $captcha_num);
	imagejpeg($image);