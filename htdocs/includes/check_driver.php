<?php
	$result = pg_query($db, "SELECT * FROM drive WHERE driver = '$driver");
	if (pg_num_rows($result) == 0) {
		header("Location: /carpool/driver_reg");
	}
?>