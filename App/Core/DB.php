<?php
	namespace App\Core;

	class DB {
		private static $db;

		/**
		 * connect database
		 * @return [type] [database]
		 */
		public static function init () {
			if (is_null(self::$db)) {
				$option = array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ);
				self::$db = new \PDO("mysql:host=127.0.0.1;charset=utf8;dbname=github", "root", "", $option);
			}

			return self::$db;
		}

		/**
		 * database query action
		 * @param  [string] $sql    [sql sentence]
		 * @param  [array] $params [parameters]
		 * @return [type]         [result]
		 */
		public static function query ($sql, $params = null) {
			$res = self::init()->prepare($sql);
			if (!$res->execute($params)) {
				echo $sql;
				print_pre($params);
				print_pre(self::init()->errorInfo());
				exit;
			}
			return $res;
		}

		/**
		 * get data
		 * @param  [string] $sql    [sql sentence]
		 * @param  [array] $params [parameters]
		 * @return [object]         [data]
		 */
		public static function fetch ($sql, $params = null) {
			return self::query($sql, $params)->fetch();
		}

		/**
		 * get data list
		 * @param  [string] $sql    [sql sentence]
		 * @param  [array] $params [parameters]
		 * @return [array]         [data list]
		 */
		public static function fetchAll ($sql, $params = null) {
			return self::query($sql, $params)->fetchAll();
		}

		/**
		 * get the number of data
		 * @param  [string] $sql    [sql sentence]
		 * @param  [array] $params [parameters]
		 * @return [integer]         [the number of data]
		 */
		public static function rowCount ($sql, $params = null) {
			return self::query($sql, $params)->rowCount();
		}

	}