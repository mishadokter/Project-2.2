<?php
	include 'inc/head.php';
	include 'inc/nav.php';
?>
	<div class="login-page">
		<div class="form">
			<form action="controllers/loginhandler.php" method="POST">
				<input type="text" name="username" placeholder="Username" required>
				<input type="password" name="password" placeholder="Password" required>
				<input type="submit" name="login" class="submitForm" value="Login">
			</form>
			<?php
				if(isset($_GET['logout'])) {
					@session_destroy();
					header("location: login.php");
				} ?>
		</div>
	</div>
</body>
</html>
