<?php

include "bootstrap.php";

$response = array();
$response["success"] = false;

$projectId = $_POST["projectId"];
//$projectId = "5";
$con = get_connection();
$con->autocommit(false);
try {
    $stmt = $con->stmt_init();
    if ($stmt->prepare("DELETE FROM `projects` WHERE `projectId`=?")) {
        $stmt->bind_param("i", $projectId);
        if (!$stmt->execute()) {
            throw new Exception("Statement 1 Failed");
        }
        if ($stmt->prepare("DELETE FROM `projectUsers` WHERE `projectId`=?")) {
            $stmt->bind_param("i", $projectId);
            if (!$stmt->execute()) {
                throw new Exception("Statement 2 Failed");
            }
            $con->commit();
            $response["success"] = true;
        }
    }
}
catch (Exception $e) {
    $con->rollback();
}

$con->autocommit(true);
$con->close();
echo json_encode($response);