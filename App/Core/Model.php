<?php
	namespace App\Core;

	class Model {
		private $db;
		var $exeArr;
		var $close;

		function __construct () {
			$this->exeArr = [];
			$this->close = true;
		}

		/**
		 * connect database
		 * @return [type] [database]
		 */
		function init () {
			$option = array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ);
			$this->db = new \PDO("mysql:host=127.0.0.1;charset=utf8;dbname=github", "root", "", $option);
			return $this->db;
		}

		/**
		 * return database
		 * @return [type] [database]
		 */
		function getDB () {
			return $this->db;
		}

		/**
		 * db disconnect
		 * @return [type] [description]
		 */
		function dbClose () {
			if ($this->close) $this->db = null;
			$this->close = true;
		}

		/**
		 * database query action
		 * @param  [string] $sql    [sql sentence]
		 * @param  [array] $params [parameters]
		 * @return [type]         [result]
		 */
		function query ($sql, $params = false) {
			$this->init();
			if ($params) $this->exeArr = $params;
			$res = $this->getDB()->prepare($sql);
			if (!$res->execute($this->exeArr)) {
				echo $sql;
				print_pre($this->exeArr);
				print_pre($this->getDB()->errorInfo());
			}
			$this->dbClose();
			return $res;
		}

		/**
		 * get data
		 * @param  [string] $sql    [sql sentence]
		 * @param  [array] $params [parameters]
		 * @return [object]         [data]
		 */
		function fetch ($sql, $params = false) {
			$this->init();
			$this->close = false;
			return $this->query($sql, $params)->fetch();
		}

		/**
		 * get data list
		 * @param  [string] $sql    [sql sentence]
		 * @param  [array] $params [parameters]
		 * @return [array]         [data list]
		 */
		function fetchAll ($sql, $params = false) {
			$this->init();
			$this->close = false;
			return $this->query($sql, $params)->fetchAll();
		}

		/**
		 * get the number of data
		 * @param  [string] $sql    [sql sentence]
		 * @param  [array] $params [parameters]
		 * @return [integer]         [the number of data]
		 */
		function rowCount ($sql, $params = false) {
			$this->init();
			$this->close = false;
			return $this->query($sql, $params)->rowCount();
		}

		/**
		 * get column
		 * @param  [array] $arr    [columns and value]
		 * @param  [string] $cancel [cancel columns]
		 * @return [string]         [column]
		 */
		function getColumn ($arr, $cancel) {
			$this->exeArr = [];
			$column = "";
			$cancel = explode("/", $cancel);
			foreach ($arr as $key => $val) {
				if (in_array($key, $cancel)) continue;
				$column .= ", {$key} = ?";
				$this->exeArr[] = $val;
			}
			return substr($column, 2);
		}

		/**
		 * 
		 * @param  [type] $action [description]
		 * @param  [type] $table  [description]
		 * @param  [type] $column [description]
		 * @return [type]         [description]
		 */
		function querySet ($action, $table, $column) {
			switch ($action) {
				case 'insert':
					$sql = "INSERT INTO {$table} SET ";
					break;
				case 'update':
					$sql = "UPDATE {$table} SET ";
					break;
				case 'delete':
					$sql = "DELETE FROM {$table} ";
					break;
			}
			$this->query($sql.$column);
		}
	}