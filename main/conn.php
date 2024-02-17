<?php
date_default_timezone_set('Asia/Kolkata');
ini_set('memory_limit', '-1');
$platform = "Production";
$host = "localhost";
$database_Username = "root";
$database_Password = "";
$database_Name = "gatitour";
$siteurl = "http://localhost/gatitour/";
$port = 3306;
$platform = "test";
if (($_SERVER['HTTP_HOST'] == 'localhost')) {
    if (!defined("BASE_URL")) {
        define("BASE_URL", "http://" . $_SERVER['HTTP_HOST'] . "/gatitour/");
    }
    $host = "localhost";
    $database_Username = "root";
    $database_Password = "";
    $database_Name = "gatitour";
    $siteurl = "http://localhost/gatitour/";
    $port = 3306;
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $platform = "test";
}

date_default_timezone_set('Asia/Kolkata');
/* object for db class in function.php $obj */
$obj = new db($host, $database_Username, $database_Password, $database_Name, $port);

// Main Settings


$compdata = $obj->selectextrawhere("personal_detail", "status=11")->fetch_assoc();
$helpline = $compdata['phone'];
$timeskip = ($platform == "test") ?  '+00:00' : '+5:30';
