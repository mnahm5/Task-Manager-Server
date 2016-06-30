<?php

include "bootstrap.php";

$con = get_connection();

$username = $_POST['username'];
$password = $_POST['password'];
$password = password_hash($password,PASSWORD_DEFAULT);
$fullName = $_POST['fullName'];
$email = $_POST['email'];
$companyName = $_POST['companyName'];

$response = array();
$response['success'] = false;

$stmt =  $con->stmt_init();
if ($stmt->prepare("INSERT INTO `users`(`username`, `password`, `fullName`, `email`, `companyName`) VALUES (?,?,?,?,?)")) {
    $stmt->bind_param("sssss", $username, $password, $fullName, $email, $companyName);
    if ($stmt->execute()) {
        $response['success'] = true;
    }
}

$con->close();
echo json_encode($response);