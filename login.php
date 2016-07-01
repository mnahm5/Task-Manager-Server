<?php
include "bootstrap.php";
$con = get_connection();

$username = $_POST["username"];
$password = $_POST["password"];
$response = array();
$response["success"] = false;

$stmt =  $con->stmt_init();
if ($stmt->prepare("SELECT `userId`, `password`, `fullName`, `email`, `companyName` FROM `users` WHERE `username`=?")) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($userId, $db_password, $fullName, $email, $companyName);
    while ($stmt->fetch()) {
        if (password_verify($password,$db_password)) {
            $response['success'] = true;
            $response['username'] = $username;
            $response['fullName'] = $fullName;
            $response['email'] = $email;
            $response['companyName'] = $companyName;
            $_SESSION['userId'] = $userId;
        }
    }
}
$con->close();
echo json_encode($response);