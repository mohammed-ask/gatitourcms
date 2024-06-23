<?php
include "main/session.php";
/* @var $obj db */
ob_start();
$id = $_GET['hakuna'];
$res = $obj->delete("users", $id);
$obj->saveactivity("Driver Deleted by Admin", "", $id, $employeeid, "Driver", "Driver Deleted by Admin");
echo "Driver Deleted Successfully";
