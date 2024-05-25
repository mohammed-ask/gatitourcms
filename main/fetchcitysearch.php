<?php
include 'function.php';
include 'conn.php';
$something = $_POST["search"];
$product = $obj->selectextrawhereupdate("cities", "name,id", "name like '%" . $something . "%'");
$response = array();

while ($row = $obj->fetch_assoc($product)) {
    $response[] = array(
        'value' => $row['name'],
        "label" => $row['name'],
        "data" => $row['name']
    );
}
echo json_encode($response);
