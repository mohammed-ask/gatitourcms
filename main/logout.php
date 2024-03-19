<?php
include 'main/session.php';
$head = "index";
if (($_SERVER['HTTP_HOST'] == 'localhost')) {
    $head = "/gatitourcms";
}
$index =  $head;
$test = $obj->logout();
header("location:$index");
