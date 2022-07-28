<?php
session_start();
extract($_POST);

//Debugging
if(empty($_SERVER['CONTENT_TYPE']))
{ 
 $_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded"; 
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Data Base Credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'zlual');
define('DB_PASSWORD', 'Zlual');
define('DB_NAME', 'zlual_IA3');

// Attempt Connection String
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn -> connect_errno) {
    $alertmsg = "Failed to connect to MySQL: " . $conn -> connect_error;
    $alert = "danger";
}
?>