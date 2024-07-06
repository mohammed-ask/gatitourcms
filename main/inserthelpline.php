<?php
include "session.php";
if(!empty($_POST['password'])){
$sy["password"] = $_POST['password'];
$pass = $obj->updatewhere("users", $sy, "id=".$employeeid."");
}
$xx["phone"] = $_POST['phone'];
$help = $obj->updatewhere("personal_detail", $xx, "status=11");
if ($help > 0) {
    echo "Redirect : Helpline Updated Successfully.  URLindex";
}
