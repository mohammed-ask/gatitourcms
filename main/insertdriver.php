<?php
include "session.php";
// echo "<pre>";
// print_r($_FILES);
// die;
$mobile = $obj->selectfieldwhere("users", "count(id)", "mobile='" . $_POST['mobile'] . "'");
if (!empty($mobile)) {
    echo "<div class='alert alert-warning'>Mobile number already registered</div>";
    die;
}
$xx['added_on'] = date('Y-m-d H:i:s');
$xx['added_by'] = $employeeid;
$xx['updated_on'] = date('Y-m-d H:i:s');
$xx['updated_by'] = $employeeid;
$xx['status'] = 1;
$path = 'main/uploads/driver';
$xx['avatar'] = $obj->uploadfilenew($path, $_FILES, "avatar",  array("jpg", "jpeg", "png"));
$xx['licensephoto'] = $obj->uploadfilenew($path, $_FILES, "license",  array("jpg", "jpeg", "png"));
$xx['name'] = ucwords($_POST['name']);
// $xx['email'] = $_POST['email'];
$xx['mobile'] = $_POST['mobile'];
$xx['city'] = $_POST['city'];
$xx['licenseexpiry'] = changedateformate($_POST['licenseexpiry']);
$xx['whatsappno'] = $_POST['whatsappno'];
$xx['adharno'] = $_POST['adharno'];
$xx['drivinglicense'] = $_POST['drivinglicense'];
$xx['password'] = $_POST['password'];
$xx['type'] = 3;
$xx['lat'] = 0;
$xx['long'] = 0;
$user = $obj->insertnew("users", $xx);
if ($user > 0) {
    echo "Redirect : Driver Created Successfully.  URLdrivers";
}
