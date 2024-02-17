<?php
include "main/session.php";
/* @var $obj db */
ob_start();
$id = $_GET['hakuna'];
$res = $obj->delete("vehicles", $id);
echo "Driver Deleted Successfully";
