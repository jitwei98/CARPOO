<?php   session_start();  ?>
<?php
	// If session is not set or user is not admin then redirect to Login Page
if(!isset($_SESSION['use'])) 
{
	header("Location: /carpool");  
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<style>
	a {
		text-decoration: none;
	}
	td a { 
		display: block; 
	}
</style>
</head>
<body>
	<div class="w3-container w3-black w3-top">
		<a href="/carpool/home" style="float:left;"><h1>Car Pooling</h1></a>
		<a href="logout.php" style="float:right;padding-top: 45px">Log Out</a>
	</div>
	<div class="w3-sidebar w3-bar-block w3-dark-gray" style="width:10%"> 
		<a href="/carpool/admin_home" class="w3-bar-item w3-button">app_user</a>
		<a href="/carpool/admin_bid" class="w3-bar-item w3-button">bid</a>
		<a href="/carpool/admin_car" class="w3-bar-item w3-button">car</a>
		<a href="/carpool/admin_drive" class="w3-bar-item w3-button">drive</a>
		<a href="/carpool/admin_offer" class="w3-bar-item w3-button">offer</a>
	</div>
	<div style="margin-left: 10%; margin-top:74px;">
		<div class="w3-container">
			<h1>offer</h1>
			<form class="w3-container" method="POST">
				<table class="w3-table-all w3-hoverable">
					<?php 
					include_once ('includes/config.php');
					$db = pg_connect($conn_str);
					$result = pg_query($db, "SELECT * FROM offer WHERE 
						date_of_ride='$_GET[edit_date]' AND
						time_of_ride='$_GET[edit_time]' AND
						driver='$_GET[edit_driver]';");
					if (pg_num_rows($result) == 0) {
						echo "<h6>Offer not found!<br></h6>";
						echo "<a class=\"w3-button w3-black\" href='admin_offer.php'>Go Back</a>";
					} else if (!$result) {
						echo pg_last_error($db)."<br>";
					} else {
						$row = pg_fetch_assoc($result);
						?>
						<!-- TODO: Follow index.php -->
						<tr>
							<td><label for="date_of_ride"><b>Date of ride : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['date_of_ride'].'" name="date_of_ride_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="time_of_ride"><b>Time of ride : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['time_of_ride'].'" name="time_of_ride_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="driver"><b>Driver : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['driver'].'" name="driver_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="origin"><b>Origin : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['origin'].'" name="origin_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="destination"><b>Destination : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['destination'].'" name="destination_updated"></td>'; ?>
						</tr>
				</table>
				<input type="submit" name="edit" value="Submit">
				<?php }?>
			</form>


			<!-- Update in database -->
			<h1>
				<?php 
				date_default_timezone_set('Asia/Singapore');
				$date_curr = date("Y/m/d");
				$time_curr = date("h/i/sa");

				function isModified() {
					return !empty($_POST[date_of_ride_updated]) || 
							!empty($_POST[time_of_ride_updated]) || 
							!empty($_POST[driver_updated]) || 
							!empty($_POST[origin_updated]) || 
							!empty($_POST[destination_updated]);
				}

				function update_offer($db, $row) {
					$date_of_ride = !empty($_POST[date_of_ride_updated]) ? $_POST[date_of_ride_updated] : $row[date_of_ride];
					$time_of_ride = !empty($_POST[time_of_ride_updated]) ? $_POST[time_of_ride_updated] : $row[model];
					$driver = !empty($_POST[driver_updated]) ? $_POST[driver_updated] : $row[driver];
					$origin = !empty($_POST[origin_updated]) ? $_POST[origin_updated] : $row[origin];
					$destination = !empty($_POST[destination_updated]) ? $_POST[destination_updated] : $row[destination];
					
					$query = "UPDATE offer SET 
								date_of_ride='$date_of_ride', 
								time_of_ride='$time_of_ride', 
								driver='$driver',
								origin='$origin', 
								destination='$destination'
								WHERE date_of_ride='$_GET[edit_date]' AND
								time_of_ride='$_GET[edit_time]' AND
								driver='$_GET[edit_driver]';";

					return pg_query($db, $query);
				}
				
				if (!empty($_POST['edit']) && isModified()) {
					if (update_offer($db, $row)) { // affected rows > 0
						$url = 'Location: /carpool/admin_offer';
						header($url);
					} else {
						echo "Error updating offer!<br>";
						echo pg_last_error($db)."<br>";
					}
				}
				?>
			</h1>


		</div>
	</div>
</body>
</html>
