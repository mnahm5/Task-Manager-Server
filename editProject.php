<?php

include "bootstrap.php";

$response = array();
$response["success"] = false;

$projectId = $_POST["projectId"];
$projectName = $_POST["projectName"];
$description = $_POST["description"];
//$projectId = "1";
//$projectName = "Dragon God Slayer";
//$description = "The plan is to kill all dragons";


$con = get_connection();
$stmt = $con->stmt_init();
if ($stmt->prepare("UPDATE `projects` SET `name`=?,`description`=? WHERE `projectId`=?")) {
    $stmt->bind_param("ssi", $projectName, $description, $projectId);
    if ($stmt->execute()) {
        $response["success"] = true;
    }
}

$con->close();
echo json_encode($response);