<?php
$url = 'localhost';
$database = 'unwdmi';
$username = 'root';
$password = '';

$conn = mysqli_connect($url, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



?>