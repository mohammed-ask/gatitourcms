<?php
include 'main/session.php';
/* @var $obj db */
$id = $_GET['hakuna'];
$obj->saveactivity("User Deleted by Admin", "", $id, $employeeid, "User", "User Deleted by Admin");
$res = $obj->delete("users", $id);
if ($res == 1) {
    echo "User Deleted Successfully";
}
