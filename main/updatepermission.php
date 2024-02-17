<?php
include 'session.php';
/* @var $obj db */
$sid = $_POST['hakuna'];
$_POST['status'] = 1;
unset($_POST['hakuna']);
$tb_name = "permissions";
$postdata = $_POST;
$ures = $obj->update($tb_name, $postdata, $sid);
if ($ures == 1) {
    echo "Redirect : Permission has been Updated URLpermission";
}
