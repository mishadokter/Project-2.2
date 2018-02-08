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
		
		<input type="button" value="Download CSV" onclick="exportCSVFile(headers, telemetry, fileTitle);"></input>
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
			$caption = 'null';
			if (getv('type') == 'temp') {$caption = "Temperature"}else{$caption = "Humidity"}
			$query = "/api.php?"+"type="+getv('type')+"&d="+getv('d')+"&s="+getv('s');
			
			console.log($query);
			$.getJSON($query, function(result){
				console.log("Result " +result);
				var ctx = $("#testchart");
				
				var myChart = new Chart(ctx, {
					type: "line",
					
					data: {
						labels: result[0],
						datasets: [{
							data: result[1],
							label: $caption,
							borderwidth: 1,
							borderColor: [
							'rgba(120, 177, 20, 1)'
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

function convertToCSV(objArray) {
    var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
    var str = '';

    for (var i = 0; i < array.length; i++) {
        var line = '';
        for (var index in array[i]) {
            if (line != '') line += ','

            line += array[i][index];
        }

        str += line + '\r\n';
    }

    return str;
}			

function exportCSVFile(headers, items, fileTitle) {
  console.log("Entered export");
    if (headers) {
        console.log(headers);
    }

    // Convert Object to JSON
    var jsonObject = JSON.stringify(items);

    var csv = JSON.stringify(items);

    var exportedFilenmae = fileTitle + '.csv' || 'export.csv';

    console.log('Create File');
  
    var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    if (navigator.msSaveBlob) { // IE 10+
        console.log("IE10+")
        navigator.msSaveBlob(blob, exportedFilenmae);
    } else {
        console.log("Modern Browser")
        var link = document.createElement("a");
        if (link.download !== undefined) { 
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", exportedFilenmae);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
    console.log("Finished");
}

var headers = {
    timestamp: 'Timestamp'.replace(/,/g, ''),
    temp: " Temp",
    humidity: " Humidity"
};

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
			if (getv('type') == 'temp') {$caption = "Temperature"}else{$caption = "Humidity"}
			$query = "/api.php?"+"type="+getv('type')+"&d="+getv('d')+"&s="+getv('s');
		var saveResult;
			$.getJSON($query, function (result){
				console.log("Result " +result);
				saveResult = result;
				async: false;
			});
async: false;
telemetry = saveResult;
console.log(telemetry);

// Get datetime for the filename
var d = new Date().toLocaleString();

var fileTitle = "Weather "+ d +"";

		</script>
		<script>
			$(document).ready(function() {
			  $("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
			  
			  setTimeout(function(){
			   window.location.reload(1);
			}, 115000);
			});
		</script>
		<script src="/libs/jquery-3.3.1.min.js"></script>
	</body>
</html>

<?php
	} // End login
	
	else {
		header("location: login.php");
	}