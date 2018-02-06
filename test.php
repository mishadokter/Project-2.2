<?php

include 'models/WeatherDataModel.php';

$Weathermodel = new WeatherDataModel();

$Weathermodel->highDewPointStations("taiwan");

?>