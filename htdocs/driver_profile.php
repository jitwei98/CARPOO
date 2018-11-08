<!-- not used -->
<?php   session_start();  ?>
<?php
	include_once ('includes/check_user.php');
 	include_once ('includes/config.php');
	$db = pg_connect($conn_str);
	$driver = $_SESSION['use'];
	date_default_timezone_set('Asia/Singapore');
	$date_curr = date("Y/m/d");
	$time_curr = date("h/i/sa");
  ?>

  <!DOCTYPE html>
  <html>
	<?php
		include_once ('includes/header.php'); 
		include_once ('includes/driver_navbar.php');
	?>
	<div class="w3-container page_container">
		<div class="w3-container">
			<h1>Driver Profile</h1>
			<form class="w3-container" method="POST">
				<table class="w3-table-all w3-hoverable">
					<?php 
					$query_user_details = "SELECT * FROM app_user d WHERE d.email = '$user'";
					$row = pg_fetch_assoc(pg_query($db, $query_user_details));
					?>
					<tr>
						<td><label for="name"><b>Name : </b></label></td>
						<?php 
						echo '<td><input type="text" value="'.$row['name'].'" name="name_updated"></td>';
						?>
					</tr>
					<tr>
						<!-- Email update disabled for now -->
						<td><label for="email"><b>Email : </b></label></td>
						<?php 
						echo '<td>'.$row['email'].'</td>';
						?>
					</tr>
					<tr>
						<td><label for="phone_number"><b>Phone number : </b></label></td>
						<?php 
						echo '<td><input type="text" value="'.$row['phone_number'].'" name="phone_number_updated"></td>';
						?>
					</tr>
					<tr>
						<td><label for="Gender"><b>Gender : </b></label></td>
						<?php 
						echo '<td>'.$row['gender'].'</td>';
						?>
					</tr>
					<tr>
						<td><label for="dob"><b>Date of birth : </b></label></td>
						<?php 
						$dob_placeholder = substr($row['dob'], 5)."-".substr($row['dob'], 0, 4);
						echo '<td>'.$dob_placeholder.'</td>';
						?>
					</tr>
					<tr>
						<td><label for="password_new"><b>New Password : </b></label></td>
						<?php 
						echo '<td><input type="password" placeholder="New Password" name="password_updated"></td>';
						?>
					</tr>
					<tr>
						<td><label for="password_repeated"><b>Confirm Password : </b></label></td>
						<?php 
						echo '<td><input type="password" placeholder="Confirm Password" name="password_repeated"></td>';
						?>
					</tr>
				</table>
				<input type="submit" name="edit" value="Save" style="float:right;">
			</form>

			<h1>
				<?php 
				function isModified() {
					return !empty($_POST[name_updated]) || !empty($_POST[phone_number_updated]) || !empty($_POST[gender_updated]) || !empty($_POST[dob_updated]) 
					|| (!empty($_POST[password_updated]) && !empty($_POST[password_repeated]));
				}

				function comparePassword() {
					if (empty($_POST[password_updated]) || empty($_POST[password_updated]))
						return false;
					return $_POST[password_updated] == $_POST[password_repeated];
				}

				// function validatePassword($db, $user, $row) {
				// 	$hash = $row[password];
				// 	return password_verify($_POST[password], $hash);
				// }

				function updateProfile($db, $user, $row) {
					$name = !empty($_POST[name_updated]) ? $_POST[name_updated] : $row[name];
					$phone_number = !empty($_POST[phone_number_updated]) ? $_POST[phone_number_updated] : $row[phone_number];
					if (comparePassword()) {
						$password = password_hash($_POST[password_updated], PASSWORD_DEFAULT);
					}
					$query = "";
					// echo $plate_number . "<br>" . $model . "<br>" . $color . "<br>";
					$query .= "UPDATE app_user SET name='$name', phone_number='$phone_number', password='$password';";
					return pg_query($db, $query);
				}


				
				if (!empty($_POST['edit']) && isModified()) {
					// if (!validatePassword($db, $user, $row)) {
					// 	echo "Incorrect password!<br>";
					 if (updateProfile($db, $user, $row)) { // affected rows > 0
					 	echo "<script type='text/javascript'>
					 	alert('Driver profile successfully updated!');
					 	window.location = '/carpool/driver_profile';
					 	</script>";
						// header("Location: /carpool/user_profile");
					} else {
						echo "Error updating driver profile!<br>";
						echo pg_last_error($db)."<br>";
					}
				}
				?>
			</h1>
		</div>
		<?php
			include_once ("includes/footer.php");
		?>
	</div>
</body>
</html>
