<?php   session_start();  ?>
<?php
	// If session is not set or user is not admin then redirect to Login Page
if(!isset($_SESSION['use']) || $_SESSION['use'] != "admin") 
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
	td a { 
		display: block; 
	}
</style>
</head>
<body>
	<div class="w3-container w3-black w3-top">
		<a href="/carpool/home" style="float:left;"><h1>Car Pooling</h1></a>
		<a href="logout.php" style="float:right;padding-top: 45px">Log Out</a>
	</div>
	<div class="w3-sidebar w3-bar-block w3-dark-gray" style="width:10%"> 
		<a href="#" class="w3-bar-item w3-button">Table_1</a>
		<a href="#" class="w3-bar-item w3-button">Table_2</a>
		<a href="#" class="w3-bar-item w3-button">Table_3</a>
	</div>
	<div style="margin-left: 10%; margin-top:74px;">
		<div class="w3-container">
			<h1>app_user</h1>
			<form class="w3-container" method="POST">
				<table class="w3-table-all w3-hoverable">
					<?php 
					include_once ('includes/config.php');
					$db = pg_connect($conn_str);
					$result = pg_query($db, "SELECT * FROM app_user WHERE email='$_GET[edit_id]'");
					if (pg_num_rows($result) == 0) {
						echo "<h6>User not found!<br></h6>";
					} else if (!$result) {
						echo pg_last_error($db)."<br>";
					} else {
						$row = pg_fetch_assoc($result);
						?>
						<!-- TODO: Follow index.php -->
						<tr>
							<td><label for="phone_number"><b>phone_number : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['phone_number'].'" name="phone_number_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="email"><b>email : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['email'].'" name="email_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="name"><b>name : </b></label></td>
							<?php echo '<td><input type="text" value="'.$row['name'].'" name="name_updated"></td>'; ?>
						</tr>
						<tr>
							<td><label for="gender"><b>gender : </b></label></td>
							<td><input list="genders" name="gender_updated"><datalist id="genders">
								<?php 
								if ($row['gender'] == "M") {
									echo '<option value="M" selected>Male</option>
									<option value="F">Female</option>';
								} else if ($row['gender'] == "F") {
									echo '<option value="M">Male</option>
									<option value="F" selected>Female</option>';
								}
								?>
							</datalist></td>
						</tr>
						<tr>
							<td><label for="dob"><b>dob : </b></label></td>
							<!-- TODO: date input instead of text input -->
							<?php echo '<td><input type="date" value="'.$row['dob'].'" name="dob_updated"></td>'; ?>
						</tr>
					
				</table>
				<input type="submit" name="edit" value="Submit">
				<?php }?>
			</form>


			<!-- Update in database -->
			<h1>
				<?php 
				date_default_timezone_set('Asia/Singapore');
				$date_curr = date("Y/m/d");
				$time_curr = date("h/i/sa");

				function isModified() {
					return !empty($_POST[phone_number_updated]) || !empty($_POST[email_updated]) || !empty($_POST[name_updated]) || !empty($_POST[gender_updated]) || !empty($_POST[dob_updated]);
				}

				function update_user($db, $user, $row) {
					$phone_number = !empty($_POST[phone_number_updated]) ? $_POST[phone_number_updated] : $row[phone_number];
					$email = !empty($_POST[email_updated]) ? $_POST[email_updated] : $row[email];
					$name = !empty($_POST[name_updated]) ? $_POST[name_updated] : $row[name];
					$gender = !empty($_POST[gender_updated]) ? $_POST[gender_updated] : $row[gender];
					$dob = !empty($_POST[dob_updated]) ? $_POST[dob_updated] : $row[dob];
					
					$query = "UPDATE app_user SET phone_number='$phone_number', email='$email', name='$name', gender='$gender', dob='$dob' WHERE email='$_GET[edit_id]' ;";

					return pg_query($db, $query);
				}
				
				if (!empty($_POST['edit']) && isModified()) {
					if (update_user($db, $_GET[edit_id], $row)) { // affected rows > 0
						echo "User profile successfully updated!<br>";
						// header("Location: /carpool/admin_home");
					} else {
						echo "Error updating user profile!<br>";
						echo pg_last_error($db)."<br>";
					}
				}
				?>
			</h1>


		</div>
	</div>
</body>
</html>
