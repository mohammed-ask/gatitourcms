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
$oary = array('vehicles.id', 'vehicles.name', 'vehicles.userid', '');
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
    $search .= " and (vehicles.name like '%$sv%' or vehicles.userid like '%$sv%')";
}
if ((isset($_GET['columns'][0]["search"]["value"])) && (!empty($_GET['columns'][0]["search"]["value"]))) {
    $search .= " and vehicles.name like '" . $_GET['columns'][0]["search"]["value"] . "'";
}
if ((isset($_GET['columns'][1]["search"]["value"])) && (!empty($_GET['columns'][1]["search"]["value"]))) {
    $search .= " and vehicles.userid like '" . $_GET['columns'][1]["search"]["value"] . "'";
}
$return['recordsTotal'] = $obj->selectfieldwhere("vehicles  ", "count(vehicles.id)", "status=1  ");
$return['recordsFiltered'] = $obj->selectfieldwhere("vehicles ", "count(vehicles.id)", "status=1  $search ");
$return['draw'] = $_GET['draw'];
$result = $obj->selectextrawhereupdate(
    "vehicles ",
    "*",
    "status=1 $search $order limit $start, $limit"
);
$num = $obj->total_rows($result);
$data = array();
while ($row = $obj->fetch_assoc($result)) {
    $n = array();
    $n[] = $i;
    $n[] = $row['name'];
    $n[] = $obj->selectfieldwhere("vehiclenames", "name", "id=" . $row['vehicleid'] . "");
    $n[] = $obj->selectfieldwhere("users", "name", "id=" . $row['userid'] . "");
    $n[] = $row['vehicleno'];
    $n[] = $row['seater'];
    $n[] = changedateformatespecito($row['added_on'], "Y-m-d H:i:s", "d/m/Y");
    $a = "";
    // if (in_array(26, $permissions)) {
    $a .=  "<a class='px-4 py-2 ml-1 text-sm font-medium leading-5 text-white  bg-primary  rounded-lg' @click='openModal'  onclick='dynamicmodal(\"" . $row['id'] . "\", \"editvehicle\", \"\", \"\")'  aria-label='Go'>
        <span>Edit Vehicle</span>
    </a>";
    // }
    // if (in_array(27, $permissions)) {
    $a .= "<a style='cursor: pointer;' class='px-4 py-2 ml-1 text-sm font-medium leading-5 text-white  bg-red  rounded-lg '  onclick='del(\"" . $row['id'] . "\", \"deletevehicle\", \"Delete Role \")' >Delete</a>";
    // }
    $n[] = $a;
    $data[] = $n;
    $i++;
}
$return['data'] = $data;
echo json_encode($return);
