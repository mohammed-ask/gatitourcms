<?php
include "main/session.php";
/* @var $obj db */
ob_start();
$id = $_GET['hakuna'];
$res = $obj->delete("vehicles", $id);
$obj->saveactivity("Vehicle Deleted by Admin", "", $id, $employeeid, "Vehicle", "Vehicle Deleted by Admin");
echo "Driver Deleted Successfully";
