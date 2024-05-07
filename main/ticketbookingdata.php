<?php
include 'session.php';
/* @var $obj db */
$limit = $_GET['length'];
$start = $_GET['start'];
$i = 1;
$return['recordsTotal'] = 0;
$return['recordsFiltered'] = 0;
$return['draw'] = $_GET['draw'];
$return['data'] = array();
$orderdirection = "";
if (isset($_GET['order'][0]['dir'])) {
    $orderdirection = $_GET['order'][0]['dir'];
}
$oary = array('ticketbooking.id', 'ticketbooking.name', 'ticketbooking.email', '');
$ocoloum = "";
if (isset($_GET['order'][0]['column'])) {
    $ci = $_GET['order'][0]['column'];
    $ocoloum = $oary[$ci];
}
$order = "";
if (!empty($ocoloum)) {
    $order = " order by $ocoloum $orderdirection ";
}
$search = "";
if (isset($_GET['search']['value']) && !empty($_GET['search']['value'])) {
    $sv = $_GET['search']['value'];
    $search .= " and (ticketbooking.name like '%$sv%' or ticketbooking.email like '%$sv%')";
}
if ((isset($_GET['columns'][0]["search"]["value"])) && (!empty($_GET['columns'][0]["search"]["value"]))) {
    $search .= " and ticketbooking.name like '" . $_GET['columns'][0]["search"]["value"] . "'";
}
if ((isset($_GET['columns'][1]["search"]["value"])) && (!empty($_GET['columns'][1]["search"]["value"]))) {
    $search .= " and ticketbooking.email like '" . $_GET['columns'][1]["search"]["value"] . "'";
}
$return['recordsTotal'] = $obj->selectfieldwhere("ticketbooking  ", "count(ticketbooking.id)", "status=1 and date(pickupat) < date(CONVERT_TZ(NOW(),'+00:00','$timeskip')) ");
$return['recordsFiltered'] = $obj->selectfieldwhere("ticketbooking ", "count(ticketbooking.id)", "status=1 and date(pickupat) < date(CONVERT_TZ(NOW(),'+00:00','$timeskip')) $search ");
$return['draw'] = $_GET['draw'];
$result = $obj->selectextrawhereupdate(
    "ticketbooking ",
    "*",
    "status=1 and date(pickupat) >= date(CONVERT_TZ(NOW(),'+00:00','$timeskip'))  $search $order limit $start, $limit"
);
$num = $obj->total_rows($result);
$data = array();
while ($row = $obj->fetch_assoc($result)) {
    $n = array();
    $n[] = $i;
    $n[] = $row['name'];
    $n[] = $row['mobileno'];;
    $n[] = $row['email'];
    $n[] = $row['traveltype'];
    $n[] = $obj->selectfieldwhere("vehiclenames", "name", "id=" . $row['vehicleid'] . "");
    $n[] = $row['from'];
    $n[] = $row['to'];
    $n[] = changedateformatespecito($row['pickupat'], "Y-m-d H:i:s", "d/m/Y H:i a");
    $n[] = changedateformatespecito($row['departureat'], "Y-m-d H:i:s", "d/m/Y H:i a");
    $n[] = changedateformatespecito($row['added_on'], "Y-m-d H:i:s", "d/m/Y H:i a");

    $a = "";
    $n[] = $a;
    $data[] = $n;
    $i++;
}
$return['data'] = $data;
echo json_encode($return);
