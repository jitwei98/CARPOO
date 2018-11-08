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
		  <a href="#" class="w3-bar-item w3-button">Car Pool History</a>
		</div>
		<div style="margin-left: 10%">
			<div class="w3-container">
				<h1>Bid For Carpool Offer</h1>
				<form class="w3-container" method="POST">
					<label for="price"><b>Bid Price : $</b></label>
					<input type="text" name="price" placeholder="Enter Bid Value">
		      		<input type="submit" name="bid" value="Submit Bid">
				</form>
				<?php
					$passenger = $_SESSION['use'];
					$offer_driver = $_GET['driver'];
					$offer_date = $_GET['d_offer'];
					$offer_time = $_GET['t_offer'];
					include_once ('includes/config.php');
					$db = pg_connect($conn_str);
					if (isset($_POST['bid'])) {
						$result = pg_query($db, "INSERT INTO bid VALUES ('$offer_date', '$offer_time', '$offer_driver', '$passenger', '$_POST[price]', 'pending')");
						if (!$result) {
							echo "Bid Invalid!<br>";
							echo pg_last_error($db)."<br>";
						}
						else {
							header("Location: /carpool/passenger_home");
						}
					}
				?>
			</div>
		</div>
	</body>
</html>