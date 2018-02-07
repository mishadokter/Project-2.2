<?php

include 'models/WeatherDataModel.php';

$Weathermodel = new WeatherDataModel();

echo '<pre>' . var_export($Weathermodel->dewPointOverview("taiwan"), true) . '</pre>';

?>