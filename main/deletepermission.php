<?php
include '../session.php';
/* @var $obj db */
$id = $_GET['hakuna'];
$res = $obj->delete("permissions", $id);
if ($res == 1) {
   echo "Permission Deleted Successfully";
}
