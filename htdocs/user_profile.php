<?php   session_start();  ?>
<?php
  if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
  {
  	header("Location: /carpool");  
  }
  $db = pg_connect("host=localhost port=5432 dbname=carpool user=postgres password=test");
  $user = $_SESSION['use'];
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
	<div class="w3-sidebar w3-bar-block w3-dark-gray" style="width:10%"> 
		<a href="#" class="w3-bar-item w3-button">Search for Car Pool</a>
		<a href="/carpool/user_profile" class="w3-bar-item w3-button">Edit User Profile</a>
		<a href="#" class="w3-bar-item w3-button">Car Pool History</a>
	</div>
	<div style="margin-left: 10%">
		<div class="w3-container">
			<h1>User Profile</h1>
			<form class="w3-container" method="POST">
				<table class="w3-table-all w3-hoverable">
					<?php 
					$query_user_details = "SELECT * FROM app_user u WHERE u.email = '$user'";
					$row = pg_fetch_assoc(pg_query($db, $query_user_details));
					// foreach ($row as $value) {
					// 	echo $value."<br>";
					// }
					?>
					<tr>
						<td><label for="name"><b>Name : </b></label></td>
						<?php 
						echo '<td><input type="text" placeholder="'.$row[name].'" name="name_updated"></td>';
						?>
					</tr>
					<tr>
						<!-- Email update disabled for now -->
						<td><label for="email"><b>Email : </b></label></td>
						<?php 
						echo '<td><input type="text" placeholder="'.$row[email].'" name="email_updated" readonly></td>';
						?>
					</tr>
					<tr>
						<td><label for="phone_number"><b>Phone number : </b></label></td>
						<?php 
						echo '<td><input type="text" placeholder="'.$row[phone_number].'" name="phone_number_updated"></td>';
						?>
					</tr>
					<tr>
						<td><label for="Gender"><b>Gender : </b></label></td>
						<?php 
						echo '<td><select placeholder="'.$row[gender].'" name="gender_updated">
						<option value="" disabled selected>Select your option</option>
						<option value="M">Male</option>
						<option value="F">Female</option>
						</select></td>';
						?>
					</tr>
					<tr>
						<td><label for="dob"><b>Date of birth : </b></label></td>
						<?php 
						$dob_placeholder = substr($row[dob], 5)."-".substr($row[dob], 0, 4);
						echo '<td><input type="date" name="dob_updated"></td>';
						?>
					</tr>
					<tr>
						<td><label for="password"><b>Password : </b></label></td>
						<?php 
						echo '<td><input type="password" placeholder="Enter Password" name="password" required></td>';
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

				function validatePassword($db, $user, $row) {
					$hash = $row[password];
					return password_verify($_POST[password], $hash);
				}

				function updateProfile($db, $user, $row) {
					$name = !empty($_POST[name_updated]) ? $_POST[name_updated] : $row[name];
					$phone_number = !empty($_POST[phone_number_updated]) ? $_POST[phone_number_updated] : $row[phone_number];
					$gender = !empty($_POST[gender_updated]) ? $_POST[gender_updated] : $row[gender];
					$dob = !empty($_POST[dob_updated]) ? $_POST[dob_updated] : $row[dob];
					$password = $row[password];
					if (comparePassword()) {
						$password = password_hash($_POST[password_updated], PASSWORD_DEFAULT);
					}
					$query = "";
					// echo $plate_number . "<br>" . $model . "<br>" . $color . "<br>";
					$query .= "UPDATE app_user SET name='$name', phone_number='$phone_number', gender='$gender', dob='$dob', password='$password';";
					return pg_query($db, $query);
				}


				
				if (!empty($_POST['edit']) && isModified()) {
					if (!validatePassword($db, $user, $row)) {
						echo "Incorrect password!<br>";
					} else if (updateProfile($db, $user, $row)) { // affected rows > 0
						// echo "User profile successfully updated!";
						header("Location: /carpool/user_profile");
					} else {
						echo "Error updating user profile!<br>";
					}
				}
				?>
			</h1>
		</div>
	</div>
</body>
</html>
