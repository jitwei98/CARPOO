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
			<h1>app_user</h1>
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
						$result = pg_query($db, "SELECT * FROM app_user;");

						$num_user = pg_query($db, "SELECT COUNT(*) FROM app_user;");
						$num_user_result = pg_fetch_assoc($num_user);

						if (pg_num_rows($result) == 0) {
							echo "No users currently.<br>";
						}
						else {
							echo '<h3>';
					    	echo $num_user_result['count'];//pg_num_rows($result);
					    	echo " user(s) available";
					    	echo '</h3>';
					    	echo 	'<th>Actions</th>
					    	<th>phone_number</th>
					    	<th>email</th>
					    	<th>name</th>
					    	<th>gender</th>
					    	<th>dob</th>
					    	<th>password</th>
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
							<td><?php echo '<a href="admin_edit_user.php?edit_id='.$row['email'].'">Edit</a>'.'<a href="admin_delete_user.php?delete_id='.$row['email'].'">Delete</a>'; ?>
							</td>
							<td><?php echo $row['phone_number'];?></td>
							<td><?php echo $row['email'];?></td>
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['gender'];?></td>
							<td><?php echo $row['dob'];?></td>
							<td><?php echo $row['password']?></td>
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
