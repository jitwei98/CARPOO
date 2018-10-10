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
		<?php 
		$result = pg_query($db, "SELECT * FROM offer where driver = '$driver' and (date_of_ride = '$date_curr' OR date_of_ride > '$date_curr')");
			// if (pg_num_rows($result) == 0) {
				// echo '<a href="/carpool/offer_form" class="w3-bar-item w3-button">Initiate Car Pool</a>';
			// }
		  	// else {
		  		// echo '<a href="/carpool/driver_home" class="w3-bar-item w3-button">View Car Pool Offers</a>';
		  	// }
		?>
		<a href="/carpool/offer_form" class="w3-bar-item w3-button">Create Car Pool Offers</a>
		<a href="/carpool/driver_home" class="w3-bar-item w3-button">View Car Pool Offered</a>
		<a href="/carpool/car_profile" class="w3-bar-item w3-button">Car Profile</a>
		<!-- <a href="/carpool/driver_profile" class="w3-bar-item w3-button">Driver Profile</a> -->
		<a href="/carpool/driver_history" class="w3-bar-item w3-button">Car Pool History</a>
	</div>
	<div style="margin-left: 10%">
		<div class="w3-container">
			<h1>Open Carpool Offers</h1>
			<table class="w3-table-all w3-hoverable">
				<thead>
					<tr class="w3-black">
						<h3>
							<?php
							if (pg_num_rows($result) == 0) {
								echo "No open offer currently";
								echo '</h3>';
								echo '</tr>';
								echo '</thead>';
							}
							else {
								$row = pg_fetch_assoc($result);
								echo $row['date_of_ride'];
								echo ", ";
								echo $row['time_of_ride'];
								echo ", ";
								echo $row['origin'];
								echo " to ";
								echo $row['destination'];
								echo '</h2>';
								echo '</tr>';
								echo '</thead>';
								$res = pg_query($db, "SELECT * FROM bid where driver='$driver' and status='pending'");
								echo '<thead>';
								echo '<tr class="w3-light-grey">';
								if (pg_num_rows($res) == 0) {
									echo "No current bids";
									echo '</tr>';
									echo '</thead>';
								} else {
									echo '<td>';
									echo "Passenger";
									echo '</td>';
									echo '<td>';
									echo "Bid Price";
									echo '</td>';
									echo '</tr>';
									echo '</thead>';
									while ($row = pg_fetch_assoc($res)) {
										echo '<tr>';
										echo '<td><a href="/carpool/accept_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'&passenger='.$row['passenger'].'&price='.$row['price'].'">';
										echo $row['passenger'];
										echo '</a></td>';
										echo '<td><a href="/carpool/accept_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'&passenger='.$row['passenger'].'&price='.$row['price'].'">';
										echo $row['price'];
										echo '</a></td>';
										echo '</tr>';
									}
									echo '</table>';
								}
							}
							?>
						</div>
					</div>
				</body>
				</html>