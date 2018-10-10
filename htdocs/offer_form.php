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
		  <a href="/carpool/offer_form" class="w3-bar-item w3-button">Initiate Car Pool</a>
		  <a href="/carpool/car_profile" class="w3-bar-item w3-button">Car Profile</a>
		  <a href="#" class="w3-bar-item w3-button">Driver Profile</a>
		  <a href="#" class="w3-bar-item w3-button">Car Pool History</a>
		</div>
		<div style="margin-left: 10%">
			<div class="w3-container">
				<form class="w3-container" method="POST">
					<h1>Initiate Carpool Offer</h1>
				    <label for="date_of_ride"><b>Date of ride</b></label>
				    <input type="date" placeholder="Enter Date" name="date_of_ride" required>
				    <hr>
				    <label for="time_of_ride"><b>Time of ride</b></label>
				    <input type="time" placeholder="Enter Time" name="time_of_ride" required>
				    <hr>
				    <label for="origin"><b>Origin of trip</b></label>
				    <input type="text" placeholder="Enter Origin" name="origin" required>
				    <hr>
				    <label for="destination"><b>Destination of ride</b></label>
				    <input type="text" placeholder="Enter Destination" name="destination" required>
				    <hr>
		      		<input type="submit" name="offer" value="Initiate Offer">
				</form>
			</div>
		</div>
		<?php
		$driver = $_SESSION['use'];
		include_once ('includes/config.php');
		$db = pg_connect($conn_str);
		$result = pg_query($db, "INSERT INTO offer VALUES ('$_POST[date_of_ride]', '$_POST[time_of_ride]', '$driver',  '$_POST[origin]', '$_POST[destination]')");
		if (!$result) {
			echo "Offer Invalid!";
		}
		else {
			header("Location: /carpool/driver_home");
		}
		?>
	</body>
</html>