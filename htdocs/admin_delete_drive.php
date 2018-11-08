<?php   session_start();  ?>
<?php
	// If session is not set or user is not admin then redirect to Login Page
	if (!isset($_SESSION['use'])) 
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
</head>
<body>
	<?php 
		include_once ('includes/navbar.php');
		include_once ('includes/admin_sidenav.php');
	?>
	<div style="margin-left: 10%; margin-top:74px;">
		<div class="w3-container">
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
