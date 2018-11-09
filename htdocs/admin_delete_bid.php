<?php   session_start();  ?>
<?php
	include_once ('includes/check_admin.php');
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
		// include_once ('includes/navbar.php');
		// include_once ('includes/admin_sidenav.php');
		include_once ('includes/header.php');
		include_once ('includes/admin_navbar.php');
	?>
		<div class="w3-container page_container">
			<?php 
			include_once ('includes/config.php');
			$db = pg_connect($conn_str);
			$result = pg_query($db, "SELECT * FROM bid WHERE 
						date_of_ride='$_GET[delete_date]' AND 
						time_of_ride='$_GET[delete_time]' AND
						driver='$_GET[delete_driver]' AND
						passenger='$_GET[delete_passenger]'
						");
			if (pg_num_rows($result) == 0) {
				echo "<h1>Bid not found!<br></h1>";
				echo "<a class=\"w3-button w3-black\" href='admin_bid.php'>Go Back</a>";
			} else if (!result) {
				echo pg_last_error($db)."<br>";
			} else {
			?>
				<h1>Are you sure you want to delete this row?</h1>
				<form class="w3-container" method="POST">
					<a class="w3-button w3-black" href='admin_bid.php'>Go Back</a>
					<input class="w3-button w3-black" type="submit" name="delete" value="Delete">
				</form>
			<?php } ?>
				<!-- Delete from database -->
				<h1>
					<?php 

					function delete_bid($db) {
					$query = "DELETE FROM bid WHERE 
										date_of_ride='$_GET[delete_date]' AND
										time_of_ride='$_GET[delete_time]' AND
										driver='$_GET[delete_driver]' AND
										passenger='$_GET[delete_passenger]';";
					return pg_query($db, $query);
				}
				
				if (!empty($_POST['delete'])) {
					if (delete_bid($db)) { // affected rows > 0
						echo "Bid successfully deleted!<br>";
						// header("Location: /carpool/admin_home");
					} else {
						echo "Error deleting bid!<br>";
						echo pg_last_error($db)."<br>";
					}
				}
				?>
			</h1>


		</div>
	</div>
</body>
</html>
