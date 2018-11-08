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
	<div class="w3-container w3-black" style="position:sticky;top:0;width:100%">
		<a href="/carpool/home" style="float:left;">
			<h1>Car Pooling</h1>
		</a>
		<a href="logout.php" style="float:right;padding-top: 45px">Log Out</a>
	</div>
	<div class="w3-sidebar w3-bar-block w3-dark-gray" style="width:10%">
		<a href="/carpool/offer_form" class="w3-bar-item w3-button">Offer A Car Pool</a>
		<a href="/carpool/driver_home" class="w3-bar-item w3-button">View Open Offers</a>
		<a href="/carpool/car_profile" class="w3-bar-item w3-button">Car Profile</a>
		<!-- <a href="/carpool/driver_profile" class="w3-bar-item w3-button">Driver Profile</a> -->
		<a href="/carpool/driver_history" class="w3-bar-item w3-button">History</a>
	</div>
	<div style="margin-left: 11%">
		<h1>Driver Dashboard</h1>
		<h2>All in Review</h2>
		<div class="w3-cell-row">
			<div class="w3-cell w3-border">
				<h4 align="center">Number of Trips</h4>
				<?php
                    $result = pg_query($db, 
                    "SELECT COUNT(*) FROM bid 
                    WHERE driver = '$driver'
					AND status = 'successful'");
                    $count_trips = pg_fetch_assoc($result)['count'];
                    echo '<h2 align="center">'.$count_trips.'</h2>';
                ?>
			</div>
			<div class="w3-cell w3-border">
				<h4 align="center">Amount Earned</h4>
				<?php
                    $result = pg_query($db, 
                    "SELECT SUM(price) FROM bid 
                    WHERE driver = '$driver'
					AND status = 'successful'");
                    $total_earnings = pg_fetch_assoc($result)['sum'];
                    echo '<h2 align="center">$'.number_format($total_earnings, 2).'</h2>';
                ?>
			</div>
			<div class="w3-cell w3-border">
				<h4 align="center">Average per Trip</h4>
				<?php
                    $result = pg_query($db, 
                    "SELECT AVG(price) FROM bid 
                    WHERE driver = '$driver'
					AND status = 'successful'");
                    $average_earnings = pg_fetch_assoc($result)['avg'];
                    echo '<h2 align="center">$'.number_format($average_earnings, 2).'</h2>';
                ?>
			</div>
		</div>
	</div>
</body>

</html>