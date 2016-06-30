<?php

include "bootstrap.php";

$response = array();
$response['success'] = false;

if (isset($_SESSION['userId'])) {
    $con = get_connection();
    $stmt =  $con->stmt_init();
    if ($stmt->prepare("SELECT `username`, `fullName`, `email`, `companyName` FROM `users` WHERE `userId`=?")) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($username, $fullName, $email, $companyName);
        while ($stmt->fetch()) {
            $response['success'] = true;
            $response['username'] = $username;
            $response['fullName'] = $fullName;
            $response['email'] = $email;
            $response['companyName'] = $companyName;
        }
    }
    $con->close();
}
echo json_encode($response);