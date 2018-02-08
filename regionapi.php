<?php
include('models/WeatherDataModel.php');

// AANPASSEN
if (isset($_GET['country'])){
	$continent = $_GET['country'];
	$WeatherModel = new WeatherDataModel();

	$data = $WeatherModel->dewPointOverview("taiwan");
	echo json_encode($data);
}
else{
	echo "No continent spcified";
}
?>