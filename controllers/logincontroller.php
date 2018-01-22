<?php
include '../inc/database.php';
	if(isset($_POST['username']) && isset($_POST['password']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$query 	  = "SELECT id, username, password, level FROM users WHERE username='$username' AND password='$password'";
		$result   = mysqli_query($db, $query) or die (mysqli_error($db));
		$count    = mysqli_num_rows($result);
		$row	  = mysqli_fetch_assoc($result);
		$level	  = $row["level"];
		
		// store session data
		@session_start();
		$_SESSION['login'] = true;
		$_SESSION['level'] = $level;
		
		if ($level == 1) {
			header("location: ../level1.php");
		}
		
		else {
			echo "Invalid username and/or password";
		}
		
	}
?>
