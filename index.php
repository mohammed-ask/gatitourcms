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
    case "$head/gitpull";
        require __DIR__ . '/main/guthubpull.php';
        break;
    case "$head/api/getmpin";
        require __DIR__ . '/main/api/getmpin.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/404.html';
        # code...
        break;
}
