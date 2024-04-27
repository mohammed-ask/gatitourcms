<?php
include "session.php";
$xx['updated_on'] = date('Y-m-d H:i:s');
$xx['updated_by'] = $employeeid;
$xx['status'] = 1;
$path = 'main/uploads/driver';
if (!empty($_FILES["avatar"]["name"])) {
    $uplid = $obj->selectfield("users", "avatar", "id", $_POST['id']);
    $oldfile = $obj->selectfield("uploadfile", "path", "id", $uplid);
    if (file_exists($oldfile)) {
        $delfile = unlink($oldfile);
        $del_file = $obj->updatewhere("uploadfile", ["status" => 99], "id=$uplid");
    }
    $xx['avatar'] = $obj->uploadfilenew($path, $_FILES, "avatar",  array("jpg", "jpeg", "png"));
}

if (!empty($_FILES["license"]["name"])) {
    $uplid = $obj->selectfield("users", "licensephoto", "id", $_POST['id']);
    $oldfile = $obj->selectfield("uploadfile", "path", "id", $uplid);
    if (file_exists($oldfile)) {
        $delfile = unlink($oldfile);
        $del_file = $obj->updatewhere("uploadfile", ["status" => 99], "id=$uplid");
    }
    $xx['licensephoto'] = $obj->uploadfilenew($path, $_FILES, "license",  array("jpg", "jpeg", "png"));
}

$xx['name'] = ucwords($_POST['name']);
// $xx['email'] = $_POST['email'];
$xx['mobile'] = $_POST['mobile'];
$xx['city'] = $_POST['city'];
$xx['licenseexpiry'] = changedateformate($_POST['licenseexpiry']);
$xx['whatsappno'] = $_POST['whatsappno'];
$xx['adharno'] = $_POST['adharno'];
$xx['drivinglicense'] = $_POST['drivinglicense'];
$xx['password'] = $_POST['password'];
$xx['vehicleavailable'] = $_POST['vehicleavailable'];
$xx['vehicletype'] = $_POST['vehicletype'];
$xx['type'] = 3;
$user = $obj->update("users", $xx, $_POST['id']);
if ($user > 0) {
    echo "Redirect : Driver Updated Successfully.  URLdrivers";
}
