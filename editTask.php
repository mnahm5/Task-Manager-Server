<?php

include "bootstrap.php";

$response = array();
$response["success"] = false;

$taskId = $_POST["taskId"];
$taskTitle = $_POST["taskTitle"];
$taskType = $_POST["taskType"];
$description = $_POST["description"];
$dueDate = strtotime($_POST["dueDate"]);

$con = get_connection();
$stmt = $con->stmt_init();
if ($stmt->prepare("UPDATE `tasks` SET `taskType`=?,`taskTitle`=?,`taskDescription`=?,`taskDueDate`=? WHERE `taskId`=?")) {
    $stmt->bind_param("ssssi", $taskType, $taskTitle, $description, $dueDate, $taskId);
    if ($stmt->execute()) {
        $response["success"] = true;
    }
}


$con->close();
echo json_encode($response);