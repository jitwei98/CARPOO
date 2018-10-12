<?php   session_start();  ?>
<?php
  if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
   {
       header("Location: /carpool");  
   }
?>
<!DOCTYPE html>
<html>

<!-- header -->
<?php include_once('includes/header.php'); ?>

<!-- navigation -->
<body>
<div class="container-fluid">
	<div class="navbar navbar-default navbar-static-top" role="navigation">
		<div class="navbar-header">
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon icon-bar"></span>
				<span class="icon icon-bar"></span>
				<span class="icon icon-bar"></span>
			</button>
			<a href="#" class="navbar-brand"> CARPOO</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="/carpool/home" class="active">HOME</a></li>
				<li><a href="about.html">ABOUT US</a></li>
				<li><a href="portfolio.html">PORTFOLIO</a></li>
				<li><a href="contact.html">CONTACT</a></li>
				<li><a href="logout.php">LOGOUT</a></li>
			</ul>
		</div>
	</div>
</div>
		<div></div>
		<?php
			$email = $_SESSION['use'];
			include_once ('includes/config.php');
			$db = pg_connect($conn_str);
			$result = pg_query($db, "SELECT * FROM drive where driver = '$email'");
		    $row = pg_fetch_assoc($result);
		    if (pg_num_rows($result) == 0) {
		    	echo '<a href=/carpool/driver_reg>';
		    	echo '<div class="w3-card-4 w3-blue-gray" style="float:left; width:40%; padding:30px; margin-top:100px; margin:30px; text-align: center;">';
		    	echo "Register as Driver here!";
		    	echo '</div>';
		    	echo '</a>';
		    }
		    else {
		    	echo '<a href=/carpool/driver_home>';
		    	echo '<div class="w3-card-4 w3-blue-gray" style="float:left; width:40%; padding:30px; margin-top:100px; margin:30px; text-align: center;">';
		    	echo "Login as Driver here!";
		    	echo '</div>';
		    	echo '</a>';

		    }
		?>
		<a href="/carpool/passenger_home">
			<div class="w3-card-4 w3-blue-gray" style="float:left; width:40%; padding:30px; margin-top:100px; margin:30px; text-align: center;">Login as Passenger!
			</div>
		</a>
	</body>
</html>



