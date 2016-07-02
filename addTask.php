<?php
include "bootstrap.php";

$response = array();
$response["success"] = false;
$projectId = $_POST["projectId"];
$taskType = $_POST["taskType"];
$taskTitle = $_POST["taskTitle"];
$description = $_POST["description"];
$dueDate = strtotime($_POST["dueDate"]);
//$projectId = "1";
//$taskType = "To Do";
//$taskTitle = "Fire";
//$description = "Learn Fire Magic";
//$dueDate = "23rd October";


$con = get_connection();
$stmt = $con->stmt_init();
if ($stmt->prepare("INSERT INTO `tasks`(`projectId`, `taskType`, `taskTitle`, `taskDescription`, `taskDueDate`) VALUES (?,?,?,?,?)")) {
    $stmt->bind_param("isssi", $projectId, $taskType, $taskTitle, $description, $dueDate);
    if ($stmt->execute()) {
        $response["success"] = true;
    }
}
$con->close();
echo json_encode($response);