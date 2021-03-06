<?php   session_start();  ?>
<?php
	if (isset($_SESSION['use'])){
		if (($_SESSION['isadmin']) == 'f'){
			header("Location: /carpool/passenger_home"); 
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

	<div id="home">
		<div class="container">
			<div class="row">
				<div class="col-md-5 col-sm-3"></div>
				<div class="col-md-7 col-sm-9">
					<h3 style="color: #fff;font-weight: bold;">move the way</h3>
					<h1 style="color: #fff;font-weight: bold;font-size: 30px;">you want</h1>
				</div>
			</div>
		</div>
	</div>
 	<div class="w3-container page_container">
		<?php
			include_once ("includes/footer.php");
		?>
	</div>
	  <div class="modal fade" id="myLoginModal" role="dialog">
	    <div class="modal-dialog">
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <!-- <button type="button" class="close" data-dismiss="modal" style="float: right">&times;</button> -->
	          <h4 class="modal-title"><span>Login</span></h4>
	        </div>
	        <div class="modal-body">
	        	<form class="w3-container" method="POST">
				    <label for="email"><b>Email</b></label>
				    <input type="text" placeholder="Enter Email" name="email" required>
				    <hr>
				    <label for="password"><b>Password</b></label>
				    <input type="password" placeholder="Enter Password" name="password" required>
				    <hr>
				    <input type="submit" name="login" value="Login">
		          	<label>
		        		<input type="checkbox" checked="checked" name="remember"> Remember me
		      		</label>
				</form>
	        </div>
	      </div>
	    </div>
	</div>
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
						if (($row[isadmin]) == 'f') {
							header("Location: /carpool/passenger_home");	
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

