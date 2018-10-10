<?php   session_start();  ?>
<?php
  if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
   {
       header("Location: /carpool");  
   }
   include_once ('includes/config.php');
	$db = pg_connect($conn_str);
	$driver = $_SESSION['use'];
	date_default_timezone_set('Asia/Singapore');
	$date_curr = date("Y/m/d");
	$time_curr = date("h/i/sa");
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
		<div class="w3-container w3-black">
			<a href="/carpool/home"><h1>Car Pooling</h1></a>
  			<a href="logout.php" style="float:right;">Log Out</a>
		</div>
		<div class="w3-sidebar w3-bar-block w3-dark-gray" style="width:10%">
			<a href="/carpool/offer_form" class="w3-bar-item w3-button">Offer A Car Pool</a>
			<a href="/carpool/driver_home" class="w3-bar-item w3-button">View Open Offers</a>
			<a href="/carpool/car_profile" class="w3-bar-item w3-button">Car Profile</a>
			<a href="/carpool/driver_history" class="w3-bar-item w3-button">History</a>
		</div>
		<div style="margin-left: 10%">
			<div class="w3-container">
				<h1>History</h1>
				<table class="w3-table-all w3-hoverable">
				<thead>
					<tr class="w3-black">
							<?php
								$result = pg_query($db, "SELECT * FROM offer o WHERE o.driver = '$driver' AND (o.date_of_ride = '$date_curr' OR o.date_of_ride > '$date_curr') AND EXISTS (SELECT * FROM bid b WHERE o.driver=b.driver AND o.date_of_ride = b.date_of_ride AND o.time_of_ride = b.time_of_ride AND b.status = 'successful')");
		   						if (pg_num_rows($result) == 0) {
		   							echo '<h3>History is empty.</h3>';
		   							echo '</tr>';
		   							echo '</thead>';
		   						}
		   						else {
	   								echo '<td>';
	   								echo "Passenger";
	   								echo '</td>';
	   								echo '<td>';
	   								echo "Bid Price";
	   								echo '</td>';
	   								echo '<td>';
	   								echo "Date of ride";
	   								echo '</td>';
	   								echo '<td>';
	   								echo "Time of ride";
	   								echo '</td>';
	   								echo '<td>';
	   								echo "Origin of ride";
	   								echo '</td>';
	   								echo '<td>';
	   								echo "Destination of ride";
	   								echo '</td>';
	   								echo '</tr>';
	   								echo '</thead>';
	   								while ($row = pg_fetch_assoc($result)) {
	   									echo '<tr>';
	   									echo '<td>';
	   									$res = pg_query($db, "SELECT * FROM bid b WHERE b.driver='$row[driver]' AND b.date_of_ride='$row[date_of_ride]' AND b.time_of_ride='$row[time_of_ride]' AND b.status='successful'");
	   									$row_p=pg_fetch_assoc($res);
		   								echo $row_p['passenger'];
		   								echo '</td>';
		   								echo '<td>';
		   								echo $row_p['price'];
		   								echo '</td>';
		   								echo '<td>';
		   								echo $row['date_of_ride'];
		   								echo '</td>';
		   								echo '<td>';
		   								echo $row['time_of_ride'];
		   								echo '</td>';
		   								echo '<td>';
		   								echo $row['origin'];
		   								echo '</td>';
		   								echo '<td>';
		   								echo $row['destination'];
		   								echo '</td>';
		   								echo '</tr>';
	   								}
								}
								echo '</table>';
							?>
			</div>
		</div>
	</body>
</html>