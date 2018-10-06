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
		</style>
	</head>
	<body>
		<div class="w3-container w3-black">
			<a href="/carpool/home"><h1>Car Pooling</h1></a>
  			<a href="logout.php" style="float:right;">Log Out</a>
		</div>
		<div class="w3-sidebar w3-bar-block w3-dark-gray" style="width:10%"> 
		  <a href="#" class="w3-bar-item w3-button">Search for Car Pool</a>
		  <a href="#" class="w3-bar-item w3-button">User Profile</a>
		  <a href="#" class="w3-bar-item w3-button">Car Pool History</a>
		</div>
		<div style="margin-left: 10%">
			<div class="w3-container">
				<h1>Open Carpool Offers</h1>
				<table class="w3-table-all w3-hoverable">
					<thead>
						<tr class="w3-light gray">
						<?php
						$db = pg_connect("host=localhost port=5432 dbname=carpool user=postgres password=test");
						date_default_timezone_set('Asia/Singapore');
						$date_curr = date("Y/m/d");
						$time_curr = date("h/i/sa");
						$db = pg_connect("host=localhost port=5432 dbname=carpool user=postgres password=test");
					    $result = pg_query($db, "SELECT * FROM offer WHERE (date_of_ride = '$date_curr') OR (date_of_ride > '$date_curr')");
					    if(pg_num_rows($result) == 0) {
					    	echo "No open offers currently.";
					    	echo '</tr>';
					    }
					    else {
					    	echo '<h3>';
					    	echo pg_num_rows($result);
					    	echo " offer(s) open";
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
					    	echo '<tr>';
					    	echo '</thead>';
					    	while($row = pg_fetch_assoc($result)) {
					    		echo '<tr>';
					    		echo '<a href="#">';
								echo '<td>';
								echo $row['driver'];
								echo '</td>';
								echo '<td>';
								echo $row['origin'];
								echo '</td>';
								echo '<td>';
								echo $row['destination'];
								echo '</td>';
								echo '<td>';
								echo $row['date_of_ride'];
								echo '</td>';
								echo '<td>';
								echo $row['time_of_ride'];
								echo '</td>';
								echo '</a>';
								echo '</tr>';
					    	}
					    }
					    echo '</table>';
						?>
	</body>
</html>



