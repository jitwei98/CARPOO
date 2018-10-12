<?php  session_start(); ?>
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
<div id="contact">
	<div class="divider">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 mt30">
				<form class="w3-container" method="POST">
					<h1>Register</h1>
				    <p>Please fill in this form to create an account.</p>
				    <label for="phone_number">Phone Number</label>
				    <input class="form-control" type="text" placeholder="Enter Mobile Number" name="phone_number" required>
				    <hr>
				    <label for="email"><b>Email</b></label>
				    <input class="form-control" type="text" placeholder="Enter Email" name="email" required>
				    <hr>
				    <label for="name"><b>Name</b></label>
				    <input class="form-control" type="text" placeholder="Enter Full Name" name="name" required>
				    <hr>
				    <label for="gender"><b>Gender</b></label>
					<input class="form-control" list="genders" name="gender">
					<datalist id="genders">
						<option value="M">Male</option>
						<option value="F">Female</option>
					</datalist>
				    <hr>
				    <label for="dob"><b>Date of birth</b></label>
				    <input class="form-control" type="date" name="dob" required>
				    <hr>
				    <label for="password"><b>Password</b></label>
				    <input class="form-control" type="password" placeholder="Enter Password" name="password" required>
				    <hr>
				    <label for="password-repeat"><b>Repeat Password</b></label>
				    <input class="form-control" type="password" placeholder="Repeat Password" name="password-repeat" required>
				    <hr>
				    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
				    <input class="btn btn-default" type="submit" name="register" value="Register"/>
				</form>
				<?php
				include_once ('includes/config.php');
				$db = pg_connect($conn_str);
				if(isset($_POST['register'])) {
					$pword = $_POST['password'];
					// $phash = password_hash($pword, PASSWORD_DEFAULT);
					$phash = $pword;

					$res = pg_query($db, "INSERT INTO app_user VALUES ('$_POST[phone_number]', '$_POST[email]', '$_POST[name]', '$_POST[gender]', '$_POST[dob]', '$phash')");
					if (!$res) {
						echo "Register failed!!"."<br>";
						echo pg_last_error($db)."<br>";
					} 
					else {
						$_SESSION['use']=$_POST['email'];
						header("Location: /carpool/home");
					}
				}
				?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- copyright section -->
<?php include_once('includes/footer.php') ?>
</body>
</html>
