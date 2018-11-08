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
		<h1>Open Carpool Offers</h1>
		<table class="w3-table-all w3-hoverable">
			<thead>
				<tr class="w3-light gray">
				<?php
				$db = pg_connect("host=localhost port=5432 dbname=carpool user=postgres password=test");
				date_default_timezone_set('Asia/Singapore');
				$date_curr = date("Y/m/d");
				$time_curr = date("h/i/sa");
			   	$user = $_SESSION['use'];
				include_once ('includes/config.php');
				$db = pg_connect($conn_str);
			    $result = pg_query($db, "SELECT * FROM offer o WHERE o.driver <> '$user' AND (o.date_of_ride = '$date_curr' OR o.date_of_ride > '$date_curr') AND NOT EXISTS (SELECT * FROM bid b WHERE o.driver=b.driver AND o.date_of_ride = b.date_of_ride AND o.time_of_ride = b.time_of_ride AND (b.status = 'successful' OR b.passenger = '$user'))");
			    if(pg_num_rows($result) == 0) {
			    	echo "No open offers currently.";
			    	echo '</tr>';
			    }
			    else {
			    	echo '<div><h3>';
			    	echo pg_num_rows($result);
			    	echo " offer(s) open";
			    	echo '</h3><p><form method="POST"><input type="text" name="query"><input type="submit" name="search" value="Search"></form></p></div>';
			    	echo '<th>';
			    	echo "Driver";
			    	echo '</th>';
			    	echo '<th>';
			    	echo "Origin of ride";
			    	echo '</th>';
			    	echo '<th>';
			    	echo "Destination of ride";
			    	echo '</th>';
			    	echo '<th>';
			    	echo "Date of ride";
			    	echo '</th>';
			    	echo '<th>';
			    	echo 'Time of ride';
			    	echo '</th>';
			    	echo '</tr></thead>';
			    	if (isset($_POST['search'])) {
			    		$result_query = pg_query($db, "SELECT * FROM offer o WHERE  o.driver <> '$user' AND (o.date_of_ride = '$date_curr' OR o.date_of_ride > '$date_curr') AND (o.origin LIKE '%$_POST[query]%' OR o.destination LIKE '%$_POST[query]%')");
			    		$result = $result_query;
			    	}
			    	while($row = pg_fetch_assoc($result)) {
			    		echo '<tr>';
						echo '<td><a href="/carpool/make_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'">';
						echo $row['driver'];
						echo '</a></td>';
						echo '<td><a href="/carpool/make_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'">';
						echo $row['origin'];
						echo '</a></td>';
						echo '<td><a href="/carpool/make_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'">';
						echo $row['destination'];
						echo '</a></td>';
						echo '<td><a href="/carpool/make_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'">';
						echo $row['date_of_ride'];
						echo '</a></td>';
						echo '<td><a href="/carpool/make_bid?d_offer='.$row['date_of_ride'].'&t_offer='.$row['time_of_ride'].'&driver='.$row['driver'].'">';
						echo $row['time_of_ride'];
						echo '</a></td>';
						echo '</tr>';
			    	}
			    }
			    echo '</table>';
				?>
	</div>
	<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up"></i></button>
	<?php
		include_once ("includes/footer.php");
	?>
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

