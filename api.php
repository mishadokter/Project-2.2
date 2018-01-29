<?php

if (isset($_GET)){
	$type = $_GET['type'];
	$stations = json_decode($_GET["s"]);
	// https://stackoverflow.com/questions/7206978/how-to-pass-an-array-via-get-in-php
}else {
	echo "Invalid query: no get variables set"
}


?>