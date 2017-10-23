<?php
	require_once "libs/login.php";
	require_once "libs/db.php";

	$is_login_failure = false;

	if (isset($_REQUEST["user"]) && isset($_REQUEST["pass"])) {

		$type = get_user_login($_REQUEST["user"], $_REQUEST["pass"]);

		if ($type == null) {
			 $is_login_failure = true;
		} else {
			set_login($_REQUEST["user"], $type);

			header("Location: ./${type}.php", true, 302);
			exit();
		}
	}
?>
<html>
	<body>
		<?php if ($is_login_failure) { ?>
			<p>Couldn't find that account. Please login again</p>
		<?php } ?>
		<form action="./index.php">
			<input type="text" name="user" value="user">
			<input type="password" name="pass" value="pass">
			<button type="submit"> Submit </button>	
		</form>
	</body>
</html>
