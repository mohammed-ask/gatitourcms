<?php
include 'main/session.php';
/* @var $obj db */
ob_start();
$_POST['added_on'] = date('Y-m-d H:i:s');
$_POST['added_by'] = $employeeid;
$_POST['updated_on'] = date('Y-m-d H:i:s');
$_POST['updated_by'] = $employeeid;
$_POST['status'] = 1;
$_POST['permissions'] = implode(",", $_POST['permissions']);
$tb_name = "roles";
$sid = $_POST['id'];
unset($_POST['id']);
$postdata = $_POST;
$pradin = $obj->update($tb_name, $postdata, $sid);
if (is_integer($pradin) && $pradin > 0) {
    echo "Redirect :  Role has been Updated to your Catalogue URLviewrole?hakuna=$sid";
} else {
    echo "Some Error Occured";
}
