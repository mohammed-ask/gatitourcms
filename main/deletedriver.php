<?php
include "main/session.php";
/* @var $obj db */
ob_start();
$id = $_GET['hakuna'];
$res = $obj->delete("users", $id);
echo "Driver Deleted Successfully";
