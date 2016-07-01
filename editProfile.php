<?php

include "bootstrap.php";

$username = $_POST["username"];
$fullName = $_POST["fullName"];
$email = $_POST["email"];
$companyName = $_POST["companyName"];

$response = array();
$response['success'] = false;

$con = get_connection();
$stmt =  $con->stmt_init();
if ($stmt->prepare("UPDATE `users` SET `fullName`=?,`email`=?,`companyName`=? WHERE `username`=?")) {
    $stmt->bind_param("ssss",$fullName,$email,$companyName,$username);
    if ($stmt->execute()) {
        $response['success'] = true;
    }
}
$con->close();

echo json_encode($response);

