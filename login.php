<?php
	include 'inc/head.php';
	include 'inc/nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>UNWDMI | Login</title>
</head>
<body>
	<div class='logincontainer'>
		<form action="controllers/loginhandler.php" method="POST">
			<label for="username">Username: </label>
			<input type="text" name="username">
			<br>
			<label for="password">Password: </label>
			<input type="password" name="password">
			<br>
			<input type="submit" value="Login">
		</form>
	</div>
</body>
</html>