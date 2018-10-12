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

<div style="margin-left: 10%; margin-right:10%; padding-top: 10px">
	<div class="w3-container">
		<h1>Open carpool offers</h1>
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
			    	echo '<h3>';
			    	echo pg_num_rows($result); // Use this or COUNT again?
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
		</div>
	</div>
	<!-- copyright section -->
<?php include_once('includes/footer.php') ?>
</body>
</html>



