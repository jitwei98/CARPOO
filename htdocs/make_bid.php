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
			<div class="w3-container">
				<h1>Bid For Carpool Offer</h1>
				<form class="w3-container" method="POST">
					<label for="price"><b>Bid Price : $</b></label>
					<input type="text" name="price" placeholder="Enter Bid Value">
		      		<input class="w3-button w3-round w3-khaki" type="submit" name="bid" value="Submit Bid">
				</form>
				<?php
					$passenger = $_SESSION['use'];
					$offer_driver = $_GET['driver'];
					$offer_date = $_GET['d_offer'];
					$offer_time = $_GET['t_offer'];
					include_once ('includes/config.php');
					$db = pg_connect($conn_str);
					if (isset($_POST['bid'])) {
						$result = pg_query($db, "INSERT INTO bid VALUES ('$offer_date', '$offer_time', '$offer_driver', '$passenger', '$_POST[price]', 'pending')");
						if (!$result) {
							echo "Bid Invalid!<br>";
							echo pg_last_error($db)."<br>";
						}
						else {
							header("Location: /carpool/passenger_home");
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