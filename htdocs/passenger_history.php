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
		<div class="w3-container w3-black">
			<a href="/carpool/home"><h1>Car Pooling</h1></a>
  			<a href="logout.php" style="float:right;">Log Out</a>
		</div>
		<div class="w3-sidebar w3-bar-block w3-dark-gray" style="width:10%"> 
		  <a href="/carpool/passenger_home" class="w3-bar-item w3-button">Search for Car Pool</a>
		  <a href="/carpool/user_profile" class="w3-bar-item w3-button">User Profile</a>
		  <a href="#" class="w3-bar-item w3-button">Car Pool History</a>
		</div>
		<div style="margin-left: 10%">
			<div class="w3-container">
				<h1>History</h1>
				<table class="w3-table-all w3-hoverable">
					<thead>
						<tr class="w3-light gray">
						<?php
						$db = pg_connect("host=localhost port=5432 dbname=carpool user=postgres password=test");
						date_default_timezone_set('Asia/Singapore');
						$date_curr = date("Y/m/d");
						$time_curr = date("h/i/sa");
					   	$user = $_SESSION['use'];
						include_once ('includes/config.php');
						$db = pg_connect($conn_str);

					    $result = pg_query($db, "SELECT * FROM offer o, bid b WHERE o.date_of_ride = b.date_of_ride AND o.time_of_ride = b.time_of_ride AND o.driver = b.driver AND b.passenger = '$user' AND o.date_of_ride < '$date_curr'");
					    if (pg_num_rows($result) == 0) {
					    	echo "History is empty.";
					    	echo '</tr>';
					    } else {
					    	echo '<h3>';
					    	echo pg_num_rows($result);
					    	echo " previous bid(s)";
					    	echo '</h3>';
					    	echo '<tr>';
					    	echo '<td>';
					    	echo "Driver";
					    	echo '</td>';
					    	echo '<td>';
					    	echo "Origin of ride";
					    	echo '</td>';
					    	echo '<td>';
					    	echo "Destination of ride";
					    	echo '</td>';
					    	echo '<td>';
					    	echo "Date of ride";
					    	echo '</td>';
					    	echo '<td>';
					    	echo 'Time of ride';
					    	echo '</td>';
					    	echo '<td>';
					    	echo 'Price offered';
					    	echo '</td>';
							echo '<td>';
					    	echo 'Status';
					    	echo '</td>';					    	
					    	echo '</tr>';
					    	echo '</thead>';
					    	while($row = pg_fetch_assoc($result)) {
					    		echo '<tr>';
								echo $row['driver'];
								echo '</a></td>';
								echo $row['origin'];
								echo '</a></td>';
								echo $row['destination'];
								echo '</a></td>';
								echo $row['date_of_ride'];
								echo '</a></td>';
								echo $row['time_of_ride'];
								echo '</a></td>';
								echo $row['price'];
								echo '</a></td>';
								echo $row['status'];
								echo '</a></td>';
								echo '</tr>';
					    	}
					    }
					    echo '</table>';
						?>
	</body>
</html>



