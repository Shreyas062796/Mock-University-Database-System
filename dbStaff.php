<?php
	error_reporting(E_ALL);
	ini_set('display_errors','On');
	define("DBSRV", "");
	define("DBUSR", "");
	define("DBPAS", "");
	define("DBDAT", "");


	class CollegeClass {
		var $year;
		var $sem;
		var $teacher_ucid;
		var $department;
		var $level;
		var $section;
		var $students;
		var $assignments;

		function __construct($row, $students, $assignments) {
			$this->year = $row["class_year"];
			$this->sem = $row["class_sem"];
			$this->teacher_ucid = $row["teacher"];
			$this->department = $row["department"];
			$this->level = $row["level"];
			$this->section = $row["section"];
			$this->students = $students;
			$this->assignments = $assignments;
		}

		function get_year() { return $this->year; }
		function get_sem() { return $this->sem; }
		function get_teacher_ucid() { return $this->teacher_ucid; }
		function get_department() { return $this->department; }
		function get_level() { return $this->level; }
		function get_section() { return $this->section; }
		function get_students() { return $this->students; }
		function get_assignments() { return $this->assignments; }
		function get_id() { return $this->get_department() . $this->get_level() . "-" . $this->get_section(); }
	}
	Class Staff
	{
		var $records;
		var $schedule;
		var $contacts;
		var $department;
		var $ucid;


		function __construct($row,$ucid,) {
			$this->records = $row["records"];
			$this->schedule = $row["schedule"];
			$this->contacts = $row["contacts"];
			$this->department = $row["department"];
			$this->ucid = $ucid;
			}
		function get_records() { return $this->records; }
		function get_schedule() { return $this->schedule; }
		function get_contacts() { return $this->contacts; }
		function get_department() { return $this->department; }
		function get_ucid() { return $this->ucid;}



	}

	class CollegeAssigment {
		var $name;
		var $about;
		var $due;
		function __construct($row) {
			$this->name = $row["name"];
			$this->about = $row["about"];
			$this->due = $row["due"];
		}
		function get_name() { return $this->name; }
		function get_about() { return $this->about; }
		function get_due() { return $this->due; }
	}

	class CollegeStudent {
		var $ucid;
		var $type;
		function __construct($ucid, $type) {
			$this->ucid = $ucid;
			$this->type = $type;
		}
		function get_ucid() { return $this->ucid; }
		function get_type() { return $type->type; }
	}

	$conn = mysqli_connect(DBSRV, DBUSR, DBPAS, DBDAT);

	function get_user_login($username, $password) {
		global $conn;

		$username = mysqli_real_escape_string($conn, $username);
		$password = md5($password);

		$query = "SELECT ucid, type, pass FROM accounts WHERE ucid = '${username}' AND pass = '${password}';";

		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0)
			while ($row = mysqli_fetch_assoc($result))
				return strtolower($row["type"]);

		return null;
	}

	function get_students_for($class_id) {
		global $conn;

		$query = "SELECT a.* FROM classes as c, enrollments as e, accounts as a WHERE c.class_id = e.class_id AND a.ucid = e.ucid AND a.type = 'STUDENT' AND e.class_id = ${class_id};";
		$result = mysqli_query($conn, $query);
		$students = array();

		if (mysqli_num_rows($result) > 0)
			while ($row = mysqli_fetch_assoc($result))
				$students[] = new CollegeStudent($row["ucid"], $row["type"]);

		return $students;
	}

	function get_assignments_for($class_id) {
		global $conn;

		$query = "SELECT name, about, due FROM assignments WHERE class_id = ${class_id};";

		$assignments = array();
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0)
			while ($row = mysqli_fetch_assoc($result))
				$assignments[] = new CollegeAssigment($row);

		return $assignments;
	}

	function get_classes_for($ucid) {
		global $conn;

		$ucid = mysqli_real_escape_string($conn, $ucid);

		$query = "SELECT classes.class_id, class_year, class_sem, teacher, department, level, section FROM classes, enrollments WHERE enrollments.ucid = '${ucid}' AND enrollments.class_id = classes.class_id;";

		echo $query;
		$classes = array();

		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0)
			while ($row = mysqli_fetch_assoc($result))
				$classes[] = new CollegeClass($row, get_students_for($row["class_id"]), get_assignments_for($row["class_id"]));

		return $classes;
	}

	function get_staff($class_id) {
		global $conn;

		$query = "SELECT name, about, due FROM assignments WHERE class_id = ${class_id};";

		$assignments = array();
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) > 0)
			while ($row = mysqli_fetch_assoc($result))
				$assignments[] = new CollegeAssigment($row);

		return $assignments;
	}

?>