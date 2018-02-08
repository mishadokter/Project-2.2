<?php 
	include 'inc/head.php';
	include 'inc/database.php';
	include('models/WeatherDataModel.php');

	// User must be logged in to acces this page
	@session_start();
	if($_SESSION['login']) {
	include 'inc/nav.php'; 


		if (isset($_GET['country'])){

			// Weather model
			$weatherModel = new WeatherDataModel();

			$data = $weatherModel->dewPointOverview("Asia");
		}
	}
?>