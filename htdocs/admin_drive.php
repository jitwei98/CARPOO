<?php   session_start();  ?>
<?php
  if (!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
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
			<h1>drive</h1>
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
						$result = pg_query($db, "SELECT * FROM drive;");

						$num_drive = pg_query($db, "SELECT COUNT(*) FROM drive;");
						$num_drive_result = pg_fetch_assoc($num_drive);

						if (pg_num_rows($result) == 0) {
							echo "No rows currently.<br>";
						}
						else {
							echo '<h3>';
					    	echo $num_drive_result['count'];//pg_num_rows($result);
					    	echo " row(s) available";
					    	echo '</h3>';
					    	echo '<th>Actions</th>
					    	<th>driver</th>
					    	<th>car</th>
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
							<td><?php echo 
							'<a href="admin_edit_drive.php?edit_driver='.$row['driver']
							.'&edit_car='.$row['car']
							.'">Edit</a>'
							.'<a href="admin_delete_drive.php?delete_driver='.$row['driver']
							.'&delete_car='.$row['car']
							.'">Delete</a>'; ?>
							</td>
							<td><?php echo $row['driver'];?></td>
							<td><?php echo $row['car'];?></td>
						</tr>
						<?php 
					}
				}
				?>
			</table>
		</div>
	</div>
</body>
</html>
