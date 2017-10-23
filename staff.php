<?php
	require_once "libs/db.php";
	require_once "libs/login.php";

	guard_page("staff");
 
	
?>
<html>
	<body>
		<h1>Welcome <?php echo get_login_ucid(); ?></h1>
 
		<h1></h1>
		<?php foreach ($classes as $c) { ?>
			<div>
				<h3><?php echo $c->get_id() . " \w " . $c->get_teacher_ucid(); ?></h3>
				<?php
					foreach ($c->get_assignments() as $a) {
						echo "<h5>Assignment: " . $a->get_name() . " DUE " . $a->get_due() . "</h5>";
						echo "<p>" . $a->get_about() . "</p>";
					}
				?>
			</div>
		<?php } ?>
	</body>
</html>

