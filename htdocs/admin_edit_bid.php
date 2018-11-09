<?php   session_start();  ?>
<?php
	include_once ('includes/check_admin.php');
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
	<?php 
		// include_once ('includes/navbar.php');
		// include_once ('includes/admin_sidenav.php');
		include_once ('includes/header.php');
		include_once ('includes/admin_navbar.php');
	?>
		<div class="w3-container page_container">
			<h1>bid</h1>
			<form class="w3-container" method="POST">
				<table class="w3-table-all w3-hoverable">
					<?php 
					include_once ('includes/config.php');
					$db = pg_connect($conn_str);
					$result = pg_query($db, "SELECT * FROM bid WHERE 
						date_of_ride='$_GET[edit_date]' AND 
						time_of_ride='$_GET[edit_time]' AND
						driver='$_GET[edit_driver]' AND
						passenger='$_GET[edit_passenger]'
						");
					if (pg_num_rows($result) == 0) {
						echo "<h6>Bid not found!<br></h6>";
					} else if (!$result) {
						echo pg_last_error($db)."<br>";
					} else {
						$row = pg_fetch_assoc($result);
						?>
						<!-- TODO: Follow index.php -->
						<tr>
							<td><label for="date_of_ride"><b>date of ride : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['date_of_ride'].'" name="date_of_ride_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="time_of_ride"><b>time of ride : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['time_of_ride'].'" name="time_of_ride_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="driver"><b>driver : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['driver'].'" name="driver_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="passenger"><b>passenger : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['passenger'].'" name="passenger_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="price"><b>price : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['price'].'" name="price_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="status"><b>status : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['status'].'" name="status_updated"></td>'; ?>
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
							!empty($_POST[passenger_updated]) ||
							!empty($_POST[price_updated]) ||
							!empty($_POST[status_updated])
							;
				}

				function update_bid($db, $row) {
					$date_of_ride = !empty($_POST[date_of_ride_updated]) ? $_POST[date_of_ride_updated] : $row[date_of_ride];
					$time_of_ride = !empty($_POST[time_of_ride_updated]) ? $_POST[time_of_ride_updated] : $row[time_of_ride];
					$driver = !empty($_POST[driver_updated]) ? $_POST[driver_updated] : $row[driver];
					$passenger = !empty($_POST[passenger_updated]) ? $_POST[passenger_updated] : $row[passenger];
					$price = !empty($_POST[price_updated]) ? $_POST[price_updated] : $row[price];
					$status = !empty($_POST[status_updated]) ? $_POST[status_updated] : $row[status];
					
					$query = "UPDATE bid SET 
								date_of_ride='$date_of_ride', 
								time_of_ride='$time_of_ride', 
								driver='$driver', 
								passenger='$passenger', 
								price='$price', 
								status='$status' 
								WHERE date_of_ride='$_GET[edit_date]' AND
										time_of_ride='$_GET[edit_time]' AND
										driver='$_GET[edit_driver]' AND
										passenger='$_GET[edit_passenger]'
								 ;";

					return pg_query($db, $query);
				}
				
				if (!empty($_POST['edit']) && isModified()) {
					if (update_bid($db, $row)) { // affected rows > 0
						// echo "Bid successfully updated!<br>";
						// $url = 'Location: /carpool/admin_edit_bid.php?edit_date='.
						// 		$row['date_of_ride'].'&edit_time='.
						// 		$row['time_of_ride'].'&edit_driver='.
						// 		$row['driver'].'&edit_passenger='.
						// 		$row['passenger'];
						$url = 'Location: /carpool/admin_bid';
						header($url);
					} else {
						echo "Error updating bid!<br>";
						echo pg_last_error($db)."<br>";
					}
				}
				?>
			</h1>


		</div>
	</div>
</body>
</html>
