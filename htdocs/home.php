<?php   session_start();  ?>
<?php
	include_once ('includes/check_user.php');
?>
<!DOCTYPE html>
<html>
	<?php
		include_once ('includes/header.php');
		include_once ('includes/navbar.php');
	?>
	<div class="w3-container page_container">
	<?php
		$email = $_SESSION['use'];
		include_once ('includes/config.php');
		$db = pg_connect($conn_str);
		$result = pg_query($db, "SELECT * FROM drive where driver = '$email'");
	    $row = pg_fetch_assoc($result);
	    if (pg_num_rows($result) == 0) {
	    	echo '<a href=/carpool/driver_reg>';
	    	echo '<div class="w3-card-4 w3-blue-gray" style="float:left; width:40%; padding:30px; margin-top:100px; margin:30px; text-align: center;">';
	    	echo "Register as Driver here!";
	    	echo '</div>';
	    	echo '</a>';
	    }
	    else {
	    	echo '<a href=/carpool/driver_home>';
	    	echo '<div class="w3-card-4 w3-blue-gray" style="float:left; width:40%; padding:30px; margin-top:100px; margin:30px; text-align: center;">';
	    	echo "Login as Driver here!";
	    	echo '</div>';
	    	echo '</a>';

	    }
	?>
	<a href="/carpool/passenger_home">
		<div class="w3-card-4 w3-blue-gray" style="float:left; width:40%; padding:30px; margin-top:100px; margin:30px; text-align: center;">Login as Passenger!
		</div>
	</a>
	</div>
	<?php
		include_once ("includes/footer.php");
	?>
	</body>
</html>



