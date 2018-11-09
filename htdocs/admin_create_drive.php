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
						?>
						<!-- TODO: Follow index.php -->
						<tr>
							<td><label for="driver"><b>Driver : </b></label></td>
							<?php echo '<td><input type="text" name="driver"></td>'; ?>
						</tr>
						<tr>
							<td><label for="car"><b>Car plate number : </b></label></td>
							<?php echo '<td><input type="text" name="car"></td>'; ?>
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

				function create_drive($db) {
					// $password = password_hash($_POST[password], PASSWORD_DEFAULT);
					$query = "INSERT INTO drive VALUES (
								'$_POST[driver]', 
								'$_POST[car]'
								 );";

					return pg_query($db, $query);
				}
				
				if (!empty($_POST['create'])) {
					if (create_drive($db)) { // affected rows > 0
						echo "Drive successfully created!<br>";
					} else {
						echo "Error creating drive!<br>";
						echo pg_last_error($db)."<br>";
					}
				}
				?>
			</h1>


		</div>
	</div>
</body>
</html>
