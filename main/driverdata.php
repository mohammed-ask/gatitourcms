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
$oary = array('users.id', 'users.name', 'users.email', '');
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
    $search .= " and (users.name like '%$sv%' or users.email like '%$sv%')";
}
if ((isset($_GET['columns'][0]["search"]["value"])) && (!empty($_GET['columns'][0]["search"]["value"]))) {
    $search .= " and users.name like '" . $_GET['columns'][0]["search"]["value"] . "'";
}
if ((isset($_GET['columns'][1]["search"]["value"])) && (!empty($_GET['columns'][1]["search"]["value"]))) {
    $search .= " and users.email like '" . $_GET['columns'][1]["search"]["value"] . "'";
}
$return['recordsTotal'] = $obj->selectfieldwhere("users  ", "count(users.id)", "status=1 and type= 3 ");
$return['recordsFiltered'] = $obj->selectfieldwhere("users ", "count(users.id)", "status=1 and type= 3 $search ");
$return['draw'] = $_GET['draw'];
$result = $obj->selectextrawhereupdate(
    "users ",
    "*",
    "status=1 and type = 3 $search $order limit $start, $limit"
);
$num = $obj->total_rows($result);
$data = array();
while ($row = $obj->fetch_assoc($result)) {
    $n = array();
    $n[] = $i;
    $n[] = $row['name'];
    $n[] = ' <a target="_blank"  href="' . $obj->fetchattachment($row["avatar"]) . '"><img style="width:50px;height:50px" src="' . $obj->fetchattachment($row["avatar"]) . '"/></a> ';

    $n[] = $row['mobile'];
    $n[] = $row['whatsappno'];
    $n[] = $row['drivinglicense'];
    $n[] = $row['trackenable'];
    $n[] = changedateformatespecito($row['licenseexpiry'], "Y-m-d", "d/m/Y");
    $n[] = ' <a target="_blank"  href="' . $obj->fetchattachment($row["licensephoto"]) . '"><img style="width:50px;height:50px" src="' . $obj->fetchattachment($row["licensephoto"]) . '"/></a> ';
    $n[] = $row['appversion'];
    $n[] = $row['adharno'];
    $n[] =  "<button class='flex items-center justify-between px-2 py-1 bg-blue text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' @click='openModal'  onclick='dynamicmodal(\"" . $row['id'] . "\", \"drivervehicles\", \"\", \"\")'  aria-label='Go'>
    <span>Show Vehicles</span>
</button>";
    $n[] = $obj->selectfieldwhere("useractivity", "count(id)", "tapon='Whatsapp' and driverid=" . $row['id'] . " and status = 1");
    $n[] = $obj->selectfieldwhere("useractivity", "count(id)", "tapon='Phone' and driverid=" . $row['id'] . " and status = 1");
    $n[] = "Latitude : " . round($row['lat'], 4) . " Longitude : " . round($row['long'], 4) . " on " . changedateformatespecito($row['lastupdate'], "Y-m-d H:i:s", "d/m/Y h:i a");
    $a = "";
    // if (in_array(26, $permissions)) {
    $a .=  "<a class='px-4 py-2 ml-1 text-sm font-medium leading-5 text-white  bg-primary  rounded-lg' @click='openModal'  onclick='dynamicmodal(\"" . $row['id'] . "\", \"editdriver\", \"\", \"\")'  aria-label='Go'>
        <span>Edit Driver</span>
    </a>";
    // }
    // if (in_array(27, $permissions)) {
    $a .= "<a style='cursor: pointer;' class='px-4 py-2 ml-1 text-sm font-medium leading-5 text-white  bg-red  rounded-lg '  onclick='del(\"" . $row['id'] . "\", \"deletedriver\", \"Delete Driver \")' >Delete</a>";
    // }
    $n[] = $a;
    $data[] = $n;
    $i++;
}
$return['data'] = $data;
echo json_encode($return);
