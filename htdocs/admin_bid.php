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
			<br>
			<div class="w3-card-4">
				<div class="w3-container w3-gray">
					<h3>Search</h3>
				</div>
				<br>
				<form class="w3-row-padding" method="POST">
					<div class="w3-cell">
						<label>From</label>
						<input name="fromdate" class="w3-input w3-border" type="date">
					</div>
					<div class="w3-cell">
						<label>To</label>
						<input name="todate" class="w3-input w3-border" type="date">
					</div>
					<div class="w3-cell">
						<br>
						<button name="search" class="w3-button w3-black" type="submit">Search</button>
					</div>
				</form>
				<br>
			</div>
			<br>
		<div class="w3-container">
			<h1>bid
				<small><a href="admin_create_bid.php" style="float: right;">ADD</a></small>
			</h1>
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
						
						
						if(isset($_POST['search'])) {
							$from_date = strtotime($_POST['fromdate']);
							$to_date = strtotime($_POST['todate']);
							
							$result = pg_query($db, 
							"SELECT * FROM bid b
							WHERE b.date_of_ride >= to_timestamp($from_date)
							AND b.date_of_ride <= to_timestamp($to_date)
							ORDER BY b.date_of_ride ASC");

							$count_result = pg_query($db, 
							"SELECT COUNT(*) FROM bid b
							WHERE b.date_of_ride >= to_timestamp($from_date)
							AND b.date_of_ride <= to_timestamp($to_date);");
						} else {
							$result = pg_query($db, "SELECT * FROM bid;");
							$count_result = pg_query($db, "SELECT COUNT(*) FROM bid;");
						}
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
					<td>
						<?php echo '<a href="admin_edit_bid.php?
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
					<td>
						<?php echo $row['date_of_ride'];?>
					</td>
					<td>
						<?php echo $row['time_of_ride'];?>
					</td>
					<td>
						<?php echo $row['driver'];?>
					</td>
					<td>
						<?php echo $row['passenger'];?>
					</td>
					<td>
						<?php echo $row['price'];?>
					</td>
					<td>
						<?php echo $row['status']?>
					</td>
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