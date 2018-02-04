<?php // Head 
	include 'inc/head.php';
	include 'inc/database.php';
	
	// User must be logged in to acces this page
	@session_start();
	if($_SESSION['login']) {
	include 'inc/nav.php'; 
?>
	
	  <div class="footer">
		<h1 class="pageTitle">Graph example</h1>
		<canvas id="testchart"></canvas>
		<script>
			$.getJSON("/api.php?type=temp&s=124690&d=8", function(result){
				console.log("Resultl " +result);
				var ctx = $("#testchart");
				var myChart = new Chart(ctx, {
					type: "line",
					
					data: {
						labels: result[0],
						datasets: [{
							data: result[1],
							label: "Temperature ℃",
							borderwidth: 1,
							borderColor: [
							'rgba(255,99,132,1)'
							]
						}]
						
					},
					options: {
						responsive: true,
				        scales: {
				            yAxes: [{
				                ticks: {
				                    beginAtZero:true,
				                    suggestedMax: 30
				                }
				            }]
				        }
			    	}
				}
			
			)});
		</script>
	</body>
</html>

<?php
	} // End login
	
	else {
		header("location: login.php");
	}