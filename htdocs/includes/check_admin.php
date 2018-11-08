<?php 
	if (!isset($_SESSION['use']) || $_SESSION['isadmin'] == 'f'){
		// not logged in or not admin
		header("Location: /carpool/"); 
	}
?>
