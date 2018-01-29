<?php
include 'models/WeatherDataModel.php';

$weatherModel = new WeatherDataModel();
$weatherModel->interp("7203402018011817014810053100741004710270009117300000000100000464124;");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>test</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script> 

</head>
<body>
	<canvas id="testchart" width="400" height="400"></canvas>


<script>
	$.getJSON("/api/test.php", function(result)){
		var ctx = $("#testchart");
		var myChart = new Chart(ctx, {
			type: "bar",
			responsive: true,
			data: {
				labels: [1, 2, 3, 4, 5, 7],
				datasets: [{
					data: [12,4,6,6,4,6,],
					label: "test data",
					borderwidth: 1
				}]
				
			},
			options: {
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true
		                }
		            }]
		        }
	    	}
		}
	
	});
</script>
</body>
</html>