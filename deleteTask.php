<?php

include "bootstrap.php";

$response = array();
$response["success"] = false;

$taskId = $_POST["taskId"];

$con = get_connection();
$stmt = $con->stmt_init();
if ($stmt->prepare("DELETE FROM `tasks` WHERE `taskId`=?")) {
    $stmt->bind_param("i",$taskId);
    if ($stmt->execute()) {
        $response["success"] = true;
    }
}

$con->close();
echo json_encode($response);