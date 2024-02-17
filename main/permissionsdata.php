<?php
include '../session.php';
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
$oary = array('permissions.id', 'permissions.name', 'permissions.description', '');
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
    $search .= " and (permissions.name like '%$sv%' or permissions.description like '%$sv%')";
}
if ((isset($_GET['columns'][0]["search"]["value"])) && (!empty($_GET['columns'][0]["search"]["value"]))) {
    $search .= " and permissions.name like '" . $_GET['columns'][0]["search"]["value"] . "'";
}
if ((isset($_GET['columns'][1]["search"]["value"])) && (!empty($_GET['columns'][1]["search"]["value"]))) {
    $search .= " and permissions.description like '" . $_GET['columns'][1]["search"]["value"] . "'";
}
$return['recordsTotal'] = $obj->selectfieldwhere("permissions  ", "count(permissions.id)", "status=1 ");
$return['recordsFiltered'] = $obj->selectfieldwhere("permissions ", "count(permissions.id)", "status=1 $search ");
$return['draw'] = $_GET['draw'];
$result = $obj->selectextrawhereupdate(
    "permissions ",
    "`permissions`.`module`,`permissions`.`name`, `permissions`.`description`,`permissions`.`department`,`permissions`.`id` ",
    "status=1 $search $order limit $start, $limit"
);
$num = $obj->total_rows($result);
$data = array();
while ($row = $obj->fetch_assoc($result)) {
    $n = array();
    $n[] = $row['id'];
    $n[] = $row['name'];
    // $n[] = $row['description'];
    // $n[] = $row['department'];
    $n[] = $obj->selectfieldwhere("modules", "name", "id='" . $row['module'] . "'");
    $a = "";
    if (in_array(83, $permissions)) {
        $a = '<a class="px-4 py-2  text-sm  bg-blue  rounded-lg " href="editpermission?hakuna=' . $row['id'] . '" class="btn btn-blue">Edit</a>';
    }
    if (in_array(84, $permissions)) {
        $a .= "<a style='cursor: pointer;' class='px-4 py-2 ml-1 text-sm font-medium leading-5 text-white  bg-red  rounded-lg '  onclick='del(\"" . $row['id'] . "\", \"deletepermission\", \"Delete Role \")' >Delete</a>";
    }
    $n[] = $a;
    $data[] = $n;
    $i++;
}
$return['data'] = $data;
echo json_encode($return);
