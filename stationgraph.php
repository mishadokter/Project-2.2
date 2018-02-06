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
			function getv(variable)
			{
		       var query = window.location.search.substring(1);
		       var vars = query.split("&");
		       for (var i=0;i<vars.length;i++) {
	               var pair = vars[i].split("=");
	               if(pair[0] == variable){return pair[1];}
	       		}
      		 	return(false);
			}
			$query = "/api.php?"+"type="+getv('type')+"&d="+getv('d')+"&s="+getv('s');
			console.log($query);
			$.getJSON($query, function(result){
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