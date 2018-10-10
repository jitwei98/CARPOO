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
		</style>
	</head>
	<body>
		<div class="w3-container w3-black">
			<a href="/carpool/home"><h1>Car Pooling</h1></a>
  			<a href="logout.php" style="float:right;">Log Out</a>
		</div>
		<div class="w3-container">
		<?php
			$email = $_SESSION['use'];
			include_once ('includes/config.php');
			$db = pg_connect($conn_str);
			$result = pg_query($db, "SELECT * FROM drive where driver = '$email'");
		    $row = pg_fetch_assoc($result);
		    if (pg_num_rows($result) == 0) {
		    	echo "<a href=/carpool/driver_reg>Register as Driver here!</a>";
		    }
		    else {
		    	echo "<a href=/carpool/makeoffer>Initiate carpool offer</a>";
		    }
		?>
		</div>
	</body>
</html>