<?php
include "bootstrap.php";

$response = array();
$response["success"] = false;

$projectId = $_POST["projectId"];
$taskType = $_POST["taskType"];
//$projectId = "1";
//$taskType = "Doing";

$con = get_connection();
$stmt = $con->stmt_init();
if ($stmt->prepare("SELECT `taskId`, `taskTitle`, `taskDescription`, `taskDueDate` FROM `tasks` WHERE `projectId`=? AND `taskType`=?")) {
    $stmt->bind_param("is", $projectId, $taskType);
    $stmt->execute();
    $stmt->bind_result($taskId, $taskTitle, $description, $dueDate);
    $taskIds = array();
    $taskTitles = array();
    $descriptions = array();
    $dueDates = array();
    while ($stmt->fetch()) {
        $taskIds[] = $taskId;
        $taskTitles[] = $taskTitle;
        $descriptions[] = $description;
        $dueDates[] = get_date($dueDate);
    }
    $response["success"] = true;
    $response["noOfTasks"] = sizeof($taskIds);
    $response["taskIds"] = $taskIds;
    $response["taskTitles"] = $taskTitles;
    $response["descriptions"] = $descriptions;
    $response["dueDates"] = $dueDates;
}
$con->close();
echo json_encode($response);