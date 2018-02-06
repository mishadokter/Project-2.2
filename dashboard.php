<?php // Head 
	include 'inc/head.php';
	include 'inc/database.php';
	
	// User must be logged in to acces this page
	@session_start();
	if($_SESSION['login']) {
	include 'inc/nav.php'; 
	
	// Start with fetching data from the database
	$sql = "SELECT username, name, country, user_stations.user_id AS user_id, user_stations.station_id AS station_id
			FROM stations, users, user_stations
			WHERE user_stations.user_id = users.id
			AND user_stations.station_id = stations.stn";
	
	$result = $db->query($sql);
	
	while($row = $result->fetch_assoc()) {
		
		$username		= $row["username"];
		$country      	= $row["country"];
		$region			= $row["name"];
	}
	?>
	
	  <div class="footer">
		<h1 class="pageTitle">Dashboard</h1>
		<p>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc nulla massa, finibus id urna quis, mattis consectetur tortor. 
		Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed lobortis metus vel pretium sagittis.
		Vestibulum consectetur arcu mi, a pulvinar nisi consequat id. Aliquam erat volutpat. Donec sagittis dui tortor, non convallis augue vehicula vitae. 
		Nulla ante ligula, aliquam eu laoreet vel, consectetur nec ante. <br> <br> Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. 
		Aenean pretium massa eu metus rhoncus, et facilisis risus bibendum. Nulla aliquam viverra est, quis ornare nisl lobortis et. 
		Duis in eros at leo bibendum pellentesque eget non metus. 
		Sed pellentesque nunc diam, ac aliquet turpis rhoncus eu. Vestibulum molestie nunc a sem placerat faucibus vitae quis dolor.<br><br>
		Our weatherservice contains 230 countries/regions and 8000 weather stations </p>
		
	  </div>
	  
	  <form action="stationgraph.php" method="GET">
	  <select name="s" required>
		<option value=""> --- Choose a country or region --- </option>
            <?php 
			$user_id = $_SESSION['user_id'];
			$query= $db->query("SELECT stations.name, stations.stn from stations INNER JOIN user_stations ON user_stations.station_id=stations.stn WHERE user_id = $user_id");
             while ($rows = $query->fetch_array(MYSQLI_ASSOC)) {
                $value= $rows['country']; ?>
                <option value=<?=$rows['stn'];?>><?=$rows['name'];?></option>
                <?php } ?>
             </select>
             <select name="type" required>
	  			<option value=""> --- Choose a data type --- </option>
             	<option value="temp">Temperature</option>
             	<option value="humid">Humidity</option>
             </select>
             <select name="d" id="" required>
             	<option value=""> --- Over a period of --- </option>
             	<option value="1">1 Day</option>
             	<option value="2">2 Days</option>
             	<option value="3">3 Days</option>
             	<option value="4">4 Days</option>
             	<option value="5">5 Days</option>
             	<option value="6">6 Days</option>
             	<option value="7">7 Days</option>
             </select>
				<input type="submit" class="selected_Country" value="Submit!">
			 </form>
			 
	<?php if(isset($_POST['selected_country']))
		{	
			$selected_country = $_POST['selected_country'];
			echo "Chosen country: $selected_country";
		}
	} // End login
	
	else {
		header("location: login.php");
	}
	?>
  
</body>
</html>
