<!-- Nav bar -->
<?php
@session_start();
//error_reporting(0);
error_reporting( error_reporting() & ~E_NOTICE ); //Hides the "variable not defined" error
?>
	<?php
	if($_SESSION['login']) { ?>
	<ul class="navigation">
		<li><a href="dashboard.php" title="">Dashboard</a></li>
		<li><a href="about.php"	title="">About us</a></li>	
		<li><a href="login.php?logout">Logout</a></li>
		<div class="clear"></div>
	</ul>
	<?php 
	}
	else { ?>
	<ul class="navigation">
		<li><a href="index.php" title="">Home</a></li>
		<li><a href="#" title="">About</a></li>
		<li><a href="login.php">Login</a></li>
		<div class="clear"></div>
	</ul>
	<?php } ?>
