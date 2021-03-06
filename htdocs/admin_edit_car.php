<?php   session_start();  ?>
<?php
	include_once ('includes/check_admin.php');
?>
<!DOCTYPE html>
<html>
<body>
	<?php 
		// include_once ('includes/navbar.php');
		// include_once ('includes/admin_sidenav.php');
		include_once ('includes/header.php');
		include_once ('includes/admin_navbar.php');
	?>
		<div class="w3-container page_container">
			<h1>car</h1>
			<form class="w3-container" method="POST">
				<table class="w3-table-all w3-hoverable">
					<?php 
					include_once ('includes/config.php');
					$db = pg_connect($conn_str);
					$result = pg_query($db, "SELECT * FROM car WHERE 
						plate_number='$_GET[edit_id]'
						");
					if (pg_num_rows($result) == 0) {
						echo "<h6>Car not found!<br></h6>";
						echo "<a class=\"w3-button w3-black\" href='admin_car.php'>Go Back</a>";
					} else if (!$result) {
						echo pg_last_error($db)."<br>";
					} else {
						$row = pg_fetch_assoc($result);
						?>
						<!-- TODO: Follow index.php -->
						<tr>
							<td><label for="plate_number"><b>Plate number : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['plate_number'].'" name="plate_number_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="model"><b>model : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['model'].'" name="model_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="color"><b>color : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['color'].'" name="color_updated"></td>'; ?>
						</tr>
				</table>
				<input type="submit" name="edit" value="Submit">
				<?php }?>
			</form>


			<!-- Update in database -->
			<h1>
				<?php 
				date_default_timezone_set('Asia/Singapore');
				$date_curr = date("Y/m/d");
				$time_curr = date("h/i/sa");

				function isModified() {
					return !empty($_POST[plate_number_updated]) || 
							!empty($_POST[model_updated]) || 
							!empty($_POST[color_updated])
							;
				}

				function update_car($db, $row) {
					$plate_number = !empty($_POST[plate_number_updated]) ? $_POST[plate_number_updated] : $row[plate_number];
					$model = !empty($_POST[model_updated]) ? $_POST[model_updated] : $row[model];
					$color = !empty($_POST[color_updated]) ? $_POST[color_updated] : $row[color];
					
					$query = "UPDATE car SET 
								plate_number='$plate_number', 
								model='$model', 
								color='$color'
								WHERE plate_number='$_GET[edit_id]';";

					return pg_query($db, $query);
				}
				
				if (!empty($_POST['edit']) && isModified()) {
					if (update_car($db, $row)) { // affected rows > 0
						// echo "Bid successfully updated!<br>";
						// $url = 'Location: /carpool/admin_edit_car.php?edit_id='.
						// 		$row['plate_number'];
						$url = 'Location: /carpool/admin_car';
						header($url);
					} else {
						echo "Error updating car!<br>";
						echo pg_last_error($db)."<br>";
					}
				}
				?>
			</h1>


		</div>
	</div>
</body>
</html>
