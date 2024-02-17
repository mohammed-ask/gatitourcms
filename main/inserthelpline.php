<?php
include "session.php";
$xx["phone"] = $_POST['phone'];
$help = $obj->updatewhere("personal_detail", $xx, "status=11");
if ($help > 0) {
    echo "Redirect : Helpline Updated Successfully.  URLindex";
}
