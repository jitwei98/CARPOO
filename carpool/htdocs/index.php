<?PHP

session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {

header ("Location: login.php");

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
		</div>
		<div class="w3-container">
			<form class="w3-container" action="/carpool/home" method="POST">
				<h1>Login</h1>
			    <label for="email"><b>Email</b></label>
			    <input type="text" placeholder="Enter Email" name="email" required>
			    <hr>
			    <label for="password"><b>Password</b></label>
			    <input type="password" placeholder="Enter Password" name="password" required>
			    <hr>
	      		<input type="submit" name="login" value="login">
	      		<button><a href="/carpool/register">Register</a></button>
	      		<label>
	        		<input type="checkbox" checked="checked" name="remember"> Remember me
	      		</label>
			</form>
		</div>
		<?php
		// Connect to the database. Please change the password in the following line accordingly
    	$db = pg_connect("host=localhost port=5432 dbname=carpool user=postgres password=test");
    	if (isset($_POST['login'])) {
		    $result = pg_query($db, "SELECT * FROM app_user where email = '$_POST[email]' and password = '$POST_['password']");
    		if (!result) {
    			$row    = pg_fetch_assoc($result);
    		}
    		else {
    			echo "Login Failed!"
    		}
    	}
		?>
	</body>
</html>
