<?php
if (isset($_POST['password'])) {
    include "session.php";
} else {
    include "function.php";
    include "conn.php";
}
// echo "<pre>";
// print_r($_FILES);
// die;
$mobile = $obj->selectfieldwhere("users", "count(id)", "mobile='" . $_POST['mobile'] . "'");
if (!empty($mobile)) {
    echo "<div class='alert alert-warning'>Mobile number already registered</div>";
    die;
}
$xx['added_on'] = date('Y-m-d H:i:s');
$xx['added_by'] = 0;
$xx['updated_on'] = date('Y-m-d H:i:s');
$xx['updated_by'] = 0;
$xx['status'] = 1;
$xx['name'] = ucwords($_POST['name']);
// $xx['email'] = $_POST['email'];
$xx['mobile'] = $_POST['mobile'];
$xx['role'] = $_POST['role'];
$xx['password'] = $_POST['password'];

$xx['type'] = 1;
$user = $obj->insertnew("users", $xx);
if ($user > 0) {
    echo "Redirect : Employee Created Successfully.  URLemployeelist";
}
