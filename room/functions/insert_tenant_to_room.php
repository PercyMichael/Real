<?php

require("../../db_config.php");

$tenant_id = clean($_POST['tenant_id']);
$room_id = clean($_POST['id']);
$date = clean($_POST['date']);

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "UPDATE rooms SET entrance_date='$date',tenant_id='$tenant_id',vacancy=1 WHERE id='$room_id'";

if (mysqli_query($conn, $sql)) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}

mysqli_close($conn);