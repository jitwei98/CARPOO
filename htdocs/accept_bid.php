<?php   session_start();  ?>
<?php
	include_once ('includes/check_user.php');
?>
<!DOCTYPE html>
<html>
	<?php
		include_once ('includes/header.php'); 
		include_once ('includes/driver_navbar.php');
	?>
	<div class="w3-container page_container">
			<div class="w3-container">
				<h1>Accept Bid?</h1>
				<form class="w3-container" method="POST">
					<!-- <label for="price"><b>Bid Price : $</b></label> -->
					<!-- <input type="text" name="price" placeholder="Enter Bid Value"> -->
		      		<input type="submit" name="accept" value="Accept">
		      		<button onclick="goBack()">Go Back</button>
				</form>

				<?php
				$offer_date = $_GET['d_offer'];
				$offer_time = $_GET['t_offer'];
				$driver = $_SESSION['use'];
				$passenger = $_GET['passenger'];
				$price = $_GET['price'];

				include_once ('includes/config.php');
				$db = pg_connect($conn_str);

				if (isset($_POST['accept'])) {
					// TODO: reject all other bids for the same offer
					$result = pg_query($db, "UPDATE bid SET status = 'successful' WHERE date_of_ride = '$offer_date' AND time_of_ride = '$offer_time' AND driver = '$driver' AND passenger = '$passenger' AND price = '$price' AND status = 'pending'");
					// $other_result = pg_query($db, "UPDATE bid SET status = 'unsuccessful' WHERE date_of_ride = '$offer_date' AND time_of_ride = '$offer_time' AND driver = '$driver' AND passenger <> '$passenger' AND status = 'pending'");
					if (!$result) {
						echo pg_last_error($db)."<br>";
					}
					else {
						echo "<p>Bid accepted!</p>";
						// header("Location: /carpool/driver_home");
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

<script>
	function goBack() {
		window.history.back();
	}
</script>