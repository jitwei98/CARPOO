<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<?php
				if (isset($_SESSION['use'])){
					echo '
					<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon icon-bar"></span>
					</button>';
				}
			?>
			<a href="/carpool/home" class="navbar-brand"> CARPOOL</a>
		</div>
		<?php
			if (isset($_SESSION['use'])){
				echo '
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="logout.php">Log Out</a></li>
					</ul>
				</div>';
			}
		?>
	</div>
</nav>