<?php
	function read_file_list ($dir) {
		// 핸들 획득
		$handle = opendir($dir);
		// 파일 목록 배열
		$files = array();

		// 디렉토리에 포함된 파일을 저장한다.
		while (($filename = readdir($handle)) !== false) {
			if ($filename == "." || $filename == "..") {
				continue;
			}

			// 파일인 경우만 배열에 추가
			if (is_file(($file_dir = $dir . "/" . $filename))) {
				if (get_ext($filename) == 'json') $files[] = $file_dir;
			}
		}

		// 핸들 해제
		closedir($handle);

		// 배열 정렬
		sort($files);

		return $files;
	}

	/**
	 * json parse
	 * @param  [string] $dir [json file dir]
	 * @return [type]      [description]
	 */
	function json_parse ($dir) {
		$arr = read_file_list($dir);
		foreach ($arr as $file_dir) {
			$file_name = explode('/', $file_dir)[count($arr) - 1];
			$table_name = preg_replace("/(.*)\.(.*)/", "$1", $file_name);
			$json_arr = json_decode(file_get_contents($file_dir))[0]->data;
			$sample_data = $json_arr[0];
			$table_sql = "CREATE TABLE {$table_name} (
				idx INT unsigned NOT NULL AUTO_INCREMENT,";
			$insert_sql = "INSERT INTO {$table_name} SET ";
			foreach ($sample_data as $key => $val) {
				$type = gettype($val);
				if ($type == 'string') {
					if (preg_match("/^[0-9]+$/", $val)) $type = 'integer';
					if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $val)) $type = 'date';
				}
				if ($type == 'string') $table_sql .= "{$key} VARCHAR(255) NOT NULL, ";
				else if ($type == 'integer') $table_sql .= "{$key} INT unsigned NOT NULL, ";
				else $table_sql .= "{$key} {$type} NOT NULL,";
				$insert_sql .= "{$key} = ?, ";
			}
			$table_sql .= " PRIMARY KEY (idx))";
			$insert_sql = substr($insert_sql, 0, strlen($insert_sql) - 2);
			// DB::query($table_sql);
			foreach ($json_arr as $json_data) {
				$params = [];
				foreach ($json_data as $data) {
					$params[] = $data;
				}
				// DB::query($insert_sql, $params);
			}
		}
	}

