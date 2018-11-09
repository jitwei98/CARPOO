<?php   session_start();  ?>
<?php
	include_once ('includes/check_user.php');
	include_once ('includes/config.php');
	$db = pg_connect($conn_str);
	$driver = $_SESSION['use'];
	include_once ('includes/check_driver.php');
	date_default_timezone_set('Asia/Singapore');
	$date_curr = date("Y/m/d");
	$time_curr = date("h/i/sa");
?>
<!DOCTYPE html>
<html>
	<?php
		include_once ('includes/header.php'); 
		include_once ('includes/driver_navbar.php');
	?>
	<div class="w3-container page_container">
			<div class="w3-container">
				<h1>History</h1>
				<table class="w3-table-all w3-hoverable">
				<thead>
					<tr class="w3-black">
							<?php
								$result = pg_query($db, "SELECT * FROM offer o WHERE o.driver = '$driver' AND (o.date_of_ride = '$date_curr' OR o.date_of_ride < '$date_curr') AND EXISTS (SELECT * FROM bid b WHERE o.driver=b.driver AND o.date_of_ride = b.date_of_ride AND o.time_of_ride = b.time_of_ride AND b.status = 'successful')");
		   						if (pg_num_rows($result) == 0) {
		   							echo '<h3>History is empty.</h3>';
		   							echo '</tr>';
		   							echo '</thead>';
		   						}
		   						else {
	   								echo '<td>';
	   								echo "Passenger";
	   								echo '</td>';
	   								echo '<td>';
	   								echo "Bid Price";
	   								echo '</td>';
	   								echo '<td>';
	   								echo "Date of ride";
	   								echo '</td>';
	   								echo '<td>';
	   								echo "Time of ride";
	   								echo '</td>';
	   								echo '<td>';
	   								echo "Origin of ride";
	   								echo '</td>';
	   								echo '<td>';
	   								echo "Destination of ride";
	   								echo '</td>';
	   								echo '</tr>';
	   								echo '</thead>';
	   								while ($row = pg_fetch_assoc($result)) {
	   									echo '<tr>';
	   									echo '<td>';
	   									$res = pg_query($db, "SELECT * FROM bid b WHERE b.driver='$row[driver]' AND b.date_of_ride='$row[date_of_ride]' AND b.time_of_ride='$row[time_of_ride]' AND b.status='successful'");
	   									$row_p=pg_fetch_assoc($res);
		   								echo $row_p['passenger'];
		   								echo '</td>';
		   								echo '<td>';
		   								echo $row_p['price'];
		   								echo '</td>';
		   								echo '<td>';
		   								echo $row['date_of_ride'];
		   								echo '</td>';
		   								echo '<td>';
		   								echo $row['time_of_ride'];
		   								echo '</td>';
		   								echo '<td>';
		   								echo $row['origin'];
		   								echo '</td>';
		   								echo '<td>';
		   								echo $row['destination'];
		   								echo '</td>';
		   								echo '</tr>';
	   								}
								}
								echo '</table>';
							?>
			</div>
		</div>
		<?php
			include_once ("includes/footer.php");
		?>
	</body>
</html>