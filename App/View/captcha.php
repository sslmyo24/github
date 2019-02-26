<?php
	function inter_incre ($stand, $max_inter, $val_local, $arr) {
		for ($i= $max_inter*-1; $i <= $max_inter; $i++) {
			switch ($val_local) {
				case 'key':
					if (array_key_exists($stand + $i, $arr)) return true;
					break;
				case 'val':
					if (in_array($stand + $i, $arr)) return true;
					break;
			}
		}
	}
	header('Content-Type: image/jpeg');
	$img_width = 400;
	$img_height = 70;
	$font_size = 20;
	$font_url = "C:\\xampp\\htdocs\\Public\\font\\arial.ttf";
	$image = imagecreate($img_width, $img_height);
	imagecolorallocate($image, 255, 255, 255);
	$text_color = imagecolorallocate($image, 0, 0, 0);
	$keys = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM9784651320';
	$len = strlen($keys);
	$captcha_arr = [];
	$y_location = [];
	for ($i = 0; $i < 6; $i++) {
		$rand_str = $keys[rand(0, $len - 1)];
		$x = rand($font_size, $img_width - $font_size);
		$y = rand($font_size, $img_height - $font_size);
		if (inter_incre($x, $img_width/10, 'key', $captcha_arr)) {
			$i--;
			continue;
		}
		$captcha_arr[$x] = $rand_str;
		$y_location[$x] = $y;
	}
	ksort($captcha_arr);
	ksort($y_location);
	$captcha_str = "";
	foreach ($captcha_arr as $x => $str) {
		$captcha_str .= $str;
		$angle = rand(-90, 90);
		imagettftext($image, $font_size, $angle, $x, $y_location[$x], $text_color, $font_url, $str);
	}
	$_SESSION['code'] = $captcha_str;
	$line_count = rand(5, 15);
	for ($i=0; $i < $line_count; $i++) {
		$x1 = rand(0, $img_width);
		$x2 = rand(0, $img_width);
		$y1 = rand(0, $img_height);
		$y2 = rand(0, $img_height);
		imageline($image, $x1, $x2, $y1, $y2, $text_color);
	}
	imagejpeg($image);