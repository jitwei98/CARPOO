<?php   session_start();  ?>
<?php 
	include_once ('includes/check_user.php');
	include_once ('includes/config.php');
	$db = pg_connect($conn_str);
	$user = $_SESSION['use'];
	$query = "DELETE FROM drive WHERE driver='$user'";
	// the update_drive trigger will remove the car from the car table too
	$result = pg_query($db, $query);
	if (!$result) {
		echo pg_last_error($db)."<br>";
	} else {
		header("Location: /carpool/");
		// TODO: Display "user deleted!"
	}
?>
