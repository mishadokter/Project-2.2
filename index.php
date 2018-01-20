<?php // Head 
	include 'inc/head.php';
	include 'inc/nav.php';
	include 'models/WeatherDataModel.php';
?>
<body>

<p> Body hi </p>

<!-- Body here -->
<?php
	$interpreter = new WeatherDataModel('data.dat');
	var_dump($interpreter->getMultipleStationData(["080290", "252820"]));

?>


</body>
</html>
