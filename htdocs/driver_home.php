<?php   session_start();  ?>
<?php
	include_once ('includes/check_user.php');
	include_once ('includes/config.php');
	$db = pg_connect($conn_str);
	$driver = $_SESSION['use'];
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
		<div class="w3-container dashboard_container">
			<div class="w3-cell-row">
				<div class="w3-cell w3-border">
					<h4 align="center">Number of Trips</h4>
					<?php
	                    $result = pg_query($db, 
	                    "SELECT COUNT(*) FROM bid 
	                    WHERE driver = '$driver'
						AND status = 'successful'");
	                    $count_trips = pg_fetch_assoc($result)['count'];
	                    echo '<h2 align="center">'.$count_trips.'</h2>';
	                ?>
				</div>
				<div class="w3-cell w3-border">
					<h4 align="center">Amount Earned</h4>
					<?php
	                    $result = pg_query($db, 
	                    "SELECT SUM(price) FROM bid 
	                    WHERE driver = '$driver'
						AND status = 'successful'");
	                    $total_earnings = pg_fetch_assoc($result)['sum'];
	                    echo '<h2 align="center">$'.number_format($total_earnings, 2).'</h2>';
	                ?>
				</div>
				<div class="w3-cell w3-border">
					<h4 align="center">Average per Trip</h4>
					<?php
	                    $result = pg_query($db, 
	                    "SELECT AVG(price) FROM bid 
	                    WHERE driver = '$driver'
						AND status = 'successful'");
	                    $average_earnings = pg_fetch_assoc($result)['avg'];
	                    echo '<h2 align="center">$'.number_format($average_earnings, 2).'</h2>';
	                ?>
				</div>
			</div>
		</div>	
		<div class="w3-container">
			<h1>Open Carpool Offers</h1>
			<?php
			$result = pg_query($db, "SELECT * FROM offer o WHERE o.driver = '$driver' AND (o.date_of_ride = '$date_curr' OR o.date_of_ride > '$date_curr') AND NOT EXISTS (SELECT * FROM bid b WHERE o.driver=b.driver AND o.date_of_ride = b.date_of_ride AND o.time_of_ride = b.time_of_ride AND (b.status = 'successful' OR b.status = 'unsuccessful')) ORDER BY o.date_of_ride ASC , o.time_of_ride ASC");
			if (pg_num_rows($result) == 0) {
				echo '<table class="w3-table-all w3-hoverable">';
				echo '<thead>';
				echo '<tr class="w3-black">';
				echo '<h3>';
				echo "No open offer currently";
				echo '</h3>';
				echo '</tr>';
				echo '</thead>';
			}
			else {
				while($row = pg_fetch_assoc($result)){
					echo '<table class="w3-table-all w3-hoverable">';
					echo '<thead>';
					echo '<tr class="w3-black">';
					echo '<h3>';
					echo $row['date_of_ride'];
					echo ", ";
					echo $row['time_of_ride'];
					echo ", ";
					echo $row['origin'];
					echo " to ";
					echo $row['destination'];
					echo '</h2>';
					echo '</tr>';
					echo '</thead>';
					$res = pg_query($db, "SELECT * FROM bid WHERE driver='$driver' AND time_of_ride='$row[time_of_ride]' AND date_of_ride='$row[date_of_ride]' AND status='pending' ORDER BY date_of_ride ASC,price DESC");
					echo '<thead>';
					echo '<tr class="w3-light-grey">';
					if (pg_num_rows($res) == 0) {
						echo "No current bids";
						echo '</tr>';
						echo '</thead>';
					} else {
						echo '<td>';
						echo "Passenger";
						echo '</td>';
						echo '<td style="margin-right:auto;">';
						echo "Bid Price";
						echo '</td>';
						echo '</tr>';
						echo '</thead>';
						while ($row = pg_fetch_assoc($res)) {
							echo '<tr>';
							echo '<td><a href="/carpool/accept_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'&passenger='.$row['passenger'].'&price='.$row['price'].'">';
							echo $row['passenger'];
							echo '</a></td>';
							echo '<td style="width:20%;><a href="/carpool/accept_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'&passenger='.$row['passenger'].'&price='.$row['price'].'">';
							echo $row['price'];
							echo '</a></td>';
							echo '</tr>';
						}
						echo '</table>';
					}
				}
			}
			?>
		</div>
		<?php
			include_once ("includes/footer.php");
		?>
	</div>
</body>
</html>
