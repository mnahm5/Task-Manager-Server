<?php
include "bootstrap.php";

$response = array();
$response["success"] = false;

$username = $_POST["username"];
//$username = "mnahm5";
$con = get_connection();
$stmt = $con->stmt_init();
if ($stmt->prepare("SELECT `projectId` FROM `projectUsers` WHERE `username` = ?")) {
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $stmt->bind_result($projectId);
    $projectIds = array();
    while ($stmt->fetch()) {
        array_push($projectIds,$projectId);
    }
    $type = "";
    $params = array();
    $query = "SELECT `projectId`, `name`, `description`, `dateCreated` FROM `projects` WHERE `projectId` in (";
    for ($i = 0; $i < sizeof($projectIds); $i++) {
        $type .= "i";
        $params[] = &$projectIds[$i];
        if ($i != (sizeof($projectIds)-1)) {
            $query .= "?,";
        }
        else {
            $query .= "?)";
        }
    }
    array_unshift($params,$type);
    if ($stmt->prepare($query)) {
        call_user_func_array(array($stmt, "bind_param"), $params);
        $stmt->execute();
        $stmt->bind_result($projectId, $projectName, $description, $dateCreated);
        $projectIds = array();
        $projectNames = array();
        $descriptions = array();
        $datesCreated = array();
        while ($stmt->fetch()) {
            $projectIds[] = $projectId;
            $projectNames[] = $projectName;
            $descriptions[] = $description;
            $datesCreated[] = $dateCreated;
        }
        $response["success"] = true;
        $response["noOfProjects"] = sizeof($projectIds);
        $response["projectIds"] = $projectIds;
        $response["projectNames"] = $projectNames;
        $response["descriptions"] = $descriptions;
        $response["datesCreated"] = $datesCreated;
    }
}

$con->close();
echo json_encode($response);