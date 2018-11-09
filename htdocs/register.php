<?php  session_start(); ?>
<!DOCTYPE html>
<html>
	<?php
		include_once ('includes/header.php'); 
		include_once ('includes/navbar.php');
	?>
	<div class="w3-container page_container">
			<form class="w3-container" method="POST">
				<h1>Register</h1>
			    <p>Please fill in this form to create an account.</p>
			    <label for="phone_number"><b>Phone Number</b></label>
			    <input type="text" placeholder="Enter Mobile Number" name="phone_number" required>
			    <hr>
			    <label for="email"><b>Email</b></label>
			    <input type="text" placeholder="Enter Email" name="email" required>
			    <hr>
			    <label for="name"><b>Name</b></label>
			    <input type="text" placeholder="Enter Full Name" name="name" required>
			    <hr>
			    <label for="gender"><b>Gender</b></label>
				<input list="genders" name="gender">
				<datalist id="genders">
					<option value="M">Male</option>
					<option value="F">Female</option>
				</datalist>
			    <hr>
			    <label for="dob"><b>Date of birth</b></label>
			    <input type="date" name="dob" required>
			    <hr>
			    <label for="password"><b>Password</b></label>
			    <input type="password" placeholder="Enter Password" name="password" required>
			    <hr>
			    <label for="password-repeat"><b>Repeat Password</b></label>
			    <input type="password" placeholder="Repeat Password" name="password-repeat" required>
			    <hr>
			    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
			    <input type="submit" name="register" value="Register"/>
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
			<?php
				include_once ("includes/footer.php");
			?>
		</div>
	</body>
</html>
