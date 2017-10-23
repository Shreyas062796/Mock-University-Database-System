<?php
	session_start();

	function set_login($username, $type) {
		$_SESSION["ucid"] = strtolower($username);
		$_SESSION["type"] = strtolower($type);
	}

	function get_login_type() {
		if (isset($_SESSION["type"]))
			return $_SESSION["type"];
		return null;
	}

	function get_login_ucid() {
		if (isset($_SESSION["ucid"]))
			return $_SESSION["ucid"];
		return null;
	}

	function guard_page($pagename) {
		if (strtolower($pagename) == get_login_type())
			return;

		header("Location: ./index.php", true, 302);
		exit();
	}

