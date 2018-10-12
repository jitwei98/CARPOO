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
  </style>
</head>
<body>
	<div class="w3-container w3-black" style="position:sticky;top:0;width:100%">
		<a href="/carpool/home" style="float:left;"><h1>Car Pooling</h1></a>
		<a href="logout.php" style="float:right;padding-top: 45px">Log Out</a>
	</div>
	<div class="w3-sidebar w3-bar-block w3-dark-gray" style="width:10%"> 
		<a href="/carpool/offer_form" class="w3-bar-item w3-button">Offer A Car Pool</a>
		<a href="/carpool/driver_home" class="w3-bar-item w3-button">View Open Offers</a>
		<a href="/carpool/car_profile" class="w3-bar-item w3-button">Car Profile</a>
		<a href="/carpool/driver_history" class="w3-bar-item w3-button">History</a>
	</div>
	<div style="margin-left: 10%">
		<div class="w3-container">
			<h1>Car Profile</h1>
			<form class="w3-container" method="POST">
				<table class="w3-table-all w3-hoverable">
					<?php 
					$query_car_details = "SELECT c.plate_number, c.model, c.color FROM drive d, car c WHERE d.driver = '$driver' AND d.car = c.plate_number";
					$row = pg_fetch_assoc(pg_query($db, $query_car_details));
						// echo $result == null;
						// foreach ($result as $value) {
    		// 				echo "$value <br>";
						// }
					?>
					<tr>
						<td><label for="plate_number"><b>Plate Number : </b></label></td>
						<!-- 						<td><input type="text" placeholder="Enter Car Plate Number" name="plate_number"></td> -->
						<?php 
						echo '<td><input type="text" value="'.$row[plate_number].'" name="plate_number_updated"></td>';
						?>
					</tr>
					<tr>
						<td><label for="model"><b>Model : </b></label></td>
						<!-- <td><input type="text" placeholder="Enter Car Model" name="model"></td> -->
						<?php 
						echo '<td><input type="text" value="'.$row[model].'" name="model_updated"></td>';
						?>
					</tr>
					<tr>
						<td><label for="color"><b>Color : </b></label></td>
						<!-- <td><input type="text" placeholder="Enter Car Color" name="color"></td> -->
						<?php 
						echo '<td><input type="text" value="'.$row[color].'" name="color_updated"></td>';
						?>
					</tr>
				</table>
				<input type="submit" name="edit" value="Submit">
			</form>

			<h1>
				<?php 
				function isModified() {
					return !empty($_POST[plate_number_updated]) || !empty($_POST[model_updated]) || !empty($_POST[color_updated]);
				}

				function update_car($db, $driver, $row) {
					$plate_number = !empty($_POST[plate_number_updated]) ? $_POST[plate_number_updated] : $row[plate_number];
					$model = !empty($_POST[model_updated]) ? $_POST[model_updated] : $row[model];
					$color = !empty($_POST[color_updated]) ? $_POST[color_updated] : $row[color];
					$query = "";
					// echo $plate_number . "<br>" . $model . "<br>" . $color . "<br>";
					
					if (!empty($_POST[plate_number_updated])) {
						$result = pg_query($db, "INSERT INTO car VALUES ('$plate_number', '$model', '$color')");
						if (!$result) {
							// echo "Error: This car is already registered with another driver!<br>";
							echo pg_last_error($db) . "<br>";
						}
						$query .= "DELETE FROM drive WHERE drive = '$driver';";
						$query .= "INSERT INTO drive VALUES ('$driver', '$plate_number');";
						// $query .= "DELETE FROM  car WHERE plate_number='$row[plate_number]';";
					} else {
						$query .= "UPDATE car SET plate_number='$plate_number', model='$model', color='$color';";
					}

					return pg_query($db, $query);
				}
				
				if (!empty($_POST['edit']) && isModified()) {
					if (update_car($db, $driver, $row)) { // affected rows > 0
						// echo "Car profile successfully updated!";
						header("Location: /carpool/car_profile");
					} else {
						echo "Error updating car profile!<br>";
						echo pg_last_error($db)."<br>";
					}
				}
				?>
			</h1>
		</div>
	</div>
</body>
</html>
