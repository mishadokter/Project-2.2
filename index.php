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
	var_dump($interpreter->getStationData("080290"));

?>


</body>
</html>
