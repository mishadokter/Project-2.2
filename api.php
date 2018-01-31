<?php
include('models/WeatherDataModel.php');
if (isset($_GET['type'])){
	$type = $_GET['type'];
	$station = $_GET['s'];
	$period = $_GET['d'];

	// Weather model
	$weatherModel = new WeatherDataModel();

	// Get Weatherstation data of specified time.
	$historicDate = date('Y-m-d', strtotime(' -'.$period.' day'));
			$data = $weatherModel->getStationData($station, $historicDate, date('Y-m-d'));

			if (!$data)
				echo "No station data available";
			else
				echo json_encode($data);
			break;

	// Case switch voor variable type
	switch ($type) {
		case 'temp':
			
		
		default:
			echo "No valid type";
			break;
	}
	
	
}else {
	echo "Invalid query: no get variables set";
}


?>