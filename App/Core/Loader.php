<?php
	/**
	 * class Loader
	 * @param [string] $c [class name]
	 */
	function Loader ($c) {
		require_once $c.".php";
	}

	spl_autoload_register('Loader');