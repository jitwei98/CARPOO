<?php   session_start();  ?>
<?php
	include_once ('includes/check_user.php');
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
			include_once ('includes/navbar.php');
		?>
		<div class="w3-sidebar w3-bar-block w3-dark-gray" style="width:10%"> 
		  <a href="/carpool/passenger_home" class="w3-bar-item w3-button">Search for Car Pool</a>
		  <a href="/carpool/user_profile" class="w3-bar-item w3-button">User Profile</a>
		  <a href="/carpool/passenger_history" class="w3-bar-item w3-button">Car Pool History</a>
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
					   	$user = $_SESSION['use'];
						include_once ('includes/config.php');
						$db = pg_connect($conn_str);
					    // $result = pg_query($db, "SELECT * FROM offer WHERE driver <> '$user' AND date_of_ride >= '$date_curr'");
					    $result = pg_query($db, "SELECT * FROM offer o WHERE o.driver <> '$user' AND (o.date_of_ride = '$date_curr' OR o.date_of_ride > '$date_curr') AND NOT EXISTS (SELECT * FROM bid b WHERE o.driver=b.driver AND o.date_of_ride = b.date_of_ride AND o.time_of_ride = b.time_of_ride AND (b.status = 'successful' OR b.passenger = '$user'))");
					    if(pg_num_rows($result) == 0) {
					    	echo "No open offers currently.";
					    	echo '</tr>';
					    }
					    else {
					    	echo '<div><h3>';
					    	echo pg_num_rows($result); // Use this or COUNT again?
					    	echo " offer(s) open";
					    	echo '</h3><p><form method="POST"><input type="text" name="query"><input type="submit" name="search" value="Search"></form></p></div>';
							echo '<thead>';
					    	echo '<th>';
					    	echo "Driver";
					    	echo '</th>';
					    	echo '<th>';
					    	echo "Origin of ride";
					    	echo '</th>';
					    	echo '<th>';
					    	echo "Destination of ride";
					    	echo '</th>';
					    	echo '<th>';
					    	echo "Date of ride";
					    	echo '</th>';
					    	echo '<th>';
					    	echo 'Time of ride';
					    	echo '</th>';
					    	echo '</thead>';
					    	if (isset($_POST['search'])) {
					    		$result_query = pg_query($db, "SELECT * FROM offer o WHERE  o.driver <> '$user' AND (o.date_of_ride = '$date_curr' OR o.date_of_ride > '$date_curr') AND (o.origin LIKE '%$_POST[query]%' OR o.destination LIKE '%$_POST[query]%')");
					    		// $result = pg_query($db, "SELECT * FROM offer o WHERE o.driver <> '$user' AND (o.date_of_ride = '$date_curr' OR o.date_of_ride > '$date_curr') AND (o.origin LIKE '$_POST[query]' OR o.destination LIKE '$_POST[query]') AND NOT EXISTS (SELECT * FROM bid b WHERE o.driver=b.driver AND o.date_of_ride = b.date_of_ride AND o.time_of_ride = b.time_of_ride AND (b.status = 'successful' OR b.passenger = '$user'))");
					    		$result = $result_query;
					    	}
					    	while($row = pg_fetch_assoc($result)) {
					    		echo '<tr>';
								echo '<td><a href="/carpool/make_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'">';
								echo $row['driver'];
								echo '</a></td>';
								echo '<td><a href="/carpool/make_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'">';
								echo $row['origin'];
								echo '</a></td>';
								echo '<td><a href="/carpool/make_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'">';
								echo $row['destination'];
								echo '</a></td>';
								echo '<td><a href="/carpool/make_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'">';
								echo $row['date_of_ride'];
								echo '</a></td>';
								echo '<td><a href="/carpool/make_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'">';
								echo $row['time_of_ride'];
								echo '</a></td>';
								echo '</tr>';
					    	}
					    }
					    echo '</table>';
						?>
	</body>
</html>



