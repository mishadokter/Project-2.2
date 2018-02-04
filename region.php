<?php // Head 
	include 'inc/head.php';
	include 'inc/database.php';
	
	// User must be logged in to acces this page
	@session_start();
	if($_SESSION['login']) {
	include 'inc/nav.php'; 
?>

	<div class="footer">
	<h1 class="pageTitle">Region overview.</h1>
	<h3>Select a region</h3>
	<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="get" accept-charset="utf-8">
		<select name="r" multiple>
			<?php //todo for loop over continenten ?>
		</select>
	</form>
	

<?php 
	} // End login
	
	else {
		header("location: login.php");
	}
?>