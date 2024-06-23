<?php
ini_set("mysqlnd_qc.cache_by_default", "1");
ini_set('session.gc_maxlifetime', 86400);
ini_set('max_input_vars', 5000);
ini_set('suhosin.request.max_vars', 5000);
ini_set('session_set_cookie_params', 5000);
ini_set('suhosin.post.max_vars', 86400);
session_start();
ob_start();
include 'function.php';
include 'conn.php';
/* @var $obj db */
$obj->check_login();
// $obj->check_activate();
$employeeid = $_SESSION['userid'];
$usermail = $_SESSION['useremail'];
$role = $_SESSION['role'];
$rowuserdata = $obj->selectextrawhere("users", "id=" . $employeeid . "")->fetch_assoc();
$avatarpath = $obj->fetchattachment($rowuserdata['avatar']);

$username = $rowuserdata['name'];
$permissions = array();
if (isset($_SESSION['permissions']) && (!empty($_SESSION['permissions']))) {
    $permissions = explode(",", $_SESSION['permissions']);
} else {
    $permissions = $obj->selectfieldwhere("roles", "`permissions`", "id='$role'");
    $_SESSION['permissions'] = $permissions;
    $permissions = explode(",", $_SESSION['permissions']);
}

