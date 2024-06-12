<?php
include 'function.php';
include 'conn.php';
$obj->hospital();
die;
// Read the JSON file
$jsonData = file_get_contents('main/cities.json');

// Decode JSON data
$cities = json_decode($jsonData, true);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gatitour";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
// $stmt = $conn->prepare("INSERT INTO cities (id, name, state) VALUES (?, ?, ?)");

// Bind parameters
// $stmt->bind_param("iss", $id, $name, $state);

// Iterate over cities and insert into database
// foreach ($cities as $city) {
//     $id = $city['id'];
//     $name = $city['name'];
//     $state = $city['state'];
//     $stmt->execute();
// }

// Close statement
$stmt->close();

// Close connection
$conn->close();

echo "Cities inserted successfully.";
