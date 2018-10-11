<?php   session_start();  ?>
<?php
	if(isset($_SESSION['use']))
	{
		header("Location: /carpool/home"); 
	}	
?>
<!DOCTYPE html>
<html>
<?php include_once('includes/header.php'); ?>

<body>

<!-- navigation -->
<div class="container">
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
			</ul>
		</div>
	</div>
</div>

<!-- home section -->

<div id="home">
	<div class="container">
		<div class="row">
			<div class="col-md-5 col-sm-3"></div>
			<div class="col-md-7 col-sm-9">
				<h3>move the way</h3>
				<h1>you want</h1>
			</div>
		</div>
	</div>
</div>

<!-- divider section -->

<div class="divider">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<div class="divider-wrapper divider-one">
					<i class="fa fa-mobile"></i>
					<h2>Ride</h2>
					<p>Tap your phone. Get where you're headed the way you want.</p>
					<a href="about.html" class="btn btn-default">Sign up to ride</a>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="divider-wrapper divider-two">
					<h2>Login</h2>
					<form class="w3-container" method="POST">
			    <label for="email"><b>Email</b></label>
			    <input type="text" placeholder="Enter Email" name="email" required>
			    <hr>
			    <label for="password"><b>Password</b></label>
			    <input type="password" placeholder="Enter Password" name="password" required>
			    <hr>
	      		<input type="submit" name="login" value="Login">
	      		<button><a href="/carpool/register">Register</a></button>
	      		<label>
	        		<input type="checkbox" checked="checked" name="remember"> Remember me
	      		</label>
				</form>
				</div>
			</div>
			<div class="col-md-4 col-sm-12">
				<div class="divider-wrapper divider-three">
					<i class="fa fa-life-ring"></i>
					<h2>Drive</h2>
					<p>Drive when you want. Find opportunities around you.</p>
					<a href="about.html" class="btn btn-default">Sign up to drive</a>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- copyright section -->
<div class="copyright">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<p>Copyright © 2084 Company Name</p>
			</div>
			<div class="col-md-6 col-sm-6">
				<ul class="social-icons">
					<li><a href="#" class="fa fa-facebook"></a></li>
					<li><a href="#" class="fa fa-twitter"></a></li>
					<li><a href="#" class="fa fa-dribbble"></a></li>
					<li><a href="#" class="fa fa-pinterest"></a></li>
					<li><a href="#" class="fa fa-behance"></a></li>
					<li><a href="#" class="fa fa-envelope-o"></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>


<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>	
<script src="js/nivo-lightbox.min.js"></script>
<script src="js/custom.js"></script>

<?php
		include_once ('includes/config.php');
		$db = pg_connect($conn_str);
		if (isset($_POST['login'])) {

			$email = $_POST['email'];
			$pword = $_POST['password'];
			$result = pg_query($db, "SELECT * FROM app_user WHERE email = '$_POST[email]'");
			$row = pg_fetch_assoc($result);

			if(!$result) {
				echo "Login Failed!";
			}
			else {
				$phash = $row[password];

				if (password_verify($pword, $phash)) {
					$_SESSION['use']=$email;
					if ($_POST['email'] == "admin") {
						header("Location: /carpool/admin");	
					} else {
						header("Location: /carpool/home");
					}
				} else {
					echo "<p>Incorrect email/password!</p>";
				}
			}
		}
?>
</body>
</html>