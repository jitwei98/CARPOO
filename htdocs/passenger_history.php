<?php   session_start();  ?>
<?php
  if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
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
		<div class="w3-container w3-black" style="position:sticky;top:0;width:100%">
			<a href="/carpool/home"><h1>Car Pooling</h1></a>
  			<a href="logout.php" style="float:right;">Log Out</a>
		</div>
		<div class="w3-sidebar w3-bar-block w3-dark-gray" style="width:10%"> 
		  <a href="/carpool/passenger_home" class="w3-bar-item w3-button">Search for Car Pool</a>
		  <a href="/carpool/user_profile" class="w3-bar-item w3-button">User Profile</a>
		  <a href="#" class="w3-bar-item w3-button">Car Pool History</a>
		</div>
		<div style="margin-left: 10%" class="w3-container">
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

					$result = pg_query($db, "SELECT * FROM offer o, bid b WHERE o.date_of_ride = b.date_of_ride AND o.time_of_ride = b.time_of_ride AND o.driver = b.driver AND b.passenger = '$user'");
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
	</body>
</html>



