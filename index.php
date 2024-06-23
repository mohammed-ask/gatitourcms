<?php
// echo $_SERVER['REQUEST_URI']." ";
$head = "";
if (($_SERVER['HTTP_HOST'] == 'localhost')) {
    $head = "/gatitourcms";
}
$request = parse_url($_SERVER['REQUEST_URI']);
switch ($request['path']) {
    case "$head/logout";
        require __DIR__ . '/main/logout.php';
        break;
    case "$head/index":                                    //User Routes
        require __DIR__ . '/main/index.php';
        break;
    case "$head/":
        require __DIR__ . '/main/index.php';
        break;
    case "$head/dashboard":
        require __DIR__ . '/main/dashboard.php';
        break;
    case "$head/privacy-policy":
        require __DIR__ . '/main/privacy-policy.php';
        break;
    case "$head";
        require __DIR__ . '/main/index.php';
        break;
    case "$head/login";
        require __DIR__ . '/main/adminlogin.php';
        break;
    case "$head/checkadminlogin";
        require __DIR__ . '/main/checkadminlogin.php';
        break;
    case "$head/logout";
        require __DIR__ . '/main/logout.php';
        break;
    case "$head/drivervehicles";
        require __DIR__ . '/main/drivervehicles.php';
        break;
    case "$head/customers";
        require __DIR__ . '/main/customers.php';
        break;
    case "$head/drivers";
        require __DIR__ . '/main/drivers.php';
        break;
    case "$head/deletedriver";
        require __DIR__ . '/main/deletedriver.php';
        break;
    case "$head/adddriver";
        require __DIR__ . '/main/adddriver.php';
        break;
    case "$head/insertdriver";
        require __DIR__ . '/main/insertdriver.php';
        break;
    case "$head/editdriver";
        require __DIR__ . '/main/editdriver.php';
        break;
    case "$head/updatedriver";
        require __DIR__ . '/main/updatedriver.php';
        break;
    case "$head/vehicles";
        require __DIR__ . '/main/vehicles.php';
        break;
    case "$head/addvehicle";
        require __DIR__ . '/main/addvehicle.php';
        break;
    case "$head/insertvehicle";
        require __DIR__ . '/main/insertvehicle.php';
        break;
    case "$head/editvehicle";
        require __DIR__ . '/main/editvehicle.php';
        break;
    case "$head/updatevehicle";
        require __DIR__ . '/main/updatevehicle.php';
        break;
    case "$head/deletevehicle";
        require __DIR__ . '/main/deletevehicle.php';
        break;
    case "$head/fillseats";
        require __DIR__ . '/main/fillseats.php';
        break;
    case "$head/helpline";
        require __DIR__ . '/main/helpline.php';
        break;
    case "$head/inserthelpline";
        require __DIR__ . '/main/inserthelpline.php';
        break;
    case "$head/test";
        require __DIR__ . '/main/test.php';
        break;
    case "$head/useractivity";
        require __DIR__ . '/main/useractivity.php';
        break;
    case "$head/ticketbooking";
        require __DIR__ . '/main/ticketbooking.php';
        break;
    case "$head/vehiclebooking";
        require __DIR__ . '/main/addticketbooking.php';
        break;
    case "$head/insertticketbooking";
        require __DIR__ . '/main/insertticketbooking.php';
        break;
    case "$head/viewrole";
        require __DIR__ . '/main/viewrole.php';
        break;
    case "$head/editrole";
        require __DIR__ . '/main/editrole.php';
        break;
    case "$head/updaterole";
        require __DIR__ . '/main/update_role.php';
        break;
    case "$head/addrole";
        require __DIR__ . '/main/addrole.php';
        break;
    case "$head/insertrole";
        require __DIR__ . '/main/insertrole.php';
        break;
    case "$head/deleterole";
        require __DIR__ . '/main/deleterole.php';
        break;
    case "$head/permission";
        require __DIR__ . '/main/permission.php';
        break;
    case "$head/addpermission";
        require __DIR__ . '/main/addpermission.php';
        break;
    case "$head/insertpermission";
        require __DIR__ . '/main/insertpermission.php';
        break;
    case "$head/editpermission";
        require __DIR__ . '/main/editpermission.php';
        break;
    case "$head/updatepermission";
        require __DIR__ . '/main/updatepermission.php';
        break;
    case "$head/deletepermission";
        require __DIR__ . '/main/deletepermission.php';
        break;
    case "$head/employeelist";
        require __DIR__ . '/main/employeelist.php';
        break;
    case "$head/addemployee";
        require __DIR__ . '/main/addemployee.php';
        break;
    case "$head/insertemployee";
        require __DIR__ . '/main/insertemployee.php';
        break;
    case "$head/editemployee";
        require __DIR__ . '/main/editemployee.php';
        break;
    case "$head/updatemployee";
        require __DIR__ . '/main/updatemployee.php';
        break;
    case "$head/deletemployee";
        require __DIR__ . '/main/deletemployee.php';
        break;
    case "$head/gitpull";
        require __DIR__ . '/main/guthubpull.php';
        break;
    case "$head/api/createuser";
        require __DIR__ . '/main/api/createuser.php';
        break;
    case "$head/api/driverlocation";
        require __DIR__ . '/main/api/driverlocation.php';
        break;
    case "$head/api/getdeviceid";
        require __DIR__ . '/main/api/getdeviceid.php';
        break;
    case "$head/api/getdriverdetails";
        require __DIR__ . '/main/api/getdriverdetails.php';
        break;
    case "$head/api/getvehiclebyid";
        require __DIR__ . '/main/api/getvehiclebyid.php';
        break;
    case "$head/api/getvehicles";
        require __DIR__ . '/main/api/getvehicles.php';
        break;
    case "$head/api/loginapi";
        require __DIR__ . '/main/api/loginapi.php';
        break;
    case "$head/api/trackingpermission";
        require __DIR__ . '/main/api/trackingpermission.php';
        break;
    case "$head/api/adduseractivity";
        require __DIR__ . '/main/api/adduseractivity.php';
        break;
    case "$head/api/checkphone";
        require __DIR__ . '/main/api/checkphone.php';
        break;
    case "$head/api/saveplayerid";
        require __DIR__ . '/main/api/saveplayerid.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/404.html';
        # code...
        break;
}
