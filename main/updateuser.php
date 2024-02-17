<?php
include "main/session.php";
$id = $_POST['id'];
unset($_POST['id']);
// echo "<pre>";
// print_r($_FILES);
// die;
$emailcount = $obj->selectfieldwhere('users', "count(id)", "email='" . $_POST['email'] . "' and status != 99 and id != '" . $id . "'");
$empcode = $obj->selectfieldwhere('users', 'count(id)', 'usercode="' . trim($_POST['employeeref']) . '" and type = 1');
if ($emailcount > 0) {
    echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>Sorry! This Mail Already Exists </div>";
}
if ($empcode != 1 && !empty($_POST['employeeref'])) {
    echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>Sorry! Employee ID Does Not Match With Our Existing Employees  </div>";
} else {
    $path = "main/uploads/userdocs";
    foreach ($_POST["name"] as $key => $value) {
        $name = 'path' . $key;
        if (!empty($_FILES['path']['name'][$key])) {
            $uplid = $obj->selectfieldwhere("userdocuments", "path", "userid='" . $id . "'  and name='" . $_POST['name'][$key] . "' and status = 1");
            $oldfile = $obj->selectfieldwhere("uploadfile", "path", "id='" . $uplid . "'");
            if (file_exists($oldfile)) {
                $delfile = unlink($oldfile);
                $obj->deletewhere("userdocuments", "userid=" . $id . " and name='" . $_POST['name'][$key] . "' and status = 1");
                $obj->deletewhere("uploadfile", "id='" . $uplid . "'");
            }
            $document[$name]['name'] = $_FILES['path']['name'][$key];
            $document[$name]['type'] = $_FILES['path']['type'][$key];
            $document[$name]['tmp_name'] = $_FILES['path']['tmp_name'][$key];
            $document[$name]['size'] = $_FILES['path']['size'][$key];
            $document[$name]['error'] = $_FILES['path']['error'][$key];
            $y['path'] = $obj->uploadfilenew($path, $document, $name, array("png", "jpg", "jpeg", "pdf", "doc"));
            $y['name'] = $_POST['name'][$key];
            $y['userid'] = $id;
            $y['added_on'] = date('Y-m-d H:i:s');
            $y['added_by'] = $employeeid;
            $y['updated_on'] = date('Y-m-d H:i:s');
            $y['updated_by'] = $employeeid;
            $y['status'] = 1;
            $postdata = $y;
            $tb_name = "userdocuments";
            $pradin = $obj->insertnew($tb_name, $postdata);
        }
    }
    $tb_name = 'users';
    $x = array();
    $x['updated_on'] = date('Y-m-d H:i:s');
    $x['updated_by'] = $employeeid;
    $x['status'] = 1;
    $x['name'] = $_POST['username'];
    $x['email'] = $_POST['email'];
    $x['mobile'] = $_POST['mobileno'];
    $x['address'] = $_POST['address'];
    $x['dob'] = changedateformate($_POST['dob']);
    $x['adharno'] = $_POST['adharno'];
    $x['panno'] = $_POST['panno'];
    $x['bankname'] = $_POST['bankname'];
    $x['accountno'] = $_POST['accountno'];
    $x['ifsc'] = $_POST['ifsc'];
    $x['message'] = $_POST['message'];
    $x['employeeref'] = $_POST['employeeref'];
    $x['password'] = $_POST['password'];
    $x['type'] = 2;
    $x['carryforward'] = $_POST['carryforward'];
    $x['longholding'] = $_POST['longholding'];
    $x['withdrawlimit'] = $_POST['withdrawlimit'];
    $x['role'] = 2;
    // $x['investmentamount'] = $_POST['investmentamount'];
    $x['limit'] = $_POST['limit'];
    $x['startdatetime'] = changedateformatespecito($_POST['starttime'], "d/m/Y H:i:s", "Y-m-d H:i:s");
    $x['enddatetime'] = changedateformatespecito($_POST['endtime'], "d/m/Y H:i:s", "Y-m-d H:i:s");
    $pradin = $obj->update($tb_name, $x, $id);
    $obj->saveactivity("Update User by Admin", "", $id, $employeeid, "User", "Update User by Admin");
    echo "Redirect : User Updated Successfully URLusers";
}
