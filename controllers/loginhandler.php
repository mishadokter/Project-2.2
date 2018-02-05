<?php
include '../inc/database.php';
	if(isset($_POST['username']) && isset($_POST['password']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$query 	  = "SELECT id, username, password FROM users WHERE username='$username' AND password='$password'";
		$result   = mysqli_query($db, $query) or die (mysqli_error($db));
		$count    = mysqli_num_rows($result);
		$row	  = mysqli_fetch_assoc($result);
		$user_id = $row['id'];
		
		if (!$row) {
			echo "Invalid username and/or password <br> <a href='../login.php'> Go back </a>";
		}
		
		else {
			// store session data
			@session_start();
			$_SESSION['login'] = true;
			$_SESSION['user_id'] = $user_id;
			header("location: /dashboard.php");
		}
		
	}
?>
