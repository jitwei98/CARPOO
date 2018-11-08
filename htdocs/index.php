<?php   session_start();  ?>
<?php
	if (isset($_SESSION['use'])){
		if (($_SESSION['isadmin']) == 'f'){
			header("Location: /carpool/home"); 
		}
		else {
			header("Location: /carpool/admin_home"); 
		}
	}
?>
<!DOCTYPE html>
<html>
	<?php
		include_once ('includes/header.php'); 
		include_once ('includes/navbar.php');
	?>
	<div class="w3-container page_container">
			<form class="w3-container" method="POST">
				<h1>Login</h1>
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
						// if (password_verify($pword, $phash)) {
						if ($pword == $phash) {
							$_SESSION['use']=$email;
							$_SESSION['isadmin'] = $row[isadmin];
							if (($row[isadmin]) == "f") {
								header("Location: /carpool/home");	
							} 
							else {
								echo $row[isadmin];
								$_SESSION['isadmin'] = $row[isadmin];
								header("Location: /carpool/admin_home");
							}
						} 
						else {
							echo "<p>Incorrect email/password!</p>";
						}
					}
				}
			?>
		</div>
	</body>
</html>
