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
			<?php 
			include_once ('includes/config.php');
			$db = pg_connect($conn_str);
			$result = pg_query($db, "SELECT * FROM drive WHERE 
						driver='$_GET[delete_driver]' AND
						car='$_GET[delete_car]'
						");
			if (pg_num_rows($result) == 0) {
				echo "<h1>Drive not found!<br></h1>";
				echo "<a class=\"w3-button w3-black\" href='admin_drive.php'>Go Back</a>";
			} else if (!result) {
				echo pg_last_error($db)."<br>";
			} else {
			?>
				<h1>Are you sure you want to delete this row?</h1>
				<form class="w3-container" method="POST">
					<a class="w3-button w3-black" href='admin_drive.php'>Go Back</a>
					<input class="w3-button w3-black" type="submit" name="delete" value="Delete">
				</form>
			<?php } ?>
				<!-- Delete from database -->
				<h1>
					<?php 

					function delete_drive($db) {
					$query = "DELETE FROM drive WHERE 
						driver='$_GET[delete_driver]' AND
						car='$_GET[delete_car]';";
					return pg_query($db, $query);
				}
				
				if (!empty($_POST['delete'])) {
					if (delete_drive($db)) { // affected rows > 0
						echo "Row successfully deleted!<br>";
						// header("Location: /carpool/admin_home");
					} else {
						echo "Error deleting row!<br>";
						echo pg_last_error($db)."<br>";
					}
				}
				?>
			</h1>


		</div>
	</div>
</body>
</html>
