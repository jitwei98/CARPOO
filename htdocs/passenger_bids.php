<?php   session_start();  ?>
<?php
  if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
  {
  	header("Location: /carpool");  
  }
  include_once ('includes/config.php');
  $db = pg_connect($conn_str);
  $user = $_SESSION['use'];
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
  	td a{ 
  		display: block; 
  	}
  </style>
</head>
<body>
	<div class="w3-container w3-black" style="position:sticky;top:0;width:100%">
		<a href="/carpool/home" style="float:left;"><h1>Car Pooling</h1></a>
		<a href="logout.php" style="float:right;padding-top: 45px">Log Out</a>
	</div>
	<div class="w3-sidebar w3-bar-block w3-dark-gray" style="width:10%"> 
	  <a href="/carpool/passenger_home" class="w3-bar-item w3-button">Search for Car Pool</a>
	  <a href="/carpool/passenger_bids" class="w3-bar-item w3-button">View Bids</a>
	  <a href="/carpool/user_profile" class="w3-bar-item w3-button">User Profile</a>
	  <a href="/carpool/passenger_history" class="w3-bar-item w3-button">Car Pool History</a>
	</div>
	<div style="margin-left: 10%">
		<div class="w3-row">
		    <a href="javascript:void(0)" onclick="openBid(event, 'Accepted');">
		      <div class="w3-third tablink w3-bottombar w3-hover-light-grey w3-padding w3-border-red">Accepted</div>
		    </a>
		    <a href="javascript:void(0)" onclick="openBid(event, 'Pending');">
		      <div class="w3-third tablink w3-bottombar w3-hover-light-grey w3-padding">Pending</div>
		    </a>
		    <a href="javascript:void(0)" onclick="openBid(event, 'Rejected');">
		      <div class="w3-third tablink w3-bottombar w3-hover-light-grey w3-padding">Rejected</div>
		    </a>
	  	</div>
		<div id="Accepted" class="w3-container bid_type" style="display:block">
			<h2>Accepted Bids</h2>
			<?php
				$result = pg_query($db, "SELECT * FROM bid WHERE status = 'successful' AND passenger = '$user'");
				if (pg_num_rows($result) == 0) {
					echo 'No accepted bids.';
				}
				else {
					echo '<table class="w3-table-all w3-hoverable">';
					echo '<thead>';
					echo '<tr>';
					echo '<th>Driver</th>';
					echo '<th>Origin of Ride</th>';
					echo '<th>Destination of Ride</th>';
					echo '<th>Date of Ride</th>';
					echo '<th>Time of Ride</th>';
					echo '<th>Price Offered</th>';
					echo '<th>Status</th>';
					echo '</tr></thead>';
					while ($row = pg_fetch_assoc($result)) {
						$offer_result = pg_query($db, "SELECT origin, destination FROM offer WHERE driver='$row[driver]' AND date_of_ride='$row[date_of_ride]' AND time_of_ride='$row[time_of_ride]'");
						$row_offer = pg_fetch_assoc($offer_result);
						echo '<tr>';
						echo '<td>', $row['driver'], '</td>';
						echo '<td>', $row_offer['origin'], '</td>';
						echo '<td>', $row_offer['destination'], '</td>';
						echo '<td>', $row['date_of_ride'], '</td>';
						echo '<td>', $row['time_of_ride'], '</td>';
						echo '<td>', $row['price'], '</td>';
						echo '<td>', $row['status'], '</td>';
						echo '</tr>';
					}
					echo '</table>';
				}
			?>
		</div>

		<div id="Pending" class="w3-container bid_type" style="display:none">
			<h2>Pending Bids</h2>
						<?php
				$result = pg_query($db, "SELECT * FROM bid WHERE status = 'pending' AND passenger = '$user'");
				if (pg_num_rows($result) == 0) {
					echo 'No accepted bids.';
				}
				else {
					echo '<table class="w3-table-all w3-hoverable">';
					echo '<thead>';
					echo '<tr>';
					echo '<th>Driver</th>';
					echo '<th>Origin of Ride</th>';
					echo '<th>Destination of Ride</th>';
					echo '<th>Date of Ride</th>';
					echo '<th>Time of Ride</th>';
					echo '<th>Price Offered</th>';
					echo '<th>Status</th>';
					echo '</tr></thead>';
					while ($row = pg_fetch_assoc($result)) {
						$offer_result = pg_query($db, "SELECT origin, destination FROM offer WHERE driver='$row[driver]' AND date_of_ride='$row[date_of_ride]' AND time_of_ride='$row[time_of_ride]'");
						$row_offer = pg_fetch_assoc($offer_result);
						echo '<tr>';
						echo '<td>', $row['driver'], '</td>';
						echo '<td>', $row_offer['origin'], '</td>';
						echo '<td>', $row_offer['destination'], '</td>';
						echo '<td>', $row['date_of_ride'], '</td>';
						echo '<td>', $row['time_of_ride'], '</td>';
						echo '<td>', $row['price'], '</td>';
						echo '<td>', $row['status'], '</td>';
						echo '</tr>';
					}
					echo '</table>';
				}
			?>
		</div>

		<div id="Rejected" class="w3-container bid_type" style="display:none">
			<h2>Rejected Bids</h2>
						<?php
				$result = pg_query($db, "SELECT * FROM bid WHERE status = 'unsuccessful' AND passenger = '$user'");
				if (pg_num_rows($result) == 0) {
					echo 'No accepted bids.';
				}
				else {
					echo '<table class="w3-table-all w3-hoverable">';
					echo '<thead>';
					echo '<tr>';
					echo '<th>Driver</th>';
					echo '<th>Origin of Ride</th>';
					echo '<th>Destination of Ride</th>';
					echo '<th>Date of Ride</th>';
					echo '<th>Time of Ride</th>';
					echo '<th>Price Offered</th>';
					echo '<th>Status</th>';
					echo '</tr></thead>';
					while ($row = pg_fetch_assoc($result)) {
						$offer_result = pg_query($db, "SELECT origin, destination FROM offer WHERE driver='$row[driver]' AND date_of_ride='$row[date_of_ride]' AND time_of_ride='$row[time_of_ride]'");
						$row_offer = pg_fetch_assoc($offer_result);
						echo '<tr>';
						echo '<td>', $row['driver'], '</td>';
						echo '<td>', $row_offer['origin'], '</td>';
						echo '<td>', $row_offer['destination'], '</td>';
						echo '<td>', $row['date_of_ride'], '</td>';
						echo '<td>', $row['time_of_ride'], '</td>';
						echo '<td>', $row['price'], '</td>';
						echo '<td>', $row['status'], '</td>';
						echo '</tr>';
					}
					echo '</table>';
				}
			?>
		</div>
	</div>
	<script>
	function openBid(evt, cityName) {
	  var i, x, tablinks;
	  x = document.getElementsByClassName("bid_type");
	  for (i = 0; i < x.length; i++) {
	     x[i].style.display = "none";
	  }
	  tablinks = document.getElementsByClassName("tablink");
	  for (i = 0; i < x.length; i++) {
	     tablinks[i].className = tablinks[i].className.replace(" w3-border-red", "");
	  }
	  document.getElementById(cityName).style.display = "block";
	  evt.currentTarget.firstElementChild.className += " w3-border-red";
	}
	</script>
</body>
</html>
