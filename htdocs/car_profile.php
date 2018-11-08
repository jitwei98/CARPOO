<?php   session_start();  ?>
<?php
	include_once ('includes/check_user.php');
 	include_once ('includes/config.php');
	$db = pg_connect($conn_str);
	$driver = $_SESSION['use'];
	date_default_timezone_set('Asia/Singapore');
	$date_curr = date("Y/m/d");
	$time_curr = date("h/i/sa");
  ?>

  <!DOCTYPE html>
  <html>
	<?php
		include_once ('includes/header.php'); 
		include_once ('includes/driver_navbar.php');
	?>
	<div class="w3-container page_container">
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
				<input type="submit" name="edit" value="Save" style="float:right;">
				<a href="delete_driver.php" 
					onclick="return confirm('Are you sure you want to delete your account?')" style="float:left" 
					class="w3-button w3-red">Delete Driver Account</a>
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
						//$query .= "DELETE FROM drive WHERE drive = '$driver';";
						//$query .= "INSERT INTO drive VALUES ('$driver', '$plate_number');";
						$query .= "UPDATE drive SET car='$plate_number' WHERE driver='$driver';";
						// trigger the delete_car() that will delete a car if the car is not driven by anyone
						// $query .= "DELETE FROM  car WHERE plate_number='$row[plate_number]';";
					} else {
						$query .= "UPDATE car SET model='$model', color='$color' WHERE plate_number='$plate_number';" ;
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
		<?php
			include_once ("includes/footer.php");
		?>
	</div>
</body>
</html>
