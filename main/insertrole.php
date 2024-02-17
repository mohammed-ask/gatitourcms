<?php
include 'main/session.php';
/* @var $obj db */
$_POST['added_on'] = date('Y-m-d H:i:s');
$_POST['added_by'] = $employeeid;
$_POST['updated_on'] = date('Y-m-d H:i:s');
$_POST['updated_by'] = $employeeid;
$_POST['status'] = 1;
$_POST['permissions'] = implode(",", $_POST['permissions']);
$tb_name = "roles";
$postdata = $_POST;
$pradin = $obj->insertnew($tb_name, $postdata);
if (is_integer($pradin) && $pradin > 0) {
    echo "Redirect : New Role has been Added! URLeditrole?hakuna=$pradin";
} else {
    echo "Some Error Occured";
}
