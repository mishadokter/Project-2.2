<!-- Nav bar -->
<?php
@session_start();
//error_reporting(0);
error_reporting( error_reporting() & ~E_NOTICE ); //Hides the "variable not defined" error
?>
  <ul class="navigation">
    <li><a href="index.php" title="">Home</a></li>
    <li><a href="#" title="">Ipsum</a></li>
    <li><a href="#" title="">Dolor</a>
      <ul>
        <li><a href="#" title="">Foo</a></li>
        <li><a href="#" title="">Bar</a></li>
        <li><a href="#" title="">Foobar</a></li>
        <li><a href="#" title="">DutchSat</a></li>
      </ul>
    </li>
	<?php
	if(!$_SESSION['login']) { ?>
		<li><a href="login.php">Login</a></li>
	<?php 
	}
	else { ?>
		<li><a href="login.php?logout">Logout</a></li>
	<?php } ?>
    <div class="clear"></div>
  </ul>
