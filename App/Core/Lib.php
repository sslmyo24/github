<?php
	/**
	 * alert message
	 * @param  [string] $str [message]
	 * @return [type]      [description]
	 */
	function alert ($str) {
		echo "<script>alert('{$str}')</script>";
	}

	/**
	 * move page
	 * @param  [string] $str [url]
	 * @return [type]      [description]
	 */
	function move ($str = false) {
		echo "<script>";
		echo $str ? "location.replace('{$str}')" : "history.back();";
		echo "</script>";
		exit;
	}

	/**
	 * access
	 * @param  [boolean] $bol [condition]
	 * @param  [string] $msg [message]
	 * @param  [string] $url [url]
	 * @return [type]      [description]
	 */
	function access ($bol, $msg, $url = false) {
		if (!$bol) {
			alert($msg);
			move($url);
		}
	}

	/**
	 * print pre
	 * @param  [array] $str [array]
	 * @return [type]      [description]
	 */
	function print_pre ($arr) {
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}

	/**
	 * get file extension
	 * @param  [string] $name [file name]
	 * @return [string]      [extension]
	 */
	function get_ext ($name) {
		return preg_replace("/^(.*)\.(.*)$/", "$2", $name);
	}

	/**
	 * file upload
	 * @param  [array] $file [$_FILES['file']]
	 * @return [string]      [save name]
	 */
	function upload ($file) {
		if (is_uploaded_file($file['tmp_name'])) {
			$save_name = time()."_".rand(0, 99999).".".get_ext($file['name']);
			if (!move_uploaded_file($file['tmp_name'], _PUBLIC."/data/{$save_name}")) {
				print_pre($file);
				exit;
			} else {
				return $save_name;
			}
		} else {
			return false;
		}
	}