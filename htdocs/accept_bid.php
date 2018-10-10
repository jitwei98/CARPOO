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
		<script>
			function goBack() {
				window.history.back();
			}
		</script>
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
				<h1>Accept Bid?</h1>
				<form class="w3-container" method="POST">
					<!-- <label for="price"><b>Bid Price : $</b></label> -->
					<!-- <input type="text" name="price" placeholder="Enter Bid Value"> -->
		      		<input type="submit" name="accept" value="Accept">
		      		<button onclick="goBack()">Go Back</button>
				</form>

				<?php
				$offer_date = $_GET['d_offer'];
				$offer_time = $_GET['t_offer'];
				$driver = $_SESSION['use'];
				$passenger = $_GET['passenger'];
				$price = $_GET['price'];

				include_once ('includes/config.php');
				$db = pg_connect($conn_str);

				if (isset($_POST['accept'])) {
					// TODO: reject all other bids for the same offer
					$result = pg_query($db, "UPDATE bid SET status = 'successful' WHERE date_of_ride = '$offer_date' AND time_of_ride = '$offer_time' AND driver = '$driver' AND passenger = '$passenger' AND price = '$price' AND status = 'pending'");
					if (!$result) {
						echo pg_last_error($db)."<br>";
					}
					else {
						header("Location: /carpool/driver_home");
					}
				}
				?>
			</div>
		</div>
	</body>
</html>