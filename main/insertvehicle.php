<?php
include "session.php";
$_POST['added_on'] = date('Y-m-d H:i:s');
$_POST['added_by'] = $employeeid;
$_POST['updated_on'] = date('Y-m-d H:i:s');
$_POST['updated_by'] = $employeeid;
$_POST['status'] = 1;
$vehicle = $obj->insertnew('vehicles', $_POST);
if ($vehicle > 0) {
    echo "Redirect : Vehicle Created Successfully.  URLvehicles";
}
