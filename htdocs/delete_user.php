<?php   session_start();  ?>
<?php 
	include_once ('includes/config.php');
	$db = pg_connect($conn_str);
	$user = $_SESSION['use'];
	$query = "DELETE FROM app_user WHERE email='$user'";
	$result = pg_query($db, $query);
	if (!$result) {
		echo pg_last_error($db)."<br>";
	} else {
		session_destroy();
		header("Location: /carpool/");
		// TODO: Display "user deleted!"
	}
?>
