<?php   session_start();  ?>
<?php
  if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
   {
       header("Location: /carpool");  
   }
// If user is already a driver redirect to home page
   $db = pg_connect("host=localhost port=5432 dbname=carpool user=postgres password=test");
   $user = $_SESSION['use'];
   $isRegisteredDriver = pg_fetch_row(pg_query($db, "SELECT * FROM drive WHERE driver = '$user'"));
// echo $isRegisteredDriver[0];
   if ($isRegisteredDriver) {
   	header("Location: /carpool/home");
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
			<form class="w3-container" method="POST">
				<h1>Details for Driver Registration</h1>
			    <label for="plate_number"><b>Car Plate Number : </b></label>
			    <input type="text" placeholder="Enter Car Plate Number" name="plate_number" required>
			    <hr>
			    <label for="model"><b>Car Model : </b></label>
			    <input type="text" placeholder="Enter Car Model" name="model" required>
			    <hr>
			    <label for="color"><b>Car Color : </b></label>
			    <input type="text" placeholder="Enter Car Color" name="color" required>
			    <hr>
	      		<input type="submit" name="driver_reg" value="Register as Driver">
			</form>
		</div>
		<?php
    	if (isset($_POST['driver_reg'])) {
    		$driver = $_SESSION['use'];
<<<<<<< HEAD
    		$plate_number = $_POST[plate_number];
    		$res = pg_query($db, "INSERT INTO car VALUES ('$plate_number', '$_POST[model]', '$_POST[color]')");
    		if (!res) {
    			echo "Invalid car details";
    		}
    		else {
    			$result = pg_query($db, "INSERT INTO drive VALUES ('$driver', '$plate_number')");
    			if (!$result) {
	            	echo "Driver registration failed";
	       		}
	       		else {
	            	header("Location: /carpool/home");
	        	}
    		}
    	}   
=======
    		$res = pg_query($db, "INSERT INTO car values ('$_POST[plate_number]', '$_POST[model]', '$_POST[color]')");
	    	$result = pg_query($db, "INSERT INTO drive VALUES ('$driver', '$_POST[plate_number]')");
	    	if (!$result || !$res) {
	            echo "Driver registration failed!!";
	        } 
	        else {
	            header("Location: /carpool/home");
	        }
        }
>>>>>>> d484d9f949264a4223ca5bfb3f7b7a7bd1ecb11f
    	?>
	</body>
</html>