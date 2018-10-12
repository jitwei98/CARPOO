<?php   session_start();  ?>
<?php
  if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
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
	<div class="w3-container w3-black w3-top">
		<a href="/carpool/home" style="float:left;"><h1>Car Pooling</h1></a>
		<a href="logout.php" style="float:right;padding-top: 45px">Log Out</a>
	</div>
	<div class="w3-sidebar w3-bar-block w3-dark-gray" style="width:10%"> 
		<a href="#" class="w3-bar-item w3-button">Table_1</a>
		<a href="#" class="w3-bar-item w3-button">Table_2</a>
		<a href="#" class="w3-bar-item w3-button">Table_3</a>
	</div>
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
						if (pg_num_rows($result) == 0) {
							echo "No users currently.<br>";
						}
						else {
							echo '<h3>';
					    	echo pg_num_rows($result); // Use this or COUNT again?
					    	echo " user(s) available";
					    	echo '</h3>';
					    	echo 	'<th>Actions</th>
					    	<th>phone_number</th>
					    	<th>email</th>
					    	<th>name</th>
					    	<th>gender</th>
					    	<th>dob</th>';
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
