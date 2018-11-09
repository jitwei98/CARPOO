<?php   session_start();  ?>
<?php
	include_once ('includes/check_admin.php');
?>
<!DOCTYPE html>
<html>
<body>
	<?php 
		// include_once ('includes/navbar.php');
		// include_once ('includes/admin_sidenav.php');
		include_once ('includes/header.php');
		include_once ('includes/admin_navbar.php');
	?>
		<div class="w3-container page_container">
			<h1>app_user</h1>
			<form class="w3-container" method="POST">
				<table class="w3-table-all w3-hoverable">
					<?php 
					include_once ('includes/config.php');
					$db = pg_connect($conn_str);
						?>
						<!-- TODO: Follow index.php -->
						<tr>
							<td><label for="phone_number"><b>Phone number : </b></label></td>
							<?php echo '<td><input type="text" name="phone_number"></td>'; ?>
						</tr>
						<tr>
							<td><label for="email"><b>Email : </b></label></td>
							<?php echo '<td><input type="text" name="email"></td>'; ?>
						</tr>
						<tr>
							<td><label for="name"><b>Name : </b></label></td>
							<?php echo '<td><input type="text" name="name"></td>'; ?>
						</tr>
						<tr>
							<td><label for="gender"><b>Gender : </b></label></td>
							<?php echo '<td><input type="text" name="gender"></td>'; ?>
						</tr>
						<tr>
							<td><label for="dob"><b>Date of birth : </b></label></td>
							<?php echo '<td><input type="text" name="dob"></td>'; ?>
						</tr>
						<tr>
							<td><label for="password"><b>Password : </b></label></td>
							<?php echo '<td><input type="password" name="password"></td>'; ?>
						</tr>
				</table>
				<input type="submit" name="create" value="Submit">
			</form>


			<!-- Update in database -->
			<h1>
				<?php 
				date_default_timezone_set('Asia/Singapore');
				$date_curr = date("Y/m/d");
				$time_curr = date("h/i/sa");

				function create_app_user($db) {
					// $password = password_hash($_POST[password], PASSWORD_DEFAULT);
					$query = "INSERT INTO app_user VALUES (
								'$_POST[phone_number]', 
								'$_POST[email]', 
								'$_POST[name]', 
								'$_POST[gender]', 
								'$_POST[dob]',
								'$_POST[password]'
								 );";

					return pg_query($db, $query);
				}
				
				if (!empty($_POST['create'])) {
					if (create_app_user($db)) { // affected rows > 0
						echo "User successfully created!<br>";
					} else {
						echo "Error creating user!<br>";
						echo pg_last_error($db)."<br>";
					}
				}
				?>
			</h1>


		</div>
	</div>
</body>
</html>
