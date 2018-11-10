<?php   session_start();  ?>
<?php
	include_once ('includes/check_user.php');
?>
<!DOCTYPE html>
<html>
	<?php
		include_once ('includes/header.php'); 
		include_once ('includes/passenger_navbar.php');
	?>
	<div class="w3-container page_container">
			<h1>Rider History</h1>
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
						<button name="search" class="w3-button w3-round w3-black" type="submit">Search</button>
					</div>
				</form>
				<br>
			</div>

			<table class="w3-table-all w3-hoverable">
				<tr class="w3-light gray">
				<?php
				$db = pg_connect("host=localhost port=5432 dbname=carpool user=postgres password=test");
				date_default_timezone_set('Asia/Singapore');
				$date_curr = date("Y/m/d");
				$time_curr = date("h/i/sa");
				$user = $_SESSION['use'];
				include_once ('includes/config.php');
				$db = pg_connect($conn_str);
				if(isset($_POST['search'])) {
					$from_date = strtotime($_POST['fromdate']);
					$to_date = strtotime($_POST['todate']);
					
					$result = pg_query($db, 
					"SELECT * FROM offer o, bid b 
					WHERE o.date_of_ride = b.date_of_ride
					AND o.date_of_ride >= to_timestamp($from_date)
					AND o.date_of_ride <= to_timestamp($to_date)
					AND o.driver = b.driver
					AND b.passenger = '$user' 
					ORDER BY b.date_of_ride ASC");
				}
				else {
					$result = pg_query($db, "SELECT * FROM offer o, bid b WHERE o.date_of_ride = b.date_of_ride AND o.time_of_ride = b.time_of_ride AND o.driver = b.driver AND b.passenger = '$user' ORDER BY b.date_of_ride ASC");
				}
				if (pg_num_rows($result) == 0) {
					echo 'History is empty. </tr>';
				} else {
					echo '<h3>', pg_num_rows($result), " previous bid(s) </h3>";
					echo '<div><form method="POST">';
					echo '<button name="delete" type="submit" value="Delete">Delete</button>';
					echo '<thead>
							<th><input type="checkbox" id="chkParent" /></th>
							<th>Driver</th>
							<th>Origin of Ride</th>
							<th>Destination of Ride</th>
							<th>Date of Ride</th>
							<th>Time of Ride</th>
							<th>Price Offered</th>
							<th>Status</th>
							</thead>';
					$counter = 0;
					while($row = pg_fetch_assoc($result)) {
						echo '<tr>';
						echo '<td><input name="selected_row[]" value="'.implode("|", array($row['driver'], $row['passenger'], $row['date_of_ride'], $row['time_of_ride'])).'" type="checkbox" /></td>';
						echo '<td>', $row['driver'], '</td>';
						echo '<td>', $row['origin'], '</td>';
						echo '<td>', $row['destination'], '</td>';
						echo '<td>', $row['date_of_ride'], '</td>';
						echo '<td>', $row['time_of_ride'], '</td>';
						echo '<td>', $row['price'], '</td>';
						echo '<td>', $row['status'], '</td>';
						echo '</tr>';
						$counter++;
					}
					echo '</form>';
					if(isset($_POST['delete']) AND isset($_POST['selected_row'])) {
						$delete_rows = $_POST['selected_row'];
						for($i = 0; $i < count($delete_rows); $i++) {
							$curr_row = explode("|", $delete_rows[$i]);
							error_log($curr_row[3]);
							pg_query($db, "DELETE FROM bid WHERE driver = '$curr_row[0]' AND passenger = '$curr_row[1]' AND date_of_ride = '$curr_row[2]' AND time_of_ride = '$curr_row[3]'");
							header("Refresh:0");
						}
					}
					
					
					echo '</div>';
				}
				?>	
			</table>
			<?php
				include_once ("includes/footer.php");
			?>
		</div>
		<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up"></i></button>
	</body>
</html>


<script>
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
</script>
