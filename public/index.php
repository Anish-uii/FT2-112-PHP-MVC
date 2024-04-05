<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('', 1);

session_start();
require '../app/core/init.php';


date_default_timezone_set('Asia/Kolkata');

$app = new App(); 
$app->loadController();
