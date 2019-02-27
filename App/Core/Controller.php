<?php
	namespace App\Core;

	class Controller {
		var $param;
		var $nav = false;

		public static function get_param () {
			$get_param = isset($_GET['param']) ? explode("/", $_GET['param']) : null;
			$param['is_member'] = isset($_SESSION['member']);
			$param['member'] = $param['is_member'] ? $_SESSION['member'] : null;
			$param['type'] = isset($get_param[0]) && strlen($get_param[0]) ? $get_param[0] : ($param['is_member'] ? "rep" : "main");
			$param['rep_url'] = isset($_GET['rep_url']) ? explode("/", $_GET['rep_url']) : null;
			if ($param['rep_url'] !== null) {
				$param['id'] = isset($param['rep_url'][0]) ? $param['rep_url'][0] : null;
				$param['project'] = isset($param['rep_url'][1]) ? $param['rep_url'][1] : null;
				$param['route'] = isset($param['rep_url'][2]) ? $param['rep_url'][2] : null;
			}
			return (Object)$param;
		}

		public static function run () {
			$param = self::get_param();
			if ($param->type == 'join'  || $param->type == 'login') {
				$ctr_name = "App\\Controller\\Member";
			} else {
				$ctr_name = "App\\Controller\\".ucfirst($param->type);
			}
			$ctr = new $ctr_name();
			$ctr->param = $param;
			$ctr->model = new Model();
			$ctr->index();
		}

		protected function index () {
			if (isset($_POST['action'])) {
				$this->action();
			}
			if (method_exists($this, $this->param->type)) {
				$this->{$this->param->type}();
			}

			extract((Array)$this);
			require_once(_APP."/View/header.php");
			if ($this->param->is_member) require_once(_APP."/View/nav_session.php");
			else require_once(_APP."/View/nav.php");
			require_once(_APP."/View/{$this->param->type}.php");
		}
	}