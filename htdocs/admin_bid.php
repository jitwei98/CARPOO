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
		<a href="/carpool/admin_home" class="w3-bar-item w3-button">app_user</a>
		<a href="#" class="w3-bar-item w3-button">bid</a>
		<a href="/carpool/admin_car" class="w3-bar-item w3-button">car</a>
		<a href="#" class="w3-bar-item w3-button">drive</a>
		<a href="#" class="w3-bar-item w3-button">offer</a>
	</div>
	<div style="margin-left: 10%; margin-top:74px;">
		<div class="w3-container">
			<h1>bid</h1>
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
						$result = pg_query($db, "SELECT * FROM bid;");

						$count_result = pg_query($db, "SELECT COUNT(*) FROM bid;");
						$count_row = pg_fetch_assoc($count_result);

						if (pg_num_rows($result) == 0) {
							echo "No bids currently.<br>";
						}
						else {
							echo '<h3>';
					    	echo $count_row['count'];//pg_num_rows($result);
					    	echo " bid(s) available";
					    	echo '</h3>';
					    	echo 	'<th>Actions</th>
					    	<th>date_of_ride</th>
					    	<th>time_of_ride</th>
					    	<th>driver</th>
					    	<th>passenger</th>
					    	<th>price</th>
					    	<th>status</th>
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
							<td><?php echo '<a href="admin_edit_bid.php?
							edit_date='.$row['date_of_ride'].'
							&edit_time='.$row['time_of_ride'].'
							&edit_driver='.$row['driver'].'
							&edit_passenger='.$row['passenger'].'
							">Edit</a>'.'
							<a href="admin_delete_bid.php?
							delete_date='.$row['date_of_ride'].'
							&delete_time='.$row['time_of_ride'].'
							&delete_driver='.$row['driver'].'
							&delete_passenger='.$row['passenger'].'
							">Delete</a>'; ?>
							</td>
							<td><?php echo $row['date_of_ride'];?></td>
							<td><?php echo $row['time_of_ride'];?></td>
							<td><?php echo $row['driver'];?></td>
							<td><?php echo $row['passenger'];?></td>
							<td><?php echo $row['price'];?></td>
							<td><?php echo $row['status']?></td>
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
