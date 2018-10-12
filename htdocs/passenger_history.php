<?php   session_start();  ?>
<?php
  if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
   {
       header("Location: /carpool");  
   }
?>
<!DOCTYPE html>
 <html>
<!-- header -->
<?php include_once('includes/header.php'); ?>

<body>

<!-- navigation -->
<?php include_once('includes/navbar_passenger.php'); ?>

		<div style="margin-left: 10%; margin-right:10%; padding-top: 50px" class="w3-container">
				<h1>History</h1>
				<table class="w3-table-all w3-hoverable">
					<tr class="w3-light gray">
					<?php
					$db = pg_connect("host=localhost port=5432 dbname=carpool user=postgres password=test");
					date_default_timezone_set('Asia/Singapore');
					$date_curr = date("Y/m/d");
					$time_curr = date("h/i/sa");
					$user = $_SESSION['use'];
					include_once ('includes/config.php');
					$db = pg_connect($conn_str);

					$result = pg_query($db, "SELECT * FROM offer o, bid b WHERE o.date_of_ride = b.date_of_ride AND o.time_of_ride = b.time_of_ride AND o.driver = b.driver AND b.passenger = '$user' ORDER BY b.date_of_ride ASC");
					if (pg_num_rows($result) == 0) {
						echo 'History is empty. </tr>';
					} else {
						echo '<h3>', pg_num_rows($result), " previous bid(s) </h3>";
						echo '<thead>
								<th><input type="checkbox" id="chkParent" /></th>
								<th>Driver</th>
								<th>Origin of Ride</th>
								<th>Destination of Ride</th>
								<th>Date of Ride</th>
								<th>Time of Ride</th>
								<th>Price Offered</th>
								<th>Status</th>
								</thead>';
						while($row = pg_fetch_assoc($result)) {
							echo '<tr>';
							echo '<td><input name="selected_row[]" value="'.$row['id'].'" type="checkbox" /></td>';
							echo '<td>', $row['driver'], '</td>';
							echo '<td>', $row['origin'], '</td>';
							echo '<td>', $row['destination'], '</td>';
							echo '<td>', $row['date_of_ride'], '</td>';
							echo '<td>', $row['time_of_ride'], '</td>';
							echo '<td>', $row['price'], '</td>';
							echo '<td>', $row['status'], '</td>';
							echo '</tr>';
						}
					}
					?>
				</table>
		</div>
		<?
	</body>
</html>



