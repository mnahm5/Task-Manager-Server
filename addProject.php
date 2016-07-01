<?php
include "bootstrap.php";

$response = array();
$response["success"] = false;

$projectName = $_POST["projectName"];
$description = $_POST["description"];
$username = $_POST["username"];
//$projectName = "Dragon Slayer";
//$description = "Slay Dragons";
//$username = "mnahm5";
$dateCreated = date_converter(strtotime("now"));

$con = get_connection();
$con->autocommit(false);
try {
    $stmt =  $con->stmt_init();
    if ($stmt->prepare("INSERT INTO `projects`(`name`, `description`, `dateCreated`) VALUES (?,?,?)")) {
        $stmt->bind_param("sss", $projectName, $description, $dateCreated);
        if (!$stmt->execute()) {
            throw new Exception("Statement 1 Failed");
        }
        $projectId = $stmt->insert_id;
        if ($stmt->prepare("INSERT INTO `projectUsers`(`projectId`, `username`) VALUES (?,?)")) {
            $stmt->bind_param("is", $projectId, $username);
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