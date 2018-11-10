<?php   session_start();  ?>
<?php
	include_once ('includes/check_user.php');
	include_once ('includes/config.php');
	$db = pg_connect($conn_str);
	$driver = $_SESSION['use'];
	include_once ('includes/check_driver.php');
?>
<!DOCTYPE html>
<html>
	<?php
		include_once ('includes/header.php'); 
		include_once ('includes/driver_navbar.php');
	?>
	<div class="w3-container page_container">
			<div class="w3-container">
				<h1>Initiate Carpool Offer</h1>
				<form class="w3-container" method="POST">
					<table class="w3-table-all w3-hoverable">
						<tr>
						    <td><label for="date_of_ride"><b>Date of ride : </b></label></td>
						    <td><input type="date" placeholder="Enter Date" name="date_of_ride" required></td>
						</tr>
					    <tr>
						    <td><label for="time_of_ride"><b>Time of ride : </b></label></td>
						    <td><input type="time" placeholder="Enter Time" name="time_of_ride" required></td>
					    </tr>
					    <tr>
						    <td><label for="origin"><b>Origin of trip : </b></label></td>
						    <td><input type="text" placeholder="Enter Origin" name="origin" required></td>
					    </tr>
					    <tr>
						    <td><label for="destination"><b>Destination of ride : </b></label></td>
						    <td><input type="text" placeholder="Enter Destination" name="destination" required></td>
						</tr>
					</table>
		      		<input class="w3-button w3-round w3-khaki" type="submit" name="offer" value="Initiate Offer" style="float:right;">
				</form>
			</div>
			<?php
				$db = pg_connect($conn_str);

				if(isset($_POST['offer'])) {
					$result = pg_query($db, "INSERT INTO offer VALUES ('$_POST[date_of_ride]', '$_POST[time_of_ride]', '$driver',  '$_POST[origin]', '$_POST[destination]')");
					if (!$result) {
						echo "Offer Invalid!<br>";
						echo pg_last_error()."<br>";
					}
					else {
						header("Location: /carpool/driver_home");
					}
				}
			?>
			<?php
				include_once ("includes/footer.php");
			?>
		</div>
	</body>
</html>