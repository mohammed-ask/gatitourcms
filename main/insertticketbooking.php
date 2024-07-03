<?php
include "function.php";
include "conn.php";
// print_r($_POST);
$xx['added_on'] = date('Y-m-d H:i:s');
$xx['added_by'] = 0;
$xx['updated_on'] = date('Y-m-d H:i:s');
$xx['updated_by'] = 0;
$xx['status'] = 1;
$xx['name'] = ucwords($_POST['fname']) . " " . $_POST['lname'];
$xx['mobileno'] = $_POST['mobileno'];
$xx['email'] = $_POST['email'];
$xx['from'] = $_POST['from'];
$xx['to'] = $_POST['to'];
$xx['vehicleid'] = $_POST['vehicleid'];
$xx['traveltype'] = $_POST['traveltype'];
$xx['pickupat'] = changedateformatespecito($_POST['pickupat'], "d/m/Y H:i:s", "Y-m-d H:i:s");
$xx['departureat'] = changedateformatespecito($_POST['departureat'], "d/m/Y H:i:s", "Y-m-d H:i:s");

if ($xx['vehicleid'] == 9) {
    $userids = $obj->selectfieldwhere("users", "group_concat(id)", "vehicleavailable='No'");
} else {
    $userids = $obj->selectfieldwhere("vehicles", "group_concat(userid)", "vehicleid=" . $xx['vehicleid'] . "");
}
// echo $userids;
$playerids = $obj->selectfieldwhere("users", "group_concat(playerid)", "id in ("  . $userids . ") and status = 1");
// echo $playerids;

$user = $obj->insertnew("ticketbooking", $xx);
if ($user > 0) {
    if (!empty($playerids)) {
        $obj->sendnotification(explode(",", $playerids), $xx['name']);
    }
    echo "Redirect : Vehicle Booking Successfull.  URLindex";
}
