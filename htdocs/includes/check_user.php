<?php 
	if (isset($_SESSION['use'])){
		if (($_SESSION['isadmin']) == 't'){
			// is admin
			header("Location: /carpool/admin_home"); 
		}
	} else {
		// havent login
		header("Location: /carpool/");
	}
?>
