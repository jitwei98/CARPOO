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
			<h1>offer</h1>
			<form class="w3-container" method="POST">
				<table class="w3-table-all w3-hoverable">
					<?php 
					include_once ('includes/config.php');
					$db = pg_connect($conn_str);
						?>
						<!-- TODO: Follow index.php -->
						<tr>
							<td><label for="date_of_ride"><b>date of ride : </b></label></td>
							<?php echo '<td><input type="text" name="date_of_ride"></td>'; ?>
						</tr>
						<tr>
							<td><label for="time_of_ride"><b>time of ride : </b></label></td>
							<?php echo '<td><input type="text" name="time_of_ride"></td>'; ?>
						</tr>
						<tr>
							<td><label for="driver"><b>driver : </b></label></td>
							<?php echo '<td><input type="text" name="driver"></td>'; ?>
						</tr>
						<tr>
							<td><label for="origin"><b>origin : </b></label></td>
							<?php echo '<td><input type="text" name="origin"></td>'; ?>
						</tr>
						<tr>
							<td><label for="destination"><b>destination : </b></label></td>
							<?php echo '<td><input type="text" name="destination"></td>'; ?>
						</tr>
				</table>
				<input type="submit" name="create" value="Submit">
			</form>


			<!-- Update in database -->
			<h1>
				<?php 
				date_default_timezone_set('Asia/Singapore');
				$date_curr = date("Y/m/d");
				$time_curr = date("h/i/sa");

				function create_offer($db) {
					$query = "INSERT INTO offer VALUES (
								'$_POST[date_of_ride]', 
								'$_POST[time_of_ride]', 
								'$_POST[driver]', 
								'$_POST[origin]', 
								'$_POST[destination]'
								 );";

					return pg_query($db, $query);
				}
				
				if (!empty($_POST['create'])) {
					if (create_offer($db)) { // affected rows > 0
						echo "Offer successfully created!<br>";
					} else {
						echo "Error creating offer!<br>";
						echo pg_last_error($db)."<br>";
					}
				}
				?>
			</h1>


		</div>
	</div>
</body>
</html>
