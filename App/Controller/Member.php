<?php
	namespace App\Controller;

	use App\Core\DB;
	use App\Core\Controller;

	class Member extends Controller {
		function action () {
			$add_sql = $msg = $url = "";
			extract($_POST);

			switch ($action) {
				case 'join':
					access(!empty($username) && !empty($email) && !empty($pw) && !empty($captcha), 'Have missing item');

					access($captcha == $_SESSION['code'], 'Captcha isn\'t same');

					$table = "member";
					$msg = 'Sign up is complete';
					$url = HOME."/login";
					break;
			}

			$cancel = "action/captcha/";
			$column = $this->model->getColumn($_POST, $cancel).$add_sql;
			$this->query($action, $table, $column);
			alert($msg);
			move($url);
		}

		function captcha () {
			$fp = fopen(_PUBLIC."/img/captcha.php", "w");
			$img_width = 400;
			$img_height = 70;
			$font_size = 30;
			$font_dir = _PUBLIC."\\font";
			$font_arr = read_file_list($font_dir);
			$keys = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM9784651320';
			$len = strlen($keys);
			$captcha_arr = [];
			$y_location = [];
			$captcha_str = "";
			$img_draw_str = '
			<?php
				header("Content-Type: image/jpeg");
				$image = imagecreate('.$img_width.', '.$img_height.');
				imagecolorallocate($image, 255, 255, 255);
				$text_color = imagecolorallocate($image, 0, 0, 0);
			';
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
				foreach ($captcha_arr as $x => $str) {
					$captcha_str .= $str;
					$angle = rand(-90, 90);
					$font_url = $font_arr[rand(0, count($font_arr) - 1)];
					$img_draw_str .= "imagettftext(\$image, {$font_size}, {$angle}, {$x}, {$y_location[$x]}, \$text_color, '{$font_url}', '{$str}');
					";
				}
			}
			ksort($captcha_arr);
			ksort($y_location);
			$_SESSION['code'] = $captcha_str;
			$line_count = rand(5, 15);
			for ($i=0; $i < $line_count; $i++) {
				$x1 = rand(0, $img_width/3);
				$x2 = rand($img_width/2, $img_width);
				$y1 = rand(0, $img_height);
				$y2 = rand(0, $img_height);
				$img_draw_str .= "imageline(\$image, {$x1}, {$y1}, {$x2}, {$y2}, \$text_color);
				";
			}
			$img_draw_str .= "imagejpeg(\$image);
			";
			fwrite($fp, $img_draw_str);
			fclose($fp);
		}

		function join () {
			$this->captcha();
		}
	}