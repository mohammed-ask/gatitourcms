<?php
include "session.php";
$xx['updated_on'] = date('Y-m-d H:i:s');
$xx['updated_by'] = $employeeid;
$xx['status'] = 1;


$xx['name'] = ucwords($_POST['name']);
// $xx['email'] = $_POST['email'];
$xx['mobile'] = $_POST['mobile'];
$xx['password'] = $_POST['password'];
$xx['role'] = $_POST['role'];
$xx['type'] = 1;
$user = $obj->update("users", $xx, $_POST['id']);
if ($user > 0) {
    echo "Redirect : Employee Updated Successfully.  URLemployeelist";
}
