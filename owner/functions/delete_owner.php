<?php
require("../../db_config.php");

if (empty($_POST['id'])) {

    header('Location:../screens/owners.php');
}
else {
    $id = clean($_POST['id']);
    $sql = "DELETE FROM owners WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(array("statusCode" => 200));
    }
    else {
        echo json_encode(array("statusCode" => 201));
    }
    mysqli_close($conn);
}
?>