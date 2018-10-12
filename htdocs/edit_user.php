<?php   session_start();  ?>
<?php
  if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
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
			<table class="w3-table-all w3-hoverable">
				<?php 
					include_once ('includes/config.php');
					$db = pg_connect($conn_str);
					// $query = 'SELECT * FROM app_user WHERE email='dhuntington0@hud.gov'';
					$result = pg_query($db, "SELECT * FROM app_user WHERE email='$_GET[email]'");
					if (!$result) {
						echo pg_last_error($db)."<br>";
					} else {
						$row = pg_fetch_assoc($result);
				?>
				<!-- TODO: Follow index.php -->
				<tr>
					<td><label for="phone_number"><b>phone_number : </b></label></td>
					<td><input type="text" placeholder="<?php echo $row['phone_number'] ?>" name="phone_number_updated"></td>
				</tr>
				<tr>
					<td><label for="email"><b>email : </b></label></td>
					<td><input type="text" placeholder="<?php echo $row['email'] ?>" name="email_updated"></td>
				</tr>
				<tr>
					<td><label for="name"><b>name : </b></label></td>
					<td><input type="text" placeholder="<?php echo $row['name'] ?>" name="name_updated"></td>
				</tr>
				<tr>
					<td><label for="gender"><b>gender : </b></label></td>
					<td>
					<datalist id="genders">
						<option 
						<?php if ($row['gender'] == "M") echo "selected"; ?>
						value="M">Male</option>
						<option 
						<?php if ($row['gender'] == "F") echo "selected"; ?>
						value="F">Female</option>
					</datalist>
					</td>
				</tr>
				<tr>
					<td><label for="dob"><b>dob : </b></label></td>
					<td><input type="text" value="<?php echo $row['dob'] ?>" name="phone_number_updated"></td>
				</tr>
				<?php 
					}
				?>
				<!-- TODO: update in database -->
			</table>
		</div>
	</div>
</body>
</html>
