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
		<div class="w3-container">
			<h1>Open Carpool Offers</h1>
							<?php
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
