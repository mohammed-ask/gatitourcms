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
$oary = array('useractivity.id', 'useractivity.userid', 'useractivity.driverid', '');
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
    $search .= " and (useractivity.userid like '%$sv%' or useractivity.driverid like '%$sv%')";
}
if ((isset($_GET['columns'][0]["search"]["value"])) && (!empty($_GET['columns'][0]["search"]["value"]))) {
    $search .= " and useractivity.userid like '" . $_GET['columns'][0]["search"]["value"] . "'";
}
if ((isset($_GET['columns'][1]["search"]["value"])) && (!empty($_GET['columns'][1]["search"]["value"]))) {
    $search .= " and useractivity.driverid like '" . $_GET['columns'][1]["search"]["value"] . "'";
}
$return['recordsTotal'] = $obj->selectfieldwhere("useractivity  ", "count(useractivity.id)", "status=1  ");
$return['recordsFiltered'] = $obj->selectfieldwhere("useractivity ", "count(useractivity.id)", "status=1  $search ");
$return['draw'] = $_GET['draw'];
$result = $obj->selectextrawhereupdate(
    "useractivity ",
    "*",
    "status=1 $search $order limit $start, $limit"
);
$num = $obj->total_rows($result);
$data = array();
while ($row = $obj->fetch_assoc($result)) {
    $n = array();
    $n[] = $i;
    $n[] = $obj->selectfieldwhere("users", "name", "id=" . $row['userid'] . "");
    $n[] = $obj->selectfieldwhere("vehicles", "name", "id=" . $row['vehicleid'] . "");
    $n[] = $obj->selectfieldwhere("users", "name", "id=" . $row['driverid'] . "");
    $n[] = $row['tapon'];
    $n[] = changedateformatespecito($row['added_on'], "Y-m-d H:i:s", "d/m/Y H:i a");
    $data[] = $n;
    $i++;
}
$return['data'] = $data;
echo json_encode($return);
