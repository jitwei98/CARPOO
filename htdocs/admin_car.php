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
			<h1>car</h1>
			<table class="w3-table-all w3-hoverable">
				<thead>
					<tr class="w3-light gray">
						<?php
						$db = pg_connect("host=localhost port=5432 dbname=carpool user=postgres password=test");
						// date_default_timezone_set('Asia/Singapore');
						// $date_curr = date("Y/m/d");
						// $time_curr = date("h/i/sa");
						$user = $_SESSION['use'];
						include_once ('includes/config.php');
						$db = pg_connect($conn_str);
						$result = pg_query($db, "SELECT * FROM car;");

						$count_result = pg_query($db, "SELECT COUNT(*) FROM car;");
						$count_row = pg_fetch_assoc($count_result);

						if (pg_num_rows($result) == 0) {
							echo "No cars currently.<br>";
						}
						else {
							echo '<h3>';
					    	echo $count_row['count'];//pg_num_rows($result);
					    	echo " car(s) available";
					    	echo '</h3>';
					    	echo 	'<th>Actions</th>
					    	<th>plate_number</th>
					    	<th>model</th>
					    	<th>color</th>
					    	';
					    }
					    ?>
					</tr>
				</thead>
				<?php 
				if (pg_num_rows($result) > 0) {
					while ($row = pg_fetch_assoc($result)) {
						?>
						<tr>
							<td><?php echo '<a href="admin_edit_car.php?
							edit_id='.$row['plate_number'].'
							">Edit</a>'.'
							<a href="admin_delete_car.php?
							delete_id='.$row['plate_number'].'
							">Delete</a>'; ?>
							</td>
							<td><?php echo $row['plate_number'];?></td>
							<td><?php echo $row['model'];?></td>
							<td><?php echo $row['color'];?></td>
						</tr>
						<?php 
					}
				}
				?>
			</table>
		</div>
</body>
</html>
