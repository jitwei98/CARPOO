<?php   session_start();  ?>
<?php
  if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
  {
  	header("Location: /carpool");  
  }
  $db = pg_connect("host=localhost port=5432 dbname=carpool user=postgres password=test");
  $driver = $_SESSION['use'];
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
		<a href="#" class="w3-bar-item w3-button">Initiate Car Pool</a>
		<a href="#" class="w3-bar-item w3-button">Car Profile</a>
		<a href="#" class="w3-bar-item w3-button">Driver Profile</a>
		<a href="#" class="w3-bar-item w3-button">Car Pool History</a>
	</div>
	<div style="margin-left: 10%">
		<div class="w3-container">
			<h1>Car Profile</h1>
			<form class="w3-container" method="POST">
				<table class="w3-table-all w3-hoverable">
					<?php 
						$query_car_details = "SELECT c.plate_number, c.model, c.color FROM drive d, car c WHERE d.driver = '$driver' AND d.car = c.plate_number";
						$result = pg_fetch_row(pg_query($db, $query_car_details));
						// echo $result == null;
						// foreach ($result as $value) {
    		// 				echo "$value <br>";
						// }
					?>
					<tr>
						<td><label for="plate_number"><b>Plate Number : </b></label></td>
<!-- 						<td><input type="text" placeholder="Enter Car Plate Number" name="plate_number"></td> -->
						<?php 
							echo '<td><input type="text" placeholder="'.$result[0].'" name="plate_number"></td>';
						?>
					</tr>
					<tr>
						<td><label for="model"><b>Model : </b></label></td>
						<!-- <td><input type="text" placeholder="Enter Car Model" name="model"></td> -->
						<?php 
							echo '<td><input type="text" placeholder="'.$result[1].'" name="plate_number"></td>';
						?>
					</tr>
					<tr>
						<td><label for="color"><b>Color : </b></label></td>
						<!-- <td><input type="text" placeholder="Enter Car Color" name="color"></td> -->
						<?php 
							echo '<td><input type="text" placeholder="'.$result[2].'" name="plate_number"></td>';
						?>
					</tr>
				</table>
				<input type="submit" name="car_profile" value="Submit">
			</form>
		</div>
	</div>
</body>
</html>