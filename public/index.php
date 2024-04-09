<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('', 1);

session_start();
require '../app/core/config.php';
$config = new App\core\Config;

require '../vendor/autoload.php';

date_default_timezone_set('Asia/Kolkata');

$app = new App\core\App(); 
$app->loadController();
