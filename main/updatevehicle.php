<?php
include "session.php";
$id = $_POST['id'];
unset($_POST['id']);
$_POST['updated_on'] = date('Y-m-d H:i:s');
$_POST['updated_by'] = $employeeid;
$vehicle = $obj->update('vehicles', $_POST, $id);
if ($vehicle > 0) {
    echo "Redirect : Vehicle Updated Successfully.  URLvehicles";
}
