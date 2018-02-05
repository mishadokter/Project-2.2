<?php // Head 
	include 'inc/head.php';
	include 'inc/database.php';
	
	// User must be logged in to acces this page
	@session_start();
	if($_SESSION['login']) {
	include 'inc/nav.php'; 
	
	// Fetch data from select option
	$selected_country = mysqli_real_escape_string($db, $_POST['selected_country']);
	$query= $db->query("SELECT name FROM stations WHERE country = '".$_POST['selected_country']."'");  
?>
	
	  <div class="footer">
		<h1 class="pageTitle">Graph example of <?php echo "$selected_country";?> </h1>
		<?php 
		echo "<h4> Weather stations of $selected_country:</h4> ";
		while($row = $query->fetch_assoc()) {
            $name	= $row['name'];
			echo "<p> $name </p>";
		}
		?>
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script> 
</html>
 
<?php
	} // End login
	
	else {
		header("location: login.php");
	}
