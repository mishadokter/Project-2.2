<?php // Head 
	include 'inc/head.php';
	include 'inc/database.php';
	// include 'models/WeatherDataModel.php';
?>
  
  <?php include 'inc/nav.php'; ?>
	  <div class="footer">
		<h1 class="pageTitle">Lorem Ipsum</h1>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc nulla massa, finibus id urna quis, mattis consectetur tortor. 
		Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed lobortis metus vel pretium sagittis.
		Vestibulum consectetur arcu mi, a pulvinar nisi consequat id. Aliquam erat volutpat. Donec sagittis dui tortor, non convallis augue vehicula vitae. 
		Nulla ante ligula, aliquam eu laoreet vel, consectetur nec ante. <br> <br> Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. 
		Aenean pretium massa eu metus rhoncus, et facilisis risus bibendum. Nulla aliquam viverra est, quis ornare nisl lobortis et. 
		Duis in eros at leo bibendum pellentesque eget non metus. 
		Sed pellentesque nunc diam, ac aliquet turpis rhoncus eu. Vestibulum molestie nunc a sem placerat faucibus vitae quis dolor.</p>
	  </div>
	  <form action="" method="POST">
	  <select name="selected_country" style='font-family: "Roboto", sans-serif; outline: 0; background: #f2f2f2; width: 100%; border: 150px; margin: 0 0 15px; padding: 15px; box-sizing: border-box; font-size: 14px'>

            <?php 
			$query= $db->query("SELECT country from stations GROUP BY country");
             while ($rows = $query->fetch_array(MYSQLI_ASSOC)) {
                    $value= $rows['country'];
                ?>
                 <option value="<?= $value?>"><?= $value?></option>
                <?php } ?>
             </select>
				<input type="submit" name="login" class="selected_Country" value="Submit!">
			 </form>
			 
	<?php if(isset($_POST['selected_country']))
		{	
			$selected_country = $_POST['selected_country'];
			echo "Chosen country: $selected_country";
		}
	?>
  
</body>
</html>