<?php
	// session
	session_start();

	// path
	define("_DIR", __dir__);
	define("_APP", _DIR."/App");
	define("_PUBLIC", _DIR."/Public");

	// url
	define("HOME", str_replace("/index.php", "", $_SERVER['PHP_SELF']));
	define("SRC", HOME."/Public");

	// config
	require_once(_APP."/Core/Loader.php");
	require_once(_APP."/Core/Lib.php");

	// run
	App\Core\Controller::run();
	