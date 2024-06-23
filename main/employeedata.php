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
    $search .= " and (users.mobile like '%$sv%' or users.whatsappno like '%$sv%')";
}
// if ((isset($_GET['columns'][0]["search"]["value"])) && (!empty($_GET['columns'][0]["search"]["value"]))) {
//     $search .= " and users.name like '" . $_GET['columns'][0]["search"]["value"] . "'";
// }
// if ((isset($_GET['columns'][1]["search"]["value"])) && (!empty($_GET['columns'][1]["search"]["value"]))) {
//     $search .= " and users.email like '" . $_GET['columns'][1]["search"]["value"] . "'";
// }
$return['recordsTotal'] = $obj->selectfieldwhere("users  ", "count(users.id)", "status=1 and type= 1 ");
$return['recordsFiltered'] = $obj->selectfieldwhere("users ", "count(users.id)", "status=1 and type= 1 $search ");
$return['draw'] = $_GET['draw'];
$result = $obj->selectextrawhereupdate(
    "users ",
    "*",
    "status=1 and type = 1 and id != 1 $search $order limit $start, $limit"
);
$num = $obj->total_rows($result);
$data = array();
while ($row = $obj->fetch_assoc($result)) {
    $n = array();
    $n[] = $i;
    $n[] = $row['name'];
    $n[] = $row['mobile'];
    $n[] = $row['role'];
    $a = "";
    // if (in_array(26, $permissions)) {
    $a .=  "<a class='px-4 py-2 ml-1 text-sm font-medium leading-5 text-white  bg-primary  rounded-lg' @click='openModal'  onclick='dynamicmodal(\"" . $row['id'] . "\", \"editemployee\", \"\", \"\")'  aria-label='Go'>
        <span>Edit Employee</span>
    </a>";
    // }
    // if (in_array(27, $permissions)) {
    $a .= "<a style='cursor: pointer;' class='px-4 py-2 ml-1 text-sm font-medium leading-5 text-white  bg-red  rounded-lg '  onclick='del(\"" . $row['id'] . "\", \"deleteemployee\", \"Delete Employee \")' >Delete</a>";
    // }
    $n[] = $a;
    $data[] = $n;
    $i++;
}
$return['data'] = $data;
echo json_encode($return);
